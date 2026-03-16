<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnimalVaccinationRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'animal_id',
        'vaccination_id',
        'vaccinated_at',
        'next_due_date',
    ];

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }

    public function vaccination()
    {
        return $this->belongsTo(Vaccination::class);
    }

    
}
