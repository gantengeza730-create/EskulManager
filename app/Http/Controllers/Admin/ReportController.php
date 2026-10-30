<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Ekskul;
use App\Models\Schedule;
use App\Support\ReportRange;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        [$from, $to, $label, $key] = ReportRange::resolve($request);
        return view('admin.laporan', ['rows' => $this->rows($from, $to), 'label' => $label, 'key' => $key, 'from' => $from, 'to' => $to]);
    }

    public function export(Request $request)
    {
        [$from, $to, $label] = ReportRange::resolve($request);
        $rows = $this->rows($from, $to);
        return response()->streamDownload(function () use ($rows, $label) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF");
            fputcsv($out, ['Periode', $label]);
            fputcsv($out, ['Ekskul', 'Pembina', 'Anggota', 'Sesi Berlangsung', 'Catatan Presensi', 'Hadir', 'Kehadiran (%)']);
            foreach ($rows as $r) fputcsv($out, [$r['name'], $r['pembina'], $r['members'], $r['sessions'], $r['records'], $r['hadir'], $r['pct'] ?? '-']);
            fclose($out);
        }, 'rekap-ekskul-' . now()->format('Ymd') . '.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    private function rows($from, $to)
    {
        return Ekskul::with('pembina')->orderBy('name')->get()->map(function ($e) use ($from, $to) {
            $att = Attendance::whereHas('schedule', fn ($q) => $q->where('ekskul_id', $e->id)->whereBetween('date', [$from, $to]))->get();
            $hadir = $att->where('status', 'hadir')->count();
            return [
                'name' => $e->name, 'pembina' => $e->pembina?->name ?? '-', 'members' => $e->memberCount(),
                // hanya sesi yang sudah berlangsung dalam rentang (bukan seluruh jadwal tetap)
                'sessions' => Schedule::where('ekskul_id', $e->id)->held()->whereBetween('date', [$from, $to])->count(),
                'records' => $att->count(), 'hadir' => $hadir, 'pct' => $att->count() ? round($hadir / $att->count() * 100) : null,
            ];
        });
    }
}
