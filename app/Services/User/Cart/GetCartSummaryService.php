<?php

namespace App\Services\User\Cart;

use App\Models\Cart;
use App\Models\Store;
use App\Models\Setting;
use App\Http\Resources\Api\User\Cart\CartItemsResource;

class GetCartSummaryService
{
    public function getCartSummary($user)
    {
        $items = $this->getCartItemsSummary($user);

        return [
            'cart_items'    => CartItemsResource::collection($items),
            'cart_prices'   => $this->getCartPricesSummary($items),
            'currency'      => 'ج.م',
        ];
    }

    public function getCartPricesSummary($items)
    {
        if ($items->isEmpty()) {
            return [
                'price'            => 0,
                'delivery_price'   => 0,
                'total_price'      => 0,
            ];
        }

        $totalPrice = $items->sum(function ($cartItem) {
            return $cartItem->product->priceAfterDiscount * $cartItem->quantity;
        });

        $storeId = $items->first()->product->store_id;
        $store = Store::select('id', 'lat', 'lng')->find($storeId);

        $user = auth()->user();

        $distanceService = new DistanceCalculatorService();
        $distance = $distanceService->calculateDistance($user->lat, $user->lng, $store->lat, $store->lng);
        $deliveryPricePerKm = Setting::where('key', 'delivery_price_per_km')->value('value');
        $deliveryPrice = $distance * $deliveryPricePerKm;

        return [
            'price'            => $totalPrice,
            'delivery_price'   => round((float)$deliveryPrice, 2),
            'total_price'      => round((float)($totalPrice + $deliveryPrice), 2),
        ];
    }

    public function getCartItemsSummary($user)
    {
        return Cart::with([
                'product:id,name,image,price,has_discount,discount_price,store_id'])
            ->where('user_id', $user->id)
            ->get();
    }
}