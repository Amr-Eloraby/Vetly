<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'total_price' => $this->total_price,
            'status' => $this->status,
            'items' => $this->items->map(function ($item) {
                return [
                    'medicine_id' => $item->medicine_id,
                    'medicine_name' => $item->medicine->name,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                ];
            }),
        ];
    }
}
