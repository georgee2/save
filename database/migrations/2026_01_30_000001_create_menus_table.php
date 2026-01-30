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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('title_english', 100);
            $table->string('title_arabic', 100)->nullable();
            $table->string('slug', 100)->unique();
            $table->text('description_english')->nullable();
            $table->text('description_arabic')->nullable();
            $table->string('location', 50)->default('header'); // header, footer, sidebar, etc.
            $table->boolean('is_primary')->default(false); // Primary menu cannot be deleted
            $table->boolean('is_active')->default(true);
            $table->boolean('is_deletable')->default(true); // If false, menu cannot be deleted (system menus)
            $table->integer('order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
