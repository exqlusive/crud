<?php

namespace App\Services\Location;

use App\Http\Requests\Location\UpdateLocationRequest;
use App\Models\Location\Location;
use Illuminate\Support\Str;

class LocationService
{
    public function updateLocationName(UpdateLocationRequest $request, Location $location): void
    {
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
    }
}
