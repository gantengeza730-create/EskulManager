<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = ['ekskul_id','room_id','title','date','start_time','end_time','type','status','is_fixed','series','notes'];
    protected $casts = ['date' => 'date', 'is_fixed' => 'boolean'];

    public function ekskul()      { return $this->belongsTo(Ekskul::class); }
    public function room()        { return $this->belongsTo(Room::class); }
    public function attendances() { return $this->hasMany(Attendance::class); }

    /**
     * Sesi yang SUDAH berlangsung: tidak dibatalkan dan (ditandai selesai / tanggalnya sudah lewat /
     * hari ini dan jamnya sudah berakhir). Jadwal tetap yang belum tiba tidak ikut terhitung.
     */
    public function scopeHeld($q)
    {
        return $q->where('status', '!=', 'dibatalkan')->where(function ($w) {
            $w->where('status', 'selesai')
              ->orWhereDate('date', '<', today())
              ->orWhere(fn ($x) => $x->whereDate('date', today())->whereTime('end_time', '<=', now()->format('H:i:s')));
        });
    }

    public function isHeld(): bool
    {
        if ($this->status === 'dibatalkan') return false;
        return $this->status === 'selesai'
            || $this->date->lt(today())
            || ($this->date->isToday() && substr((string) $this->end_time, 0, 8) <= now()->format('H:i:s'));
    }

    /** Status yang ditampilkan: jadwal yang waktunya sudah lewat otomatis "selesai". */
    public function displayStatus(): string
    {
        if ($this->status === 'dibatalkan') return 'dibatalkan';
        return $this->isHeld() ? 'selesai' : 'terjadwal';
    }

    public function timeRange(): string
    {
        return substr($this->start_time, 0, 5) . ' – ' . substr($this->end_time, 0, 5);
    }

    public function typeLabel(): string
    {
        return ['latihan' => 'Latihan', 'uji_tanding' => 'Uji Tanding', 'lainnya' => 'Lainnya'][$this->type] ?? $this->type;
    }
}
