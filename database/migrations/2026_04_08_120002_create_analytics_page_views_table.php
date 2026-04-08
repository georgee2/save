<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('analytics_page_views', function (Blueprint $table) {
            $table->id();
            $table->uuid('session_id');
            $table->uuid('visitor_id');
            $table->text('url');
            $table->string('page_title', 500)->nullable();
            $table->string('route_name', 200)->nullable();
            $table->text('referrer')->nullable();
            $table->unsignedInteger('time_on_page')->nullable();
            $table->timestamp('viewed_at')->nullable();
            $table->timestamps();

            $table->index('session_id');
            $table->index('visitor_id');
            $table->index('viewed_at');
            $table->index('route_name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('analytics_page_views');
    }
};
