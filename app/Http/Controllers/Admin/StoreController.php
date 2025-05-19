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

        $stores = Store::query()
            ->searchByName($search)
            ->when($status === 'active', function ($query) {
                return $query->where('is_active', true);
            })
            ->when($status === 'inactive', function ($query) {
                return $query->where('is_active', false);
            })
            ->select(['id', 'name', 'rating', 'is_active'])
            ->paginate(15);

        return view('admin.stores.index', compact('stores', 'search', 'status'));
    }

    public function show($id)
    {
        $store = Store::find($id);
        return view('admin.stores.show', compact('store'));
    }

    public function destroy($id)
    {
        $store = Store::findOrFail($id);
        $store->delete();
        return redirect()->back()->with('success', 'تم حذف المتجر بنجاح.');
    }
    public function activate($id)
    {
        $store = Store::findOrFail($id);
        $store->is_active = !$store->is_active;
        $store->save();
        return redirect()->back()->with('success', 'تم تحديث حالة المتجر بنجاح.');
    }
}
