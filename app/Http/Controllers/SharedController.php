<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Certificate;
use App\Models\Ekskul;
use App\Models\Gallery;
use App\Models\Schedule;
use App\Models\User;
use App\Support\Notifier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/** Fitur yang dipakai bersama oleh admin, pembina, dan siswa. */
class SharedController extends Controller
{
    public function dashboardRedirect()
    {
        $u = auth()->user();
        return redirect()->route($u->isAdmin() ? 'admin.dashboard' : ($u->isPembina() ? 'pembina.dashboard' : 'siswa.dashboard'));
    }

    /* ----- Notifikasi ----- */
    public function notifications()
    {
        $items = auth()->user()->appNotifications()->paginate(15);
        return view('shared.notifikasi', compact('items'));
    }

    public function readAll()
    {
        auth()->user()->appNotifications()->whereNull('read_at')->update(['read_at' => now()]);
        return back()->with('success', 'Semua notifikasi ditandai telah dibaca.');
    }

    public function readOne($id)
    {
        $n = auth()->user()->appNotifications()->findOrFail($id);
        $n->update(['read_at' => $n->read_at ?? now()]);
        return redirect($n->url ?: route('notifikasi.index'));
    }

    /* ----- Profil ----- */
    public function profile()
    {
        return view('shared.profil', ['user' => auth()->user()]);
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'nullable|string|max:20',
            'kelas' => 'nullable|string|max:30',
            'password' => 'nullable|string|min:8|confirmed',
        ]);
        if (empty($data['password'])) unset($data['password']);
        if (!$user->isSiswa()) unset($data['kelas']);
        $user->update($data);
        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    /* ----- Jadwal (admin memakai halaman CRUD sendiri) ----- */
    public function schedules(Request $request)
    {
        $user = auth()->user();
        if ($user->isAdmin()) return redirect()->route('admin.jadwal.index');

        $ids = $user->scopedEkskulIds();
        $upcoming = Schedule::with(['ekskul', 'room'])->whereIn('ekskul_id', $ids)
            ->whereDate('date', '>=', today())->orderBy('date')->orderBy('start_time')->get();
        $past = Schedule::with(['ekskul', 'room'])->whereIn('ekskul_id', $ids)
            ->whereDate('date', '<', today())->orderByDesc('date')->take(10)->get();
        return view('shared.jadwal', compact('upcoming', 'past'));
    }

    /* ----- Kalender terintegrasi ----- */
    public function calendar(Request $request)
    {
        $user = auth()->user();
        $month = $request->query('bulan');
        try { $cursor = Carbon::createFromFormat('Y-m', $month)->startOfMonth(); }
        catch (\Throwable $e) { $cursor = now()->startOfMonth(); }

        $events = Schedule::with('ekskul')->whereIn('ekskul_id', $user->scopedEkskulIds())
            ->whereBetween('date', [$cursor->copy()->startOfMonth(), $cursor->copy()->endOfMonth()])
            ->orderBy('start_time')->get()->groupBy(fn ($s) => $s->date->format('Y-m-d'));

        $offset = ($cursor->dayOfWeekIso - 1);
        $legend = Ekskul::whereIn('id', $user->scopedEkskulIds())->get(['id', 'name', 'color']);
        return view('shared.kalender', [
            'cursor' => $cursor, 'events' => $events, 'offset' => $offset, 'legend' => $legend,
            'prev' => $cursor->copy()->subMonth()->format('Y-m'), 'next' => $cursor->copy()->addMonth()->format('Y-m'),
        ]);
    }

    /* ----- Pengumuman & Berita ----- */
    public function announcements()
    {
        $user = auth()->user();
        $ids = $user->scopedEkskulIds();
        $items = Announcement::with(['author', 'ekskul'])
            ->where(function ($q) use ($ids, $user) {
                $q->whereNull('ekskul_id')->orWhereIn('ekskul_id', $ids);
                if ($user->isPembina() || $user->isAdmin()) $q->orWhere('user_id', $user->id);
            })->latest()->paginate(10);
        $ekskuls = $user->isAdmin() ? Ekskul::orderBy('name')->get() : ($user->isPembina() ? $user->ekskulsBina : collect());
        return view('shared.pengumuman', compact('items', 'ekskuls'));
    }

    public function storeAnnouncement(Request $request)
    {
        $user = auth()->user();
        $data = $request->validate([
            'title' => 'required|string|max:150',
            'body' => 'required|string',
            'type' => 'required|in:pengumuman,berita',
            'ekskul_id' => ($user->isPembina() ? 'required' : 'nullable') . '|exists:ekskuls,id',
        ]);
        if ($user->isPembina() && !in_array((int) $data['ekskul_id'], $user->scopedEkskulIds(), true)) abort(403);

        $a = Announcement::create($data + ['user_id' => $user->id]);

        // Kirim notifikasi ke penerima
        $recipients = $a->ekskul_id
            ? Ekskul::find($a->ekskul_id)->members
            : User::where('role', 'siswa')->where('is_active', true)->get();
        Notifier::send($recipients->reject(fn ($r) => $r->id === $user->id), ucfirst($a->type) . ' baru: ' . $a->title,
            \Str::limit($a->body, 90), route('pengumuman.index'));

        return back()->with('success', ucfirst($a->type) . ' berhasil diterbitkan.');
    }

    public function destroyAnnouncement(Announcement $announcement)
    {
        $this->authorizeOwner($announcement->user_id);
        $announcement->delete();
        return back()->with('success', 'Data dihapus.');
    }

    /* ----- Galeri ----- */
    public function gallery()
    {
        $user = auth()->user();
        $ids = $user->scopedEkskulIds();
        $items = Gallery::with(['ekskul', 'uploader'])
            ->where(fn ($q) => $q->whereNull('ekskul_id')->orWhereIn('ekskul_id', $ids))
            ->latest()->paginate(12);
        $ekskuls = $user->isAdmin() ? Ekskul::orderBy('name')->get() : ($user->isPembina() ? $user->ekskulsBina : collect());
        return view('shared.galeri', compact('items', 'ekskuls'));
    }

    public function storeGallery(Request $request)
    {
        $user = auth()->user();
        $data = $request->validate([
            'title' => 'required|string|max:150',
            'description' => 'nullable|string|max:500',
            'ekskul_id' => ($user->isPembina() ? 'required' : 'nullable') . '|exists:ekskuls,id',
            'image' => 'required|image|max:4096',
        ]);
        if ($user->isPembina() && !in_array((int) $data['ekskul_id'], $user->scopedEkskulIds(), true)) abort(403);

        Gallery::create([
            'user_id' => $user->id,
            'ekskul_id' => $data['ekskul_id'] ?? null,
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'image_path' => $request->file('image')->store('galeri', 'public'),
        ]);
        return back()->with('success', 'Foto dokumentasi berhasil diunggah.');
    }

    public function destroyGallery(Gallery $gallery)
    {
        $this->authorizeOwner($gallery->user_id);
        Storage::disk('public')->delete($gallery->image_path);
        $gallery->delete();
        return back()->with('success', 'Foto dihapus.');
    }

    /* ----- Cetak sertifikat (pemilik atau admin) ----- */
    public function printCertificate(Certificate $certificate)
    {
        $user = auth()->user();
        if (!$user->isAdmin() && $certificate->user_id !== $user->id) abort(403);
        $certificate->load(['user', 'ekskul.pembina']);
        return view('shared.sertifikat-cetak', compact('certificate'));
    }

    private function authorizeOwner(int $ownerId): void
    {
        $u = auth()->user();
        if (!$u->isAdmin() && $u->id !== $ownerId) abort(403);
    }
}
