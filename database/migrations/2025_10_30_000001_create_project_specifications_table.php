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
        Schema::create('project_specifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->foreignId('specification_id')->constrained('specifications')->onDelete('cascade');
            $table->string('value_english');
            $table->string('value_arabic');
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes for better performance
            $table->index('project_id');
            $table->index('specification_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_specifications');
    }
};

