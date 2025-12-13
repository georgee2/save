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
        Schema::create('contact_information', function (Blueprint $table) {
            $table->id();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('secondary_mobile')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('twitter')->nullable();
            $table->string('pinterest')->nullable();
            $table->string('location_text_english')->nullable();
            $table->string('location_text_arabic')->nullable();
            $table->text('location_map')->nullable();
            $table->string('footer_bio_english', 250)->nullable();
            $table->string('footer_bio_arabic', 250)->nullable();
            $table->text('tags')->nullable(); // Comma-separated tags string
            $table->text('seo_description_english')->nullable();
            $table->text('seo_description_arabic')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_information');
    }
};

