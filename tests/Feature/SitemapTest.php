<?php

use App\Models\Gleanable;
use App\Models\GleaningLocation;

test('the sitemap lists the static pages as xml', function () {
    $response = $this->get('/sitemap.xml');

    $response->assertOk();
    expect($response->headers->get('Content-Type'))->toContain('application/xml');
    $response->assertSee('<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">', false);
    $response->assertSee(route('home'), false);
    $response->assertSee(route('about'), false);
    $response->assertSee(route('locations.index'), false);
});

test('the sitemap lists the locations created in the last two months', function () {
    $gleanable = Gleanable::factory()->create();

    $recent = GleaningLocation::factory()->create([
        'gleanable_id' => $gleanable->id,
        'created_at' => now()->subMonth(),
    ]);

    $old = GleaningLocation::factory()->create([
        'gleanable_id' => $gleanable->id,
        'created_at' => now()->subMonths(6),
    ]);

    $response = $this->get('/sitemap.xml');

    $response->assertOk();
    $response->assertSee(route('locations.show', $recent->id), false);
    $response->assertDontSee(route('locations.show', $old->id), false);
});
