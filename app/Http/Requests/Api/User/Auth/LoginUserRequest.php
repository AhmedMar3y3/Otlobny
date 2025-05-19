<?php

namespace App\Http\Requests\Api\User\Auth;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class LoginUserRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'email',
                Rule::exists('users', 'email'),
            ],
            'password' => ['required', 'string'],
        ];
    }
}
