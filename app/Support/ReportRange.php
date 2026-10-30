<?php

namespace App\Support;

use Carbon\Carbon;
use Illuminate\Http\Request;

/** Rentang tanggal untuk filter laporan: hari ini s.d. 1 bulan, atau tanggal bebas. */
class ReportRange
{
    public const PRESETS = ['hari' => 'Hari ini', '7' => '7 hari', '14' => '14 hari', '30' => '1 bulan terakhir', 'bulan' => 'Bulan ini'];

    /** @return array{0:Carbon,1:Carbon,2:string,3:string} dari, sampai, label, kunci */
    public static function resolve(Request $r): array
    {
        $today = today();
        if ($r->filled('dari') && $r->filled('sampai')) {
            try {
                $from = Carbon::parse($r->query('dari'))->startOfDay();
                $to = Carbon::parse($r->query('sampai'))->endOfDay();
                if ($from->gt($to)) [$from, $to] = [$to->copy()->startOfDay(), $from->copy()->endOfDay()];
                return [$from, $to, $from->translatedFormat('d M Y') . ' – ' . $to->translatedFormat('d M Y'), 'custom'];
            } catch (\Throwable $e) { /* pakai bawaan */ }
        }
        $key = $r->query('rentang', '30');
        switch ($key) {
            case 'hari':  $from = $today->copy(); break;
            case '7':     $from = $today->copy()->subDays(6); break;
            case '14':    $from = $today->copy()->subDays(13); break;
            case 'bulan': $from = $today->copy()->startOfMonth(); break;
            default:      $key = '30'; $from = $today->copy()->subDays(29);
        }
        $to = $today->copy();
        return [$from->startOfDay(), $to->endOfDay(), self::PRESETS[$key] . ' (' . $from->translatedFormat('d M') . ' – ' . $to->translatedFormat('d M Y') . ')', $key];
    }
}
