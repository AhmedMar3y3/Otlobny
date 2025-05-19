<?php

namespace App\Services\Order;

use App\Models\Order;
use App\Models\Product;
use App\Enums\OrderPayTypes;
use App\Enums\OrderPayStatus;
use Illuminate\Support\Facades\DB;

class ConfirmPaymentOrderService
{
    public function confirmPayment(Order $order)
    {
        if ($order->pay_type->value == OrderPayTypes::ONLINE->value) {
            $order->update([
                'pay_status' => OrderPayStatus::PAIED,
            ]);
        }

        $user = $order->user;
        $carts = $user->carts();

        foreach ($carts as $cart) {
            $product = Product::find($cart->product_id);
            if ($product && $product->has_stock) {
                DB::transaction(function () use ($product, $cart) {
                    $lockedProduct = Product::where('id', $product->id)->lockForUpdate()->first();
                    if ($lockedProduct) {
                        $lockedProduct->decrement('stock', $cart->quantity);
                    }
                });
            }
        }

        $carts->delete();
    }
}
