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

    public function generateSchedule($animalId)
    {
        $user = Auth::user();
        $animal = Animal::where('user_id', $user->id)->findOrFail($animalId);
        $ageWeeks = $this->getAnimalAgeWeeks($animal->birth_date);
        $vaccines = Vaccination::where('animal_type', $animal->type)->get();
        $records = AnimalVaccinationRecord::where('animal_id', $animalId)
            ->get()
            ->groupBy('vaccination_id');
        $schedule = [];
        foreach ($vaccines as $vaccine) {
            $record = $records->get($vaccine->id)?->last();
            $item = [
                'id' => $vaccine->id,
                'vaccine' => $vaccine->name,
                'age_range' => $vaccine->start_age_weeks . ' → ' . $vaccine->end_age_weeks . ' weeks',
            ];
            if ($record) {
                $item['status'] = 'done';
                $item['date'] = Carbon::parse($record->vaccinated_at)->format('d M Y');
                if ($record->next_due_date) {

                    if (Carbon::parse($record->next_due_date)->isFuture()) {
                        $schedule[] = [
                            'vaccine' => $vaccine->name,
                            'status' => 'upcoming',
                            'age_range' => $item['age_range'],
                            'date' => Carbon::parse($record->next_due_date)->format('d M Y'),
                        ];
                    }
                    if (Carbon::parse($record->next_due_date)->isPast()) {
                        $schedule[] = [
                            'vaccine' => $vaccine->name,
                            'status' => 'missed',
                            'age_range' => $item['age_range'],
                            'date' => Carbon::parse($record->next_due_date)->format('d M Y'),
                        ];
                    }
                }
            } else {
                if ($ageWeeks > $vaccine->end_age_weeks) {
                    $item['status'] = 'missed';
                } elseif ($ageWeeks >= $vaccine->start_age_weeks && $ageWeeks <= $vaccine->end_age_weeks) {
                    $item['status'] = 'available';
                } else {
                    $item['status'] = 'upcoming';
                }
            }
            $schedule[] = $item;
        }
        return collect($schedule)->sortByDesc(function ($item) {
            return $item['status'] === 'done';
        })->values();
    }

    public function getUserAnimalsWithVaccines()
    {
        $user = Auth::user();
        $animals = Animal::where('user_id', $user->id)->get();

        $data = [];

        foreach ($animals as $animal) {

            // مهم جدًا reset هنا
            $schedule = [];

            // هات التطعيمات حسب نوع الحيوان الحالي
            $vaccines = Vaccination::where('animal_type', $animal->type)->get();

            $ageWeeks = Carbon::parse($animal->birth_date)->diffInWeeks(now());

            $records = AnimalVaccinationRecord::where('animal_id', $animal->id)
                ->get()
                ->groupBy('vaccination_id');

            foreach ($vaccines as $vaccine) {

                $record = $records->get($vaccine->id)?->last();

                $item = [
                    'vaccine_id' => $vaccine->id,
                    'vaccine' => $vaccine->name,
                    'age_range' => $vaccine->start_age_weeks . ' → ' . $vaccine->end_age_weeks . ' weeks',
                ];

                if ($record) {

                    $item['status'] = 'done';
                    $item['date'] = Carbon::parse($record->vaccinated_at)->format('d M Y');

                    if ($record->next_due_date) {
                        $nextDate = Carbon::parse($record->next_due_date);

                        $item['next_status'] = $nextDate->isFuture() ? 'upcoming' : 'missed';
                        $item['next_date'] = $nextDate->format('d M Y');
                    }

                } else {

                    if ($ageWeeks > $vaccine->end_age_weeks) {
                        $item['status'] = 'missed';
                    } elseif ($ageWeeks >= $vaccine->start_age_weeks) {
                        $item['status'] = 'available';
                    } else {
                        $item['status'] = 'upcoming';
                    }
                }

                $schedule[] = $item;
            }

            $data[] = [
                'animal_id' => $animal->id,
                'animal_name' => $animal->name,
                'animal_type' => $animal->type,
                'vaccines' => $schedule
            ];
        }

        return $data;
    }
    
    public function takeVaccine($animalId, $vaccineId, $date)
    {
        $user = Auth::user();
        $animal = Animal::where('user_id', $user->id)->findOrFail($animalId);
        $vaccinatedAt = $date;
        $nextDate = null;
        $vaccine = Vaccination::findOrFail($vaccineId);
        if ($vaccine->is_repeatable) {
            $nextDate = Carbon::parse($vaccinatedAt)->addWeeks($vaccine->repeat_every_weeks)->format('Y-m-d');
        }
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
        $vaccineRecord = AnimalVaccinationRecord::where('animal_id', $animalId)
            ->where('vaccination_id', $vaccineId)
            ->first();
        if($vaccineRecord) {
            return [
                'status' => 400,
                'message' => 'Vaccine is already added',
                'data' => null
            ];
        }
        AnimalVaccinationRecord::create([
            'animal_id' => $animalId,
            'vaccination_id' => $vaccineId,
            'vaccinated_at' => $vaccinatedAt,
            'next_due_date' => $nextDate
        ]);
        $data = [
            'animal' => $animal->name,
            'vaccine' => $vaccine->name,
            'vaccinated_date' => $vaccinatedAt,
            'next_due_date' => $nextDate
        ];

        return [
            'status' => 200,
            'message' => 'Vaccine taken successfully',
            'data' => $data
        ];
    }

    public function makeAsDone($animalId, $vaccineId , $date)
    {
        $user = Auth::user();
        $vaccine = Vaccination::where('id', $vaccineId)->first();
        if(!$vaccine) {
            return [
                'status' => 404,
                'message' => 'Vaccine not found',
                'data' => null
            ];
        }
        AnimalVaccinationRecord::create([
            'animal_id' => $animalId,
            'vaccination_id' => $vaccineId,
            'vaccinated_at' => Carbon::parse($date),
            'next_due_date' => Carbon::parse($date)->addWeeks($vaccine->repeat_every_weeks)
        ]);
        $vaccine->status = 'done';
    }
}