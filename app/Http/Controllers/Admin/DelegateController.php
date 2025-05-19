<?php

namespace App\Http\Controllers\Admin;

use App\Models\Delegate;
use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;

class DelegateController extends Controller
{
    public function index()
    {
        $delegates = Delegate::where('is_active', 1)->get();
        return view('Admin.delegates.index', compact('delegates'));
    }

    public function show($id)
    {
        $delegate = Delegate::find($id);
        return response()->json($delegate);
    }
    public function destroy($id)
    {
        $delegate = Delegate::find($id);
        if ($delegate->orders()->where('status', OrderStatus::SHIPPING->value)->count() > 0) {
            return redirect()->route('admin.delegates.index')->with('error', 'لا يمكن حذف مندوب لديه طلبات في حالة الشحن');
        }
        $delegate->delete();
        return redirect()->route('admin.delegates.index')->with('success', 'تم الحذف بنجاح');
    }
}
