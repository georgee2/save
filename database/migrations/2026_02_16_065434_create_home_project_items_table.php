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
        Schema::create('home_project_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('home_project_setting_id')->constrained('home_project_settings')->onDelete('cascade');
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->integer('ordering')->default(0);
            $table->timestamps();
            
            $table->unique(['home_project_setting_id', 'project_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_project_items');
    }
};
