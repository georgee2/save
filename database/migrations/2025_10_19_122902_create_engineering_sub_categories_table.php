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
        Schema::create('engineering_sub_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('engineering_categories')->onDelete('cascade');
            $table->string('title_english');
            $table->string('title_arabic');
            $table->string('bio_english', 500)->nullable();
            $table->string('bio_arabic', 500)->nullable();
            $table->text('description_english')->nullable();
            $table->text('description_arabic')->nullable();
            $table->string('icon');
            $table->string('image')->nullable();
            $table->string('cover')->nullable();
            $table->text('seo_tags')->nullable();
            $table->text('seo_description_english')->nullable();
            $table->text('seo_description_arabic')->nullable();
            $table->string('slug')->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('engineering_sub_categories');
    }
};
