<?php

namespace App\Http\Requests\Store\Profile;

use App\Http\Requests\BaseRequest;
use Illuminate\Support\Facades\Auth;

class UpdateProfileRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
        
            'name' => [
                'nullable',
                'string',
            ],
            'email' => [
                'nullable',
                'email',
                'unique:stores,email,' . Auth::guard('store')->id(),
            ],
            'image' => [
                'nullable',
                'image',
                'mimes:png,jpg,jpeg',
                'max:5000',
            ],

            'category_id' => [
                'nullable',
                'exists:categories,id',
            ],
            'delivery_time_min' => [
                'nullable',
                'numeric',
            ],
            'delivery_time_max' => [
                'nullable',
                'numeric',
            ],

            'lng' => [
                'nullable',
                'numeric',
            ],
            'lat' => [
                'nullable',
                'numeric',
            ],
            'whatsapp' => [
                'nullable',
                'string',
                'max:15'
            ],
        ];
    }
}
