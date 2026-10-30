<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $fillable = ['number','user_id','ekskul_id','title','issued_at'];
    protected $casts = ['issued_at' => 'date'];
    public function user()   { return $this->belongsTo(User::class); }
    public function ekskul() { return $this->belongsTo(Ekskul::class); }
}
