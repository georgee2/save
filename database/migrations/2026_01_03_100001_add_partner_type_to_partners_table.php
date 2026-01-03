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
        Schema::table('partners', function (Blueprint $table) {
            // partner_type: 'partner', 'branch', or 'government'
            $table->enum('partner_type', ['partner', 'branch', 'government'])->default('partner')->after('id');
            // display_order for sorting partners and branches separately
            $table->integer('display_order')->nullable()->after('partner_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('partners', function (Blueprint $table) {
            $table->dropColumn(['partner_type', 'display_order']);
        });
    }
};

