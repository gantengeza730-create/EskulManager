<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    protected $fillable = ['ekskul_id', 'user_id', 'technique', 'discipline', 'teamwork', 'attitude', 'notes', 'assessed_by'];

    public function ekskul() { return $this->belongsTo(Ekskul::class); }
    public function user()   { return $this->belongsTo(User::class); }

    public function average(): int
    {
        return (int) round(($this->technique + $this->discipline + $this->teamwork + $this->attitude) / 4);
    }
}
