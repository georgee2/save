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
        Schema::create('offer_building_components', function (Blueprint $table) {
            $table->id();
            $table->foreignId('offer_id')->constrained('offers')->onDelete('cascade');
            $table->foreignId('building_component_id')->constrained('building_components')->onDelete('cascade');
            $table->decimal('construction_cost', 15, 2);
            $table->timestamps();
            $table->softDeletes();
            
            // Unique constraint to prevent duplicate entries
            $table->unique(['offer_id', 'building_component_id'], 'offer_component_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offer_building_components');
    }
};

