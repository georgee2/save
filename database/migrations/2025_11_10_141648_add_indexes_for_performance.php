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
        // Add indexes to services table
        Schema::table('services', function (Blueprint $table) {
            $table->index('publish_status');
            $table->index('deleted_at');
            $table->index(['publish_status', 'deleted_at']);
        });
        
        // Add indexes to projects table
        Schema::table('projects', function (Blueprint $table) {
            $table->index('publish_status');
            $table->index('home_status');
            $table->index('deleted_at');
            $table->index('category_id');
            $table->index('type_id');
            $table->index(['publish_status', 'deleted_at']);
        });
        
        // Add indexes to portfolios table
        Schema::table('portfolios', function (Blueprint $table) {
            $table->index('deleted_at');
        });
        
        // Add indexes to showcases table
        Schema::table('showcases', function (Blueprint $table) {
            $table->index('status');
            $table->index('home_status');
            $table->index('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop indexes from services table
        Schema::table('services', function (Blueprint $table) {
            $table->dropIndex(['publish_status']);
            $table->dropIndex(['deleted_at']);
            $table->dropIndex(['publish_status', 'deleted_at']);
        });
        
        // Drop indexes from projects table
        Schema::table('projects', function (Blueprint $table) {
            $table->dropIndex(['publish_status']);
            $table->dropIndex(['home_status']);
            $table->dropIndex(['deleted_at']);
            $table->dropIndex(['category_id']);
            $table->dropIndex(['type_id']);
            $table->dropIndex(['publish_status', 'deleted_at']);
        });
        
        // Drop indexes from portfolios table
        Schema::table('portfolios', function (Blueprint $table) {
            $table->dropIndex(['deleted_at']);
        });
        
        // Drop indexes from showcases table
        Schema::table('showcases', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['home_status']);
            $table->dropIndex(['deleted_at']);
        });
    }
};
