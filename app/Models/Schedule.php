<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = ['ekskul_id', 'room_id', 'title', 'date', 'start_time', 'end_time', 'type', 'status', 'notes'];
    protected $casts = ['date' => 'date'];

    public function ekskul()      { return $this->belongsTo(Ekskul::class); }
    public function room()        { return $this->belongsTo(Room::class); }
    public function attendances() { return $this->hasMany(Attendance::class); }

    public function timeRange(): string
    {
        return substr($this->start_time, 0, 5) . ' – ' . substr($this->end_time, 0, 5);
    }

    public function typeLabel(): string
    {
        return ['latihan' => 'Latihan', 'uji_tanding' => 'Uji Tanding', 'lainnya' => 'Lainnya'][$this->type] ?? $this->type;
    }
}
