<?php

namespace App\Http\Controllers;

use App\Models\MotionSensor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MotionSensorController extends Controller
{
    private $lastState = null;

public function store(Request $request)
{
    // Validate the incoming request
    $validatedData = $request->validate([
        'motion_detected' => 'required|boolean',
        'countdown' => 'required|integer',
        'event_time' => 'nullable|date_format:Y-m-d\TH:i:s',
        'created_at' => 'nullable|date_format:Y-m-d\TH:i:s',
        'updated_at' => 'nullable|date_format:Y-m-d\TH:i:s',
    ]);

    // Convert ISO 8601 to the desired format
    $validatedData['event_time'] = \Carbon\Carbon::parse($validatedData['event_time'])->format('Y-m-d H:i:s');
    $validatedData['created_at'] = \Carbon\Carbon::parse($validatedData['created_at'])->format('Y-m-d H:i:s');
    $validatedData['updated_at'] = \Carbon\Carbon::parse($validatedData['updated_at'])->format('Y-m-d H:i:s');

        $currentState = $validatedData['motion_detected'] ? 'on' : 'off';

        // Only log the state change if it's different from the last state
        if ($this->lastState !== $currentState) {
            // Use provided event_time if present, otherwise use the current timestamp
            $timestamp = $validatedData['event_time'] ?? now();

            // Store the event in the database
            MotionSensor::create([
                'motion_detected' => $validatedData['motion_detected'],
                'event_time' => $timestamp,
                'created_at' => $validatedData['created_at'] ?? now(), // Use provided created_at or current time
                'updated_at' => $validatedData['updated_at'] ?? now(), // Use provided updated_at or current time
            ]);

            if ($currentState == 'on') {
                Log::info("[$timestamp] Motion Detected - Turned on");
            } else if ($currentState == 'off') {
                Log::info("[$timestamp] No Motion - Turned off");
            }

            $this->lastState = $currentState;
        }

        // Respond with a success message
        return response()->json(['message' => 'Data received successfully']);
    }
}
