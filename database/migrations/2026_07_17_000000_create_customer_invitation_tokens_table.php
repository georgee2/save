<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Dedicated token store for customer account-activation invites.
 * Mirrors password_reset_tokens but is driven by the `invitations` password
 * broker (config/auth.php) with a long expiry, so activation links stay valid
 * long after registration while password-reset links remain short-lived.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_invitation_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_invitation_tokens');
    }
};
