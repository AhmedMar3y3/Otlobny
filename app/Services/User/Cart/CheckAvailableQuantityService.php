<?php

namespace App\Services\User\Cart;

use App\Models\Product;


class CheckAvailableQuantityService
{
    public function checkAvailability(Product $product, int $quantity)
    {
       // dd($product);
        if (!$product->has_stock) {
            return true;
        }
        return $product->quantity >= $quantity;
    }
}