<?php

use App\Http\Controllers\OfficeRoomsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\SoundLevelController;


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

Route::post('office/store', [OfficeRoomsController::class, 'store']); // Store a new entry with collected data

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('office/index', [OfficeRoomsController::class, 'index']); // Gets today's data
});

//Resource controller to handle settings for the client devices | Handles get/post/put/delete depending on the function names in the controller
Route::resource('settings', SettingsController::class)->except('show', 'create', 'edit', 'destroy');

// Trigger the event  Real Project
//Route::post('/sensor-data', [OfficeRoomsController::class, 'store']);
Route::get('/update-sensor', [OfficeRoomsController::class, 'updateSensorData']);

Route::get('/displayChart', function () {
    return view('welcome');
});



require __DIR__.'/auth.php';
