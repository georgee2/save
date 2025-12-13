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
        Schema::create('home_blocks', function (Blueprint $table) {
            $table->id();
            $table->string('title_english', 100);
            $table->string('title_arabic', 100);
            $table->string('subtitle_english', 75)->nullable();
            $table->string('subtitle_arabic', 75)->nullable();
            $table->string('button_text_english', 50)->nullable();
            $table->string('button_text_arabic', 50)->nullable();
            $table->string('url_english')->nullable();
            $table->string('url_arabic')->nullable();
            $table->enum('location', ['about_section', 'why_choose_us']);
            $table->boolean('status')->default(0)->comment('0: active, 1: not active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_blocks');
    }
};
