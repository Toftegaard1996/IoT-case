<?php

namespace App\Http\Controllers;

use App\Events\SensorDataUpdated;
use App\Http\Requests\OfficeRoomsRequest;
use App\Models\OfficeRooms;
use Carbon\Carbon;
use Inertia\Inertia;

class OfficeRoomsController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard', [
            'officeRoomToday' => OfficeRooms::whereDate('created_at', Carbon::today())->get(),
            'rooms' => OfficeRooms::all()->unique('roomName'),
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
            'brightness' => $request->input('brightness'),
            'mode' => $request->input('mode'),
            'motion' => $request->input('motion'),
        ]);

        event(new SensorDataUpdated([$sensorData])); // Broadcasting only the newly created data as an array

        return response()->json(['message' => 'Sensor data saved and event broadcasted'], 201);
    }

    public function updateSensorData()
    {
        // Retrieve all records as a collection (without pagination)
        $allData = OfficeRooms::orderBy('created_at', 'desc')->get();

        // Return all the data as a JSON response, but do not broadcast again
        return response()->json($allData);
    }

    public function yesterdayData()
    {
        return OfficeRooms::whereDate('created_at', Carbon::yesterday())->get();
    }
    
        public function overview()
    {
        // Fetch necessary data for the overview page
        $sensorData = Sensor::all(); // Adjust this to fetch the required data

        return Inertia::render('Overview', [
            'sensorData' => $sensorData,
        ]);
    }

}
