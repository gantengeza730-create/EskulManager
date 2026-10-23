<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = ['user_id', 'ekskul_id', 'type', 'title', 'body'];

    public function author() { return $this->belongsTo(User::class, 'user_id'); }
    public function ekskul() { return $this->belongsTo(Ekskul::class); }
}
