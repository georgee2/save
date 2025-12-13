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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title_english');
            $table->string('title_arabic');
            $table->text('description_english');
            $table->text('description_arabic');
            $table->text('bio_english');
            $table->text('bio_arabic');
            $table->string('main_image')->nullable();
            $table->string('icon')->nullable();
            $table->string('hero_image')->nullable();
            $table->unsignedBigInteger('service_id')->nullable();
            $table->string('seo_tags')->nullable();
            $table->text('seo_des_en')->nullable();
            $table->text('seo_des_ar')->nullable();
            $table->boolean('is_sub_service')->default(false);
            $table->string('slug')->unique();
            $table->timestamps();
            
            // Foreign key for parent service
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
