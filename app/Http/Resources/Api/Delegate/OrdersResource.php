<?php

namespace App\Http\Resources\Api\Delegate;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrdersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'order_num' => $this->order_num,
            'created_at' => $this->created_at,
            'map_desc' => $this->map_desc,
            'status' => $this->status,
        ];
    }
}
