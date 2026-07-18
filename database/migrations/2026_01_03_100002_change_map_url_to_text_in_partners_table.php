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
        // Column type change requires doctrine/dbal (MySQL); skip on other drivers (e.g. SQLite in tests).
        if (\Illuminate\Support\Facades\DB::getDriverName() !== 'mysql') {
            return;
        }

        Schema::table('partners', function (Blueprint $table) {
            $table->text('map_url')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (\Illuminate\Support\Facades\DB::getDriverName() !== 'mysql') {
            return;
        }

        Schema::table('partners', function (Blueprint $table) {
            $table->string('map_url')->nullable()->change();
        });
    }
};

