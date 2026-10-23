<?php

namespace App\Http\Controllers\Pembina;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Registration;
use App\Models\Schedule;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $ekskuls = $user->ekskulsBina()->withCount(['registrations as members_count' => fn ($q) => $q->where('status', 'accepted')])->get();
        $ids = $ekskuls->pluck('id');

        $attAll = Attendance::whereHas('schedule', fn ($q) => $q->whereIn('ekskul_id', $ids))->get();
        $attPct = $attAll->count() ? round($attAll->where('status', 'hadir')->count() / $attAll->count() * 100) : null;

        return view('pembina.dashboard', [
            'ekskuls' => $ekskuls,
            'totalMembers' => $ekskuls->sum('members_count'),
            'pendingCount' => Registration::whereIn('ekskul_id', $ids)->where('status', 'pending')->count(),
            'attPct' => $attPct,
            'upcoming' => Schedule::with(['ekskul', 'room'])->whereIn('ekskul_id', $ids)
                ->whereDate('date', '>=', today())->orderBy('date')->orderBy('start_time')->take(5)->get(),
            'pendingList' => Registration::with(['user', 'ekskul'])->whereIn('ekskul_id', $ids)
                ->where('status', 'pending')->latest()->take(5)->get(),
        ]);
    }
}
