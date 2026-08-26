<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // A user is only allowed one FCM token going forward. Any user with more
        // than one existing row keeps just their most recently updated token before
        // the unique index is added below, so this migration is safe to run even
        // where duplicates already exist.
        DB::table('user_fcm_tokens')
            ->select('user_id')
            ->groupBy('user_id')
            ->havingRaw('COUNT(*) > 1')
            ->pluck('user_id')
            ->each(function ($userId) {
                $keepId = DB::table('user_fcm_tokens')
                    ->where('user_id', $userId)
                    ->orderByDesc('updated_at')
                    ->value('id');

                DB::table('user_fcm_tokens')
                    ->where('user_id', $userId)
                    ->where('id', '!=', $keepId)
                    ->delete();
            });

        Schema::table('user_fcm_tokens', function (Blueprint $table) {
            $table->unique('user_id');
        });
    }

    public function down(): void
    {
        Schema::table('user_fcm_tokens', function (Blueprint $table) {
            $table->dropUnique(['user_id']);
        });
    }
};
