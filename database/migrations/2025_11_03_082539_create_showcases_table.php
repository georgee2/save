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
        Schema::create('showcases', function (Blueprint $table) {
            $table->id();
            $table->string('title_english');
            $table->string('title_arabic');
            $table->string('main_image'); // 600x600 webp
            $table->string('page_image'); // 600x600 webp
            $table->longText('description_english');
            $table->longText('description_arabic');
            $table->string('seo_tags')->nullable();
            $table->text('seo_description_english')->nullable();
            $table->text('seo_description_arabic')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('home_status', ['shown', 'not_shown'])->default('not_shown');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('showcases');
    }
};
