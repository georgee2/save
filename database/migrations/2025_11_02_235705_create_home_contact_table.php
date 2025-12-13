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
        Schema::create('home_contact', function (Blueprint $table) {
            $table->id();
            $table->string('title_english', 125);
            $table->string('title_arabic', 125);
            $table->string('subtitle_english', 50)->nullable();
            $table->string('subtitle_arabic', 50)->nullable();
            $table->string('background');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_contact');
    }
};
