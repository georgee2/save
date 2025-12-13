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
        Schema::create('fs_length_components', function (Blueprint $table) {
            $table->id();
            $table->foreignId('feasibility_study_id')->constrained('feasibility_studies')->onDelete('cascade');
            $table->foreignId('building_component_id')->constrained('building_components')->onDelete('cascade');
            $table->foreignId('length_component_id')->constrained('length_components')->onDelete('cascade');
            $table->decimal('unit_cost', 15, 2);
            $table->timestamps();
            $table->softDeletes();
            
            // Add indexes
            $table->index('feasibility_study_id');
            $table->index('building_component_id');
            $table->index('length_component_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fs_length_components');
    }
};

