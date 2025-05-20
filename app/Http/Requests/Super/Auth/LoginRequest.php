<?php

namespace App\Http\Requests\Super\Auth;

use App\Http\Requests\BaseRequest;

class LoginRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:supers,email',
            'password' => 'required|string',
        ];
    }
}
