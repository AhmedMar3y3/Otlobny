<?php

namespace App\Http\Requests\admin;

use App\Http\Requests\BaseRequest;

class AssignToDelegateRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'delegate_id' => 'required|exists:delegates,id',
        ];
    }
}
