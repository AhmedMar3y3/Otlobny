<?php

namespace App\Http\Requests\Api\User\Cart;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class AddToCartRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product_id' => [
                'required',
                Rule::exists('products', 'id')->whereNull('deleted_at'),
            ],
            'quantity' => [
                'required',
                'numeric',
            ],

            'note' => [
                'nullable',
                'string',
            ],
        ];
    }
}
