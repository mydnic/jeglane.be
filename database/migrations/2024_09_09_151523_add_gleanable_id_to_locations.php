<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('gleaning_locations', function (Blueprint $table) {
            $table->foreignId('gleanable_id')->constrained()->onDelete('cascade');
            $table->string('city')->nullable();
            $table->string('postal_code')->nullable();
        });
    }
};
