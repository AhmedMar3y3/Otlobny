<?php

namespace App\Http\Controllers\Admin;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StoreController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $status = $request->query('status');
        $adminId = auth('admin')->id();

        $stores = Store::query()
            ->where('admin_id', $adminId)
            ->searchByName($search)
            ->when($status === 'active', function ($query) {
                return $query->where('is_active', true);
            })
            ->when($status === 'inactive', function ($query) {
                return $query->where('is_active', false);
            })
            ->select(['id', 'name', 'rating', 'is_active'])
            ->paginate(15);

        return view('Admin.stores.index', compact('stores', 'search', 'status'));
    }

    public function show($id)
    {
        $store = Store::findOrFail($id);
        if($store->admin_id != auth('admin')->id()){
            return redirect()->back()->with('error', 'لا يمكنك عرض هذا المتجر.');
        }
        return view('Admin.stores.show', compact('store'));
    }

    public function activate($id)
    {
        $store = Store::findOrFail($id);
        $store->is_active = !$store->is_active;
        $store->save();
        return redirect()->back()->with('success', 'تم تحديث حالة المتجر بنجاح.');
    }
}
