<?php

namespace App\Actions;

class BuildSitemapXml
{
    public function __invoke(array $urls): string
    {
        $xml = ['<?xml version="1.0" encoding="UTF-8"?>'];
        $xml[] = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach ($urls as $u) {
            $xml[] = '  <url>';
            $xml[] = '    <loc>'.e($u['loc']).'</loc>';
            if (! empty($u['lastmod'])) {
                $xml[] = '    <lastmod>'.e($u['lastmod']).'</lastmod>';
            }
            if (! empty($u['changefreq'])) {
                $xml[] = '    <changefreq>'.e($u['changefreq']).'</changefreq>';
            }
            if (! empty($u['priority'])) {
                $xml[] = '    <priority>'.e($u['priority']).'</priority>';
            }
            $xml[] = '  </url>';
        }

        $xml[] = '</urlset>';

        return implode("\n", $xml);
    }
}
