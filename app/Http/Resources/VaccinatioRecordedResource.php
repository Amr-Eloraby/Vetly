<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VaccinatioRecordedResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'animal' => $this->animal->name,
            'vaccination' => $this->vaccination->name,
            'vaccinated_at' => $this->vaccinated_at,
            'next_due_date' => $this->next_due_date,
        ];
    }
}
