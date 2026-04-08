<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('analytics_sessions', function (Blueprint $table) {
            $table->id();
            $table->uuid('session_id')->unique();
            $table->uuid('visitor_id');
            $table->string('ip_address', 45)->nullable();
            $table->text('entry_page')->nullable();
            $table->text('exit_page')->nullable();
            $table->unsignedInteger('page_count')->default(0);
            $table->unsignedInteger('duration_seconds')->default(0);
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended_at')->nullable();
            $table->boolean('is_bounce')->default(true);
            $table->timestamps();

            $table->index('visitor_id');
            $table->index('started_at');
            $table->index('is_bounce');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('analytics_sessions');
    }
};
