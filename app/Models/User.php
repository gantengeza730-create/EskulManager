<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'nis', 'kelas', 'phone',
        'is_active', 'verification_code', 'email_verified_at',
    ];

    protected $hidden = ['password', 'remember_token', 'verification_code'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function isAdmin(): bool   { return $this->role === 'admin'; }
    public function isPembina(): bool { return $this->role === 'pembina'; }
    public function isSiswa(): bool   { return $this->role === 'siswa'; }

    public function initials(): string
    {
        $p = preg_split('/\s+/', trim($this->name));
        return strtoupper(substr($p[0], 0, 1) . (isset($p[1]) ? substr($p[1], 0, 1) : ''));
    }

    public function roleLabel(): string
    {
        return ['admin' => 'Admin', 'pembina' => 'Pembina Ekskul', 'siswa' => 'Siswa'][$this->role] ?? $this->role;
    }

    // Ekskul yang dibina (untuk pembina)
    public function ekskulsBina() { return $this->hasMany(Ekskul::class, 'pembina_id'); }

    public function registrations() { return $this->hasMany(Registration::class); }

    // Ekskul yang sudah diterima (untuk siswa)
    public function joinedEkskuls()
    {
        return $this->belongsToMany(Ekskul::class, 'registrations')->wherePivot('status', 'accepted');
    }

    public function attendances()  { return $this->hasMany(Attendance::class); }
    public function assessments()  { return $this->hasMany(Assessment::class); }
    public function certificates() { return $this->hasMany(Certificate::class); }
    public function appNotifications() { return $this->hasMany(AppNotification::class)->latest(); }

    public function unreadCount(): int
    {
        return $this->hasMany(AppNotification::class)->whereNull('read_at')->count();
    }

    /** ID ekskul yang boleh dilihat user ini (admin: semua, pembina: binaan, siswa: yang diikuti). */
    public function scopedEkskulIds(): array
    {
        if ($this->isAdmin())   return Ekskul::pluck('id')->all();
        if ($this->isPembina()) return $this->ekskulsBina()->pluck('id')->all();
        return $this->joinedEkskuls()->pluck('ekskuls.id')->all();
    }
}
