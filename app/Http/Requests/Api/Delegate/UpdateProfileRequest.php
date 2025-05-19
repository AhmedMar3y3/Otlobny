<?php

namespace App\Http\Requests\Api\Delegate;

use Illuminate\Validation\Rule;
use App\Http\Requests\BaseRequest;

class UpdateProfileRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name'      => [
                'nullable',
                'string',
            ],
            'last_name'      => [
                'nullable',
                'string',
            ],
            'birth_date'      => [
                'nullable',
                'date',
            ],
            'image'      => [
                'nullable',
                'image',
                'mimes:png,jpg,jpeg',
                'max:2048',
            ],
            'email'     => [
                'nullable',
                'email',
                Rule::unique('delegates', 'email')->whereNull('deleted_at'),
            ],
            'phone'     => [
                'nullable',
                'numeric',
                Rule::unique('delegates', 'phone')->whereNull('deleted_at'),
            ]
        ];
    }
}
