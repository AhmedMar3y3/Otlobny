<?php

namespace App\Http\Requests\Api\Delegate;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends BaseRequest
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
            'first_name'   => 'required|string',
            'last_name'    => 'required|string',
            'phone'        => [
                'required',
                'numeric',
                Rule::unique('delegates', 'phone')->whereNull('deleted_at'),
            ],
            'email'        => [
                'required',
                'email',
                Rule::unique('delegates', 'email')->whereNull('deleted_at'),
            ],
            'password'     => 'required|string',
            'admin_code'=> [
                'required',
                'string',
                Rule::exists('admins', 'code'),
            ],
        ];
    }
}
