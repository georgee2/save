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
        Schema::create('facts', function (Blueprint $table) {
            $table->id();
            $table->string('title_english', 100);
            $table->string('title_arabic', 100);
            $table->string('icon'); // 100x100 webp image
            $table->string('fact_number', 50);
            $table->integer('ordering')->default(0);
            $table->tinyInteger('status')->default(0)->comment('0: Active, 1: Not Active');
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
        Schema::dropIfExists('facts');
    }
};
