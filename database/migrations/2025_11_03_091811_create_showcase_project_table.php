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
        Schema::create('showcase_project', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('showcase_id');
            $table->unsignedBigInteger('project_id');
            $table->timestamps();
            
            // Foreign keys
            $table->foreign('showcase_id')->references('id')->on('showcases')->onDelete('cascade');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            
            // Unique constraint to prevent duplicate entries
            $table->unique(['showcase_id', 'project_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('showcase_project');
    }
};
