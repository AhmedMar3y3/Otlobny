<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('store_id', auth('store')->id())->with('products')->paginate(15);
        return view('Store.orders.index', compact('orders'));
    }

    public function show($id)
    {
        return view('Store.orders.show', compact('id'));
    }

    public function assignDelegate(Request $request, $orderId)
    {
        return redirect()->back()->with('success', 'تم تعيين المندوب بنجاح.');
    }
}
