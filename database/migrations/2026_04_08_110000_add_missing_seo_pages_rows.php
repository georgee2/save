<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('seo_pages')->insertOrIgnore([
            ['page_key' => 'about', 'page_name' => 'About Us', 'created_at' => now(), 'updated_at' => now()],
            ['page_key' => 'contact', 'page_name' => 'Contact Us', 'created_at' => now(), 'updated_at' => now()],
            ['page_key' => 'careers', 'page_name' => 'Careers', 'created_at' => now(), 'updated_at' => now()],
            ['page_key' => 'favourites', 'page_name' => 'Favourites', 'created_at' => now(), 'updated_at' => now()],
            ['page_key' => 'featured_projects', 'page_name' => 'Featured Projects', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        DB::table('seo_pages')->whereIn('page_key', ['about', 'contact', 'careers', 'favourites', 'featured_projects'])->delete();
    }
};
