<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VaccinationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'animal_type' => $this->animal_type,
            'is_repeatable' => $this->is_repeatable ? 'Yes' : 'No',
            'repeat_every' => $this->repeat_every_weeks,
        ];
    }
}
