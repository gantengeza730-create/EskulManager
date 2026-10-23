<?php

namespace App\Http\Controllers\Pembina;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Schedule;

/** Laporan kegiatan & rekap presensi untuk ekskul binaan. */
class ReportController extends Controller
{
    public function index()
    {
        $ekskuls = auth()->user()->ekskulsBina;
        $report = $ekskuls->map(function ($e) {
            $sessions = Schedule::where('ekskul_id', $e->id)->where('status', 'selesai')->count();
            $att = Attendance::whereHas('schedule', fn ($q) => $q->where('ekskul_id', $e->id))->get();
            $members = $e->members()->orderBy('name')->get()->map(function ($m) use ($att) {
                $mine = $att->where('user_id', $m->id);
                $hadir = $mine->where('status', 'hadir')->count();
                return ['name' => $m->name, 'kelas' => $m->kelas, 'hadir' => $hadir, 'total' => $mine->count(),
                        'pct' => $mine->count() ? round($hadir / $mine->count() * 100) : null];
            });
            return ['ekskul' => $e, 'sessions' => $sessions, 'members' => $members];
        });
        return view('pembina.laporan', compact('report'));
    }
}
