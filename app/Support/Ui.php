<?php

namespace App\Support;

/** Fungsi kecil untuk membantu tampilan di Blade. */
class Ui
{
    public static function level(?int $v): string   { return $v === null ? '' : ($v >= 85 ? 'ok' : ($v >= 70 ? 'mid' : 'low')); }

    public static function bar(?int $v): string
    {
        if ($v === null) return '';
        return '<div class="bar"><span class="' . self::level($v) . '" style="width:' . max(0, min(100, $v)) . '%"></span></div>';
    }

    public static function statusBadge(string $s): string
    {
        $map = ['hadir' => 'b-ok', 'izin' => 'b-warn', 'sakit' => 'b-info', 'alpha' => 'b-bad',
                'accepted' => 'b-ok', 'pending' => 'b-warn', 'rejected' => 'b-bad',
                'terjadwal' => 'b-info', 'selesai' => 'b-ok', 'dibatalkan' => 'b-bad'];
        $label = ['accepted' => 'Diterima', 'pending' => 'Menunggu', 'rejected' => 'Ditolak'][$s] ?? ucfirst($s);
        return '<span class="b ' . ($map[$s] ?? 'b-info') . '">' . e($label) . '</span>';
    }
}
