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
        Schema::create('service_features', function (Blueprint $table) {
            $table->id();
            $table->string('title_english');
            $table->string('title_arabic');
            $table->text('description_english');
            $table->text('description_arabic');
            $table->string('image')->nullable();
            $table->string('icon');
            $table->unsignedBigInteger('service_id');
            $table->timestamps();
            
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_features');
    }
};
