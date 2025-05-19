<?php

namespace App\Services\User\Cart;

use App\Models\Cart;

class DeleteCartService
{
    public function deleteCart($cartId){
        Cart::find($cartId)->delete();
    }

    public function deleteAllCarts($userId){
        Cart::where('user_id', $userId)->delete();
    }
}