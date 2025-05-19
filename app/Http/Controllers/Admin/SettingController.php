<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use App\Http\Controllers\Controller;
use App\Http\Requests\admin\UpdateSettingRequest;

class SettingController extends Controller
{
    public function index()
    {
        $data = Setting::pluck('value', 'key');
        return view('Admin.settings.index', compact('data'));
    }

    public function update(UpdateSettingRequest $request)
    {
        foreach ($request->validated() as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
        return redirect()->route('admin.settings.index')->with('success', 'تم تحديث الإعدادات بنجاح.');
    }
}
