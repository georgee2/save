<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Server-side expiry for the email-change token.
 *
 * The only freshness check was the 24h signed URL, so the stored token itself never
 * expired: a link that leaked from a mailbox stayed usable indefinitely against the
 * database, and a request that was never completed left a live token behind forever.
 *
 * The token is also stored hashed from now on (see ProfileSettingsController), so a
 * database leak no longer hands over a working email-change confirmation.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'pending_email_expires_at')) {
                $table->timestamp('pending_email_expires_at')->nullable()->after('pending_email_token');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'pending_email_expires_at')) {
                $table->dropColumn('pending_email_expires_at');
            }
        });
    }
};
