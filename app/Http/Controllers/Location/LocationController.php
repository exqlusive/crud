<?php

namespace App\Http\Controllers\Location;

use App\Http\Controllers\Controller;
use App\Http\Requests\Location\LocationRequest;
use App\Http\Requests\Location\UpdateLocationRequest;
use App\Http\Resources\Location\LocationResource;
use App\Http\Resources\Reservation\ReservationResource;
use App\Models\Location\Location;
use App\Services\Location\LocationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class LocationController extends Controller
{
    public function __construct(
        private readonly LocationService $location,
    ) {
    }

    public function index(): AnonymousResourceCollection
    {
        $this->authorize('viewAny', Location::class);

        $locations = Location::all();
        return LocationResource::collection($locations);
    }

    public function show(Location $location): LocationResource
    {
        $this->authorize('view', $location);

        return new LocationResource($location);
    }

    public function store(LocationRequest $request): LocationResource
    {
        $this->authorize('create', Location::class);

        $location = Location::create($request->all());
        return new LocationResource($location);
    }

    public function update(UpdateLocationRequest $request, Location $location): LocationResource
    {
        $this->authorize('update', $location);

        $this->location->updateLocationName($request, $location);

        $location->update($request->all());

        return new LocationResource($location);
    }

    public function destroy(Location $location): JsonResponse
    {
        $this->authorize('delete', $location);

        $location->delete();
        return response()->json(['message' => 'Location deleted successfully']);
    }

    public function reservations(Location $location): AnonymousResourceCollection
    {
        $this->authorize('view', $location);

        return ReservationResource::collection($location->reservations);
    }
}
