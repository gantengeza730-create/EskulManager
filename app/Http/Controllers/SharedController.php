<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Certificate;
use App\Models\Ekskul;
use App\Models\Gallery;
use App\Models\Registration;
use App\Models\Schedule;
use App\Models\User;
use App\Support\Notifier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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
    public function profile() { return view('shared.profil', ['user' => auth()->user()]); }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'kelas' => $user->isSiswa() ? 'required|string|max:30' : 'nullable',
            'password' => 'nullable|string|min:8|confirmed',
        ]);
        if (empty($data['password'])) unset($data['password']);
        if (!$user->isSiswa()) unset($data['kelas']);
        $user->update($data);
        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    /* ----- Jadwal (admin memakai halaman CRUD sendiri) ----- */
    public function schedules()
    {
        $user = auth()->user();
        if ($user->isAdmin()) return redirect()->route('admin.jadwal.index');
        $ids = $user->scopedEkskulIds();
        $upcoming = Schedule::with(['ekskul', 'room'])->whereIn('ekskul_id', $ids)->whereDate('date', '>=', today())->orderBy('date')->orderBy('start_time')->take(30)->get();
        $past = Schedule::with(['ekskul', 'room'])->whereIn('ekskul_id', $ids)->whereDate('date', '<', today())->orderByDesc('date')->take(10)->get();
        return view('shared.jadwal', compact('upcoming', 'past'));
    }

    /* ----- Kalender terintegrasi ----- */
    public function calendar(Request $request)
    {
        $user = auth()->user();
        try { $cursor = Carbon::createFromFormat('Y-m', (string) $request->query('bulan'))->startOfMonth(); }
        catch (\Throwable $e) { $cursor = now()->startOfMonth(); }
        $ids = $user->scopedEkskulIds();
        $events = Schedule::with('ekskul')->whereIn('ekskul_id', $ids)
            ->whereBetween('date', [$cursor->copy()->startOfMonth(), $cursor->copy()->endOfMonth()])
            ->orderBy('start_time')->get()->groupBy(fn ($s) => $s->date->format('Y-m-d'));
        return view('shared.kalender', [
            'cursor' => $cursor, 'events' => $events, 'offset' => $cursor->dayOfWeekIso - 1,
            'legend' => Ekskul::whereIn('id', $ids)->get(['id', 'name', 'color']),
            'prev' => $cursor->copy()->subMonth()->format('Y-m'), 'next' => $cursor->copy()->addMonth()->format('Y-m'),
        ]);
    }

    /* ----- Pengumuman & Berita ----- */
    public function announcements(Request $request)
    {
        $user = auth()->user();
        $ids = $user->scopedEkskulIds();
        $q = Announcement::with(['author', 'ekskul', 'targets']);

        if (!$user->isAdmin()) {
            $q->where(function ($w) use ($ids, $user) {
                $w->where('type', 'berita')->orWhere(function ($p) use ($ids, $user) {
                    $p->where('type', 'pengumuman')->where(function ($v) use ($ids, $user) {
                        $v->where('is_all', true)
                          ->orWhereHas('targets', fn ($t) => $t->whereIn('ekskuls.id', $ids))
                          ->orWhere('user_id', $user->id);
                    });
                });
            });
        }

        $type = $request->query('jenis');
        $about = $request->query('tentang');
        if (in_array($type, ['pengumuman', 'berita'], true)) $q->where('type', $type);
        if ($about === 'sekolah') {
            $q->where(fn ($w) => $w->where(fn ($x) => $x->where('type', 'berita')->whereNull('ekskul_id'))
                                   ->orWhere(fn ($x) => $x->where('type', 'pengumuman')->where('is_all', true)));
        } elseif ($about) {
            $q->where(fn ($w) => $w->where(fn ($x) => $x->where('type', 'berita')->where('ekskul_id', $about))
                                   ->orWhere(fn ($x) => $x->where('type', 'pengumuman')->whereHas('targets', fn ($t) => $t->where('ekskuls.id', $about))));
        }

        $items = $q->latest()->paginate(10)->withQueryString();
        $ekskuls = $user->isAdmin() ? Ekskul::orderBy('name')->get() : ($user->isPembina() ? $user->ekskulsBina()->orderBy('name')->get() : collect());
        $topics = Ekskul::whereIn('id', $ids)->orderBy('name')->get(['id', 'name']);
        return view('shared.pengumuman', compact('items', 'ekskuls', 'topics', 'type', 'about'));
    }

    public function storeAnnouncement(Request $request)
    {
        $user = auth()->user();
        $type = $request->input('type');
        $rules = ['type' => 'required|in:pengumuman,berita', 'title' => 'required|string|max:150', 'body' => 'required|string'];
        if ($type === 'berita') $rules['about'] = 'required';
        else { $rules['targets'] = 'required|array|min:1'; $rules['targets.*'] = 'required'; }
        $data = $request->validate($rules, [
            'targets.required' => 'Pilih minimal satu tujuan pengumuman.',
            'targets.min' => 'Pilih minimal satu tujuan pengumuman.',
            'about.required' => 'Pilih topik berita (Sekolah atau ekskul).',
        ]);
        $own = $user->scopedEkskulIds();
        $allSiswa = fn () => User::where('role', 'siswa')->where('is_active', true)->get();

        if ($type === 'berita') {
            $ekId = $data['about'] === 'sekolah' ? null : (int) $data['about'];
            if ($ekId === null && !$user->isAdmin()) abort(403);
            if ($ekId !== null && !in_array($ekId, $own, true)) abort(403);
            $a = Announcement::create(['user_id' => $user->id, 'type' => 'berita', 'title' => $data['title'], 'body' => $data['body'], 'ekskul_id' => $ekId, 'is_all' => true]);
            $recipients = $ekId ? Ekskul::find($ekId)->members : $allSiswa();
        } else {
            $isAll = in_array('all', $data['targets'], true);
            if ($isAll && !$user->isAdmin()) abort(403);
            $ids = $isAll ? [] : array_map('intval', array_filter($data['targets'], fn ($t) => $t !== 'all'));
            foreach ($ids as $i) if (!in_array($i, $own, true)) abort(403);
            $a = Announcement::create(['user_id' => $user->id, 'type' => 'pengumuman', 'title' => $data['title'], 'body' => $data['body'], 'ekskul_id' => null, 'is_all' => $isAll]);
            $a->targets()->sync($ids);
            $recipients = $isAll ? $allSiswa()
                : User::whereIn('id', Registration::whereIn('ekskul_id', $ids)->where('status', 'accepted')->pluck('user_id'))->get();
        }
        Notifier::send($recipients->reject(fn ($r) => $r->id === $user->id), ucfirst($a->type) . ' baru: ' . $a->title, Str::limit($a->body, 90), route('pengumuman.index'));
        return back()->with('success', ucfirst($a->type) . ' berhasil diterbitkan.');
    }

    public function destroyAnnouncement(Announcement $announcement)
    {
        $this->authorizeOwner($announcement->user_id);
        $announcement->delete();
        return back()->with('success', 'Data dihapus.');
    }

    /* ----- Galeri / Dokumentasi ----- */
    public function gallery(Request $request)
    {
        $user = auth()->user();
        $ids = $user->scopedEkskulIds();
        $about = $request->query('tentang');
        $q = Gallery::with(['ekskul', 'uploader']);
        if (!$user->isAdmin()) $q->where(fn ($w) => $w->whereNull('ekskul_id')->orWhereIn('ekskul_id', $ids));
        if ($about === 'sekolah') $q->whereNull('ekskul_id');
        elseif ($about) $q->where('ekskul_id', $about);
        $items = $q->latest()->paginate(12)->withQueryString();
        $ekskuls = $user->isAdmin() ? Ekskul::orderBy('name')->get() : ($user->isPembina() ? $user->ekskulsBina()->orderBy('name')->get() : collect());
        $topics = Ekskul::whereIn('id', $ids)->orderBy('name')->get(['id', 'name']);
        return view('shared.galeri', compact('items', 'ekskuls', 'topics', 'about'));
    }

    public function storeGallery(Request $request)
    {
        $user = auth()->user();
        $data = $request->validate([
            'title' => 'required|string|max:150',
            'description' => 'required|string|max:500',
            'about' => 'required',
            'image' => 'required|image|max:4096',
        ], ['about.required' => 'Pilih dokumentasi tentang apa (Sekolah atau ekskul).']);
        $ekId = $data['about'] === 'sekolah' ? null : (int) $data['about'];
        if ($ekId === null && !$user->isAdmin()) abort(403);
        if ($ekId !== null && !in_array($ekId, $user->scopedEkskulIds(), true)) abort(403);
        Gallery::create([
            'user_id' => $user->id, 'ekskul_id' => $ekId, 'title' => $data['title'], 'description' => $data['description'],
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
