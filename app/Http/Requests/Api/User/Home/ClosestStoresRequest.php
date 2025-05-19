<?php

namespace App\Http\Requests\Api\User\Home;

use App\Http\Requests\BaseRequest;

class ClosestStoresRequest extends BaseRequest
{
public function rules()
    {
        return [
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ];
    }
}
