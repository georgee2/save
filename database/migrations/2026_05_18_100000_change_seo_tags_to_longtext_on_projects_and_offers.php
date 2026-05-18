<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE `projects` MODIFY `seo_tags` LONGTEXT NULL');
        DB::statement('ALTER TABLE `offers` MODIFY `seo_tags` LONGTEXT NULL');
    }

    public function down(): void
    {
        // Truncate any oversized values before narrowing the column so strict-mode MySQL doesn't reject the alter.
        DB::statement('UPDATE `projects` SET `seo_tags` = LEFT(`seo_tags`, 255) WHERE CHAR_LENGTH(`seo_tags`) > 255');
        DB::statement('UPDATE `offers`   SET `seo_tags` = LEFT(`seo_tags`, 255) WHERE CHAR_LENGTH(`seo_tags`) > 255');

        DB::statement('ALTER TABLE `projects` MODIFY `seo_tags` VARCHAR(255) NULL');
        DB::statement('ALTER TABLE `offers` MODIFY `seo_tags` VARCHAR(255) NULL');
    }
};
