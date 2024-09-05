<?php

use App\Http\Controllers\OfficeRoomsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\SoundLevelController;


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', [OfficeRoomsController::class, 'index']
)->middleware(['auth', 'verified'])->name('dashboard');

Route::get('office/index', [OfficeRoomsController::class, 'index']); // Gets today's data
Route::post('office/store', [OfficeRoomsController::class, 'store']); // Store a new entry with collected data

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Resource controller to handle settings for the client devices | Handles get/post/put/delete depending on the function names in the controller
Route::resource('settings', SettingsController::class)->except('show', 'create', 'edit', 'destroy');

// Trigger the event  Real Project
//Route::post('/sensor-data', [OfficeRoomsController::class, 'store']);
Route::get('/update-sensor', [OfficeRoomsController::class, 'updateSensorData']);

Route::get('/displayChart', function () {
    return view('welcome');
});


//Route::get('/analyse-sensor', [SensorController::class, 'analyseSensor']);
//Route::get('/get-sensor-analyse', [SensorController::class, 'getSensorAnalysis'])->name('get.sensor.analyse');
////Route::get('/sensor-data', [SensorController::class, 'showSensorData']);
//Route::post('/sensor-data', [SensorController::class, 'store']);
// API Route for Sound Levels
//Route::post('/sound-levels', [SoundLevelController::class, 'store']);
// API Routes for Device Settings
//Route::get('/device-settings', [DeviceSettingController::class, 'index']);
//Route::get('/device-settings/{id}', [DeviceSettingController::class, 'show']);
//Route::post('/device-settings', [DeviceSettingController::class, 'store']);
//Route::put('/device-settings/{id}', [DeviceSettingController::class, 'update']);
//Route::delete('/device-settings/{id}', [DeviceSettingController::class, 'destroy']);



require __DIR__.'/auth.php';
