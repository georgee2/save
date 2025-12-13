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
        Schema::table('showcases', function (Blueprint $table) {
            // Add slug column
            $table->string('slug')->unique()->after('title_arabic');
            
            // Add cover image column
            $table->string('cover_image')->nullable()->after('slug')->comment('1890x420 webp');
            
            // Note: main_image and page_image columns already exist
            // main_image will be 292x330 webp
            // page_image will be 870x450 webp
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('showcases', function (Blueprint $table) {
            $table->dropColumn(['slug', 'cover_image']);
        });
    }
};
