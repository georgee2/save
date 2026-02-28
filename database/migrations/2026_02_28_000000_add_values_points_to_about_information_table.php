<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('about_information', function (Blueprint $table) {
            $table->text('values_points_english')->nullable()->after('values_arabic');
            $table->text('values_points_arabic')->nullable()->after('values_points_english');
        });
    }

    public function down(): void
    {
        Schema::table('about_information', function (Blueprint $table) {
            $table->dropColumn(['values_points_english', 'values_points_arabic']);
        });
    }
};
