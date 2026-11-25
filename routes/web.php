<?php

use App\Http\Controllers\RegistrationPdfController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->prefix('registrations/{registration}')->group(function () {
    Route::get('/badge', [RegistrationPdfController::class, 'badge'])->name('registrations.badge');
    Route::get('/attestation', [RegistrationPdfController::class, 'attestation'])->name('registrations.attestation');
});
