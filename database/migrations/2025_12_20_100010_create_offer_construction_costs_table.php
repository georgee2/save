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
        Schema::create('offer_construction_costs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('offer_id')->constrained('offers')->onDelete('cascade');
            $table->unsignedBigInteger('feasibility_study_component_id');
            $table->foreignId('substation_room_id')->nullable()->constrained('substation_rooms')->onDelete('cascade');
            $table->foreignId('pumps_room_id')->nullable()->constrained('pumps_rooms')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
            
            // Add foreign key with custom short name
            $table->foreign('feasibility_study_component_id', 'occ_fsc_id_foreign')
                  ->references('id')
                  ->on('feasibility_study_components')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offer_construction_costs');
    }
};

