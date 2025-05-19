<?php

namespace App\Http\Requests\Api\User\Cart;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DeleteCartRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'cart_id' => [
                'required',
                Rule::exists('carts', 'id')->where('user_id', auth()->user()->id)
            ]
        ];
    }
}
