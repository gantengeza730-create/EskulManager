<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = ['user_id', 'ekskul_id', 'title', 'description', 'image_path'];

    public function ekskul() { return $this->belongsTo(Ekskul::class); }
    public function uploader() { return $this->belongsTo(User::class, 'user_id'); }
}
