<?php

namespace App\Http\Controllers\Pembina;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Schedule;
use App\Support\ReportRange;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        [$from, $to, $label, $key] = ReportRange::resolve($request);
        $report = auth()->user()->ekskulsBina->map(function ($e) use ($from, $to) {
            // hanya sesi yang SUDAH berlangsung dalam rentang (jadwal tetap yang belum tiba tidak dihitung)
            $sessions = Schedule::where('ekskul_id', $e->id)->held()->whereBetween('date', [$from, $to])->count();
            $att = Attendance::whereHas('schedule', fn ($q) => $q->where('ekskul_id', $e->id)->whereBetween('date', [$from, $to]))->get();
            $members = $e->members()->orderBy('name')->get()->map(function ($m) use ($att) {
                $mine = $att->where('user_id', $m->id);
                $hadir = $mine->where('status', 'hadir')->count();
                return ['name' => $m->name, 'kelas' => $m->kelas, 'hadir' => $hadir, 'izin' => $mine->whereIn('status', ['izin', 'sakit'])->count(),
                        'alpha' => $mine->where('status', 'alpha')->count(), 'total' => $mine->count(),
                        'pct' => $mine->count() ? round($hadir / $mine->count() * 100) : null];
            });
            return ['ekskul' => $e, 'sessions' => $sessions, 'members' => $members];
        });
        return view('pembina.laporan', compact('report', 'label', 'key', 'from', 'to'));
    }
}
