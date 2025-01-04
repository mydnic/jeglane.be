<?php

namespace App\Console\Commands;

use App\Models\GleaningLocation;
use Illuminate\Console\Command;

class ArchiveOldGleaningLocations extends Command
{
    protected $signature = 'gleaning:archive-old';
    protected $description = 'Archive gleaning locations older than 3 months';

    public function handle()
    {
        $threeMonthsAgo = now()->subMonths(3);
        
        $count = GleaningLocation::where('created_at', '<', $threeMonthsAgo)
            ->whereNull('archived_at')
            ->update(['archived_at' => now()]);

        $this->info("Archived {$count} gleaning locations.");
    }
}
