<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contact_us_email_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contact_us_id')->index();
            $table->unsignedBigInteger('user_id');
            $table->string('to_email');
            $table->string('subject');
            $table->text('body');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_us_email_logs');
    }
};
