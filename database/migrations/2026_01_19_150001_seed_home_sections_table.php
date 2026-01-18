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
        // Seed default home sections based on current index.blade.php
        $sections = [
            [
                'name' => 'slider',
                'title_english' => 'Hero Slider',
                'title_arabic' => 'السلايدر الرئيسي',
                'blade_view' => 'home.slider',
                'icon' => 'fa fa-images',
                'ordering' => 1,
                'status' => 0,
                'show_divider' => 1, // No divider after slider
                'description' => 'Main hero slider section at the top of the homepage',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'subcategory',
                'title_english' => 'Engineering Categories',
                'title_arabic' => 'فئات الهندسة',
                'blade_view' => 'home.subcategory',
                'icon' => 'fa fa-th-large',
                'ordering' => 2,
                'status' => 0,
                'show_divider' => 0,
                'description' => 'Engineering subcategories showcase section',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'featuredprojects',
                'title_english' => 'Featured Projects',
                'title_arabic' => 'المشاريع المميزة',
                'blade_view' => 'home.featuredprojects',
                'icon' => 'fa fa-star',
                'ordering' => 3,
                'status' => 0,
                'show_divider' => 0,
                'description' => 'Featured projects slider section',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'offers',
                'title_english' => 'Special Offers',
                'title_arabic' => 'العروض الخاصة',
                'blade_view' => 'home.offers',
                'icon' => 'fa fa-tag',
                'ordering' => 4,
                'status' => 0,
                'show_divider' => 0,
                'description' => 'Special offers and deals section',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'about',
                'title_english' => 'About Us',
                'title_arabic' => 'من نحن',
                'blade_view' => 'home.about',
                'icon' => 'fa fa-info-circle',
                'ordering' => 5,
                'status' => 0,
                'show_divider' => 0,
                'description' => 'About us section with company information',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'interior-gallery',
                'title_english' => 'Interior Design Gallery',
                'title_arabic' => 'معرض التصميم الداخلي',
                'blade_view' => 'home.interior-gallery',
                'icon' => 'fa fa-paint-brush',
                'ordering' => 6,
                'status' => 0,
                'show_divider' => 0,
                'description' => 'Interior design gallery showcase',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'services',
                'title_english' => 'Our Services',
                'title_arabic' => 'خدماتنا',
                'blade_view' => 'home.services',
                'icon' => 'fa fa-cogs',
                'ordering' => 7,
                'status' => 0,
                'show_divider' => 0,
                'description' => 'Services showcase section',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'whychooseus',
                'title_english' => 'Why Choose Us',
                'title_arabic' => 'لماذا تختارنا',
                'blade_view' => 'home.whychooseus',
                'icon' => 'fa fa-check-circle',
                'ordering' => 8,
                'status' => 0,
                'show_divider' => 0,
                'description' => 'Why choose us section with features',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'projects',
                'title_english' => 'Projects Gallery',
                'title_arabic' => 'معرض المشاريع',
                'blade_view' => 'home.projects',
                'icon' => 'fa fa-building',
                'ordering' => 9,
                'status' => 0,
                'show_divider' => 0,
                'description' => 'Projects gallery with category tabs',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'team',
                'title_english' => 'Our Team',
                'title_arabic' => 'فريقنا',
                'blade_view' => 'home.team',
                'icon' => 'fa fa-users',
                'ordering' => 10,
                'status' => 0,
                'show_divider' => 0,
                'description' => 'Team members showcase section',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'contactfaq',
                'title_english' => 'Contact & FAQ',
                'title_arabic' => 'التواصل والأسئلة الشائعة',
                'blade_view' => 'home.contactfaq',
                'icon' => 'fa fa-question-circle',
                'ordering' => 11,
                'status' => 0,
                'show_divider' => 0,
                'description' => 'Contact information and FAQ section',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'news',
                'title_english' => 'Latest News',
                'title_arabic' => 'آخر الأخبار',
                'blade_view' => 'home.news',
                'icon' => 'fa fa-newspaper',
                'ordering' => 12,
                'status' => 0,
                'show_divider' => 0,
                'description' => 'Latest news and articles section',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'government-partners',
                'title_english' => 'Government Partners',
                'title_arabic' => 'الشركاء الحكوميون',
                'blade_view' => 'home.government-partners',
                'icon' => 'fa fa-handshake',
                'ordering' => 13,
                'status' => 0,
                'show_divider' => 1, // No divider after last section
                'description' => 'Government partners logos slider',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('home_sections')->insert($sections);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('home_sections')->truncate();
    }
};
