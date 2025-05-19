<?php

namespace App\Http\Requests\Store\Product;

use App\Http\Requests\BaseRequest;

class UpdateProductRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'name' =>
            [
                'nullable',
                'string',
            ],
            'image' =>
            [
                'nullable',
                'image',
                'mimes:png,jpg,jpeg',
                'max:2048',
            ],

            'description' =>
            [
                'nullable',
                'string',
            ],
            'price' =>
            [
                'nullable',
                'numeric',
            ],
            'has_discount' =>
            [
                'nullable',
                'boolean',
            ],
            'discount_price' =>
            [
                'required_if:has_discount,1',
                'numeric',
            ],
            'product_category_id' =>
            [
                'nullable',
                'exists:product_categories,id',
            ],
            'has_stock' =>
            [
                'nullable',
                'boolean',
            ],
            'stock' =>
            [
                'required_if:has_stock,1',
                'integer',
            ],

            'is_frequent' =>
            [
                'nullable',
                'boolean',
            ],
        ];
    }
}
