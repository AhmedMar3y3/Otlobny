<?php

namespace App\Services\User\Cart;

use App\Models\Cart;

class AddUpdateCartService
{
    public function addToCart(array $validated,$userId,$productId){
        return  Cart::updateOrCreate([
            'user_id'       => $userId,
            'product_id'    => $productId,
        ],$validated);
    }
}
