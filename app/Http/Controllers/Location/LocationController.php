<?php

namespace App\Http\Controllers\Location;

use App\Http\Controllers\Controller;
use App\Models\Location\Location;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    use AuthorizesRequests;

    // Show all locations (publicly accessible)
    public function index(): JsonResponse
    {
        $locations = Location::all();
        return response()->json($locations);
    }

    // Show a single location (publicly accessible)
    public function show(Location $location): JsonResponse
    {
        return response()->json($location);
    }

    // Create a new location (admin only)
    public function store(Request $request): JsonResponse
    {
        $this->authorize('create', Location::class);

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $location = Location::create($request->all());

        return response()->json($location, 201);
    }

    // Update a location (admin only)
    public function update(Request $request, Location $location): JsonResponse
    {
        $this->authorize('update', $location);

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'address' => 'sometimes|string|max:255',
            // Other location fields...
        ]);

        $location->update($request->all());

        return response()->json($location);
    }

    // Delete a location (admin only)
    public function destroy(Location $location): JsonResponse
    {
        $this->authorize('delete', $location);

        $location->delete();

        return response()->json(['message' => 'Location deleted successfully']);
    }
}
