<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Try and login with wrong credentials
     */
    public function test_login_with_wrong_credentials(): void
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => 'non_existing_email@test.com',
            'password' => 'wrong_password',
        ]);

        $response->assertStatus(401);
    }

    /**
     * Try and login with correct credentials
     */
    public function test_login_with_correct_credentials(): void
    {
        // Create a user and login
        $user = User::factory()->create(['password' => bcrypt('password')]);

        $response = $this->postJson('/api/auth/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(200);
    }

    /**
     * Try and register a new user
     */
    public function test_register_new_user(): void
    {
        $password = $this->faker->password();

        $response = $this->postJson('/api/auth/register', [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => $password,
            'password_confirmation' => $password,
        ]);

        $response->assertStatus(201);
    }

    /**
     * Try and get the current user
     */
    public function test_get_current_user(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->getJson('/api/users');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'email',
                'created_at',
                'updated_at',
            ],
        ]);
    }

    public function get_user_reservations(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->getJson('/api/users/reservations');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'uuid',
                    'location_id',
                    'user_id',
                    'arrival_date',
                    'departure_date',
                    'number_of_guests',
                ],
            ],
        ]);
    }
}
