<?php

namespace App\Http\Controllers\Reservation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Reservation\ReservationRequest;
use App\Http\Requests\Reservation\UpdateReservationRequest;
use App\Http\Resources\Reservation\ReservationResource;
use App\Models\Reservation\Reservation;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ReservationController extends Controller
{
    // Get reservations (user's own or all for managers)
    public function index(Request $request): AnonymousResourceCollection
    {
        $reservations = Reservation::with('location', 'user')
            ->when($request->user()->role !== 'location_manager', function ($query) use ($request) {
                $query->where('user_id', $request->user()->id);
            })
            ->get();

        return ReservationResource::collection($reservations);
    }

    // Get a single reservation
    public function show(Reservation $reservation): JsonResponse
    {
        return response()->json($reservation->load('location', 'user'));
    }

    // Create a new reservation
    public function store(ReservationRequest $request): JsonResponse
    {
        $reservation = $request->user()->reservations()->create($request->all());

        return response()->json($reservation, 201);
    }

    // Update a reservation
    public function update(UpdateReservationRequest $request, Reservation $reservation): JsonResponse
    {
        $reservation->update($request->all());

        return response()->json($reservation);
    }

    // Delete a reservation
    public function destroy(Reservation $reservation): JsonResponse
    {
        $reservation->delete();

        return response()->json(['message' => 'Reservation deleted successfully']);
    }
}
