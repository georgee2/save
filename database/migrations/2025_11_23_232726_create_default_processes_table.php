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
        Schema::create('default_processes', function (Blueprint $table) {
            $table->id();
            $table->string('title_english', 150);
            $table->string('title_arabic', 150);
            $table->string('sub_title_english', 100);
            $table->string('sub_title_arabic', 100);
            $table->string('bio_english', 150)->nullable();
            $table->string('bio_arabic', 150)->nullable();
            $table->string('button_text_english', 50)->nullable();
            $table->string('button_text_arabic', 50)->nullable();
            $table->string('url_english')->nullable();
            $table->string('url_arabic')->nullable();
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
        Schema::dropIfExists('default_processes');
    }
};
