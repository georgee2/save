<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('alt_text_english', 200)->nullable()->after('main_image');
            $table->string('alt_text_arabic', 200)->nullable()->after('alt_text_english');
        });

        Schema::table('offers', function (Blueprint $table) {
            $table->string('alt_text_english', 200)->nullable()->after('main_image');
            $table->string('alt_text_arabic', 200)->nullable()->after('alt_text_english');
        });

        Schema::table('interior_design_galleries', function (Blueprint $table) {
            $table->string('alt_text_english', 200)->nullable()->after('image');
            $table->string('alt_text_arabic', 200)->nullable()->after('alt_text_english');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['alt_text_english', 'alt_text_arabic']);
        });
        Schema::table('offers', function (Blueprint $table) {
            $table->dropColumn(['alt_text_english', 'alt_text_arabic']);
        });
        Schema::table('interior_design_galleries', function (Blueprint $table) {
            $table->dropColumn(['alt_text_english', 'alt_text_arabic']);
        });
    }
};
