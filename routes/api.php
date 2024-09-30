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

// Routes requiring 'manage-locations' ability
Route::middleware(['auth:sanctum', 'abilities:manage-locations'])->group(function () {
    Route::post('/locations', [LocationController::class, 'store']);
    Route::put('/locations/{location}', [LocationController::class, 'update']);
    Route::delete('/locations/{location}', [LocationController::class, 'destroy']);
});

// Routes requiring 'manage-reservations' ability
Route::middleware(['auth:sanctum', 'abilities:manage-reservations'])->group(function () {
    Route::get('/reservations', [ReservationController::class, 'index']);
    Route::post('/reservations', [ReservationController::class, 'store']);
    Route::put('/reservations/{reservation}', [ReservationController::class, 'update']);
    Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy']);
});
