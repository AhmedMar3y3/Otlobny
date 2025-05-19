<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Delegate;
use App\Enums\OrderPayTypes;
use App\Enums\OrderPayStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\admin\AssignToDelegateRequest;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'delegate'])
            ->where(function ($query) {
                $query->where('pay_type', OrderPayTypes::ONLINE->value)->where('pay_status', OrderPayStatus::PAIED->value);
            })
            ->orWhere('pay_type', OrderPayTypes::CASH->value)
            ->orderBy('status', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $delegates = Delegate::where('is_active', true)->get();

        return view("Store.orders.index", compact("orders", "delegates"));
    }

    public function show($id)
    {
        $order = Order::with([
            'items',
            'items.product',
            'items.additions',
            'user:id,first_name,last_name,phone,image',
            'delegate:id,first_name,last_name,phone,image'
        ])->findOrFail($id);

        return view("Admin.orders.show", compact("order"));
    }

    public function assignDelegate(AssignToDelegateRequest $request, Order $order)
    {
        $order->update([
            'delegate_id' => $request->delegate_id,
        ]);

        return redirect()->back()->with('success', 'تم تعيين المندوب بنجاح');
    }
}
