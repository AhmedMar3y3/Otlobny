<?php

namespace App\Http\Resources\Api\Delegate;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DelegateOrdersResource extends JsonResource
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
            'order_number' => $this->order_num,
            'items_count'  => $this->items->count(),
            'total_price'  => $this->total_price,
            'created_at'   =>$this->created_at,
            'items' => $this->items->map(function ($item) {
                return [
                    'name' => $item->product->name,
                    'image' => $item->product->image,
                ];
            }),
        ];
    }
}
