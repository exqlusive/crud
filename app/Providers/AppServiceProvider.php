<?php

namespace App\Providers;

use App\Models\Location\Location;
use App\Models\Reservation\Reservation;
use App\Policies\Location\LocationPolicy;
use App\Policies\Reservation\ReservationPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Reservation::class, ReservationPolicy::class);
        Gate::policy(Location::class, LocationPolicy::class);
    }
}
