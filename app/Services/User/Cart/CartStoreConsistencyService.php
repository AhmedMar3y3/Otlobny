<?php

namespace App\Services\User\Cart;

use App\Models\Cart;

class CartStoreConsistencyService
{
    public function canAddProductToCart($userId, $productStoreId)
    {
        if (!Cart::where('user_id', $userId)->exists()) {
            return true;
        }

        $firstCartItemStoreId = Cart::where('user_id', $userId)
            ->join('products', 'carts.product_id', '=', 'products.id')
            ->value('products.store_id');

        if ($firstCartItemStoreId !== $productStoreId) {
            throw new \Exception('لا يمكن إضافة منتجات من متاجر مختلفة إلى السلة');
        }

        return true;
    }
}