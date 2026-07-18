<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('customer_email_logs', function (Blueprint $table) {
            if (!Schema::hasColumn('customer_email_logs', 'status')) {
                $table->enum('status', ['queued', 'sent', 'failed'])->default('queued')->after('type');
            }
        });

        // Existing rows predate async status tracking; treat them as sent.
        DB::table('customer_email_logs')->update(['status' => 'sent']);
    }

    public function down(): void
    {
        Schema::table('customer_email_logs', function (Blueprint $table) {
            if (Schema::hasColumn('customer_email_logs', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
