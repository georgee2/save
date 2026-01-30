<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * This migration adds query filter columns to menu_items table
     * to support dynamic content filtering by categories/subcategories.
     */
    public function up(): void
    {
        Schema::table('menu_items', function (Blueprint $table) {
            // Query source type: offers, projects, interior
            $table->string('query_source', 50)->nullable()->after('item_type');
            
            // Selected category IDs (JSON array)
            $table->json('query_category_ids')->nullable()->after('query_source');
            
            // Selected subcategory IDs (JSON array) - for offers and projects only
            $table->json('query_subcategory_ids')->nullable()->after('query_category_ids');
            
            // Query type: 'category', 'subcategory', or 'all'
            $table->string('query_type', 20)->nullable()->after('query_subcategory_ids');
            
            // Additional query options (JSON) - for future extensibility
            $table->json('query_options')->nullable()->after('query_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->dropColumn([
                'query_source',
                'query_category_ids',
                'query_subcategory_ids',
                'query_type',
                'query_options',
            ]);
        });
    }
};
