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
        Schema::create('offer_fs_income_components', function (Blueprint $table) {
            $table->id();
            $table->foreignId('offer_feasibility_study_id')->constrained('offer_feasibility_studies')->onDelete('cascade');
            $table->foreignId('income_component_id')->constrained('income_components')->onDelete('cascade');
            $table->integer('number_of_units')->default(0);
            $table->decimal('rent_per_year', 15, 2)->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offer_fs_income_components');
    }
};

