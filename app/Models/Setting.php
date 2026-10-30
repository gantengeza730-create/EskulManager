<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** Pengaturan sekolah (nama sekolah, kepala sekolah, logo, dll) disimpan sebagai key-value. */
class Setting extends Model
{
    protected $fillable = ['key', 'value'];
    protected static ?array $cache = null;

    public static function get(string $key, $default = null)
    {
        if (self::$cache === null) {
            try { self::$cache = self::query()->pluck('value', 'key')->all(); }
            catch (\Throwable $e) { self::$cache = []; }
        }
        $v = self::$cache[$key] ?? null;
        return ($v === null || $v === '') ? $default : $v;
    }

    public static function put(array $pairs): void
    {
        foreach ($pairs as $k => $v) self::updateOrCreate(['key' => $k], ['value' => $v]);
        self::$cache = null;
    }
}
