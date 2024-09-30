<?php

use App\Http\Controllers\Location\LocationController;
use App\Http\Controllers\Reservation\ReservationController;
use App\Http\Controllers\Reservation\ReservationGuestController;
use App\Http\Controllers\User\UserAuthenticationController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\UserReservationController;
use App\Http\Middleware\AuthorizeResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public routes for authentication
Route::prefix('auth')->group(function () {
    Route::post('/register', [UserAuthenticationController::class, 'register']);
    Route::post('/login', [UserAuthenticationController::class, 'login']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    /**
     * User routes
     */
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/reservations', [UserReservationController::class, 'index']);

    Route::resource('locations', LocationController::class);
    Route::get('/locations/{location}/reservations', [LocationController::class, 'reservations']);
    Route::resource('reservations', ReservationController::class);
});


