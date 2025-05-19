<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Addition;
use App\Models\Delegate;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Store;

class HomeController extends Controller
{
    public function dashboard()
    {
        $users = User::count();
        $orders = Order::count();
        $products = Product::count();
        $additions = Store::count();
        $code = Admin::where('id', auth('admin')->id())->first()->code;
        $delegates = Delegate::where('is_active', 1)->count();
        $last7DaysUsers = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->toDateString();
            $userCount = User::whereDate('created_at', $date)->count();
            $last7DaysUsers->put($date, $userCount);
        }

        

        return view('Admin.dashboard', compact('products', 'code', 'delegates', 'users', 'orders', 'additions', 'last7DaysUsers'));
    }
}
