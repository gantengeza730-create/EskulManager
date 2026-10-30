<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ekskul extends Model
{
    protected $fillable = ['name','category','description','requirements','location','schedule_text','quota','color','pembina_id','is_active'];
    protected $casts = ['is_active' => 'boolean'];

    public function pembina()       { return $this->belongsTo(User::class, 'pembina_id'); }
    public function registrations() { return $this->hasMany(Registration::class); }
    public function schedules()     { return $this->hasMany(Schedule::class); }
    public function assessments()   { return $this->hasMany(Assessment::class); }
    public function members()       { return $this->belongsToMany(User::class, 'registrations')->wherePivot('status', 'accepted'); }

    public function memberCount(): int
    {
        return $this->registrations()->where('status', 'accepted')->count();
    }

    /** Ekskul besar = jumlah anggota mencapai batas yang diatur admin (Pengaturan Sekolah). */
    public function isBig(?int $count = null): bool
    {
        $count = $count ?? $this->memberCount();
        return $count >= (int) Setting::get('ekskul_besar_min', 30);
    }

    public function requirementList(): array
    {
        return array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', (string) $this->requirements))));
    }
}
