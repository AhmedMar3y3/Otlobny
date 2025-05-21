<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Admin;
use App\Models\Store;
use App\Models\Delegate;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function dashboard()
    {
        $stores = Store::where('admin_id', auth('admin')->id())->count();
        $code = Admin::where('id', auth('admin')->id())->first()->code;
        $delegates = Delegate::where('is_active', 1)->count();
        $last7DaysStores = collect();
        $adminId = auth('admin')->id();
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->toDateString();
            $storeCount = Store::where('admin_id', $adminId)
            ->whereDate('created_at', $date)
            ->count();
            $last7DaysStores->put($date, $storeCount);
        }

        return view('Admin.dashboard', compact('code', 'delegates', 'stores', 'last7DaysStores'));
    }
}
