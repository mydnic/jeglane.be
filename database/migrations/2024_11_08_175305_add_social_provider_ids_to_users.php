<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('social_provider')->nullable()->unique()->after('password');
            $table->string('social_provider_id')->nullable()->unique()->after('password');
        });
    }

};
