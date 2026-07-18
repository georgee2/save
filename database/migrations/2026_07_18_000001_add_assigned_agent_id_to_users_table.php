<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Note: the `agents` table uses the MyISAM engine, which does not support
        // foreign keys, so this mirrors the existing `favourites.sales_agent_id`
        // pattern: a plain nullable, indexed reference column (no FK constraint).
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'assigned_agent_id')) {
                $table->unsignedBigInteger('assigned_agent_id')->nullable()->after('source');
                $table->index('assigned_agent_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'assigned_agent_id')) {
                $table->dropIndex(['assigned_agent_id']);
                $table->dropColumn('assigned_agent_id');
            }
        });
    }
};
