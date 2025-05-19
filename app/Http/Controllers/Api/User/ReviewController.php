<?php

namespace App\Http\Controllers\Api\User;

use App\Models\Review;
use App\Models\Store;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\User\Review\ReviewsResource;
use App\Http\Requests\Api\User\Review\StoreReviewRequest;

class ReviewController extends Controller
{
    use HttpResponses;
    public function addReview(StoreReviewRequest $request)
    {
        Review::create($request->validated() + ['user_id' => auth()->id()]);
        return $this->successResponse('تم إضافة التقييم بنجاح');
    }

    public function getStoreReviews($storeId)
    {
        $store = Store::with([
            'reviews' => function ($query) {
                $query->whereHasReview()->with('user')->paginate(10);
            }
        ])->findOrFail($storeId);

        return $this->successWithDataResponse(new ReviewsResource($store));
    }
}
