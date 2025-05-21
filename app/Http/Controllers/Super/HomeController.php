<?php

namespace App\Http\Controllers\Super;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Admin;
use App\Models\Super;
use App\Models\Store;
use App\Models\Delegate;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function dashboard()
    {
        $users = User::count();
        $orders = Order::count();
        $code = Super::where('id', auth('super')->id())->first()->code;
        $stores = Store::count();
        $admins = Admin::count();
        $delegates = Delegate::where('is_active', 1)->count();
        $last7DaysUsers = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->toDateString();
            $userCount = User::whereDate('created_at', $date)->count();
            $last7DaysUsers->put($date, $userCount);
        }

        return view('Super.dashboard', compact('code', 'admins', 'delegates', 'users', 'orders', 'stores', 'last7DaysUsers'));
    }
}
