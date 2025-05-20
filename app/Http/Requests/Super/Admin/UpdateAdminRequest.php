<?php

namespace App\Http\Requests\Super\Admin;

use App\Http\Requests\BaseRequest;

class UpdateAdminRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'name' => 'nullable|string',
            'email' => 'nullable|email|unique:admins,email',
            'password' => 'nullable|string',
        ];
    }
}
