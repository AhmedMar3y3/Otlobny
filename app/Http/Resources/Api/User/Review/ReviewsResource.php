<?php

namespace App\Http\Resources\Api\User\Review;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       return [
                'rating' => $this->rating,
                'number_of_ratings' => $this->number_of_ratings,
                'reviews' => $this->reviews->map(function ($review) {
                    return [
                        'id' => $review->id,
                        'user_name' => $review->user->first_name . ' ' . $review->user->last_name,
                        'user_image' => $review->user->image,
                        'rating' => $review->rating,
                        'review' => $review->review,
                        'created_from' => $review->created_at->diffForHumans(),
                    ];
                }),
            ];
    }
}
