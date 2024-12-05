<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('gleaning_locations', function (Blueprint $table) {
            $table->uuid('id')->index()->primary()->change();
        });

        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->uuid('gleaning_location_id');
            $table->foreign('gleaning_location_id')
                ->references('id')
                ->on('gleaning_locations')
                ->onDelete('cascade');
            $table->tinyInteger('vote'); // 1 for upvote, -1 for downvote
            $table->timestamps();

            // Ensure a user can only vote once per location
            $table->unique(['user_id', 'gleaning_location_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('votes');
    }
};
