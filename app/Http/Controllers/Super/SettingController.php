<?php

namespace App\Http\Controllers\Super;

use App\Models\Setting;
use App\Http\Controllers\Controller;
use App\Http\Requests\admin\UpdateSettingRequest;

class SettingController extends Controller
{
    public function index()
    {
        $data = Setting::pluck('value', 'key');
        return view('Super.settings.index', compact('data'));
    }

    public function update(UpdateSettingRequest $request)
    {
        foreach ($request->validated() as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
        return redirect()->route('super.settings.index')->with('success', 'تم تحديث الإعدادات بنجاح.');
    }
}
