<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Delegate;
use App\Enums\OrderStatus;
use Illuminate\Http\Request;
use App\Services\Admin\OrderService;
use App\Http\Controllers\Controller;
use App\Http\Requests\admin\AssignToDelegateRequest;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index(Request $request)
    {
        $status = $request->query('status');
        if ($status !== null && $status !== '') {
            $status = (int) $status;
            $enumStatus = OrderStatus::tryFrom($status);
            if ($enumStatus === null) {
                $status = null;
            }
        } else {
            $status = null;
        }

        $orders = $this->orderService->getFilteredOrders($status);

        $delegates = Delegate::where('is_active', true)->get();

        return view("Admin.orders.index", compact("orders", "delegates", "status"));
    }

    public function show($id)
    {
        $order = Order::with([
            'items',
            'items.product',
            'user:id,first_name,last_name,phone,image',
            'delegate:id,first_name,last_name,phone,image',
            'store.category'
        ])->findOrFail($id);

        $adminId = auth('admin')->id();
        if ($order->store->admin_id !== $adminId) {
            abort(403, 'Unauthorized');
        }

        return view("Admin.orders.show", compact("order"));
    }

    public function assignDelegate(AssignToDelegateRequest $request, Order $order)
    {
        $order->update($request->validated());
        return redirect()->back()->with('success', 'تم تعيين المندوب بنجاح');
    }
}