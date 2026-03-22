<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('favourite_email_logs', function (Blueprint $table) {
            $table->id();
            $table->string('session_id', 120)->index();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('to_email');
            $table->string('cc_email')->nullable();
            $table->string('subject');
            $table->text('body')->nullable();
            $table->json('attachments')->nullable();
            $table->enum('type', ['direct', 'notification'])->default('direct');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('favourite_email_logs');
    }
};
