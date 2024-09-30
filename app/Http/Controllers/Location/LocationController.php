<?php

namespace App\Http\Controllers\Location;

use App\Http\Controllers\Controller;
use App\Http\Requests\Location\LocationRequest;
use App\Http\Requests\Location\UpdateLocationRequest;
use App\Http\Resources\Location\LocationResource;
use App\Models\Location\Location;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LocationController extends Controller
{
    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $locations = Location::all();
        return LocationResource::collection($locations);
    }

    public function show(Location $location): LocationResource
    {
        return new LocationResource($location);
    }

    public function store(LocationRequest $request): LocationResource
    {
        $location = Location::create($request->all());
        return new LocationResource($location);
    }

    public function update(UpdateLocationRequest $request, Location $location): LocationResource
    {
        // Update slug if name has changed
        if ($request->has('name') && $request->name !== $location->name) {
            $slug = Str::slug($request->name);
            $originalSlug = $slug;
            $counter = 1;

            // Ensure the slug is unique
            while (Location::where('slug', $slug)->exists()) {
                $slug = "{$originalSlug}-{$counter}";
                $counter++;
            }

            $location->slug = $slug;
        }

        $location->update($request->all());

        return new LocationResource($location);
    }

    public function destroy(Location $location): JsonResponse
    {
        $location->delete();
        return response()->json(['message' => 'Location deleted successfully']);
    }
}
