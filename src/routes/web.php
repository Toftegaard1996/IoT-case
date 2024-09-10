<?php

use App\Http\Controllers\OfficeRoomsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\SoundLevelController;
use App\Http\Controllers\MotionSensorController;


Route::get('/blah', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/', [OfficeRoomsController::class, 'index']
)->middleware(['auth', 'verified'])->name('dashboard');

//Route::post('office/store', [OfficeRoomsController::class, 'store']); // Store a new entry with collected data

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

//    Route::get('office/index', [OfficeRoomsController::class, 'index']); // Gets today's data
    Route::get('setting/index', [SettingsController::class, 'index'])->name('settings.index');
    Route::get('setting/edit/{settings}', [SettingsController::class, 'edit'])->name('settings.edit');
});

// Trigger the event  Real Project
//Route::post('/sensor-data', [OfficeRoomsController::class, 'store']);
Route::get('/update-sensor', [OfficeRoomsController::class, 'updateSensorData']);

Route::get('/displayChart', function () {
    return view('welcome');
});

// define a route for the get/put request to handle Settings
Route::get('/settings', [SettingsController::class, 'getSettings']);
Route::get('/settings/{roomName}', [SettingsController::class, 'getSettingsByRoomName']);
Route::put('/settings/update/{roomName}', [SettingsController::class, 'updateByRoomName'])->name('settings.update');


// Define a route for the POST request
Route::post('/office/store', [OfficeRoomsController::class, 'storeOffice']);
// Define a route for the GET request to retrieve all office rooms data
Route::get('/office', [OfficeRoomsController::class, 'index']);

// Define a route for the POST request to handle motion sensor data
Route::post('/motion-sensors', [MotionSensorController::class, 'store']);


require __DIR__.'/auth.php';
