<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = ['user_id','ekskul_id','type','title','body','is_all'];
    protected $casts = ['is_all' => 'boolean'];

    public function author()  { return $this->belongsTo(User::class, 'user_id'); }
    public function ekskul()  { return $this->belongsTo(Ekskul::class); }                 // topik berita
    public function targets() { return $this->belongsToMany(Ekskul::class, 'announcement_ekskul'); } // tujuan pengumuman

    /** Berita: "tentang apa". Pengumuman: "ditujukan untuk siapa". */
    public function aboutLabel(): string
    {
        if ($this->type === 'berita') return $this->ekskul?->name ?? 'Sekolah';
        return $this->is_all ? 'Seluruh sekolah' : $this->targets->pluck('name')->join(', ');
    }
}
