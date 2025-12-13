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
        Schema::create('home_faqs', function (Blueprint $table) {
            $table->id();
            $table->string('question_english');
            $table->string('question_arabic');
            $table->text('answer_english');
            $table->text('answer_arabic');
            $table->integer('order')->default(0);
            $table->tinyInteger('status')->default(0)->comment('0: Active, 1: Inactive');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_faqs');
    }
};
