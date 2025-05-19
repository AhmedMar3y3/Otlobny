<?php

namespace App\Http\Requests\Api\User\ResetPassword;

use Illuminate\Validation\Rule;
use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'code'      => [
                'required',
                'numeric',
            ],
            'email'     => [
                'required',
                'email',
                Rule::exists('users', 'email')->whereNull('deleted_at'),
            ],
            'password'  => [
                'required',
                'string',
                'confirmed',
            ],
        ];
    }
}
