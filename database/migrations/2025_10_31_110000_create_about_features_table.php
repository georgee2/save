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
        Schema::create('about_features', function (Blueprint $table) {
            $table->id();
            $table->string('icon')->nullable();
            $table->string('title_english');
            $table->string('title_arabic');
            $table->text('description_english');
            $table->text('description_arabic');
            $table->tinyInteger('status')->default(0)->comment('0: Active, 1: Not Active');
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_features');
    }
};

