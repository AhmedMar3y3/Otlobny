<?php

namespace App\Http\Resources\Api\User\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'order_num'     => $this->order_num,
            'items_count'   => $this->items->count(),
            'total_price'   => $this->total_price .' '. __('admin.rs'),
            'items'         => OrderItemsResource::collection($this->items),
            'created_at'    => $this->created_at->format('Y-m-d'),
        ];
    }
}
