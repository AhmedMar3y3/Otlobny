<?php

namespace App\Http\Requests\Store\Auth;

use App\Http\Requests\BaseRequest;

class RegisterStoreRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:stores,email',
            'password' => 'required|string',
            'code' => 'required|string|exists:admins,code',
        ];
    }
}
