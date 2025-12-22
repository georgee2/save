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
        Schema::create('offer_fs_construction_costs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('offer_feasibility_study_id')->constrained('offer_feasibility_studies')->onDelete('cascade');
            $table->foreignId('substation_room_id')->nullable()->constrained('substation_rooms')->onDelete('set null');
            $table->decimal('substation_cost', 15, 2)->default(0);
            $table->foreignId('pumps_room_id')->nullable()->constrained('pumps_rooms')->onDelete('set null');
            $table->decimal('pumps_cost', 15, 2)->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offer_fs_construction_costs');
    }
};

