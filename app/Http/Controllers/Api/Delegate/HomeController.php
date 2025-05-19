<?php

namespace App\Http\Controllers\Api\Delegate;

use App\Enums\OrderStatus;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Delegate\NewOrdersResource;

class HomeController extends Controller
{
    use HttpResponses;

    public function newOrders()
    {
        //TODO : ask about the date and the show details in the design
        $orders = auth('delegate')->user()->orders()->where('status', OrderStatus::WAITING->value)->with('orderDetails')->get();
        return $this->successWithDataResponse(NewOrdersResource::collection($orders));
    }

    public function stats()
    {
        //TODO : ask about the filter in the stats in te design
        $delegate = auth('delegate')->user();

        $statistics = [
            'total_orders' => $delegate->orders()->count(),
            'delivered_orders' => $delegate->orders()->where('status', OrderStatus::DELIVERED->value)->count(),
            'rejected_orders' => $delegate->rejectedOrders()->count(),
            'waiting_orders' => $delegate->orders()->where('status', OrderStatus::WAITING->value)->count(),
        ];

        return $this->successWithDataResponse($statistics);
    }
}
