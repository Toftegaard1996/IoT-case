<?php

namespace App\Http\Controllers;
use App\Models\DeviceSetting;
use Illuminate\Http\Request;
class DeviceSettingController extends Controller
{
    public function index()
    {
        $settings = DeviceSetting::all();
        return response()->json($settings);
    }
    public function show($id)
    {
        $setting = DeviceSetting::find($id);
        if ($setting) {
            return response()->json($setting);
        } else {
            return response()->json(['message' => 'Setting not found'], 404);
        }
    }
    public function store(Request $request)
    {
        $setting = DeviceSetting::create($request->all());
        return response()->json($setting, 201);
    }

    public function update(Request $request, $id)
    {
        $setting = DeviceSetting::find($id);
        if ($setting) {
            $setting->update($request->all());
            return response()->json($setting);
        } else {
            return response()->json(['message' => 'Setting not found'], 404);
        }
    }
    public function destroy($id)
    {
        $setting = DeviceSetting::find($id);
        if ($setting) {
            $setting->delete();
            return response()->json(['message' => 'Setting deleted']);
        } else {
            return response()->json(['message' => 'Setting not found'], 404);
        }
    }
}
