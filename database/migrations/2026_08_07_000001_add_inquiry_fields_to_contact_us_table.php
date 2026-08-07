<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Lets a contact submission record which offer or project it is about, and when the
 * visitor would like to visit.
 *
 * The offer and project inquiry forms route into contact_us so their leads land in the CRM
 * workflow that already exists (assign agent, status, comments, replies). Without these
 * columns the enquiry arrives with no indication of what it refers to.
 *
 * related_id has no foreign key, matching the existing unconstrained agent_id: the target
 * lives in one of two tables depending on related_type, and a deleted offer should not
 * cascade away the lead it generated.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contact_us', function (Blueprint $table) {
            if (!Schema::hasColumn('contact_us', 'related_type')) {
                $table->string('related_type', 20)->nullable()->after('service_id');
            }
            if (!Schema::hasColumn('contact_us', 'related_id')) {
                $table->unsignedBigInteger('related_id')->nullable()->after('related_type');
            }
            if (!Schema::hasColumn('contact_us', 'preferred_date')) {
                $table->date('preferred_date')->nullable()->after('related_id');
            }
            if (!Schema::hasColumn('contact_us', 'preferred_time')) {
                $table->string('preferred_time', 20)->nullable()->after('preferred_date');
            }
        });
    }

    public function down(): void
    {
        Schema::table('contact_us', function (Blueprint $table) {
            $table->dropColumn(['related_type', 'related_id', 'preferred_date', 'preferred_time']);
        });
    }
};
