<?php

namespace App\Http\Controllers;

use App\Events\SensorDataUpdated;
use App\Http\Requests\OfficeRoomsRequest;
use App\Models\OfficeRooms;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;

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

    public function rules()
    {
        return [
            'roomName' => 'required|string|max:255',
            'temp' => 'nullable|numeric',
            'humidity' => 'nullable|numeric',
            'noise' => 'nullable|numeric',
            'light' => 'nullable|numeric',
            'motion' => 'nullable|boolean',
            'brightness' => 'nullable|integer',
            'mode' => 'nullable|string|max:255',
        ];
    }

    public function updateSensorData()
    {
        // Retrieve all records as a collection (without pagination)
        $allData = OfficeRooms::orderBy('created_at', 'desc')->get();

        // Return all the data as a JSON response, but do not broadcast again
        return response()->json($allData);
    }

//    public function yesterdayData()
//    {
//        return OfficeRooms::whereDate('created_at', Carbon::yesterday())->get();
//    }

    // Method to handle the POST request
//    public function storeOffice(Request $request)
//    {
//        // Log incoming request data for debugging
//        Log::info('Incoming Request Data:', $request->all());
//
//        // Try-catch block to catch and log any validation or database errors
//        try {
//            // Validate incoming data
//            $validatedData = $request->validate([
//                'roomName'   => 'required|string|max:255',
//                'temp'       => 'required|numeric',
//                'humidity'   => 'required|numeric',
//                'noise'      => 'required|numeric',
//                'light'      => 'required|numeric',
//                'brightness' => 'required|integer',
//                'mode'       => 'required|string|max:255',
//                'motion'     => 'required|boolean',
//            ]);
//
//            // Log validated data to make sure it’s correct
//            Log::info('Validated Data:', $validatedData);
//
//            // Create a new record in the database
//            $officeRoom = OfficeRooms::create($validatedData);
//
//            // Log success before returning response
//            Log::info('Data successfully saved to the database:', $officeRoom->toArray());
//
//            // Return a response indicating success
//            return response()->json([
//                'message' => 'Sensor data stored successfully',
//                'data'    => $officeRoom
//            ], 201);
//        } catch (\Exception $e) {
//            // Log any errors that occur
//            Log::error('Error storing sensor data:', ['error' => $e->getMessage()]);
//
//            // Return an error response
//            return response()->json([
//                'message' => 'Failed to store sensor data',
//                'error'   => $e->getMessage()
//            ], 500);
//        }
//    }
//    // Method to handle the GET request (retrieving data)
//    public function index()
//    {
//        // Retrieve all office room records from the database
//        $officeRooms = OfficeRooms::all();
//
//        // Return the data as a JSON response
//        return response()->json([
//            'message' => 'Office rooms data retrieved successfully',
//            'data'    => $officeRooms
//        ], 200);
//    }
}
