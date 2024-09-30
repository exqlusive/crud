<?php

namespace Tests\Feature\Reservation;

use App\Models\Location\Location;
use App\Models\Reservation\Reservation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReservationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Create a new reservation
     */
    public function test_create_reservation(): void
    {
        // Create a user and set role to admin and a location to ensure they exist
        $user = User::factory()->create(['role' => 'admin']);
        $location = Location::factory()->create();

        // Create a reservation using the created user and location
        $response = $this->actingAs($user)->postJson('/api/reservations', [
            'location_id' => $location->id, // Use the created location ID
            'user_id' => $user->id, // Use the created user ID
            'arrival_date' => now()->format('Y-m-d'), // Set the arrival date to today
            'departure_date' => now()->addDays(3)->format('Y-m-d'), // Set departure date to 3 days later
            'number_of_guests' => $this->faker->numberBetween(1, 10),
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'uuid',
                'user_id',
                'location_id',
                'arrival_date',
                'departure_date',
                'number_of_guests',
                'created_at',
                'updated_at',
                'location' => [
                    'id',
                    'uuid',
                    'name',
                    'slug',
                    'created_at',
                    'updated_at',
                ],
                'user' => [
                    'id',
                    'uuid',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);
    }

    /**
     * Get all reservations
     */
    public function test_get_reservations(): void
    {
        // Create a user and a location to ensure they exist
        $user = User::factory()->create(['role' => 'admin']);
        $location = Location::factory()->create();

        // Create a reservation using the created user and location
        $reservation = Reservation::factory()->create([
            'location_id' => $location->id, // Use the created location ID
            'user_id' => $user->id, // Use the created user ID
        ]);

        // Get all reservations
        $response = $this->actingAs($user)->get('/api/reservations');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'user_id',
                    'location_id',
                    'arrival_date',
                    'departure_date',
                    'number_of_guests',
                    'created_at',
                    'updated_at',
                    'location' => [
                        'id',
                        'name',
                        'slug',
                        'created_at',
                        'updated_at',
                    ],
                    'user' => [
                        'id',
                        'name',
                        'email',
                        'created_at',
                        'updated_at',
                    ],
                ],
            ],
        ]);
    }

    /**
     * Get a single reservation
     */
    public function test_get_reservation(): void
    {
        // Create a user and a location to ensure they exist
        $user = User::factory()->create(['role' => 'admin']);
        $location = Location::factory()->create();

        // Create a reservation using the created user and location
        $reservation = Reservation::factory()->create([
            'location_id' => $location->id, // Use the created location ID
            'user_id' => $user->id, // Use the created user ID
        ]);

        // Get the created reservation
        $response = $this->actingAs($user)->get("/api/reservations/{$reservation->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'uuid',
                'user_id',
                'location_id',
                'arrival_date',
                'departure_date',
                'number_of_guests',
                'created_at',
                'updated_at',
                'location' => [
                    'id',
                    'uuid',
                    'name',
                    'slug',
                    'created_at',
                    'updated_at',
                ],
                'user' => [
                    'id',
                    'uuid',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);
    }

    /**
     * Guest trying to get another guest their reservation
     */
    public function test_guest_not_authorized_reservation(): void
    {
        // Create a user and a location to ensure they exist
        $guestA = User::factory()->create();
        $guestB = User::factory()->create();

        $location = Location::factory()->create();

        // Create reservations where
        $reservation = Reservation::factory()->create([
            'location_id' => $location->id, // Use the created location ID
            'user_id' => $guestA->id, // Use the created user ID
        ]);

        // Get the created reservation
        $response = $this->actingAs($guestB)->get("/api/reservations/{$reservation->id}");

        $response->assertStatus(403);
    }

    /**
     * Guest trying to get their own reservation
     */
    public function test_guest_authorized_reservation(): void
    {
        // Create a user and a location to ensure they exist
        $guestA = User::factory()->create();
        $location = Location::factory()->create();

        // Create reservation where
        $reservation = Reservation::factory()->create([
            'location_id' => $location->id, // Use the created location ID
            'user_id' => $guestA->id, // Use the created user ID
        ]);

        // Get the created reservation
        $response = $this->actingAs($guestA)->get("/api/reservations/{$reservation->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'uuid',
                'user_id',
                'location_id',
                'arrival_date',
                'departure_date',
                'number_of_guests',
                'created_at',
                'updated_at',
                'location' => [
                    'id',
                    'uuid',
                    'name',
                    'slug',
                    'created_at',
                    'updated_at',
                ],
                'user' => [
                    'id',
                    'uuid',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);
    }

    /**
     * Update a reservation
     */
    public function test_update_reservation(): void
    {
        // Create a user and a location to ensure they exist
        $user = User::factory()->create(['role' => 'admin']);
        $location = Location::factory()->create();

        // Create a reservation using the created user and location
        $reservation = Reservation::factory()->create([
            'location_id' => $location->id, // Use the created location ID
            'user_id' => $user->id, // Use the created user ID
        ]);

        // Update the created reservation
        $response = $this->actingAs($user)->putJson("/api/reservations/{$reservation->id}", [
            'arrival_date' => now()->format('Y-m-d'), // Set the arrival date to today
            'departure_date' => now()->addDays(3)->format('Y-m-d'), // Set departure date to 3 days later
            'number_of_guests' => $this->faker->numberBetween(1, 10),
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'uuid',
                'user_id',
                'location_id',
                'arrival_date',
                'departure_date',
                'number_of_guests',
                'created_at',
                'updated_at',
            ],
        ]);
    }
}
