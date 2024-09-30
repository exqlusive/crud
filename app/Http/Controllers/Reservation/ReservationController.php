<?php

namespace App\Http\Controllers\Reservation;

use App\Http\Controllers\Controller;
use App\Models\Reservation\Reservation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    // Get reservations (user's own or all for managers)
    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', Reservation::class);

        $reservations = Reservation::with('location', 'user')
            ->when($request->user()->role !== 'location_manager', function ($query) use ($request) {
                $query->where('user_id', $request->user()->id);
            })
            ->get();

        return response()->json($reservations);
    }

    // Get a single reservation
    public function show(Reservation $reservation): JsonResponse
    {
        $this->authorize('view', $reservation);

        return response()->json($reservation->load('location', 'user'));
    }

    // Create a new reservation
    public function store(Request $request)
    {
        $request->validate([
            'location_id' => 'required|exists:locations,id',
            'date' => 'required|date',
            'time' => 'required',
        ]);

        $reservation = $request->user()->reservations()->create($request->all());

        return response()->json($reservation, 201);
    }

    // Update a reservation
    public function update(Request $request, Reservation $reservation): JsonResponse
    {
        $this->authorize('update', $reservation);

        $request->validate([
            'date' => 'sometimes|date',
            'time' => 'sometimes',
        ]);

        $reservation->update($request->all());

        return response()->json($reservation);
    }

    // Delete a reservation
    public function destroy(Reservation $reservation): JsonResponse
    {
        $this->authorize('delete', $reservation);

        $reservation->delete();

        return response()->json(['message' => 'Reservation deleted successfully']);
    }
}
