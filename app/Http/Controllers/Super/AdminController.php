<?php

namespace App\Http\Controllers\Super;

use App\Models\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Super\Admin\RegisterAdminRequest;

class AdminController extends Controller
{
    public function index()
    {
        $admins = Admin::all();
        return view('Super.admins.index', compact('admins'));
    }

    public function store(RegisterAdminRequest $request)
    {
        Admin::create($request->validated());
        return redirect()->back()->with('success', 'تم إنشاء المسؤول بنجاح.');
    }

    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);
        $admin->delete();
        return redirect()->back()->with('success', 'تم حذف المسؤول بنجاح.');
    }
}
