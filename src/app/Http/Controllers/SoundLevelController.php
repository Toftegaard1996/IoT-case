<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\SoundLevel;
class SoundLevelController extends Controller
{
    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'sound_level' => 'required|integer',
        ]);
        // Save the sound level to the database
        $soundLevel = new SoundLevel();
        $soundLevel->level = $validated['sound_level'];
        $soundLevel->save();
        return response()->json(['message' => 'Sound level recorded successfully'], 201);
    }
}