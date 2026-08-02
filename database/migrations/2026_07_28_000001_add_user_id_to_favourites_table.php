<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('favourites', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->after('id');
            $table->unique(['user_id', 'item_type', 'item_id'], 'fav_user_unique');
        });
    }

    public function down(): void
    {
        Schema::table('favourites', function (Blueprint $table) {
            $table->dropUnique('fav_user_unique');
            $table->dropColumn('user_id');
        });
    }
};
