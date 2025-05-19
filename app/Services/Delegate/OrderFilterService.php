<?php

namespace App\Services\Delegate;

use App\Models\Order;
use App\Enums\OrderStatus;
use Illuminate\Support\Collection;

class OrderFilterService
{
    public function filterOrdersForDelegate($delegate, ?string $status = null): Collection
    {
        $query = Order::where('delegate_id', $delegate->id)
            ->select('id', 'order_num', 'created_at', 'map_desc', 'status');

        if ($status) {
            $enum = match ($status) {
                'completed' => OrderStatus::DELIVERED->value,
                'waiting' => OrderStatus::WAITING->value,
                'shipping' => OrderStatus::SHIPPING->value,
            };
            $query->where('status', $enum);
        }

        return $query->get();
    }
}
