<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Http\Requests\admin\store;
use App\Http\Requests\admin\login;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //API
    public function register(store $request)
    {
        if (Admin::exists()) {
            return response()->json(['error' => 'المسؤول موجود بالفعل'], 403);
        }
        $admin = Admin::create($request->validated());
        return response()->json($admin, 201);
    }

    //WEB
    public function loadLoginPage()
    {
        return view('Admin.login');
    }

    public function loginUser(login $request)
    {
        $credentials = $request->validated();
        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('admin.dashboard')->with('success', 'تم تسجيل الدخول بنجاح');
        }
        return back()->withErrors(['error' => 'خطأ في كلمة المرور او المستخدم'])->withInput();
    }


    public function logout()
    {
        Auth::logout();
        return redirect()->route('loginPage')->with('success', 'تم تسجيل الخروج بنجاح');
    }
}
