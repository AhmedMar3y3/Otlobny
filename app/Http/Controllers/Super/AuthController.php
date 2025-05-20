<?php

namespace App\Http\Controllers\Super;

use App\Models\Super;
use App\Http\Requests\admin\store;
use App\Http\Controllers\Controller;
use App\Http\Requests\Super\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //API
    public function register(store $request)
    {
        if (Super::exists()) {
            return response()->json(['error' => 'المسؤول موجود بالفعل'], 403);
        }
        $admin = Super::create($request->validated());
        return response()->json($admin, 201);
    }

    //WEB
    public function loadLoginPage()
    {
        return view('Super.login');
    }

    public function loginUser(LoginRequest $request)
    {
        $credentials = $request->validated();
        if (Auth::guard('super')->attempt($credentials)) {
            return redirect()->route('super.dashboard')->with('success', 'تم تسجيل الدخول بنجاح');
        }
        return back()->withErrors(['error' => 'خطأ في كلمة المرور او المستخدم'])->withInput();
    }


    public function logout()
    {
        Auth::logout();
        return redirect()->route('superLoginPage')->with('success', 'تم تسجيل الخروج بنجاح');
    }
}
