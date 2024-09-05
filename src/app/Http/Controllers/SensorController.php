<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\SensorDataUpdated;
use App\Models\SensorData;

class SensorController extends Controller
{
    // Method to store new sensor data
    public function store(Request $request)
    {
        // Validate the incoming data----POST
        $validatedData = $request->validate([
            'SensorID' => 'required|string|max:255',
            'Temperature' => 'required|numeric',
            'Humidity' => 'required|numeric',
            'Timestamp' => 'required|date',
        ]);

        // Create a new sensor data record
        $sensorData = SensorData::create($validatedData);

        // Broadcast the event with the new sensor data
        event(new SensorDataUpdated([$sensorData])); // Broadcasting only the newly created data as an array

        return response()->json(['message' => 'Sensor data saved and event broadcasted'], 201);
    }

    // Method to retrieve all sensor data (for initial load)------GET
    public function updateSensorData()
    {
        // Retrieve all records as a collection (without pagination)
        $allData = SensorData::orderBy('Timestamp', 'desc')->get();

        // Return all the data as a JSON response, but do not broadcast again
        return response()->json($allData);
    }
}
