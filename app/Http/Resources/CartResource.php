<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
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
            'items' => [
                'medicine' => $this->items->map(function ($item) {
                    return [
                        'id' => $item->medicine_id,
                        'name' => $item->medicine->name,
                        'price' => $item->medicine->price,
                        'quantity' => $item->quantity,
                    ];
                }),
                'total_price' => $this->items->sum(function ($item) {
                    return $item->medicine->price * $item->quantity;
                }),
            ],
        ];
    }
}
