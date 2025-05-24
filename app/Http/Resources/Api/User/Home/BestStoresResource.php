<?php

namespace App\Http\Resources\Api\User\Home;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BestStoresResource extends JsonResource
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
            'is_open' => $this->is_open,
            'name' => $this->name,
            'image' => $this->image,
            'rating' => $this->rating,
            'number_of_ratings' => $this->number_of_ratings,
            'delivery_time_min' => $this->delivery_time_min,
            'delivery_time_max' => $this->delivery_time_max,
             'discount_percentage' => optional(
                $this->products->where('has_discount', 1)->sortByDesc('discount_percentage')->first()
            )->discount_percentage,
        ];
    }
}
