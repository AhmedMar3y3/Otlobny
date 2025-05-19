<?php

namespace App\Services\Order;

use App\Services\User\Cart\GetCartSummaryService;

class OrderItemsService
{
    public function createOrderItems($order, $user)
    {
        $items = (new GetCartSummaryService())->getCartItemsSummary($user);

        foreach ($items as $item) {
            $order->items()->create([
                'product_id'    => $item->product_id,
                'quantity'      => $item->quantity,
                'product_price' => $item->product->priceAfterDiscount,
                'total_price'   => $item->item_price,
            ]);
        }
    }
}
