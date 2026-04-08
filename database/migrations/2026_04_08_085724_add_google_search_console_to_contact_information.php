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
        Schema::table('contact_information', function (Blueprint $table) {
            $table->string('google_search_console', 500)->nullable()->after('confirmation_email_body_ar');
            $table->string('google_analytics', 500)->nullable()->after('google_search_console');
            $table->string('facebook_pixel', 500)->nullable()->after('google_analytics');
        });
    }

    public function down(): void
    {
        Schema::table('contact_information', function (Blueprint $table) {
            $table->dropColumn(['google_search_console', 'google_analytics', 'facebook_pixel']);
        });
    }
};
