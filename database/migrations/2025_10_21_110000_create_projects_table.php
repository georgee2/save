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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title_english');
            $table->string('title_arabic');
            $table->string('slug')->unique();
            
            // Foreign Keys
            $table->foreignId('category_id')->constrained('engineering_categories')->onDelete('cascade');
            $table->foreignId('subcategory_id')->nullable()->constrained('engineering_sub_categories')->onDelete('set null');
            $table->foreignId('currency_id')->nullable()->constrained('currencies')->onDelete('set null');
            $table->foreignId('style_id')->nullable()->constrained('project_styles')->onDelete('set null');
            $table->foreignId('type_id')->constrained('project_types')->onDelete('cascade');
            
            // Area measurements
            $table->decimal('sqft', 10, 2)->nullable();
            $table->decimal('sqm', 10, 2)->nullable();
            
            // URLs
            $table->string('video_url')->nullable();
            $table->string('tour_url')->nullable();
            
            // Images
            $table->string('main_image');
            $table->string('site_image')->nullable();
            $table->string('plan_2d_image')->nullable();
            $table->string('plan_3d_image')->nullable();
            
            // Descriptions
            $table->text('description_english')->nullable();
            $table->text('description_arabic')->nullable();
            $table->string('bio_english', 500)->nullable();
            $table->string('bio_arabic', 500)->nullable();
            
            // SEO
            $table->string('seo_tags')->nullable();
            $table->text('seo_description_english')->nullable();
            $table->text('seo_description_arabic')->nullable();
            
            // Status fields
            $table->tinyInteger('home_status')->default(1)->comment('0: Shown on home, 1: Not shown');
            $table->tinyInteger('publish_status')->default(1)->comment('0: Published, 1: Unpublished');
            
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};

