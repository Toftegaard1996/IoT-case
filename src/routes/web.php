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

    Route::get('/yesterdayGraph', [OfficeRoomsController::class, 'yesterdayData'])->name('yesterdayGraph');

    //Setting routes for frontend
    Route::get('setting/index', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('settings/store', [SettingsController::class, 'store'])->name('settings.store');
    Route::get('setting/edit/{settings}', [SettingsController::class, 'edit'])->name('settings.edit');
    Route::put('/settings/update/{roomName}', [SettingsController::class, 'updateByRoomName'])->name('settings.update');
});

// Trigger the event  Real Project
Route::get('/update-sensor', [OfficeRoomsController::class, 'updateSensorData']);

Route::get('/displayChart', function () {
    return view('welcome');
});

// define a route for the get/put request to handle Settings | Setting route for Pi
Route::get('/settings', [SettingsController::class, 'getSettings']);
Route::get('/settings/{roomName}', [SettingsController::class, 'getSettingsByRoomName']);



// Define a route for the POST request
Route::post('/office/store', [OfficeRoomsController::class, 'store']);
// Define a route for the GET request to retrieve all office rooms data
Route::get('/office', [OfficeRoomsController::class, 'index']);

// Define a route for the POST request to handle motion sensor data
Route::post('/motion-sensors', [MotionSensorController::class, 'store']);


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/overview', function () {
        return Inertia::render('Overview/Overview');
    })->name('overview');
});


require __DIR__.'/auth.php';
