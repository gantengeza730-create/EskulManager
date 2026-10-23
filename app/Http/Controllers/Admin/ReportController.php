<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Ekskul;
use App\Models\Schedule;
use Illuminate\Http\Request;

/** Laporan kegiatan & rekap presensi seluruh ekskul. */
class ReportController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.laporan', ['rows' => $this->rows(), 'from' => $request->query('dari'), 'to' => $request->query('sampai')]);
    }

    /** Ekspor rekap ke CSV (bisa dibuka di Excel). */
    public function export()
    {
        $rows = $this->rows();
        return response()->streamDownload(function () use ($rows) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF");
            fputcsv($out, ['Ekskul', 'Pembina', 'Anggota', 'Sesi Selesai', 'Catatan Presensi', 'Hadir', 'Kehadiran (%)']);
            foreach ($rows as $r) {
                fputcsv($out, [$r['name'], $r['pembina'], $r['members'], $r['sessions'], $r['records'], $r['hadir'], $r['pct'] ?? '-']);
            }
            fclose($out);
        }, 'rekap-ekskul-' . now()->format('Ymd') . '.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    private function rows()
    {
        return Ekskul::with('pembina')->orderBy('name')->get()->map(function ($e) {
            $att = Attendance::whereHas('schedule', fn ($q) => $q->where('ekskul_id', $e->id))->get();
            $hadir = $att->where('status', 'hadir')->count();
            return [
                'name' => $e->name, 'pembina' => $e->pembina?->name ?? '-', 'members' => $e->memberCount(),
                'sessions' => Schedule::where('ekskul_id', $e->id)->where('status', 'selesai')->count(),
                'records' => $att->count(), 'hadir' => $hadir, 'pct' => $att->count() ? round($hadir / $att->count() * 100) : null,
            ];
        });
    }
}
