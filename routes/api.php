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

// Test route
Route::post('/test', function () {
    return response()->json(['message' => 'POST works!']);
});

// Public registration
Route::post('/registrations', [RegistrationController::class, 'store'])->middleware('throttle:10,1');

// Authentication
Route::post('/auth/login', [AuthController::class, 'login']);

// Protected admin routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/me', [AuthController::class, 'me']);

    // CRUD resources
    Route::apiResource('events', EventController::class);
    Route::apiResource('formations', FormationController::class);
    Route::apiResource('services', ServiceController::class);
    Route::apiResource('projects', ProjectController::class);
    Route::apiResource('news', NewsController::class);
    Route::apiResource('gallery', GalleryItemController::class);

    // Registrations (read-only)
    Route::get('/registrations', [RegistrationController::class, 'index']);
    Route::get('/registrations/{id}', [RegistrationController::class, 'show']);
});
