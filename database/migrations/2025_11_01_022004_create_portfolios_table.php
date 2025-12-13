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
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            $table->string('title_english');
            $table->string('title_arabic');
            $table->string('main_image')->comment('645x460 webp');
            $table->text('bio_english')->nullable();
            $table->text('bio_arabic')->nullable();
            $table->text('description_english'); // max 3000 chars
            $table->text('description_arabic'); // max 3000 chars
            $table->date('date');
            $table->string('icon')->comment('100x100 webp');
            $table->string('cover')->comment('1890x420 webp');
            $table->string('client_name');
            $table->foreignId('portfolio_type_id')->constrained('portfolio_types')->onDelete('cascade');
            $table->text('seo_tags')->nullable();
            $table->text('seo_description_english')->nullable();
            $table->text('seo_description_arabic')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0: Publish, 1: Not Publish');
            $table->tinyInteger('home_status')->default(0)->comment('0: Shown, 1: Not Shown');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolios');
    }
};
