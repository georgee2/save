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
        Schema::create('feasibility_study_components', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_type_id')->constrained('project_types')->onDelete('cascade');
            $table->enum('target', ['Building Components', 'Income Components', 'Length Components']);
            $table->string('header_english');
            $table->string('header_arabic');
            $table->string('title_english');
            $table->string('title_arabic');
            $table->enum('status', ['Active', 'Not Active'])->default('Active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feasibility_study_components');
    }
};

