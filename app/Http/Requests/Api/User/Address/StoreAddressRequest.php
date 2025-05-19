<?php

namespace App\Http\Requests\Api\User\Address;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddressRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'    =>
            [
                'required',
                'string',
            ],
            'lat'      =>
            [
                'required',
                'string'
            ],
            'lng'      =>
            [
                'required',
                'string'
            ],
            'map_desc' =>
            [
                'required',
                'string'
            ],
        ];
    }
}
