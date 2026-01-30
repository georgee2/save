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
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->constrained('menus')->onDelete('cascade');
            $table->foreignId('parent_id')->nullable()->constrained('menu_items')->onDelete('cascade');
            
            // Menu item content
            $table->string('title_english', 150);
            $table->string('title_arabic', 150)->nullable();
            $table->text('description_english')->nullable();
            $table->text('description_arabic')->nullable();
            
            // Link configuration
            $table->string('url', 500)->nullable(); // External URL or custom URL
            $table->string('route_name', 150)->nullable(); // Laravel route name
            $table->json('route_params')->nullable(); // Route parameters as JSON
            $table->enum('link_target', ['_self', '_blank'])->default('_self');
            
            // Visual configuration
            $table->string('icon', 100)->nullable(); // Font Awesome class or image path
            $table->string('icon_type', 20)->default('fontawesome'); // fontawesome, image, svg
            $table->string('css_class', 200)->nullable(); // Additional CSS classes
            
            // Item type - determines how item is rendered/sourced
            $table->enum('item_type', [
                'static',           // Manual/static link
                'dynamic_services', // Dynamic: pulls from services
                'dynamic_offers',   // Dynamic: pulls from offer categories
                'dynamic_projects', // Dynamic: pulls from project categories
                'dynamic_news',     // Dynamic: pulls from news categories
                'dynamic_query',    // Dynamic: custom query from categories/subcategories
                'divider',          // Menu divider/separator
                'header'            // Section header (non-clickable)
            ])->default('static');
            
            // Dynamic content settings (for dynamic types)
            $table->boolean('show_children')->default(true); // Show sub-items for dynamic types
            $table->integer('max_children')->nullable(); // Limit number of children shown
            
            // Status and visibility
            $table->boolean('is_active')->default(true);
            $table->boolean('is_visible_desktop')->default(true);
            $table->boolean('is_visible_mobile')->default(true);
            
            // Conditional visibility
            $table->boolean('requires_auth')->default(false);
            $table->boolean('requires_guest')->default(false);
            $table->string('permission')->nullable(); // Required permission to view
            
            // Ordering
            $table->integer('order')->default(0);
            $table->integer('depth')->default(0); // Nesting level (0 = root)
            
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes for performance
            $table->index(['menu_id', 'parent_id', 'order']);
            $table->index(['menu_id', 'is_active', 'order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};
