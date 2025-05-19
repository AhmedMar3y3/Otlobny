<?php

namespace App\Http\Requests\admin;

use App\Http\Requests\BaseRequest;

class store extends BaseRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ];
    }
}
