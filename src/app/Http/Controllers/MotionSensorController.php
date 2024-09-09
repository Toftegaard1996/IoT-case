<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MotionSensor;

class MotionSensorController extends Controller
{
    /**
     * Store a newly created motion sensor record in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'roomName' => 'required|string|max:255',
            'motion' => 'required|boolean',
        ]);

        // Create a new motion sensor record
        $motionSensor = MotionSensor::create([
            'motion_detected' => $request->motion,
            'created_at' => now(),
        ]);

        // Return a response
        return response()->json($motionSensor, 201);
    }
}