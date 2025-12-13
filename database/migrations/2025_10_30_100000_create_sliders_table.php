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
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('title_english', 255);
            $table->string('title_arabic', 255);
            $table->text('bio_english');
            $table->text('bio_arabic');
            $table->string('button_text_english', 50)->nullable();
            $table->string('button_text_arabic', 50)->nullable();
            $table->string('url_english')->nullable();
            $table->string('url_arabic')->nullable();
            $table->string('image');
            $table->integer('ordering')->default(0);
            $table->tinyInteger('status')->default(0)->comment('0: Publish, 1: Not Publish');
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes for better performance
            $table->index('status');
            $table->index('ordering');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sliders');
    }
};

