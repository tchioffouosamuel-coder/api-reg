<?php

use App\Http\Controllers\RegistrationPdfController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return response()->json(['message' => 'Please use /api/auth/login'], 401);
})->name('login');

Route::middleware(['auth'])->prefix('registrations/{registration}')->group(function () {
    Route::get('/badge', [RegistrationPdfController::class, 'badge'])->name('registrations.badge');
    Route::get('/attestation', [RegistrationPdfController::class, 'attestation'])->name('registrations.attestation');
});
