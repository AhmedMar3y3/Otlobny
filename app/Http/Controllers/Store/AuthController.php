<?php

namespace App\Http\Controllers\Store;

use App\Models\Store;
use App\Models\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Store\Auth\LoginStoreRequest;
use App\Http\Requests\Store\Auth\RegisterStoreRequest;

class AuthController extends Controller
{
    public function loadRegisterPage()
    {
        return view('Store.register');
    }
    public function registerUser(RegisterStoreRequest $request)
    {
        $validatedData = $request->only(['name', 'email', 'password']);
        $admin = Admin::where('code', $request->code)->first();
        if (!$admin) {
            return back()->withErrors(['code' => 'رمز المشرف غير صحيح.'])->withInput();
        }
        Store::create($validatedData + ['admin_id' => $admin->id, 'area' => $admin->area]);
        return redirect()->route('storeloginPage')->with('success', 'تم تسجيل حسابك بنجاح برجاء تسجيل الدخول.');
    }
    public function loadLoginPage()
    {
        return view('Store.login');
    }

    public function loginUser(LoginStoreRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::guard('store')->attempt($credentials)) {
            return redirect()->route('store.dashboard')->with('success', 'تم تسجيل الدخول بنجاح.');
        }

        return back()->withErrors([
            'email' => 'بيانات الاعتماد المقدمة لا تتطابق مع سجلاتنا.',
        ])->withInput();
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('storeloginPage')->with('success', 'تم تسجيل الخروج بنجاح.');
    }
}
