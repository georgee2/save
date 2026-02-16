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
        Schema::create('home_project_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('engineering_categories')->onDelete('cascade');
            $table->integer('max_projects')->default(9);
            $table->integer('ordering')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
            
            $table->unique('category_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_project_settings');
    }
};
