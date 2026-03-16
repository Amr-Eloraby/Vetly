<?php

namespace App\Services;

use App\Models\Animal;
use App\Models\Vaccination;
use App\Models\AnimalVaccinationRecord;

class VaccinationService {
    public function getDueVaccinationsForAnimal(Animal $animal) 
    {
        $ageWeeks = $animal->age_in_weeks;

        $vaccinations = Vaccination::where('start_age_weeks', '<=', $ageWeeks)
            ->where('end_age_weeks', '>=', $ageWeeks)
            ->get();

        $dueVaccinations = [];

        foreach ($vaccinations as $v) {
            $lastRecord = $pet->vaccinations()->where('vaccination_id', $v->id)
                ->orderBy('vaccinated_at', 'desc')->first();

            $nextDueDate = null;
            $daysRemaining = null;

            if ($lastRecord) {
                if ($v->is_repeatable) {
                    $nextDueDate = \Carbon\Carbon::parse($lastRecord->pivot->vaccinated_at)
                        ->addWeeks($v->repeat_every_weeks);
                    $daysRemaining = $nextDueDate->diffInDays(now(), false);
                }
            } else {
                if ($v->is_repeatable) {
                    $nextDueDate = now();
                    $daysRemaining = 0;
                }
            }

            $dueVaccinations[] = [
                'vaccination' => $v,
                'last_record' => $lastRecord,
                'next_due_date' => $nextDueDate,
                'days_remaining' => $daysRemaining
            ];
        }

        return $dueVaccinations;
    }

    public function recordVaccination(Animal $animal, Vaccination $vaccination) 
    {
        $nextDue = null;
        if ($vaccination->is_repeatable) {
            $lastRecord = $animal->vaccinations()->where('vaccination_id', $vaccination->id)
                            ->orderBy('vaccinated_at', 'desc')->first();
            $lastDate = $lastRecord ? $lastRecord->pivot->vaccinated_at : now();
            $nextDue = \Carbon\Carbon::parse($lastDate)
                ->addWeeks($vaccination->repeat_every_weeks);
        }
        
        return AnimalVaccinationRecord::create([
            'animal_id' => $animal->id,
            'vaccination_id' => $vaccination->id,
            'vaccinated_at' => now(),
            'next_due_date' => $nextDue
        ]);
    }
}