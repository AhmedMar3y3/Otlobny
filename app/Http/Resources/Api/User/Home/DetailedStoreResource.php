<?php

namespace App\Http\Resources\Api\User\Home;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailedStoreResource extends JsonResource
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
            'categories_names' => $this->productCategories
                ? $this->productCategories
                ->filter(function ($category) {
                    return $category->products && $category->products->count() > 0;
                })
                ->take(3)
                ->pluck('title')
                ->toArray()
                : [],
            'categories' => $this->productCategories
                ? $this->productCategories
                ->filter(function ($category) {
                    return $category->products && $category->products->count() > 0;
                })
                ->map(function ($category) {
                    return [
                        'category_id' => $category->id,
                        'category_title' => $category->title,
                    ];
                })
                ->values()
                ->toArray()
                : [],
        ];
    }
}
