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
        Schema::create('fs_construction_costs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('feasibility_study_id')->constrained('feasibility_studies')->onDelete('cascade');
            $table->foreignId('substation_room_id')->nullable()->constrained('substation_rooms')->onDelete('cascade');
            $table->decimal('substation_cost', 15, 2)->nullable();
            $table->foreignId('pumps_room_id')->nullable()->constrained('pumps_rooms')->onDelete('cascade');
            $table->decimal('pumps_cost', 15, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            // Add indexes
            $table->index('feasibility_study_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fs_construction_costs');
    }
};

