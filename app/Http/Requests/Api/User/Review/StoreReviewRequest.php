<?php

namespace App\Http\Requests\Api\User\Review;

use App\Http\Requests\BaseRequest;

class StoreReviewRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'store_id' => 'required|exists:stores,id',
            'rating' => 'required|integer|in:1,2,3,4,5',
            'review' => 'nullable|string|max:2000',
        ];
    }
}
