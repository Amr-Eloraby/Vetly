<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'birth_date',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vaccinationRecords()
    {
        return $this->hasMany(AnimalVaccinationRecord::class);
    }

    public function vaccinations()
    {
        return $this->belongsToMany(Vaccination::class, 'animal_vaccination_records', 'animal_id', 'vaccination_id')
            ->withPivot('vaccinated_at', 'next_due_date');
    }   

    public function getAgeInWeeksAttribute()
    {
        return $this->birth_date->diffInWeeks();
    }

    public function getAgeInMonthsAttribute()
    {
        return $this->birth_date->diffInMonths();
    }

    public function getAgeInYearsAttribute()
    {
        return $this->birth_date->diffInYears();
    }
}
