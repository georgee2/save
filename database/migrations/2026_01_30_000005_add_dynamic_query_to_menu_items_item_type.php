<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Alter the ENUM column to add 'dynamic_query' type
        DB::statement("ALTER TABLE menu_items MODIFY COLUMN item_type ENUM(
            'static',
            'dynamic_services',
            'dynamic_offers',
            'dynamic_projects',
            'dynamic_news',
            'dynamic_query',
            'divider',
            'header'
        ) DEFAULT 'static'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original ENUM without 'dynamic_query'
        // First, update any dynamic_query items to static
        DB::table('menu_items')
            ->where('item_type', 'dynamic_query')
            ->update(['item_type' => 'static']);
            
        DB::statement("ALTER TABLE menu_items MODIFY COLUMN item_type ENUM(
            'static',
            'dynamic_services',
            'dynamic_offers',
            'dynamic_projects',
            'dynamic_news',
            'divider',
            'header'
        ) DEFAULT 'static'");
    }
};
