<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Backfill: clear customer assignments that point to a soft-deleted or
     * missing agent. Going forward, AgentController@destroy clears these on
     * delete, but pre-existing data may still hold stale references.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('users', 'assigned_agent_id')) {
            return;
        }

        DB::table('users')
            ->whereNotNull('assigned_agent_id')
            ->whereNotIn('assigned_agent_id', function ($q) {
                $q->select('id')->from('agents')->whereNull('deleted_at');
            })
            ->update(['assigned_agent_id' => null]);
    }

    public function down(): void
    {
        // No-op: cleared references cannot be reliably restored.
    }
};
