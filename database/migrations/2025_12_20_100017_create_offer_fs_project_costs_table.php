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
        Schema::create('offer_fs_project_costs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('offer_feasibility_study_id')->constrained('offer_feasibility_studies')->onDelete('cascade');
            $table->decimal('land_cost', 15, 2)->default(0);
            $table->decimal('consultant_cost', 15, 2)->default(0);
            $table->decimal('government_fees', 15, 2)->default(0);
            $table->decimal('additional_fees', 15, 2)->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offer_fs_project_costs');
    }
};

