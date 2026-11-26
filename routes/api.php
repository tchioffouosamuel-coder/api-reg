<?php

use App\Http\Controllers\Api\RegistrationController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\FormationController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\GalleryItemController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Test routes
Route::post('/test', function () {
    return response()->json(['message' => 'POST works!']);
});

Route::post('/test-auth', 'App\Http\Controllers\Api\AuthController@me')->middleware('auth.sanctum');

Route::post('/events-test', [EventController::class, 'store'])->middleware('auth.sanctum');

Route::post('/events-no-middleware', [EventController::class, 'store'])->withoutMiddleware(['auth', 'csrf', 'web']);

Route::post('/test-simple', function () {
    return response()->json(['message' => 'Simple POST works!', 'method' => 'POST']);
});

Route::post('/test-controller', function (Illuminate\Http\Request $request) {
    return response()->json(['received' => $request->all()]);
});

// Public registration
Route::post('/registrations', [RegistrationController::class, 'store'])->middleware('throttle:10,1');

// Authentication
Route::post('/auth/login', [AuthController::class, 'login']);

// Protected admin routes
Route::middleware('auth.sanctum')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/me', [AuthController::class, 'me']);

    // Events routes
    Route::get('/events', [EventController::class, 'index']);
    Route::post('/events', [EventController::class, 'store']);
    Route::get('/events/{event}', [EventController::class, 'show']);
    Route::put('/events/{event}', [EventController::class, 'update']);
    Route::delete('/events/{event}', [EventController::class, 'destroy']);

    // Formations routes
    Route::apiResource('formations', FormationController::class);
    Route::apiResource('services', ServiceController::class);
    Route::apiResource('projects', ProjectController::class);
    Route::apiResource('news', NewsController::class);
    Route::apiResource('gallery', GalleryItemController::class);

    // Registrations (read-only)
    Route::get('/registrations', [RegistrationController::class, 'index']);
    Route::get('/registrations/{id}', [RegistrationController::class, 'show']);
});
