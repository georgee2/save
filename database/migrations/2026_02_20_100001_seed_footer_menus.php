<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create Quick Links Footer Menu
        $quickLinksMenuId = DB::table('menus')->insertGetId([
            'title_english' => 'Quick Links',
            'title_arabic' => 'روابط سريعة',
            'slug' => 'footer-quick-links',
            'description_english' => 'Footer quick links menu',
            'description_arabic' => 'قائمة الروابط السريعة في التذييل',
            'location' => 'footer_quick_links',
            'is_primary' => false,
            'is_active' => true,
            'is_deletable' => false,
            'order' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create Company Footer Menu
        $companyMenuId = DB::table('menus')->insertGetId([
            'title_english' => 'Company',
            'title_arabic' => 'الشركة',
            'slug' => 'footer-company',
            'description_english' => 'Footer company links menu',
            'description_arabic' => 'قائمة روابط الشركة في التذييل',
            'location' => 'footer_company',
            'is_primary' => false,
            'is_active' => true,
            'is_deletable' => false,
            'order' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Add Quick Links menu items
        $quickLinksItems = [
            ['title_english' => 'Home', 'title_arabic' => 'الرئيسية', 'route_name' => 'index', 'icon' => 'fas fa-home', 'order' => 1],
            ['title_english' => 'Services', 'title_arabic' => 'الخدمات', 'route_name' => 'services.index', 'icon' => 'fas fa-cogs', 'order' => 2],
            ['title_english' => 'Offers', 'title_arabic' => 'العروض', 'route_name' => 'offers.index', 'icon' => 'fas fa-tags', 'order' => 3],
            ['title_english' => 'Projects', 'title_arabic' => 'المشاريع', 'route_name' => 'projects.index', 'icon' => 'fas fa-building', 'order' => 4],
            ['title_english' => 'News', 'title_arabic' => 'الأخبار', 'route_name' => 'blogs.index', 'icon' => 'fas fa-newspaper', 'order' => 5],
            ['title_english' => 'Contact Us', 'title_arabic' => 'اتصل بنا', 'route_name' => 'contact', 'icon' => 'fas fa-envelope', 'order' => 6],
        ];

        foreach ($quickLinksItems as $item) {
            DB::table('menu_items')->insert([
                'menu_id' => $quickLinksMenuId,
                'parent_id' => null,
                'title_english' => $item['title_english'],
                'title_arabic' => $item['title_arabic'],
                'url' => null,
                'route_name' => $item['route_name'],
                'route_params' => null,
                'link_target' => '_self',
                'icon' => $item['icon'],
                'icon_type' => 'fontawesome',
                'css_class' => null,
                'item_type' => 'static',
                'query_source' => null,
                'query_category_ids' => null,
                'query_subcategory_ids' => null,
                'query_type' => null,
                'query_options' => null,
                'show_children' => false,
                'max_children' => null,
                'service_id' => null,
                'is_active' => true,
                'is_visible_desktop' => true,
                'is_visible_mobile' => true,
                'requires_auth' => false,
                'requires_guest' => false,
                'permission' => null,
                'order' => $item['order'],
                'depth' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Add Company menu items
        $companyItems = [
            ['title_english' => 'About Us', 'title_arabic' => 'من نحن', 'route_name' => 'about', 'icon' => 'fas fa-info-circle', 'order' => 1],
            ['title_english' => 'Board of Directors', 'title_arabic' => 'مجلس الإدارة', 'route_name' => 'team.board', 'icon' => 'fas fa-users-cog', 'order' => 2],
            ['title_english' => 'Our Team', 'title_arabic' => 'فريقنا', 'route_name' => 'team.index', 'icon' => 'fas fa-users', 'order' => 3],
            ['title_english' => 'Our Partners', 'title_arabic' => 'شركاؤنا', 'route_name' => 'partners.index', 'icon' => 'fas fa-handshake', 'order' => 4],
            ['title_english' => 'Our Branches', 'title_arabic' => 'فروعنا', 'route_name' => 'branches.index', 'icon' => 'fas fa-map-marker-alt', 'order' => 5],
            ['title_english' => 'Careers', 'title_arabic' => 'الوظائف', 'route_name' => 'careers.index', 'icon' => 'fas fa-briefcase', 'order' => 6],
        ];

        foreach ($companyItems as $item) {
            DB::table('menu_items')->insert([
                'menu_id' => $companyMenuId,
                'parent_id' => null,
                'title_english' => $item['title_english'],
                'title_arabic' => $item['title_arabic'],
                'url' => null,
                'route_name' => $item['route_name'],
                'route_params' => null,
                'link_target' => '_self',
                'icon' => $item['icon'],
                'icon_type' => 'fontawesome',
                'css_class' => null,
                'item_type' => 'static',
                'query_source' => null,
                'query_category_ids' => null,
                'query_subcategory_ids' => null,
                'query_type' => null,
                'query_options' => null,
                'show_children' => false,
                'max_children' => null,
                'service_id' => null,
                'is_active' => true,
                'is_visible_desktop' => true,
                'is_visible_mobile' => true,
                'requires_auth' => false,
                'requires_guest' => false,
                'permission' => null,
                'order' => $item['order'],
                'depth' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Delete menu items first
        $menuIds = DB::table('menus')
            ->whereIn('slug', ['footer-quick-links', 'footer-company'])
            ->pluck('id');
        
        DB::table('menu_items')->whereIn('menu_id', $menuIds)->delete();
        
        // Delete menus
        DB::table('menus')->whereIn('slug', ['footer-quick-links', 'footer-company'])->delete();
    }
};
