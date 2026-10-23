<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Schedule;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $ids = $user->scopedEkskulIds();

        $att = $user->attendances()->get();
        $attPct = $att->count() ? round($att->where('status', 'hadir')->count() / $att->count() * 100) : null;
        $assessments = $user->assessments()->get();
        $avg = $assessments->count() ? round($assessments->avg(fn ($a) => $a->average())) : null;

        return view('siswa.dashboard', [
            'joined' => $user->joinedEkskuls()->with('pembina')->get(),
            'pending' => $user->registrations()->where('status', 'pending')->with('ekskul')->get(),
            'attPct' => $attPct,
            'avg' => $avg,
            'certCount' => $user->certificates()->count(),
            'upcoming' => Schedule::with(['ekskul', 'room'])->whereIn('ekskul_id', $ids)
                ->whereDate('date', '>=', today())->orderBy('date')->orderBy('start_time')->take(4)->get(),
            'announcements' => Announcement::with('ekskul')
                ->where(fn ($q) => $q->whereNull('ekskul_id')->orWhereIn('ekskul_id', $ids))
                ->latest()->take(3)->get(),
        ]);
    }
}
