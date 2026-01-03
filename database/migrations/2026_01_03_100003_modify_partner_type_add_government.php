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
        // Modify the enum to include 'government' type
        DB::statement("ALTER TABLE partners MODIFY COLUMN partner_type ENUM('partner', 'branch', 'government') DEFAULT 'partner'");
        
        // Make email and mobile nullable for government partners
        Schema::table('partners', function (Blueprint $table) {
            $table->string('mobile')->nullable()->change();
            $table->string('email')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to original enum values
        DB::statement("ALTER TABLE partners MODIFY COLUMN partner_type ENUM('partner', 'branch') DEFAULT 'partner'");
        
        Schema::table('partners', function (Blueprint $table) {
            $table->string('mobile')->nullable(false)->change();
            $table->string('email')->nullable(false)->change();
        });
    }
};

