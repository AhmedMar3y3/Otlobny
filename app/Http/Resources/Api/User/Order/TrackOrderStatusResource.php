<?php

namespace App\Http\Resources\Api\User\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TrackOrderStatusResource extends JsonResource
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
            'map_desc'     => $this->map_desc,
            'order_num'     => $this->order_num,
            'total_price'   => $this->total_price . ' ' . __('admin.rs'),
            'items'         => OrdersItemsResource::collection($this->items),
            'items_count'   => $this->items->count(),
            'status_num'    => $this->status->value,
            'status_text'   => __('order.' . $this->status->name),
        ];
    }
}
