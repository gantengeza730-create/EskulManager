<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ekskul extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'coach',
        'description',
        'image',
    ];

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function evaluations()
    {
        return $this->hasMany(EkskulEvaluation::class);
    }
}
