<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Ekskul;
use App\Models\Registration;
use App\Support\Notifier;
use Illuminate\Http\Request;

class EkskulController extends Controller
{
    /** Jelajahi semua ekskul + status pendaftaran saya. */
    public function index(Request $request)
    {
        $cat = $request->query('kategori');
        $ekskuls = Ekskul::where('is_active', true)->with('pembina')
            ->when($cat, fn ($q) => $q->where('category', $cat))->orderBy('name')->get();
        $mine = Registration::where('user_id', auth()->id())->pluck('status', 'ekskul_id');
        $categories = Ekskul::where('is_active', true)->distinct()->pluck('category');
        return view('siswa.ekskul', compact('ekskuls', 'mine', 'categories', 'cat'));
    }

    /** Formulir pendaftaran ekstrakurikuler. */
    public function form(Ekskul $ekskul)
    {
        $existing = Registration::where('user_id', auth()->id())->where('ekskul_id', $ekskul->id)->first();
        return view('siswa.ekskul-form', compact('ekskul', 'existing'));
    }

    public function register(Request $request, Ekskul $ekskul)
    {
        $request->validate(['reason' => 'required|string|min:10|max:500', 'agree' => 'accepted']);
        $user = auth()->user();

        abort_unless($ekskul->is_active, 404);

        if (Registration::where('user_id', $user->id)->where('ekskul_id', $ekskul->id)->exists()) {
            return back()->with('error', 'Anda sudah pernah mendaftar ke ekskul ini.');
        }
        if ($ekskul->memberCount() >= $ekskul->quota) {
            return back()->with('error', 'Maaf, kuota ekskul ini sudah penuh.');
        }

        Registration::create(['user_id' => $user->id, 'ekskul_id' => $ekskul->id, 'reason' => $request->reason]);

        if ($ekskul->pembina) {
            Notifier::send($ekskul->pembina, 'Pendaftar baru: ' . $user->name,
                $user->kelas . ' mendaftar ke ' . $ekskul->name, route('pembina.pendaftar.index'));
        }
        return redirect()->route('siswa.ekskul.index')->with('success', 'Pendaftaran ke ' . $ekskul->name . ' terkirim. Tunggu persetujuan pembina.');
    }
}
