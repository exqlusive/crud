<?php

namespace Tests\Feature\Location;

use App\Models\Location\Location;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LocationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * A basic feature test example.
     */
    public function test_create_location_authorized(): void
    {
        $user = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($user)->postJson('/api/locations', [
            'name' => $this->faker->name(),
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'uuid',
                'name',
                'slug',
                'created_at',
                'updated_at',
            ],
        ]);
    }

    public function test_create_location_unauthorized(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)->postJson('/api/locations', [
            'name' => $this->faker->name(),
        ]);

        $response->assertStatus(403);
    }

    public function test_update_location(): void
    {
        $user = User::factory()->create(['role' => 'admin']);
        $location = Location::factory()->create();

        $response = $this->actingAs($user)->putJson("/api/locations/{$location->id}", [
            'name' => $this->faker->name(),
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'uuid',
                'name',
                'slug',
                'created_at',
                'updated_at',
            ],
        ]);
    }
}
