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
        Schema::create('showcase_service', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('showcase_id');
            $table->unsignedBigInteger('service_id');
            $table->timestamps();
            
            // Foreign keys
            $table->foreign('showcase_id')->references('id')->on('showcases')->onDelete('cascade');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            
            // Unique constraint to prevent duplicate entries
            $table->unique(['showcase_id', 'service_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('showcase_service');
    }
};
