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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title_english');
            $table->string('title_arabic');
            $table->text('bio_english');
            $table->text('bio_arabic');
            $table->longText('body_english');
            $table->longText('body_arabic');
            $table->string('button_text')->nullable();
            $table->string('button_text_arabic')->nullable();
            $table->string('link_english')->nullable();
            $table->string('link_arabic')->nullable();
            $table->longText('seo_tags');
            $table->longText('seo_des_en');
            $table->longText('seo_des_ar');
            $table->string('image');
            $table->foreignId('category_code')->constrained('newscategories');
            $table->string('cover')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
