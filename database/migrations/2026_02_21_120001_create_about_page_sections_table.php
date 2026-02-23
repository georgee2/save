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
        Schema::create('about_page_sections', function (Blueprint $table) {
            $table->id();
            $table->string('section_key')->unique();
            $table->string('title_english');
            $table->string('title_arabic');
            $table->string('description')->nullable();
            $table->string('icon')->nullable();
            $table->string('blade_partial')->nullable();
            $table->integer('ordering')->default(0);
            $table->tinyInteger('status')->default(0); // 0 = active, 1 = inactive
            $table->timestamps();
        });

        // Insert default sections
        $sections = [
            [
                'section_key' => 'hero',
                'title_english' => 'Hero Section',
                'title_arabic' => 'قسم البطل',
                'description' => 'Page banner with breadcrumb, title and subtitle',
                'icon' => 'fa fa-image',
                'blade_partial' => 'pages.about.partials.hero',
                'ordering' => 1,
                'status' => 0,
            ],
            [
                'section_key' => 'about_content',
                'title_english' => 'About Content',
                'title_arabic' => 'محتوى من نحن',
                'description' => 'Main about section with image, text and key points',
                'icon' => 'fa fa-info-circle',
                'blade_partial' => 'pages.about.partials.about-content',
                'ordering' => 2,
                'status' => 0,
            ],
            [
                'section_key' => 'features',
                'title_english' => 'Features Section',
                'title_arabic' => 'قسم المميزات',
                'description' => 'Grid of feature cards with icons',
                'icon' => 'fa fa-star',
                'blade_partial' => 'pages.about.partials.features',
                'ordering' => 3,
                'status' => 0,
            ],
            [
                'section_key' => 'mission_vision_values',
                'title_english' => 'Mission, Vision & Values',
                'title_arabic' => 'الرسالة والرؤية والقيم',
                'description' => 'Company mission, vision and values sections',
                'icon' => 'fa fa-bullseye',
                'blade_partial' => 'pages.about.partials.mission-vision-values',
                'ordering' => 4,
                'status' => 0,
            ],
            [
                'section_key' => 'certificates',
                'title_english' => 'Certificates Section',
                'title_arabic' => 'قسم الشهادات',
                'description' => 'Certificates slider with lightbox gallery',
                'icon' => 'fa fa-certificate',
                'blade_partial' => 'pages.about.partials.certificates',
                'ordering' => 5,
                'status' => 0,
            ],
            [
                'section_key' => 'team',
                'title_english' => 'Team Section',
                'title_arabic' => 'قسم الفريق',
                'description' => 'Team members slider',
                'icon' => 'fa fa-users',
                'blade_partial' => 'pages.about.partials.team',
                'ordering' => 6,
                'status' => 0,
            ],
            [
                'section_key' => 'custom_blocks',
                'title_english' => 'Custom Blocks',
                'title_arabic' => 'الكتل المخصصة',
                'description' => 'Alternating layout content blocks',
                'icon' => 'fa fa-th-large',
                'blade_partial' => 'pages.about.partials.custom-blocks',
                'ordering' => 7,
                'status' => 0,
            ],
            [
                'section_key' => 'government_partners',
                'title_english' => 'Government Partners',
                'title_arabic' => 'الشركاء الحكوميين',
                'description' => 'Government partners slider',
                'icon' => 'fa fa-handshake-o',
                'blade_partial' => 'pages.about.partials.government-partners',
                'ordering' => 8,
                'status' => 0,
            ],
            [
                'section_key' => 'cta',
                'title_english' => 'Call to Action',
                'title_arabic' => 'دعوة للعمل',
                'description' => 'Contact us CTA section',
                'icon' => 'fa fa-bullhorn',
                'blade_partial' => 'pages.about.partials.cta',
                'ordering' => 9,
                'status' => 0,
            ],
        ];

        foreach ($sections as $section) {
            DB::table('about_page_sections')->insert(array_merge($section, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_page_sections');
    }
};
