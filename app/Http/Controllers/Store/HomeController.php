<?php

namespace App\Http\Controllers\Store;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function stats()
    {
        $orders = Order::where('store_id', Auth::guard('store')->id())
            ->count();
        $products = Product::where('store_id', Auth::guard('store')->id())->count();
        $categories = ProductCategory::where('store_id', Auth::guard('store')->id())->count();
        $last7DaysOrders = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->toDateString();
            $orderCount = Order::whereDate('created_at', $date)
                ->where('store_id', Auth::guard('store')->id())
                ->count();
            $last7DaysOrders->put($date, $orderCount);
        }

        $recentOrders = Order::where('store_id', Auth::guard('store')->id())
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        return view('Store.dashboard', compact('products', 'categories', 'orders', 'last7DaysOrders', 'recentOrders'));
    }

    public function toggleOpenClose()
    {
        $store = Auth::guard('store')->user();
        $store->is_open = !$store->is_open;
        $store->save();
        return redirect()->back()->with('success', 'تم تحديث حالة المتجر بنجاح.');
    }
}
