<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $fillable = ['user_id','ekskul_id','reason','status','reject_reason','decided_at'];
    protected $casts = ['decided_at' => 'datetime'];

    public function user()   { return $this->belongsTo(User::class); }
    public function ekskul() { return $this->belongsTo(Ekskul::class); }
}
