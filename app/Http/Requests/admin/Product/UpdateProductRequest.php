<?php

namespace App\Http\Requests\admin\Product;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;


class UpdateProductRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
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
            'recipe' => 
            [
                'nullable',
                 'string',
            ],
            'quantity' => 
            [
                'nullable',
                 'numeric',
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

            'can_apply_prize' => 
            [
                'nullable',
                 'boolean',
            ],
            'points' => 
            [
                'nullable',
                 'numeric',
            ],
            'category_id' => 
            [
                'nullable',
                 'numeric',
                 Rule::exists('categories', 'id'),

            ],
            'sub_category_id' => 
            [
                'nullable',
                 'numeric',
                Rule::exists('categories', 'id'),
            ],
        ];
    }
}
