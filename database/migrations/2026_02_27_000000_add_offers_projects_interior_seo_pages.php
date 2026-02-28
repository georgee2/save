<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('seo_pages')->insertOrIgnore([
            ['page_key' => 'offers_index', 'page_name' => 'Offers Index', 'created_at' => now(), 'updated_at' => now()],
            ['page_key' => 'projects_index', 'page_name' => 'Projects Index', 'created_at' => now(), 'updated_at' => now()],
            ['page_key' => 'interior_index', 'page_name' => 'Interior Design Index', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        DB::table('seo_pages')->whereIn('page_key', ['offers_index', 'projects_index', 'interior_index'])->delete();
    }
};
