<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SensorController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| These routes are loaded by the RouteServiceProvider and all of them will
| be assigned the "api" middleware group.
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// ESP32 sends sensor data here (POST)
Route::post('/sensor-data', [SensorController::class, 'store']);

// Dashboard fetches latest reading (GET)
Route::get('/sensor/latest', [SensorController::class, 'latest']);

// Dashboard fetches history for charts (GET)
Route::get('/sensor/history', [SensorController::class, 'history']);