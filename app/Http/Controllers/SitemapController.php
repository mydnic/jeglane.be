<?php

namespace App\Http\Controllers;

use App\Models\GleaningLocation;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $base = config('app.url') ?: url('/');

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

        $xml = $this->buildXml($urls);

        return response($xml, 200)
            ->header('Content-Type', 'application/xml');
    }

    protected function buildXml(array $urls): string
    {
        $xml = ['<?xml version="1.0" encoding="UTF-8"?>'];
        $xml[] = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach ($urls as $u) {
            $xml[] = '  <url>';
            $xml[] = '    <loc>' . e($u['loc']) . '</loc>';
            if (!empty($u['lastmod'])) {
                $xml[] = '    <lastmod>' . e($u['lastmod']) . '</lastmod>';
            }
            if (!empty($u['changefreq'])) {
                $xml[] = '    <changefreq>' . e($u['changefreq']) . '</changefreq>';
            }
            if (!empty($u['priority'])) {
                $xml[] = '    <priority>' . e($u['priority']) . '</priority>';
            }
            $xml[] = '  </url>';
        }

        $xml[] = '</urlset>';

        return implode("\n", $xml);
    }
}
