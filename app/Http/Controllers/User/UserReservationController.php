<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserReservationController extends Controller
{
    public function index()
    {
        return response()->json(auth()->user()->reservations()->with('location')->get());
    }
}
