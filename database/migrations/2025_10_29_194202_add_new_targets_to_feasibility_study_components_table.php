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
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        Schema::table('feasibility_study_components', function (Blueprint $table) {
            // Modify the target enum to include new values
            DB::statement("ALTER TABLE `feasibility_study_components` MODIFY `target` ENUM('Building Components', 'Income Components', 'Length Components', 'Construction Cost', 'Project Cost') NOT NULL");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        Schema::table('feasibility_study_components', function (Blueprint $table) {
            // Revert back to original enum values
            DB::statement("ALTER TABLE `feasibility_study_components` MODIFY `target` ENUM('Building Components', 'Income Components', 'Length Components') NOT NULL");
        });
    }
};
