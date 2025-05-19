<?php

namespace App\Http\Requests\Store\Category;

use App\Http\Requests\BaseRequest;

class StoreCategoryRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'title'   =>
            [
                'required',
                'string',
                'max:255'
            ],
        ];
    }
}
