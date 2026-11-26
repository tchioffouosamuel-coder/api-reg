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

// Test simple POST
Route::post('/test-simple-post', function (Illuminate\Http\Request $request) {
    return response()->json(['received' => 'OK', 'data' => $request->all()]);
});

Route::post('/events-no-middleware', [EventController::class, 'store']);
Route::post('/events-test-direct', [EventController::class, 'store']);

// Public registration
Route::post('/registrations', [RegistrationController::class, 'store'])->middleware('throttle:10,1');

// Authentication
Route::post('/auth/login', [AuthController::class, 'login']);

// Protected admin routes - Apply middleware to individual routes instead of group
Route::post('/auth/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/auth/me', [AuthController::class, 'me'])->middleware('auth:sanctum');

// Events routes
Route::get('/events', [EventController::class, 'index'])->middleware('auth:sanctum');
Route::post('/events', [EventController::class, 'store'])->middleware('auth:sanctum');
Route::get('/events/{event}', [EventController::class, 'show'])->middleware('auth:sanctum');
Route::put('/events/{event}', [EventController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/events/{event}', [EventController::class, 'destroy'])->middleware('auth:sanctum');

// Formations routes
Route::apiResource('formations', FormationController::class)->middleware('auth:sanctum');
Route::apiResource('services', ServiceController::class)->middleware('auth:sanctum');
Route::apiResource('projects', ProjectController::class)->middleware('auth:sanctum');
Route::apiResource('news', NewsController::class)->middleware('auth:sanctum');
Route::apiResource('gallery', GalleryItemController::class)->middleware('auth:sanctum');

// Registrations (read-only)
Route::get('/registrations', [RegistrationController::class, 'index'])->middleware('auth:sanctum');
Route::get('/registrations/{id}', [RegistrationController::class, 'show'])->middleware('auth:sanctum');
