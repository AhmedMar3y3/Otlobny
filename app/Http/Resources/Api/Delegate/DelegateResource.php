<?php

namespace App\Http\Resources\Api\Delegate;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DelegateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

     private $token;
     public function setToken($token){
         $this->token = $token;
 
         return $this;
     }
    public function toArray(Request $request): array
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'country_code' => $this->country_code,
            'phone' => $this->phone,
            'token' => $this->token ?? "",
        ];
    }
}
