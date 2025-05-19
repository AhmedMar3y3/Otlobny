<?php

namespace App\Http\Requests\Api\Delegate;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class FilterOrdersRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status' => ['nullable', Rule::in(['completed', 'waiting', 'shipping'])],

        ];
    }
}
