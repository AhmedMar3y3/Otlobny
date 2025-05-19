<?php

namespace App\Http\Requests\admin\Product;

use App\Http\Requests\BaseRequest;

class StoreProductRequest extends BaseRequest
{
    public function rules(): array
    {
        
        return [
            'name' => 
            [
                'required',
                 'string',
            ],
            'image' => 
            [
                'required',
                'image',
                'mimes:png,jpg,jpeg',
                'max:5000',
            ],

            'description' => 
            [
                'nullable',
                 'string',
            ],
            'price' => 
            [
                'required',
                 'numeric',
            ],
            'has_discount' => 
            [
                'required',
                 'boolean',
            ],
            'discount_price' => 
            [
                'required_if:has_discount,1',
                 'numeric',
            ],
            'product_category_id' => 
            [
                'required',
                'exists:product_categories,id',
            ],
            
        ];
    }
}