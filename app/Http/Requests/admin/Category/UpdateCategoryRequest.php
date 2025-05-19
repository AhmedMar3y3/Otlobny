<?php

namespace App\Http\Requests\admin\Category;

use App\Http\Requests\BaseRequest;

class UpdateCategoryRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'name'   =>
            [
                'nullable',
                'string',
                'max:255'
            ],
            'image'   =>
            [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif,svg',
                'max:5000'
            ],
        ];
    }
}
