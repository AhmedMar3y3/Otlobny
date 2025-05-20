<?php

namespace App\Http\Requests\Super\Admin;

use App\Http\Requests\BaseRequest;

class RegisterAdminRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|string',
            'area' => 'required|string',
        ];
    }
}
