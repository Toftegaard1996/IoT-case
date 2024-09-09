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
            'settings' => Settings::all(),
            'rooms' => OfficeRooms::all()->unique('roomName'),
        ]);
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
        // Implementation if needed
    }

    public function store(SettingsRequest $request)
    {
        $setting = Settings::create([
            'roomName' => $request->input('roomName'),
            'interval' => $request->input('interval'),
            'maxTemp' => $request->input('maxTemp'),
            'minTemp' => $request->input('minTemp'),
            'startHour' => $request->input('startHour'),
            'endHour' => $request->input('endHour')
        ]);
        return response()->json($setting, 201);
    }

    public function edit()
    {
        // Implementation if needed
    }

    public function updateByRoomName(Request $request, $roomName)
    {
        // Find the setting by roomName
        $setting = Settings::where('roomName', $roomName)->first();

        // Check if the setting exists
        if (!$setting) {
            return response()->json(['message' => 'Setting not found'], 404);
        }

        // Update the setting with new data from the request
        $setting->update([
            'interval' => $request->input('interval'),
            'maxTemp' => $request->input('maxTemp'),
            'minTemp' => $request->input('minTemp'),
            'startHour' => $request->input('startHour'),
            'endHour' => $request->input('endHour')
        ]);

        // Return the updated setting
        return response()->json($setting, 200);
    }

    public function destroy($id)
    {
        $setting = Settings::find($id);
        if ($setting) {
            $setting->delete();
            return response()->json(['message' => 'Setting deleted'], 200);
        } else {
            return response()->json(['message' => 'Setting not found'], 404);
        }
    }

    public function getSettings()
    {
        $settings = Settings::all();
        if ($settings->isNotEmpty()) {
            return response()->json($settings);
        } else {
            return response()->json(['message' => 'No settings found'], 404);
        }
    }
}



// namespace App\Http\Controllers;

// use App\Http\Requests\SettingsRequest;
// use App\Models\OfficeRooms;
// use App\Models\Settings;
// use Illuminate\Http\Request;
// use Inertia\Inertia;

// class SettingsController extends Controller
// {
//     public function index()
//     {
//         return Inertia::render('Settings/Index', [
//             'settings' => Settings::all(),
//             'rooms' => OfficeRooms::all()->unique('roomName'),
//         ]);

// //        return response()->json($settings);
//     }

//     public function show($id)
//     {
//         $setting = Settings::find($id);
//         if ($setting) {
//             return response()->json($setting);
//         } else {
//             return response()->json(['message' => 'Setting not found'], 404);
//         }
//     }

//     public function create()
//     {

//     }

//     public function store(SettingsRequest $request)
//     {
//         $setting = Settings::create([
//             'roomName' => $request->input('roomName'),
//             'interval' => $request->input('interval'),
//             'maxTemp' => $request->input('maxTemp'),
//             'minTEmp' => $request->input('minTemp'),
//             'startHour' => $request->input('startHour'),
//             'endHour' => $request->input('endHour')
//         ]);
//         return response()->json($setting, 201);
//     }

//     public function edit()
//     {

//     }

//     public function update(Request $request, Settings $settings)
//     {
//         $settings->update([
//             'roomName' => $request->input('roomName'),
//             'interval' => $request->input('interval'),
//             'maxTemp' => $request->input('maxTemp'),
//             'minTEmp' => $request->input('minTemp'),
//             'startHour' => $request->input('startHour'),
//             'endHour' => $request->input('endHour')
//         ]);
//         return response()->json($settings, 201);
//     }

//     public function destroy()
//     {

//     }
// }
