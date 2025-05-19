<?php

namespace App\Http\Requests\Api\User\Order;

use App\Enums\OrderPayTypes;
use Illuminate\Validation\Rule;
use App\Http\Requests\BaseRequest;

class StoreOrderRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $validPayTypes = array_column(OrderPayTypes::cases(), 'value');

        return [
            'address_id' => [
                'required',
                Rule::exists('addresses', 'id')->where('user_id', auth()->user()->id),
            ],
            'pay_type' => [
                'required',
                'in:' . implode(',', $validPayTypes),
            ]
        ];
    }
}
