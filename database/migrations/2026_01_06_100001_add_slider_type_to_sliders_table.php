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
        Schema::table('sliders', function (Blueprint $table) {
            // Slider type: 'default' (current behavior), 'project', 'offer'
            $table->enum('slider_type', ['default', 'project', 'offer'])->default('default')->after('id');
            
            // Foreign keys for project and offer (nullable)
            $table->unsignedBigInteger('project_id')->nullable()->after('slider_type');
            $table->unsignedBigInteger('offer_id')->nullable()->after('project_id');
            
            // Make title, bio fields nullable for project/offer types
            $table->string('title_english', 255)->nullable()->change();
            $table->string('title_arabic', 255)->nullable()->change();
            $table->text('bio_english')->nullable()->change();
            $table->text('bio_arabic')->nullable()->change();
            
            // Add indexes
            $table->index('slider_type');
            $table->index('project_id');
            $table->index('offer_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->dropIndex(['slider_type']);
            $table->dropIndex(['project_id']);
            $table->dropIndex(['offer_id']);
            
            $table->dropColumn(['slider_type', 'project_id', 'offer_id']);
        });
    }
};

