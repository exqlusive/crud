<?php

use App\Http\Controllers\Location\LocationController;
use App\Http\Controllers\Reservation\ReservationController;
use App\Http\Controllers\User\UserAuthenticationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public routes for authentication
Route::prefix('auth')->group(function () {
    Route::post('/register', [UserAuthenticationController::class, 'register']);
    Route::post('/login', [UserAuthenticationController::class, 'login']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::resource('locations', LocationController::class);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::resource('/reservations', ReservationController::class);
});
