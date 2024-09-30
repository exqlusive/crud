<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserReservationResource;
use Illuminate\Http\Request;

class UserReservationController extends Controller
{
    public function index(): UserReservationResource
    {
        $user = auth()->user();

        if ($user === null) {
            abort(401);
        }

        return new UserReservationResource($user->load('reservations'));
    }
}
