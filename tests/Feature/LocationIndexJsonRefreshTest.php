<?php

use App\Models\Gleanable;
use App\Models\GleaningLocation;

test('locations index renders the inertia page for a normal navigation', function () {
    $response = $this->get('/locations');

    $response->assertOk();
    $response->assertHeaderMissing('X-Inertia');
    expect($response->headers->get('Content-Type'))->toContain('text/html');
});

test('locations index returns plain json for the map live refresh', function () {
    $gleanable = Gleanable::factory()->create();
    GleaningLocation::factory()->create([
        'gleanable_id' => $gleanable->id,
        'created_at' => now(),
    ]);

    $response = $this->getJson('/locations');

    $response->assertOk();
    $response->assertHeaderMissing('X-Inertia');
    $response->assertJsonCount(1, 'locations');
});
