<?php

namespace App\Http\Requests\admin;

use App\Http\Requests\BaseRequest;

class login extends BaseRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:admins,email',
            'password' => 'required|string',
        ];
    }
}
