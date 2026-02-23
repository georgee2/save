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
        Schema::create('contact_page_sections', function (Blueprint $table) {
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
                'description' => 'Page banner with breadcrumb and title',
                'icon' => 'fa fa-image',
                'blade_partial' => 'pages.contact.partials.hero',
                'ordering' => 1,
                'status' => 0,
            ],
            [
                'section_key' => 'contact_info_cards',
                'title_english' => 'Contact Info Cards',
                'title_arabic' => 'بطاقات معلومات الاتصال',
                'description' => 'Phone, Email, and Location cards',
                'icon' => 'fa fa-id-card',
                'blade_partial' => 'pages.contact.partials.info-cards',
                'ordering' => 2,
                'status' => 0,
            ],
            [
                'section_key' => 'company_profile',
                'title_english' => 'Company Profile Download',
                'title_arabic' => 'تحميل ملف الشركة',
                'description' => 'Company profile PDF download section',
                'icon' => 'fa fa-file-pdf-o',
                'blade_partial' => 'pages.contact.partials.company-profile',
                'ordering' => 3,
                'status' => 0,
            ],
            [
                'section_key' => 'contact_form_map',
                'title_english' => 'Contact Form & Map',
                'title_arabic' => 'نموذج الاتصال والخريطة',
                'description' => 'Contact form with map and social links',
                'icon' => 'fa fa-envelope',
                'blade_partial' => 'pages.contact.partials.form-map',
                'ordering' => 4,
                'status' => 0,
            ],
            [
                'section_key' => 'branches',
                'title_english' => 'Branches Section',
                'title_arabic' => 'قسم الفروع',
                'description' => 'Company branches grid',
                'icon' => 'fa fa-building',
                'blade_partial' => 'pages.contact.partials.branches',
                'ordering' => 5,
                'status' => 0,
            ],
            [
                'section_key' => 'cta',
                'title_english' => 'Call to Action',
                'title_arabic' => 'دعوة للعمل',
                'description' => 'Quick response CTA with WhatsApp button',
                'icon' => 'fa fa-bullhorn',
                'blade_partial' => 'pages.contact.partials.cta',
                'ordering' => 6,
                'status' => 0,
            ],
        ];

        foreach ($sections as $section) {
            DB::table('contact_page_sections')->insert(array_merge($section, [
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
        Schema::dropIfExists('contact_page_sections');
    }
};
