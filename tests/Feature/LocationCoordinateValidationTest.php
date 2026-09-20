<?php

use App\Models\Gleanable;
use App\Models\User;

test('web location store rejects out of range coordinates', function () {
    $user = User::factory()->create();
    $gleanable = Gleanable::factory()->create();

    $response = $this->actingAs($user)->post('/locations', [
        'latitude' => 300,
        'longitude' => 400,
        'city' => 'Phillipeville',
        'postal_code' => 5600,
        'gleanable_id' => $gleanable->id,
        'confirmed' => true,
    ]);

    $response->assertSessionHasErrors(['latitude', 'longitude']);
    $this->assertDatabaseCount('gleaning_locations', 0);
});

test('web location store accepts valid coordinates', function () {
    $user = User::factory()->create();
    $gleanable = Gleanable::factory()->create();

    $response = $this->actingAs($user)->post('/locations', [
        'latitude' => 50.4650432,
        'longitude' => 4.5652519,
        'city' => 'Namur',
        'postal_code' => 5000,
        'gleanable_id' => $gleanable->id,
        'confirmed' => true,
    ]);

    $response->assertSessionDoesntHaveErrors();
    $this->assertDatabaseCount('gleaning_locations', 1);
});

test('api location store rejects out of range coordinates', function () {
    $user = User::factory()->create();
    $gleanable = Gleanable::factory()->create();

    $response = $this->actingAs($user, 'sanctum')->postJson('/api/locations', [
        'latitude' => 300,
        'longitude' => 400,
        'city' => 'Phillipeville',
        'postal_code' => 5600,
        'gleanable_id' => $gleanable->id,
    ]);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['latitude', 'longitude']);
    $this->assertDatabaseCount('gleaning_locations', 0);
});

test('api location index rejects out of range coordinates', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user, 'sanctum')->getJson('/api/locations?latitude=300&longitude=400');

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['latitude', 'longitude']);
});
