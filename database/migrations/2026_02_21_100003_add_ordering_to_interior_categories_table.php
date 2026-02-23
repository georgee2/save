<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('interior_categories', function (Blueprint $table) {
            $table->integer('ordering')->default(0)->after('slug');
            $table->tinyInteger('publish_status')->default(0)->after('ordering');
        });

        // Set initial ordering based on existing order
        $categories = DB::table('interior_categories')
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'asc')
            ->get();

        foreach ($categories as $index => $category) {
            DB::table('interior_categories')
                ->where('id', $category->id)
                ->update(['ordering' => $index + 1]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('interior_categories', function (Blueprint $table) {
            $table->dropColumn('ordering');
            $table->dropColumn('publish_status');
        });
    }
};
