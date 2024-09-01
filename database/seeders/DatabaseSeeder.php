<?php

namespace Database\Seeders;

use App\Models\GleaningLocation;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'mydnic@gmail.com',
        ]);

        GleaningLocation::factory()->count(10)->create();
    }
}
