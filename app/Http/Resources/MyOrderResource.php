<?php

namespace App\Http\Resources;

use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MyOrderResource extends JsonResource
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
            'created_at' => $this->created_at->format('Y/m/d h:i A'),
            'total_price' => $this->total_price,
            'items' =>$this->items->map(function ($item) {
                return [
                    'name' => $item->medicine->name,
                    'price' => $item->medicine->price,
                    'quantity' => $item->quantity,
                    'image' => ImageService::url($item->medicine->image),
                    'total_price' => $item->medicine->price * $item->quantity,
                ];
            }),
        ];
    }
}
