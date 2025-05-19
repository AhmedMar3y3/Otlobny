<?php

namespace App\Http\Requests\Api\User\Profile;

use App\Http\Requests\BaseRequest;

class EnableNotificationsRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'fcm_token' => 'required|string',
        ];
    }
}
