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
            // Add new image fields
            $table->string('cover_image')->nullable()->after('main_image')->comment('1890x420 WebP');
            $table->string('page_image')->nullable()->after('cover_image')->comment('868x450 WebP');
            
            // Note: site_image, plan_2d_image, and plan_3d_image already exist in the table
            // We'll just document the expected dimensions in comments for clarity
        });
        
        // Add comments to existing image columns to document expected dimensions
        DB::statement("ALTER TABLE projects MODIFY COLUMN main_image VARCHAR(255) COMMENT '820x550 WebP'");
        DB::statement("ALTER TABLE projects MODIFY COLUMN site_image VARCHAR(255) NULL COMMENT '420x420 WebP'");
        DB::statement("ALTER TABLE projects MODIFY COLUMN plan_2d_image VARCHAR(255) NULL COMMENT '420x420 WebP (2D Plan)'");
        DB::statement("ALTER TABLE projects MODIFY COLUMN plan_3d_image VARCHAR(255) NULL COMMENT '870x420 WebP (3D Image)'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['cover_image', 'page_image']);
        });
        
        // Remove comments (optional, as they don't affect functionality)
        DB::statement("ALTER TABLE projects MODIFY COLUMN main_image VARCHAR(255)");
        DB::statement("ALTER TABLE projects MODIFY COLUMN site_image VARCHAR(255) NULL");
        DB::statement("ALTER TABLE projects MODIFY COLUMN plan_2d_image VARCHAR(255) NULL");
        DB::statement("ALTER TABLE projects MODIFY COLUMN plan_3d_image VARCHAR(255) NULL");
    }
};

