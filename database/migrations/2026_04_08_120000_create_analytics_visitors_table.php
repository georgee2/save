<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('analytics_visitors', function (Blueprint $table) {
            $table->id();
            $table->uuid('visitor_id')->unique();
            $table->string('ip_address', 45)->nullable();
            $table->string('country', 100)->nullable();
            $table->string('country_code', 10)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('emirate', 50)->nullable();
            $table->string('device_type', 20)->default('desktop');
            $table->string('browser', 50)->nullable();
            $table->string('os', 50)->nullable();
            $table->timestamp('first_visit_at')->nullable();
            $table->timestamp('last_visit_at')->nullable();
            $table->unsignedInteger('total_visits')->default(0);
            $table->timestamps();

            $table->index('ip_address');
            $table->index('country_code');
            $table->index('emirate');
            $table->index('last_visit_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('analytics_visitors');
    }
};
