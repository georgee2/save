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
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        // Alter the ENUM column to add 'category_with_subs' type
        DB::statement("ALTER TABLE menu_items MODIFY COLUMN item_type ENUM(
            'static',
            'dynamic_services',
            'dynamic_offers',
            'dynamic_projects',
            'dynamic_news',
            'dynamic_query',
            'category_with_subs',
            'divider',
            'header'
        ) DEFAULT 'static'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        // Revert back to ENUM without 'category_with_subs'
        // First, update any category_with_subs items to static
        DB::table('menu_items')
            ->where('item_type', 'category_with_subs')
            ->update(['item_type' => 'static']);
            
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
};
