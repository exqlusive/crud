<?php

namespace App\Services\Reservation;

use App\Models\Reservation\Reservation;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ReservationService
{
    public function getReservations(Request $request): Collection
    {
        return Reservation::with('location', 'user')
            ->when($request->user()->role !== 'location_manager', function ($query) use ($request) {
                $query->where('user_id', $request->user()->id);
            })
            ->get();
    }
}
