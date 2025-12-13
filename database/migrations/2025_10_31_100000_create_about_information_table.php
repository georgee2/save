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
        Schema::create('about_information', function (Blueprint $table) {
            $table->id();
            $table->string('title_english')->nullable();
            $table->string('title_arabic')->nullable();
            $table->string('subtitle_english')->nullable();
            $table->string('subtitle_arabic')->nullable();
            $table->text('about_english')->nullable();
            $table->text('about_arabic')->nullable();
            $table->string('about_image')->nullable();
            $table->text('mission_english')->nullable();
            $table->text('mission_arabic')->nullable();
            $table->string('mission_image')->nullable();
            $table->text('vision_english')->nullable();
            $table->text('vision_arabic')->nullable();
            $table->string('vision_image')->nullable();
            $table->text('values_english')->nullable();
            $table->text('values_arabic')->nullable();
            $table->string('values_image')->nullable();
            $table->string('page_cover_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_information');
    }
};

