<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ServiceTitle;
use Illuminate\Support\Facades\DB;

class ServiceTitlesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing titles
        DB::table('service_titles')->truncate();
        
        // Default service titles for each section
        $titles = [
            [
                'title_english' => 'Our Features',
                'title_arabic' => 'ميزاتنا',
                'subtitle_english' => 'What Makes Us Different',
                'subtitle_arabic' => 'ما يميزنا',
                'target' => 'features',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title_english' => 'Our Process',
                'title_arabic' => 'عمليتنا',
                'subtitle_english' => 'How We Work',
                'subtitle_arabic' => 'كيف نعمل',
                'target' => 'processes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title_english' => 'Our Values',
                'title_arabic' => 'قيمنا',
                'subtitle_english' => 'What We Stand For',
                'subtitle_arabic' => 'ما نؤمن به',
                'target' => 'values',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title_english' => 'Frequently Asked Questions',
                'title_arabic' => 'الأسئلة الشائعة',
                'subtitle_english' => 'Get Your Answers',
                'subtitle_arabic' => 'احصل على إجاباتك',
                'target' => 'faqs',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title_english' => 'Related Services',
                'title_arabic' => 'الخدمات ذات الصلة',
                'subtitle_english' => 'Explore More',
                'subtitle_arabic' => 'استكشف المزيد',
                'target' => 'sub_services',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        
        // Insert titles
        foreach ($titles as $title) {
            ServiceTitle::create($title);
        }
        
        $this->command->info('Service titles seeded successfully!');
    }
}
