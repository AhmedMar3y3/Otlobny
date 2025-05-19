<?php

namespace App\Observers;

use App\Models\Store;
use App\Models\Review;

class StoreRatingObserver
{
    public function created(Review $review)
    {
        $this->updateStoreRating($review->store_id);
    }

    // public function deleted(Review $review)
    // {
    //     $this->updateStoreRating($review->store_id);
    // }

    protected function updateStoreRating($storeId)
    {
        $store = Store::find($storeId);
        if ($store) {
            $averageRating = Review::where('store_id', $store->id)->avg('rating');
            $store->rating = $averageRating ? round($averageRating, 2) : null;
            $store->increment('number_of_ratings');
            $store->save();
        }
    }
}
