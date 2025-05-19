<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class LocationRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'lat'      => 'required|string',
            'lng'      => 'required|string',
            'map_desc' => 'required|string',
        ];
    }
}
