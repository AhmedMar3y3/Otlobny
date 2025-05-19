<?php

namespace App\Http\Requests\admin\Category;

use App\Http\Requests\BaseRequest;

class StoreCategoryRequest extends BaseRequest
{
    public function rules(): array
    {
        
        return [
            'name'   =>
            [
                'required',
                'string',
                'max:255'
            ],

            'image' => [
                'required',
                'image',
                'mimes:jpeg,png,jpg,gif|max:5000',
            ],
        ];
    }
}
