<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->tinyInteger('publish_status')->default(0)->after('slug')->comment('0: Published, 1: Not Published');
            $table->tinyInteger('home_feature_status')->default(0)->after('publish_status')->comment('0: Shown, 1: Not Shown');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['publish_status', 'home_feature_status']);
        });
    }
};
