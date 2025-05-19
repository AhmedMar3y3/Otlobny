<?php

namespace App\Services\Order;

use App\Services\User\Cart\GetCartSummaryService;

class OrderPricesService
{
    public function getOrderPrices($user){
        $cartSummary = new GetCartSummaryService();
        
        $items = $cartSummary->getCartItemsSummary($user);

        return $cartSummary->getCartPricesSummary($items);
    }
}