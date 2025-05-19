<?php

namespace App\Http\Controllers\Store;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Store\Profile\UpdateProfileRequest;
use App\Http\Requests\Store\Profile\ChangePasswordRequest;

class ProfileController extends Controller
{
    public function getProfile()
    {
        $user = Auth::guard('store')->user();
        $categories = Category::all();
        return view('Store.profile', compact('user', 'categories'));
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = Auth::guard('store')->user();
        $user->update($request->validated());
        return redirect()->route('store.profile.index')->with('success', 'تم تحديث الملف الشخصي بنجاح');
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $user = Auth::guard('store')->user();
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->route('store.profile.index')->with('success', 'تم تغيير كلمة المرور بنجاح');
    }
}