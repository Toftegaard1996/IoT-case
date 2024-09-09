<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingsRequest;
use App\Models\OfficeRooms;
use App\Models\Settings;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SettingsController extends Controller
{
    public function index()
    {
        return Inertia::render('Settings/Index', [
            'settings' => Settings::orderBy('roomName')->all(),
            'rooms' => OfficeRooms::all()->unique('roomName'),
        ]);

//        return response()->json($settings);
    }

    public function show($id)
    {
        $setting = Settings::find($id);
        if ($setting) {
            return response()->json($setting);
        } else {
            return response()->json(['message' => 'Setting not found'], 404);
        }
    }

    public function create()
    {

    }

    public function store(SettingsRequest $request)
    {
        $setting = Settings::create([
            'roomName' => $request->input('roomName'),
            'interval' => $request->input('interval'),
            'maxTemp' => $request->input('maxTemp'),
            'minTEmp' => $request->input('minTemp'),
            'startHour' => $request->input('startHour'),
            'endHour' => $request->input('endHour')
        ]);
        return response()->json($setting, 201);
    }

    public function edit()
    {

    }

    public function update(Request $request, Settings $settings)
    {
        $settings->update([
            'roomName' => $request->input('roomName'),
            'interval' => $request->input('interval'),
            'maxTemp' => $request->input('maxTemp'),
            'minTEmp' => $request->input('minTemp'),
            'startHour' => $request->input('startHour'),
            'endHour' => $request->input('endHour')
        ]);
        return response()->json($settings, 201);
    }

    public function destroy()
    {

    }
}
