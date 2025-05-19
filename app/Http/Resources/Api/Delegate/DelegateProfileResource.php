<?php

namespace App\Http\Resources\Api\Delegate;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DelegateProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'country_code' => $this->country_code,
            'phone' => $this->phone,
            'image' => $this->image,
            'map_desc' => $this->map_desc,
            'birth_date' => $this->birth_date,
        ];
    }
}
