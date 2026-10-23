<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Ekskul;
use App\Models\Gallery;
use App\Models\Registration;
use App\Models\User;

class LandingController extends Controller
{
    public function home()
    {
        return view('landing', [
            'ekskuls' => Ekskul::where('is_active', true)->with('pembina')->get(),
            'stats' => [
                'ekskul' => Ekskul::where('is_active', true)->count(),
                'siswa' => Registration::where('status', 'accepted')->distinct('user_id')->count('user_id'),
                'pembina' => User::where('role', 'pembina')->count(),
            ],
            'berita' => Announcement::where('type', 'berita')->latest()->take(3)->get(),
            'galeri' => Gallery::latest()->take(4)->get(),
        ]);
    }

    /** Halaman detail ekskul: Info, Syarat, Anggota. */
    public function show(Ekskul $ekskul)
    {
        $ekskul->load('pembina');
        $members = auth()->check() ? $ekskul->members()->orderBy('name')->get() : collect();
        $myReg = auth()->check() && auth()->user()->isSiswa()
            ? Registration::where('user_id', auth()->id())->where('ekskul_id', $ekskul->id)->first()
            : null;
        return view('ekskul.show', compact('ekskul', 'members', 'myReg'));
    }
}
