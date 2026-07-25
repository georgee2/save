<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Records where a contact submission came from.
 *
 * Without these a spam wave cannot be attributed, blocked, or cleaned up after the fact:
 * there was no way to tell two submissions from one source apart. `source` was already
 * being validated and posted by the home page form, but then silently discarded, so lead
 * attribution was lost too.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contact_us', function (Blueprint $table) {
            // 45 chars covers IPv6, including IPv4-mapped form.
            $table->string('ip_address', 45)->nullable()->after('message');
            $table->string('user_agent', 255)->nullable()->after('ip_address');
            $table->string('source', 50)->nullable()->after('user_agent');
        });
    }

    public function down(): void
    {
        Schema::table('contact_us', function (Blueprint $table) {
            $table->dropColumn(['ip_address', 'user_agent', 'source']);
        });
    }
};
