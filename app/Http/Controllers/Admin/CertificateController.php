<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Ekskul;
use App\Support\Notifier;
use Illuminate\Http\Request;

/** Generate piagam/sertifikat keikutsertaan (satu siswa atau seluruh anggota). */
class CertificateController extends Controller
{
    public function index()
    {
        $items = Certificate::with(['user', 'ekskul'])->latest()->paginate(15);
        $ekskuls = Ekskul::with('members')->orderBy('name')->get();
        return view('admin.sertifikat', compact('items', 'ekskuls'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'ekskul_id' => 'required|exists:ekskuls,id',
            'user_id' => 'nullable|exists:users,id',      // kosong = seluruh anggota
            'title' => 'required|string|max:150',
            'issued_at' => 'required|date',
        ]);
        $ekskul = Ekskul::findOrFail($data['ekskul_id']);
        $recipients = $data['user_id']
            ? $ekskul->members()->where('users.id', $data['user_id'])->get()
            : $ekskul->members;

        if ($recipients->isEmpty()) return back()->with('error', 'Tidak ada anggota yang dapat menerima sertifikat.');

        foreach ($recipients as $u) {
            $c = Certificate::create([
                'number' => $this->makeNumber($ekskul),
                'user_id' => $u->id, 'ekskul_id' => $ekskul->id,
                'title' => $data['title'], 'issued_at' => $data['issued_at'],
            ]);
            Notifier::send($u, 'Sertifikat baru diterbitkan', $data['title'] . ' — ' . $ekskul->name, route('sertifikat.cetak', $c));
        }
        return back()->with('success', $recipients->count() . ' sertifikat berhasil diterbitkan.');
    }

    public function destroy(Certificate $certificate)
    {
        $certificate->delete();
        return back()->with('success', 'Sertifikat dihapus.');
    }

    private function makeNumber(Ekskul $ekskul): string
    {
        do {
            $n = sprintf('SRT/%s/%s/%04d', strtoupper(substr(preg_replace('/\W/', '', $ekskul->name), 0, 3)), now()->format('Y'), random_int(1, 9999));
        } while (Certificate::where('number', $n)->exists());
        return $n;
    }
}
