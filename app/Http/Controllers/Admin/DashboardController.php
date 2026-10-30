<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Attendance;
use App\Models\Certificate;
use App\Models\Ekskul;
use App\Models\Registration;
use App\Models\Schedule;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $popularity = Ekskul::withCount(['registrations as members_count' => fn ($q) => $q->where('status', 'accepted')])->orderByDesc('members_count')->take(6)->get();
        $att = Attendance::count();
        return view('admin.dashboard', [
            'stats' => [
                'siswa' => User::where('role', 'siswa')->count(),
                'ekskul' => Ekskul::where('is_active', true)->count(),
                'pembina' => User::where('role', 'pembina')->count(),
                'sertifikat' => Certificate::count(),
                'attPct' => $att ? round(Attendance::where('status', 'hadir')->count() / $att * 100) : null,
            ],
            'popularity' => $popularity,
            'maxMembers' => max(1, $popularity->max('members_count')),
            'recent' => Registration::with(['user', 'ekskul'])->latest()->take(6)->get(),
            'upcoming' => Schedule::with(['ekskul', 'room'])->whereDate('date', '>=', today())->orderBy('date')->orderBy('start_time')->take(5)->get(),
            // berita & pengumuman tampil di dashboard admin
            'news' => Announcement::with(['ekskul'])->where('type', 'berita')->latest()->take(4)->get(),
            'notices' => Announcement::with(['targets'])->where('type', 'pengumuman')->latest()->take(4)->get(),
        ]);
    }
}
