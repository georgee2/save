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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->string('name_english', 255);
            $table->string('name_arabic', 255);
            $table->string('image')->nullable();
            $table->string('bio_english', 300)->nullable();
            $table->string('bio_arabic', 300)->nullable();
            $table->integer('ordering')->default(0);
            $table->tinyInteger('publish_status')->default(0)->comment('0=not published, 1=published');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
