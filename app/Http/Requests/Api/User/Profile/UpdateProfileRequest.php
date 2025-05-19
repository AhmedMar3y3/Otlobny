<?php

namespace App\Http\Requests\Api\User\Profile;

use Illuminate\Validation\Rule;
use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

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
                Rule::unique('users', 'email'),
            ],
            'phone'     => [
                'nullable',
                'numeric',
                Rule::unique('users', 'phone'),
            ],
            'lng'      => [
                'nullable',
                'numeric',
            ],
            'lat'      => [
                'nullable',
                'numeric',
            ],
            'map_desc'      => [
                'nullable',
                'string',
            ],
        ];
    }
}
