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
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->enum('card_type', ['card_with_background', 'icon_card']);
            
            // Images
            $table->string('icon_dark')->nullable()->comment('100x100 webp - used in icon_card type');
            $table->string('icon_white')->nullable()->comment('100x100 webp - used in both types');
            $table->string('background')->nullable()->comment('300x300 webp - used in card_with_background type');
            
            // Text fields (only for icon_card type)
            $table->string('title_english', 100)->nullable();
            $table->string('title_arabic', 100)->nullable();
            $table->string('bio_english', 150)->nullable();
            $table->string('bio_arabic', 150)->nullable();
            
            // Foreign Key
            $table->foreignId('home_block_id')->constrained('home_blocks')->onDelete('cascade');
            
            // Status
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
        Schema::dropIfExists('cards');
    }
};
