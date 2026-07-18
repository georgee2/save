<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Minimal local mirror of ERPNext projects (master plan section 5.2), so the
 * customer project list page is fast + filterable. Full detail is fetched live +
 * cached via ErpNextService. Populated later by the webhook / on-read sync.
 *
 * user_id is a plain indexed column (NOT a foreign key) to stay compatible with
 * the mixed MyISAM/InnoDB table engines in this database.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('customer_projects')) {
            return;
        }

        Schema::create('customer_projects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->string('erp_project_id')->unique();
            $table->string('name')->nullable();
            $table->string('status')->nullable();
            $table->unsignedTinyInteger('progress_percent')->default(0);
            $table->string('contract_ref')->nullable();
            $table->timestamp('last_synced_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_projects');
    }
};
