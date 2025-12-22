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
        Schema::create('offer_floors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('offer_id')->constrained('offers')->onDelete('cascade');
            $table->foreignId('building_component_id')->constrained('building_components')->onDelete('cascade');
            $table->foreignId('floor_component_id')->constrained('floor_components')->onDelete('cascade');
            
            // Area measurements
            $table->decimal('sqft', 10, 2);
            $table->decimal('sqm', 10, 2);
            
            // Count
            $table->integer('count');
            
            // Images
            $table->string('image_2d')->nullable();
            $table->string('image_3d');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offer_floors');
    }
};

