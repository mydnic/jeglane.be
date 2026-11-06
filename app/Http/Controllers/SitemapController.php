<?php

namespace App\Http\Controllers;

use App\Actions\BuildSitemapXml;
use App\Models\GleaningLocation;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(BuildSitemapXml $buildXml): Response
    {
        $urls = [
            [
                'loc' => route('home'),
                'changefreq' => 'weekly',
                'priority' => '1.0',
            ],
            [
                'loc' => route('about'),
                'changefreq' => 'yearly',
                'priority' => '0.5',
            ],
            [
                'loc' => route('locations.index'),
                'changefreq' => 'daily',
                'priority' => '0.8',
            ],
        ];

        $locations = GleaningLocation::query()
            ->whereDate('created_at', '>=', now()->subMonths(2))
            ->latest('updated_at')
            ->get(['id', 'updated_at']);

        foreach ($locations as $loc) {
            $urls[] = [
                'loc' => route('locations.show', $loc->id),
                'lastmod' => optional($loc->updated_at)->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.7',
            ];
        }

        return response($buildXml($urls), 200)
            ->header('Content-Type', 'application/xml');
    }
}
