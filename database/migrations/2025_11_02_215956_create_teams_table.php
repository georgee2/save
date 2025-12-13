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
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name_english');
            $table->string('name_arabic');
            
            // Foreign Keys
            $table->foreignId('job_title_id')->constrained('job_titles')->onDelete('cascade');
            $table->foreignId('rank_id')->constrained('ranks')->onDelete('cascade');
            
            // Contact Information
            $table->string('email');
            $table->string('mobile');
            
            // Images
            $table->string('main_image');
            $table->string('icon');
            $table->string('page_image');
            
            // Work Experience
            $table->text('work_experience_english')->nullable();
            $table->text('work_experience_arabic')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
