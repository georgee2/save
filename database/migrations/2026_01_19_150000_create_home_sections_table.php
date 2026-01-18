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
        Schema::create('home_sections', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Internal name (e.g., 'slider', 'about', 'services')
            $table->string('title_english'); // Display title in English
            $table->string('title_arabic'); // Display title in Arabic
            $table->string('blade_view'); // Blade view path (e.g., 'home.slider', 'home.about')
            $table->string('icon')->nullable(); // Icon class for admin display
            $table->integer('ordering')->default(0); // Sort order
            $table->boolean('status')->default(0); // 0: Active, 1: Inactive
            $table->boolean('show_divider')->default(1); // 0: Show divider after, 1: No divider
            $table->text('description')->nullable(); // Optional description
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_sections');
    }
};
