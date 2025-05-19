<?php

namespace App\Http\Requests\Api\User\Auth;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'first_name'   => 'required|string',
            'last_name'    => 'required|string',
            'phone'        => [
                'required',
                'numeric',
                Rule::unique('users', 'phone'),
            ],
            'email'        => [
                'required',
                'email',
                Rule::unique('users', 'email'),
            ],
            'password'     => 'required|string',
        ];
    }
}
