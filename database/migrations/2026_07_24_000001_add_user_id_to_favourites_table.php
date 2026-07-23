<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Link favourites to a customer account. Nullable so guest favourites keep
     * working unchanged; set when a guest's list is merged into their account.
     *
     * NOTE: the `favourites` table is MyISAM, which does not support foreign
     * keys — so this is a plain indexed column. Referential integrity is handled
     * in application code (FavouriteMergeService + Favourite::scopeForUser).
     */
    public function up(): void
    {
        Schema::table('favourites', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->index()->after('session_id');
        });
    }

    public function down(): void
    {
        Schema::table('favourites', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }
};
