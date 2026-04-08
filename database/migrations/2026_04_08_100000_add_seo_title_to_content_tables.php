<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('seo_title_english', 200)->nullable()->after('slug');
            $table->string('seo_title_arabic', 200)->nullable()->after('seo_title_english');
        });

        Schema::table('offers', function (Blueprint $table) {
            $table->string('seo_title_english', 200)->nullable()->after('slug');
            $table->string('seo_title_arabic', 200)->nullable()->after('seo_title_english');
        });

        Schema::table('interior_design_galleries', function (Blueprint $table) {
            $table->string('seo_title_english', 200)->nullable()->after('slug');
            $table->string('seo_title_arabic', 200)->nullable()->after('seo_title_english');
        });

        Schema::table('services', function (Blueprint $table) {
            $table->string('seo_title_english', 200)->nullable()->after('slug');
            $table->string('seo_title_arabic', 200)->nullable()->after('seo_title_english');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['seo_title_english', 'seo_title_arabic']);
        });
        Schema::table('offers', function (Blueprint $table) {
            $table->dropColumn(['seo_title_english', 'seo_title_arabic']);
        });
        Schema::table('interior_design_galleries', function (Blueprint $table) {
            $table->dropColumn(['seo_title_english', 'seo_title_arabic']);
        });
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['seo_title_english', 'seo_title_arabic']);
        });
    }
};
