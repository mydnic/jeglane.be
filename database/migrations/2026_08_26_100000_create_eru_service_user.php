<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        User::firstOrCreate(
            ['email' => 'eru@jeglane.be'],
            [
                'name' => 'Eru',
                'password' => Hash::make(Str::random(40)),
                'email_verified_at' => now(),
            ]
        );
    }

    public function down(): void
    {
        User::where('email', 'eru@jeglane.be')->delete();
    }
};
