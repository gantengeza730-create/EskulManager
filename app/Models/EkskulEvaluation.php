<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EkskulEvaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_id',
        'user_id',
        'ekskul_id',
        'score',
        'notes',
        'evaluation_date',
    ];

    protected $casts = [
        'evaluation_date' => 'date',
    ];

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ekskul()
    {
        return $this->belongsTo(Ekskul::class);
    }
}
