<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;

/** Riwayat presensi, nilai, dan sertifikat milik siswa yang login. */
class RecordController extends Controller
{
    public function attendance()
    {
        $rows = auth()->user()->attendances()->with('schedule.ekskul')->get()
            ->sortByDesc(fn ($a) => $a->schedule->date);
        $summary = [
            'hadir' => $rows->where('status', 'hadir')->count(),
            'izin' => $rows->where('status', 'izin')->count(),
            'sakit' => $rows->where('status', 'sakit')->count(),
            'alpha' => $rows->where('status', 'alpha')->count(),
        ];
        $pct = $rows->count() ? round($summary['hadir'] / $rows->count() * 100) : null;
        return view('siswa.presensi', compact('rows', 'summary', 'pct'));
    }

    public function assessments()
    {
        $items = auth()->user()->assessments()->with('ekskul')->get();
        return view('siswa.nilai', compact('items'));
    }

    public function certificates()
    {
        $items = auth()->user()->certificates()->with('ekskul')->latest('issued_at')->get();
        return view('siswa.sertifikat', compact('items'));
    }
}
