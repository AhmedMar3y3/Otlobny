<?php

namespace App\Http\Resources\Api\User\Cart;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemsResource extends JsonResource
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
            'product_name'  => $this->product->name,
            'product_image' => $this->product->image,
            'quantity'      => $this->quantity,
            'price'         => $this->product->price * $this->quantity,
            'note'         => $this->note ?? 'لا يوجد ملاحظات',
        ];
    }
}
