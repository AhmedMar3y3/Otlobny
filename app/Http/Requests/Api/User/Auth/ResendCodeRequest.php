<?php

namespace App\Http\Requests\Api\User\Auth;

use Illuminate\Validation\Rule;
use App\Http\Requests\BaseRequest;

class ResendCodeRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'phone' => [
                'required',
                'numeric',
                Rule::exists('users', 'phone')->whereNull('deleted_at')],
        ];
    }
}
