<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('gleaning_locations', function (Blueprint $table) {
            $table->timestamp('archived_at')->nullable()->after('longitude');
        });
    }

    public function down()
    {
        Schema::table('gleaning_locations', function (Blueprint $table) {
            $table->dropColumn('archived_at');
        });
    }
};
