<?php

namespace App\Http\Requests\Api\User\Cart;

use Illuminate\Validation\Rule;
use App\Http\Requests\BaseRequest;

class UpdateCartRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'cart_id' => [
                'required',
                Rule::exists('carts', 'id'),
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
