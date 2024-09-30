<?php

namespace App\Http\Controllers\Reservation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Reservation\ReservationRequest;
use App\Http\Requests\Reservation\UpdateReservationRequest;
use App\Http\Resources\Reservation\ReservationResource;
use App\Models\Reservation\Reservation;
use App\Services\Reservation\ReservationService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ReservationController extends Controller
{
    public function __construct(
        private readonly ReservationService $reservation,
    ) {
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $reservations = $this->reservation->getReservations($request);

        return ReservationResource::collection($reservations);
    }

    public function show(Reservation $reservation): JsonResponse
    {
        return response()->json($reservation->load('location', 'user'));
    }

    public function store(ReservationRequest $request): JsonResponse
    {
        $reservation = $request->user()->reservations()->create($request->all());

        return response()->json($reservation, 201);
    }

    public function update(UpdateReservationRequest $request, Reservation $reservation): JsonResponse
    {
        $reservation->update($request->all());

        return response()->json($reservation);
    }

    public function destroy(Reservation $reservation): JsonResponse
    {
        $reservation->delete();

        return response()->json(['message' => 'Reservation deleted successfully']);
    }
}
