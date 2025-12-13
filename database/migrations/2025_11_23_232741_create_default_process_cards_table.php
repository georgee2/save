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
        Schema::create('default_process_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('default_process_id')->constrained('default_processes')->onDelete('cascade');
            $table->string('title_english', 150);
            $table->string('title_arabic', 150);
            $table->string('bio_english', 300);
            $table->string('bio_arabic', 300);
            $table->integer('ordering')->default(0);
            $table->tinyInteger('status')->default(0)->comment('0: Active, 1: Not Active');
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index('default_process_id');
            $table->index('ordering');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('default_process_cards');
    }
};
