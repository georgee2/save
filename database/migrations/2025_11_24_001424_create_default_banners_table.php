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
        Schema::create('default_banners', function (Blueprint $table) {
            $table->id();
            $table->string('title_english', 150);
            $table->string('title_arabic', 150);
            $table->string('background'); // 1890x492 webp image
            $table->tinyInteger('status')->default(0)->comment('0: Active, 1: Not Active');
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('default_banners');
    }
};
