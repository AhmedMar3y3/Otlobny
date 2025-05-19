<?php

namespace App\Services\OrderPayment;

use App\Interface\PayOrderInterface;
use App\Services\Order\ConfirmPaymentOrderService;

class CashPaymentService implements PayOrderInterface
{
    public function payOrder($order){
        (new ConfirmPaymentOrderService())->confirmPayment($order);

        return [
            'redirect_url' => null,
        ];
    }
}