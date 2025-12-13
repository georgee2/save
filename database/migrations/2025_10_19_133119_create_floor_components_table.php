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
        Schema::create('floor_components', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_type_id')->constrained('project_types')->onDelete('cascade');
            $table->foreignId('component_id')->constrained('building_components')->onDelete('cascade');
            $table->string('name_english');
            $table->string('name_arabic');
            $table->string('icon');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('floor_components');
    }
};
