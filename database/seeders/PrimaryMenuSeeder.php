<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\MenuSetting;

class PrimaryMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * This seeder creates the primary header menu based on the current header structure.
     * The primary menu cannot be deleted, only hidden or modified.
     */
    public function run(): void
    {
        // Create the primary header menu
        $menu = Menu::firstOrCreate(
            ['slug' => 'primary-header'],
            [
                'title_english' => 'Primary Header Menu',
                'title_arabic' => 'القائمة الرئيسية',
                'description_english' => 'Main navigation menu displayed in the website header',
                'description_arabic' => 'قائمة التنقل الرئيسية المعروضة في رأس الموقع',
                'location' => 'header',
                'is_primary' => true,
                'is_active' => true,
                'is_deletable' => false, // Cannot be deleted
                'order' => 1,
            ]
        );

        // Clear existing items for this menu (for re-seeding)
        MenuItem::where('menu_id', $menu->id)->forceDelete();

        $order = 0;

        // 1. Home - Static link (no children)
        $this->createMenuItem($menu, [
            'title_english' => 'Home',
            'title_arabic' => 'الرئيسية',
            'route_name' => 'index',
            'icon' => null,
            'item_type' => 'static',
            'order' => ++$order,
        ]);

        // 2. Services - Dynamic menu item that pulls from services
        $servicesItem = $this->createMenuItem($menu, [
            'title_english' => 'Services',
            'title_arabic' => 'خدماتنا',
            'route_name' => 'services.index',
            'icon' => null,
            'item_type' => 'dynamic_services',
            'show_children' => true,
            'order' => ++$order,
        ]);

        // Add "All Services" as first child
        $this->createMenuItem($menu, [
            'parent_id' => $servicesItem->id,
            'title_english' => 'All Services',
            'title_arabic' => 'جميع الخدمات',
            'route_name' => 'services.index',
            'icon' => 'fal fa-th-large',
            'icon_type' => 'fontawesome',
            'item_type' => 'static',
            'order' => 1,
            'depth' => 1,
        ]);

        // 3. Offers - Dynamic menu item that pulls from offer categories
        $offersItem = $this->createMenuItem($menu, [
            'title_english' => 'Offers',
            'title_arabic' => 'العروض',
            'route_name' => 'offers.index',
            'icon' => null,
            'item_type' => 'dynamic_offers',
            'show_children' => true,
            'order' => ++$order,
        ]);

        // Add "All Offers" as first child
        $this->createMenuItem($menu, [
            'parent_id' => $offersItem->id,
            'title_english' => 'All Offers',
            'title_arabic' => 'جميع العروض',
            'route_name' => 'offers.index',
            'icon' => 'fal fa-th-large',
            'icon_type' => 'fontawesome',
            'item_type' => 'static',
            'order' => 1,
            'depth' => 1,
        ]);

        // 4. Projects - Dynamic menu item that pulls from project categories
        $projectsItem = $this->createMenuItem($menu, [
            'title_english' => 'Projects',
            'title_arabic' => 'المشاريع',
            'route_name' => 'projects.index',
            'icon' => null,
            'item_type' => 'dynamic_projects',
            'show_children' => true,
            'order' => ++$order,
        ]);

        // Add "All Projects" as first child
        $this->createMenuItem($menu, [
            'parent_id' => $projectsItem->id,
            'title_english' => 'All Projects',
            'title_arabic' => 'جميع المشاريع',
            'route_name' => 'projects.index',
            'icon' => 'fal fa-th-large',
            'icon_type' => 'fontawesome',
            'item_type' => 'static',
            'order' => 1,
            'depth' => 1,
        ]);

        // 5. Interior Design - Dynamic menu item that pulls from interior categories
        $interiorItem = $this->createMenuItem($menu, [
            'title_english' => 'Interior Design',
            'title_arabic' => 'التصميم الداخلي',
            'route_name' => 'interior.index',
            'icon' => null,
            'item_type' => 'dynamic_query',
            'query_source' => 'interior',
            'show_children' => true,
            'order' => ++$order,
        ]);

        // Add "All Interior Designs" as first child
        $this->createMenuItem($menu, [
            'parent_id' => $interiorItem->id,
            'title_english' => 'All Interior Designs',
            'title_arabic' => 'جميع التصاميم الداخلية',
            'route_name' => 'interior.index',
            'icon' => 'fal fa-th-large',
            'icon_type' => 'fontawesome',
            'item_type' => 'static',
            'order' => 1,
            'depth' => 1,
        ]);

        // 7. News - Dynamic menu item (currently hidden in original header)
        $newsItem = $this->createMenuItem($menu, [
            'title_english' => 'News',
            'title_arabic' => 'الأخبار',
            'route_name' => 'blogs.index',
            'icon' => null,
            'item_type' => 'dynamic_news',
            'show_children' => true,
            'is_active' => false, // Hidden as in original header
            'order' => ++$order,
        ]);

        // Add "All News" as first child
        $this->createMenuItem($menu, [
            'parent_id' => $newsItem->id,
            'title_english' => 'All News',
            'title_arabic' => 'جميع الأخبار',
            'route_name' => 'blogs.index',
            'icon' => 'fal fa-newspaper',
            'icon_type' => 'fontawesome',
            'item_type' => 'static',
            'order' => 1,
            'depth' => 1,
        ]);

        // 8. About Us - Static with static children
        $aboutItem = $this->createMenuItem($menu, [
            'title_english' => 'About Us',
            'title_arabic' => 'من نحن',
            'route_name' => 'about',
            'icon' => null,
            'item_type' => 'static',
            'order' => ++$order,
        ]);

        // About Us children
        $aboutChildren = [
            [
                'title_english' => 'About Company',
                'title_arabic' => 'عن الشركة',
                'route_name' => 'about',
                'icon' => 'fal fa-info-circle',
            ],
            [
                'title_english' => 'Board of Directors',
                'title_arabic' => 'مجلس الإدارة',
                'route_name' => 'team.board',
                'icon' => 'fal fa-user-tie',
            ],
            [
                'title_english' => 'Our Team',
                'title_arabic' => 'فريق العمل',
                'route_name' => 'team.index',
                'icon' => 'fal fa-users',
            ],
            [
                'title_english' => 'Our Partners',
                'title_arabic' => 'شركاؤنا',
                'route_name' => 'partners.index',
                'icon' => 'fal fa-handshake',
            ],
            [
                'title_english' => 'Our Branches',
                'title_arabic' => 'فروعنا',
                'route_name' => 'branches.index',
                'icon' => 'fal fa-building',
            ],
        ];

        $childOrder = 0;
        foreach ($aboutChildren as $child) {
            $this->createMenuItem($menu, [
                'parent_id' => $aboutItem->id,
                'title_english' => $child['title_english'],
                'title_arabic' => $child['title_arabic'],
                'route_name' => $child['route_name'],
                'icon' => $child['icon'],
                'icon_type' => 'fontawesome',
                'item_type' => 'static',
                'order' => ++$childOrder,
                'depth' => 1,
            ]);
        }

        // 9. Contact Us - Static link (no children)
        $this->createMenuItem($menu, [
            'title_english' => 'Contact Us',
            'title_arabic' => 'اتصل بنا',
            'route_name' => 'contact',
            'icon' => null,
            'item_type' => 'static',
            'order' => ++$order,
        ]);

        // 10. Careers - Static link (conditional visibility based on active jobs)
        // Note: The visibility logic will be handled in the view/composer, not in the seeder
        $this->createMenuItem($menu, [
            'title_english' => 'Careers',
            'title_arabic' => 'الوظائف',
            'route_name' => 'careers.index',
            'icon' => null,
            'item_type' => 'static',
            'is_active' => false, // Hidden as in original header (hidden attribute)
            'order' => ++$order,
        ]);

        // Create menu settings
        $this->createMenuSettings();

        $this->command->info('Primary menu seeded successfully with ' . MenuItem::where('menu_id', $menu->id)->count() . ' items.');
    }

    /**
     * Create a menu item
     */
    protected function createMenuItem(Menu $menu, array $data): MenuItem
    {
        return MenuItem::create(array_merge([
            'menu_id' => $menu->id,
            'parent_id' => null,
            'description_english' => null,
            'description_arabic' => null,
            'url' => null,
            'route_params' => null,
            'link_target' => '_self',
            'icon' => null,
            'icon_type' => 'fontawesome',
            'css_class' => null,
            'item_type' => 'static',
            'show_children' => true,
            'max_children' => null,
            'is_active' => true,
            'is_visible_desktop' => true,
            'is_visible_mobile' => true,
            'requires_auth' => false,
            'requires_guest' => false,
            'permission' => null,
            'order' => 0,
            'depth' => 0,
        ], $data));
    }

    /**
     * Create default menu settings
     */
    protected function createMenuSettings(): void
    {
        $settings = [
            [
                'key' => 'menu_cache_enabled',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'performance',
                'label_english' => 'Enable Menu Cache',
                'label_arabic' => 'تفعيل التخزين المؤقت للقائمة',
                'description_english' => 'Cache menu items for better performance',
                'description_arabic' => 'تخزين عناصر القائمة مؤقتًا لأداء أفضل',
                'is_system' => true,
            ],
            [
                'key' => 'menu_cache_duration',
                'value' => '3600',
                'type' => 'integer',
                'group' => 'performance',
                'label_english' => 'Cache Duration (seconds)',
                'label_arabic' => 'مدة التخزين المؤقت (بالثواني)',
                'description_english' => 'How long to cache menu items',
                'description_arabic' => 'مدة تخزين عناصر القائمة مؤقتًا',
                'is_system' => true,
            ],
            [
                'key' => 'show_icons_in_menu',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'display',
                'label_english' => 'Show Icons in Menu',
                'label_arabic' => 'عرض الأيقونات في القائمة',
                'description_english' => 'Display icons next to menu items',
                'description_arabic' => 'عرض الأيقونات بجانب عناصر القائمة',
                'is_system' => false,
            ],
            [
                'key' => 'max_menu_depth',
                'value' => '3',
                'type' => 'integer',
                'group' => 'structure',
                'label_english' => 'Maximum Menu Depth',
                'label_arabic' => 'أقصى عمق للقائمة',
                'description_english' => 'Maximum nesting level for menu items',
                'description_arabic' => 'أقصى مستوى تداخل لعناصر القائمة',
                'is_system' => true,
            ],
            [
                'key' => 'use_dynamic_menu',
                'value' => 'false',
                'type' => 'boolean',
                'group' => 'general',
                'label_english' => 'Use Database Menu',
                'label_arabic' => 'استخدام قائمة قاعدة البيانات',
                'description_english' => 'Use menu from database instead of hardcoded header. Enable this after configuring your menu.',
                'description_arabic' => 'استخدام القائمة من قاعدة البيانات بدلاً من الرأس المبرمج. قم بتفعيل هذا بعد تهيئة قائمتك.',
                'is_system' => true,
            ],
        ];

        foreach ($settings as $setting) {
            MenuSetting::firstOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
