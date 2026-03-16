<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaccination extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'animal_type',
        'start_age_weeks',
        'end_age_weeks',
        'is_repeatable',
        'repeat_every_weeks',
    ];
}
