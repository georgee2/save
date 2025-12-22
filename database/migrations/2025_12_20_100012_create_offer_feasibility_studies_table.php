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
        Schema::create('offer_feasibility_studies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('offer_id')->constrained('offers')->onDelete('cascade');
            $table->foreignId('emirate_id')->constrained('emirates')->onDelete('cascade');
            $table->string('study_name');
            $table->enum('study_type', ['Master', 'Custom'])->default('Custom');
            $table->text('description')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('currency_id')->nullable()->constrained('currencies')->onDelete('set null');
            $table->enum('status', ['Draft', 'Active', 'Archived'])->default('Draft');
            $table->timestamps();
            $table->softDeletes();
            
            // Add indexes for better query performance
            $table->index('offer_id');
            $table->index('emirate_id');
            $table->index('study_type');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offer_feasibility_studies');
    }
};

