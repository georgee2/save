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
        Schema::table('projects', function (Blueprint $table) {
            $table->string('project_code')->nullable()->after('id');
            $table->string('location_english')->nullable()->after('seo_description_arabic');
            $table->string('location_arabic')->nullable()->after('location_english');
            $table->decimal('project_cost', 15, 2)->nullable()->after('location_arabic');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['project_code', 'location_english', 'location_arabic', 'project_cost']);
        });
    }
};

