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
        Schema::create('service_titles', function (Blueprint $table) {
            $table->id();
            $table->string('title_english');
            $table->string('title_arabic');
            $table->string('subtitle_english')->nullable();
            $table->string('subtitle_arabic')->nullable();
            $table->enum('target', ['features', 'processes', 'values', 'faqs', 'sub_services'])->comment('Section target: features, processes, values, faqs, sub_services');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_titles');
    }
};
