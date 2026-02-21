<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules = [
            'projects' => [
                'name' => 'Projects',
                'actions' => ['view', 'create', 'edit', 'delete', 'restore', 'force_delete'],
            ],
            'offers' => [
                'name' => 'Offers',
                'actions' => ['view', 'create', 'edit', 'delete', 'restore', 'force_delete'],
            ],
            'services' => [
                'name' => 'Services',
                'actions' => ['view', 'create', 'edit', 'delete', 'restore', 'force_delete'],
            ],
            'news' => [
                'name' => 'News',
                'actions' => ['view', 'create', 'edit', 'delete', 'restore', 'force_delete'],
            ],
            'portfolios' => [
                'name' => 'Portfolios',
                'actions' => ['view', 'create', 'edit', 'delete', 'restore', 'force_delete'],
            ],
            'sliders' => [
                'name' => 'Sliders',
                'actions' => ['view', 'create', 'edit', 'delete', 'restore', 'force_delete'],
            ],
            'partners' => [
                'name' => 'Partners',
                'actions' => ['view', 'create', 'edit', 'delete', 'restore', 'force_delete'],
            ],
            'team' => [
                'name' => 'Team Members',
                'actions' => ['view', 'create', 'edit', 'delete', 'restore', 'force_delete'],
            ],
            'interior-design-galleries' => [
                'name' => 'Interior Design Galleries',
                'actions' => ['view', 'create', 'edit', 'delete', 'restore', 'force_delete'],
            ],
            'interior-categories' => [
                'name' => 'Interior Categories',
                'actions' => ['view', 'create', 'edit', 'delete'],
            ],
            'engineering-categories' => [
                'name' => 'Engineering Categories',
                'actions' => ['view', 'create', 'edit', 'delete', 'restore', 'force_delete'],
            ],
            'engineering-sub-categories' => [
                'name' => 'Engineering Sub Categories',
                'actions' => ['view', 'create', 'edit', 'delete', 'restore', 'force_delete'],
            ],
            'offer-categories' => [
                'name' => 'Offer Categories',
                'actions' => ['view', 'create', 'edit', 'delete', 'restore', 'force_delete'],
            ],
            'offer-sub-categories' => [
                'name' => 'Offer Sub Categories',
                'actions' => ['view', 'create', 'edit', 'delete', 'restore', 'force_delete'],
            ],
            'amenities' => [
                'name' => 'Amenities',
                'actions' => ['view', 'create', 'edit', 'delete', 'restore', 'force_delete'],
            ],
            'currencies' => [
                'name' => 'Currencies',
                'actions' => ['view', 'create', 'edit', 'delete', 'restore'],
            ],
            'emirates' => [
                'name' => 'Emirates',
                'actions' => ['view', 'create', 'edit', 'delete', 'restore'],
            ],
            'building-components' => [
                'name' => 'Building Components',
                'actions' => ['view', 'create', 'edit', 'delete', 'restore'],
            ],
            'floor-components' => [
                'name' => 'Floor Components',
                'actions' => ['view', 'create', 'edit', 'delete', 'restore'],
            ],
            'income-components' => [
                'name' => 'Income Components',
                'actions' => ['view', 'create', 'edit', 'delete', 'restore'],
            ],
            'length-components' => [
                'name' => 'Length Components',
                'actions' => ['view', 'create', 'edit', 'delete', 'restore'],
            ],
            'feasibility-study-components' => [
                'name' => 'Feasibility Study Components',
                'actions' => ['view', 'create', 'edit', 'delete', 'restore'],
            ],
            'project-types' => [
                'name' => 'Project Types',
                'actions' => ['view', 'create', 'edit', 'delete', 'restore'],
            ],
            'project-styles' => [
                'name' => 'Project Styles',
                'actions' => ['view', 'create', 'edit', 'delete', 'restore'],
            ],
            'specifications' => [
                'name' => 'Specifications',
                'actions' => ['view', 'create', 'edit', 'delete', 'restore'],
            ],
            'substation-rooms' => [
                'name' => 'Substation Rooms',
                'actions' => ['view', 'create', 'edit', 'delete', 'restore'],
            ],
            'pumps-rooms' => [
                'name' => 'Pumps Rooms',
                'actions' => ['view', 'create', 'edit', 'delete', 'restore'],
            ],
            'portfolio-types' => [
                'name' => 'Portfolio Types',
                'actions' => ['view', 'create', 'edit', 'delete', 'restore'],
            ],
            'job-titles' => [
                'name' => 'Job Titles',
                'actions' => ['view', 'create', 'edit', 'delete', 'restore'],
            ],
            'job-categories' => [
                'name' => 'Job Categories',
                'actions' => ['view', 'create', 'edit', 'delete', 'restore'],
            ],
            'ranks' => [
                'name' => 'Ranks',
                'actions' => ['view', 'create', 'edit', 'delete', 'restore'],
            ],
            'languages' => [
                'name' => 'Languages',
                'actions' => ['view', 'edit'],
            ],
            'menus' => [
                'name' => 'Menus',
                'actions' => ['view', 'create', 'edit', 'delete'],
            ],
            'menu-items' => [
                'name' => 'Menu Items',
                'actions' => ['view', 'create', 'edit', 'delete'],
            ],
            'certificates' => [
                'name' => 'Certificates',
                'actions' => ['view', 'create', 'edit', 'delete'],
            ],
            'job-postings' => [
                'name' => 'Job Postings',
                'actions' => ['view', 'create', 'edit', 'delete', 'restore', 'force_delete'],
            ],
            'job-applications' => [
                'name' => 'Job Applications',
                'actions' => ['view', 'delete'],
            ],
            'contact-us' => [
                'name' => 'Contact Messages',
                'actions' => ['view', 'delete'],
            ],
            'about-information' => [
                'name' => 'About Information',
                'actions' => ['view', 'edit'],
            ],
            'about-features' => [
                'name' => 'About Features',
                'actions' => ['view', 'create', 'edit', 'delete'],
            ],
            'about-custom-blocks' => [
                'name' => 'About Custom Blocks',
                'actions' => ['view', 'create', 'edit', 'delete'],
            ],
            'contact-information' => [
                'name' => 'Contact Information',
                'actions' => ['view', 'edit'],
            ],
            'home-sections' => [
                'name' => 'Home Sections',
                'actions' => ['view', 'edit'],
            ],
            'home-projects' => [
                'name' => 'Home Projects',
                'actions' => ['view', 'edit'],
            ],
            'page-banners' => [
                'name' => 'Page Banners',
                'actions' => ['view', 'edit'],
            ],
            'settings' => [
                'name' => 'Settings',
                'actions' => ['view', 'edit'],
            ],
            'users' => [
                'name' => 'Users',
                'actions' => ['view', 'create', 'edit', 'delete'],
            ],
            'roles' => [
                'name' => 'Roles',
                'actions' => ['view', 'create', 'edit', 'delete'],
            ],
            'activity-logs' => [
                'name' => 'Activity Logs',
                'actions' => ['view', 'delete'],
            ],
            'dashboard' => [
                'name' => 'Dashboard',
                'actions' => ['view'],
            ],
        ];

        $actionLabels = [
            'view' => 'View',
            'create' => 'Create',
            'edit' => 'Edit',
            'delete' => 'Delete',
            'restore' => 'Restore',
            'force_delete' => 'Force Delete',
        ];

        $order = 0;
        foreach ($modules as $moduleSlug => $moduleData) {
            foreach ($moduleData['actions'] as $action) {
                $slug = $moduleSlug . '-' . $action;
                $name = $actionLabels[$action] . ' ' . $moduleData['name'];
                
                Permission::firstOrCreate(
                    ['slug' => $slug],
                    [
                        'name' => $name,
                        'module' => $moduleSlug,
                        'action' => $action,
                        'description' => $name,
                        'order' => $order++,
                    ]
                );
            }
        }

        $superAdmin = Role::firstOrCreate(
            ['slug' => 'super-admin'],
            [
                'name' => 'Super Admin',
                'description' => 'Has full access to all features and settings',
                'is_system' => true,
                'is_active' => true,
            ]
        );

        $allPermissions = Permission::pluck('id')->toArray();
        $superAdmin->permissions()->sync($allPermissions);

        $admin = Role::firstOrCreate(
            ['slug' => 'admin'],
            [
                'name' => 'Admin',
                'description' => 'Has access to most features except system settings',
                'is_system' => false,
                'is_active' => true,
            ]
        );

        $adminPermissions = Permission::whereNotIn('module', ['roles', 'settings', 'activity-logs'])
            ->pluck('id')
            ->toArray();
        $admin->permissions()->sync($adminPermissions);

        $editor = Role::firstOrCreate(
            ['slug' => 'editor'],
            [
                'name' => 'Editor',
                'description' => 'Can view and edit content but cannot delete',
                'is_system' => false,
                'is_active' => true,
            ]
        );

        $editorPermissions = Permission::whereIn('action', ['view', 'create', 'edit'])
            ->whereNotIn('module', ['users', 'roles', 'settings', 'activity-logs'])
            ->pluck('id')
            ->toArray();
        $editor->permissions()->sync($editorPermissions);

        $viewer = Role::firstOrCreate(
            ['slug' => 'viewer'],
            [
                'name' => 'Viewer',
                'description' => 'Can only view content',
                'is_system' => false,
                'is_active' => true,
            ]
        );

        $viewerPermissions = Permission::where('action', 'view')
            ->whereNotIn('module', ['users', 'roles', 'settings', 'activity-logs'])
            ->pluck('id')
            ->toArray();
        $viewer->permissions()->sync($viewerPermissions);

        $firstUser = User::first();
        if ($firstUser && !$firstUser->roles()->exists()) {
            $firstUser->roles()->attach($superAdmin->id);
        }

        $this->command->info('Roles and permissions seeded successfully!');
        $this->command->info('Total permissions created: ' . Permission::count());
        $this->command->info('Total roles created: ' . Role::count());
    }
}
