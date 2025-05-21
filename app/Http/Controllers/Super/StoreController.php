<?php

namespace App\Http\Controllers\Super;

use App\Models\Store;
use App\Models\Admin;
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
            ->with('admin') // Include the admin relationship
            ->select(['id', 'name', 'rating', 'is_active', 'admin_id'])
            ->paginate(15);

        $admins = Admin::select(['id', 'name', 'area'])->get();

        return view('Super.stores.index', compact('stores', 'search', 'status', 'admins'));
    }

    public function show($id)
    {
        $store = Store::findOrFail($id);
        return view('Super.stores.show', compact('store'));
    }

    public function destroy($id)
    {
        $store = Store::findOrFail($id);
        $store->delete();
        return redirect()->back()->with('success', 'تم حذف المتجر بنجاح.');
    }

    public function changeAdmin(Request $request, $id)
    {
        $request->validate([
            'admin_id' => 'required|exists:admins,id',
        ]);

        $store = Store::findOrFail($id);
        $store->admin_id = $request->input('admin_id');
        $store->area = Admin::findOrFail($request->input('admin_id'))->area;
        $store->save();
        return redirect()->back()->with('success', 'تم تغيير المسؤول بنجاح.');
    }
}