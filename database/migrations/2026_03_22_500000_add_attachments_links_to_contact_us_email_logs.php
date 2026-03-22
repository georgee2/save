<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contact_us_email_logs', function (Blueprint $table) {
            $table->text('attachments')->nullable()->after('body');
            $table->text('links')->nullable()->after('attachments');
        });
    }

    public function down(): void
    {
        Schema::table('contact_us_email_logs', function (Blueprint $table) {
            $table->dropColumn(['attachments', 'links']);
        });
    }
};
