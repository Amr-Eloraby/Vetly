<?php

namespace App\Services;

use App\Models\Animal;
use App\Models\Vaccination;
use App\Models\AnimalVaccinationRecord;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class VaccinationService {
    public function getAnimalAgeWeeks($birthDate)
    {
        return Carbon::parse($birthDate)->diffInWeeks(now());
    }
    

    public function getAvailableVaccines($animalId)
    {
        $user = Auth::user();
        $animal = Animal::where('user_id', $user->id)->findOrFail($animalId);

        $ageWeeks = $this->getAnimalAgeWeeks($animal->birth_date);

        return Vaccination::where('animal_type', $animal->type)
            ->where('start_age_weeks', '<=', $ageWeeks)
            ->where('end_age_weeks', '>=', $ageWeeks)
            ->get();
    }

    public function takeVaccine($animalId, $vaccineId)
    {
        $user = Auth::user();
        $animal = Animal::where('user_id', $user->id)->findOrFail($animalId);
        $vaccine = Vaccination::findOrFail($vaccineId);

        $exists = AnimalVaccinationRecord::where('animal_id', $animalId)
            ->where('vaccination_id', $vaccineId)
            ->exists();

        if ($exists && !$vaccine->is_repeatable) {
            return [
                'status' => 400,
                'message' => 'Vaccine already taken',
                'data' => null
            ];
        }

        $nextDate = null;

        if ($vaccine->is_repeatable) {
            $nextDate = Carbon::parse(now()->addWeeks($vaccine->repeat_every_weeks))->format('Y-m-d');
        }

        AnimalVaccinationRecord::create([
            'animal_id' => $animalId,
            'vaccination_id' => $vaccineId,
            'vaccinated_at' => now(),
            'next_due_date' => $nextDate
        ]);

        $data = [
            'animal' => $animal->name,
            'vaccine' => $vaccine->name,
            'vaccinated_date' => now()->format('Y-m-d'),
            'next_due_date' => $nextDate
        ];

        return [
            'status' => 200,
            'message' => 'Vaccine taken successfully',
            'data' => $data
        ];
    }

    public function getUpcomingVaccines($animalId)
    {
        $user = Auth::user();
        $animal = Animal::where('user_id', $user->id)->findOrFail($animalId);
        $upcomingVaccines = AnimalVaccinationRecord::where('animal_id', $animalId)
            ->whereNotNull('next_due_date')
            ->get();

        return $upcomingVaccines;
    }
}