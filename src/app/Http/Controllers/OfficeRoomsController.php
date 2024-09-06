<?php

namespace App\Http\Controllers;

use App\Events\SensorDataUpdated;
use App\Http\Requests\OfficeRoomsRequest;
use App\Models\OfficeRooms;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OfficeRoomsController extends Controller
{
    public function index()
    {
//	    dd(OfficeRooms::whereDate('created_at', Carbon::today())->get());
        return Inertia::render('Dashboard', [
            'officeRoomToday' => OfficeRooms::whereDate('created_at', Carbon::today())->get(),
        ]);
    }

    public function store(OfficeRoomsRequest $request)
    {
        $sensorData = OfficeRooms::create([
            'roomName' => $request->input('roomName'),
            'temp' => $request->input('temp'),
            'humidity' => $request->input('humidity'),
            'noise' => $request->input('noise'),
            'light' => $request->input('light'),
            'motion' => $request->input('motion'),
        ]);

        event(new SensorDataUpdated([$sensorData])); // Broadcasting only the newly created data as an array

        return response()->json(['message' => 'Sensor data saved and event broadcasted'], 201);
    }

    public function updateSensorData()
    {
        // Retrieve all records as a collection (without pagination)
        $allData = OfficeRooms::orderBy('Timestamp', 'desc')->get();

        // Return all the data as a JSON response, but do not broadcast again
        return response()->json($allData);
    }

    public function yesterdayData()
    {
        return OfficeRooms::whereDate('created_at', Carbon::yesterday())->get();
    }
}
