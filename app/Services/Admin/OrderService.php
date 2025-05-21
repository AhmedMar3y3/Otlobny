<?php

namespace App\Services\Admin;

use App\Models\Order;
use App\Models\Store;
use App\Enums\OrderPayTypes;
use App\Enums\OrderPayStatus;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    public function getFilteredOrders($status = null)
    {
        $adminId = Auth::guard('admin')->id();
        $storeIds = Store::where('admin_id', $adminId)->pluck('id');

        $query = Order::with(['user', 'delegate'])
            ->whereIn('store_id', $storeIds)
            ->where(function ($query) {
                $query->where(function ($q) {
                    $q->where('pay_type', OrderPayTypes::ONLINE->value)
                        ->where('pay_status', OrderPayStatus::PAIED->value);
                })->orWhere('pay_type', OrderPayTypes::CASH->value);
            });

        if ($status !== null) {
            $query->where('status', $status);
        }

        return $query->orderBy('status', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
    }
}
