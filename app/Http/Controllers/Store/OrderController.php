<?php

namespace App\Http\Controllers\Store;

use App\Models\Order;
use App\Http\Controllers\Controller;
use App\Enums\OrderStatus;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $query = Order::where('store_id', auth('store')->id())->with('items');

        if ($status !== null && $status !== '') {
            $enumStatus = OrderStatus::tryFrom((int) $status);
            if ($enumStatus !== null) {
                $query->where('status', $enumStatus->value);
            }
        }
        $orders = $query->orderBy('created_at', 'desc')->paginate(15);
        $statuses = OrderStatus::cases();

        return view('Store.orders.index', compact('orders', 'status', 'statuses'));
    }

    public function show($id)
    {
        $order = Order::with([
            'items',
            'items.product',
            'delegate:id,first_name,last_name,phone,image'
        ])->findOrFail($id);
        return view('Store.orders.show', compact('order'));
    }

    public function markAsWaiting($id)
    {
        $order = Order::where('store_id', auth('store')->id())->findOrFail($id);

        if ($order->status !== OrderStatus::PREPARING) {
            return redirect()->back()->with('error', 'يمكن تحديث الطلب إلى "في انتظار التوصيل" فقط إذا كان في حالة "قيد التحضير".');
        }

        $order->status = OrderStatus::WAITING;
        $order->save();

        return redirect()->back()->with('success', 'تم تحديث حالة الطلب إلى "في انتظار التوصيل" بنجاح.');
    }
}
