<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seo_pages', function (Blueprint $table) {
            $table->id();
            $table->string('page_key')->unique();
            $table->string('page_name');
            $table->string('seo_title_english', 255)->nullable();
            $table->string('seo_title_arabic', 255)->nullable();
            $table->text('seo_description_english')->nullable();
            $table->text('seo_description_arabic')->nullable();
            $table->text('seo_tags')->nullable();
            $table->timestamps();
        });

        DB::table('seo_pages')->insert([
            ['page_key' => 'home', 'page_name' => 'Home Page', 'created_at' => now(), 'updated_at' => now()],
            ['page_key' => 'news_index', 'page_name' => 'News Index', 'created_at' => now(), 'updated_at' => now()],
            ['page_key' => 'branches', 'page_name' => 'Branches', 'created_at' => now(), 'updated_at' => now()],
            ['page_key' => 'partners', 'page_name' => 'Partners', 'created_at' => now(), 'updated_at' => now()],
            ['page_key' => 'government', 'page_name' => 'Government Partners', 'created_at' => now(), 'updated_at' => now()],
            ['page_key' => 'team', 'page_name' => 'Team Members', 'created_at' => now(), 'updated_at' => now()],
            ['page_key' => 'board', 'page_name' => 'Board of Directors', 'created_at' => now(), 'updated_at' => now()],
            ['page_key' => 'services_index', 'page_name' => 'Services Index', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('seo_pages');
    }
};
