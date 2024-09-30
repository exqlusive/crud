<?php

namespace Database\Factories\Reservation;

use App\Models\Location\Location;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'location_id' => Location::factory(),
            'user_id' => User::factory(),
            'arrival_date' => now(),
            'departure_date' => now()->addDays(3),
            'number_of_guests' => 2,
        ];
    }
}
