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
        Schema::create('jobs_postings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_title_id')->constrained('job_titles')->onDelete('cascade');
            $table->foreignId('job_category_id')->constrained('job_categories')->onDelete('cascade');
            $table->enum('job_type', ['Contract', 'Full Time', 'Intern', 'Hybrid', 'Remotely', 'Part-time']);
            $table->string('code')->unique();
            $table->decimal('salary', 10, 2)->nullable();
            $table->boolean('show_salary')->default(false);
            $table->date('registration_start_date');
            $table->date('registration_end_date');
            $table->text('job_description_en');
            $table->text('job_description_ar');
            $table->text('requirements_en')->nullable();
            $table->text('requirements_ar')->nullable();
            $table->text('responsibilities_en')->nullable();
            $table->text('responsibilities_ar')->nullable();
            $table->enum('status', ['Publish', 'Not Publish'])->default('Not Publish');
            $table->string('icon')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs_postings');
    }
};
