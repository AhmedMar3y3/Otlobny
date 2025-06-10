<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Resources\Api\User\Order\TrackOrderStatusResource;
use App\Models\Order;
use App\Models\Address;
use App\Enums\OrderPayTypes;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Services\Order\OrderItemsService;
use App\Services\Order\OrderPricesService;
use App\Http\Resources\Api\User\Order\OrderResource;
use App\Http\Resources\Api\User\Order\OrdersResource;
use App\Http\Requests\Api\User\Order\StoreOrderRequest;

class OrderController extends Controller
{
    use HttpResponses;

    public function store(StoreOrderRequest $request)
    {
        $user = auth()->user();

        if (! $user->carts()->exists()) {
            return $this->failureResponse('السله فارغه');
        }

        try {
            DB::beginTransaction();
            $addressData = $this->getAddressData($request->address_id);

            $prices = (new OrderPricesService())->getOrderPrices($user, $addressData);

            $order = Order::create($addressData + $prices + [
                'user_id' => $user->id,
                'pay_type' => $request->pay_type,
                'store_id' => $user->carts()->first()->product->store_id,
            ]);

            (new OrderItemsService())->createOrderItems($order, $user);

            $payTypeClass = 'App\Services\OrderPayment\\' . OrderPayTypes::from($request->pay_type)->formattedName() . 'PaymentService';

            $response = (new $payTypeClass())->payOrder($order, $user);

            DB::commit();

            return $this->successWithDataResponse($response);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->failureResponse($e->getMessage());
        }
    }

    private function getAddressData($address_id)
    {
        return Address::find($address_id, ['lat', 'lng', 'map_desc', 'title'])->toArray();
    }

    public function orders()
    {
        $orders = auth()->user()->orders;
        $orders->load(['items', 'items.product']);
        return $this->successWithDataResponse(OrdersResource::collection($orders));
    }

    public function showOrder(Order $order)
    {
        $order->load(['items', 'items.product']);
        return $this->successWithDataResponse(new OrderResource($order));
    }

    public function trackOrderStatus(Order $order)
    {
        return $this->successWithDataResponse(new TrackOrderStatusResource($order));
    }

    // public function getOrderLocation(Order $order)
    // {
    //     return $this->successWithDataResponse([
    //         'lat' => $order->delegate()->lat,
    //         'lng' => $order->delegate()->lng,
    //     ]);
    // }
}
