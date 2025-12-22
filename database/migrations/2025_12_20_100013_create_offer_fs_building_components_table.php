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
        Schema::create('offer_fs_building_components', function (Blueprint $table) {
            $table->id();
            $table->foreignId('offer_feasibility_study_id')->constrained('offer_feasibility_studies')->onDelete('cascade');
            $table->foreignId('building_component_id')->constrained('building_components')->onDelete('cascade');
            $table->decimal('construction_cost', 15, 2)->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offer_fs_building_components');
    }
};

