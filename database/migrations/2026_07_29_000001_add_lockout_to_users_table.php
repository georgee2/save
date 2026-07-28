<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Durable brute-force lockout.
 *
 * Every login limiter keyed on the IP, so one account had no aggregate attempt ceiling: an
 * attacker rotating IPs got 5 tries per minute per IP against a single address, unbounded in
 * total. The rate limiter alone is not enough to fix that because it lives in the cache,
 * which a deploy or a cache flush wipes. This column is the durable half.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'locked_until')) {
                $table->timestamp('locked_until')->nullable()->after('is_active');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'locked_until')) {
                $table->dropColumn('locked_until');
            }
        });
    }
};
