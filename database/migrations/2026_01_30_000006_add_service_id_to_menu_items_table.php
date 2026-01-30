<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Add service_id column to menu_items table for single service selection
     */
    public function up(): void
    {
        Schema::table('menu_items', function (Blueprint $table) {
            // Add service_id for single service selection (used with dynamic_services type)
            $table->unsignedBigInteger('service_id')->nullable()->after('max_children');
            
            // Add index for better query performance
            $table->index('service_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->dropIndex(['service_id']);
            $table->dropColumn('service_id');
        });
    }
};
