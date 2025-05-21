<?php

namespace App\Http\Resources\Api\User\Order\Profile;

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
            'id'            => $this->id,
            'store_id'      => $this->store_id,
            'store_name'    => $this->store->name,
            'store_image'   => $this->store->image,
            'order_num'     => $this->order_num,
            'items_count'   => $this->items->count(),
            'total_price'   => $this->total_price .' '. __('admin.rs'),
            'status'        => __('order.' . $this->status->name),
            'created_at'    => $this->created_at->format('Y-m-d'),
        ];
    }
}
