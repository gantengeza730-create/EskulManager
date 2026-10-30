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
        $ekskuls = Ekskul::where('is_active', true)->with('pembina')
            ->withCount(['registrations as members_count' => fn ($q) => $q->where('status', 'accepted')])
            ->orderBy('name')->get();
        return view('landing', [
            'ekskuls' => $ekskuls,
            'stats' => [
                'ekskul' => $ekskuls->count(),
                'siswa' => Registration::where('status', 'accepted')->distinct('user_id')->count('user_id'),
                'pembina' => User::where('role', 'pembina')->count(),
            ],
            'berita' => Announcement::with('ekskul')->where('type', 'berita')->latest()->take(9)->get(),
            'galeri' => Gallery::with('ekskul')->latest()->take(8)->get(),
        ]);
    }

    public function show(Ekskul $ekskul)
    {
        $ekskul->load('pembina');
        $members = auth()->check() ? $ekskul->members()->orderBy('name')->get() : collect();
        $myReg = auth()->check() && auth()->user()->isSiswa()
            ? Registration::where('user_id', auth()->id())->where('ekskul_id', $ekskul->id)->first() : null;
        return view('ekskul.show', compact('ekskul', 'members', 'myReg'));
    }
}
