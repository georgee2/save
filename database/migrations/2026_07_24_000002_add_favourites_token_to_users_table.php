<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Canonical per-customer favourites list id. A random UUID that becomes the
     * customer's stable `favourites.session_id` across devices (and doubles as
     * their share token — unguessable, never derived from user_id).
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->char('favourites_token', 36)->nullable()->unique()->after('erp_user_id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['favourites_token']);
            $table->dropColumn('favourites_token');
        });
    }
};
