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
        Schema::create('interior_design_galleries', function (Blueprint $table) {
            $table->id();
            $table->string('title_english');
            $table->string('title_arabic');
            $table->string('bio_english', 150)->nullable();
            $table->string('bio_arabic', 150)->nullable();
            $table->string('image'); // 765x432 converted to webp
            $table->tinyInteger('publish_status')->default(0); // 0 = published, 1 = not published
            $table->tinyInteger('home_status')->default(1); // 0 = shown on home, 1 = not shown
            $table->foreignId('project_id')->nullable()->constrained('projects')->onDelete('set null');
            $table->foreignId('project_style_id')->nullable()->constrained('project_styles')->onDelete('set null');
            $table->foreignId('project_type_id')->constrained('project_types')->onDelete('cascade');
            $table->foreignId('emirate_id')->nullable()->constrained('emirates')->onDelete('set null');
            $table->integer('ordering')->default(0);
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
        Schema::dropIfExists('interior_design_galleries');
    }
};
