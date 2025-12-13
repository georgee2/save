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
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->string('name_english');
            $table->string('name_arabic');
            $table->string('tax_number')->nullable();
            $table->string('website_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('map_url')->nullable();
            $table->text('location_text_english')->nullable();
            $table->text('location_text_arabic')->nullable();
            $table->string('office_number')->nullable();
            $table->string('mobile');
            $table->string('email');
            $table->string('logo_english');
            $table->string('logo_arabic');
            $table->longText('about_english')->nullable();
            $table->longText('about_arabic')->nullable();
            $table->longText('mission_english')->nullable();
            $table->longText('mission_arabic')->nullable();
            $table->longText('vision_english')->nullable();
            $table->longText('vision_arabic')->nullable();
            $table->string('seo_tags')->nullable();
            $table->text('seo_description_english')->nullable();
            $table->text('seo_description_arabic')->nullable();
            $table->string('opening_hours')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partners');
    }
};

