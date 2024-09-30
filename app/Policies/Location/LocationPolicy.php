<?php

namespace App\Policies\Location;

use App\Models\Location\Location;
use App\Models\User;

class LocationPolicy
{
    /**
     * Determine if any user can view the locations.
     */
    public function viewAny(?User $user): bool
    {
        // Anyone (including guests) can view locations
        return true;
    }

    /**
     * Determine if a user can view a specific location.
     */
    public function view(?User $user, Location $location): bool
    {
        return true;
    }

    /**
     * Determine if the user can create a location.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can update a location.
     */
    public function update(User $user, Location $location): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can delete a location.
     */
    public function delete(User $user, Location $location): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can restore a deleted location.
     */
    public function restore(User $user, Location $location): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can permanently delete a location.
     */
    public function forceDelete(User $user, Location $location): bool
    {
        return $user->isAdmin();
    }
}
