<?php

namespace App\Http\Requests\Store\Auth;

use App\Http\Requests\BaseRequest;

class LoginStoreRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:stores,email',
            'password' => 'required|string',
        ];
    }
}
