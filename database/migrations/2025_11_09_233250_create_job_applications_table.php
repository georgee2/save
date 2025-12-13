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
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained('jobs_postings')->onDelete('cascade');
            $table->string('applicant_name');
            $table->string('email');
            $table->string('phone', 50);
            $table->string('resume'); // File path to uploaded CV
            $table->text('cover_letter')->nullable();
            $table->enum('status', ['Received', 'Reviewed', 'Interview', 'Hired', 'Rejected'])->default('Received');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
