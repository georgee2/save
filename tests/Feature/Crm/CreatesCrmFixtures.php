<?php

namespace Tests\Feature\Crm;

use App\Models\Agent;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter;
use Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect;

trait CreatesCrmFixtures
{
    protected function seedRoles(): void
    {
        $this->seed(RolesAndPermissionsSeeder::class);
    }

    /**
     * Seed a contact_information singleton so the global HeaderComposer (bound to '*')
     * doesn't hit ContactInformation::getContactInfo()'s auto-create path, which inserts
     * an uncast array default and blows up on an empty test database.
     */
    protected function seedSiteSingletons(): void
    {
        DB::table('contact_information')->insert([
            'tags' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * The mcamara localization middleware issues 302 locale redirects on GET requests,
     * which would mask the actual controller/permission responses under test.
     */
    protected function withoutLocaleRedirects(): void
    {
        $this->withoutMiddleware([
            LocaleSessionRedirect::class,
            LaravelLocalizationRedirectFilter::class,
        ]);
    }

    /**
     * Create a staff user, optionally assigned a seeded role (super-admin/admin/editor/viewer).
     */
    protected function makeStaff(?string $role = null): User
    {
        $user = User::factory()->staff()->create();

        if ($role !== null) {
            $user->assignRole($role);
        }

        return $user;
    }

    protected function makeCustomer(array $attrs = []): User
    {
        return User::factory()->customer()->create($attrs);
    }

    /**
     * Create an active agent linked to a staff user (so findWithRelations resolves a CC email).
     */
    protected function makeAgent(string $email = 'agent@example.com'): Agent
    {
        $agentUser = User::factory()->staff()->create(['email' => $email]);

        $jobTitleId = DB::table('job_titles')->insertGetId([
            'name_english' => 'Sales Agent',
            'name_arabic' => 'agent-ar',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $rankId = DB::table('ranks')->insertGetId([
            'name_english' => 'Senior',
            'name_arabic' => 'rank-ar',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return Agent::create([
            'full_name_en' => 'Agent Smith',
            'full_name_ar' => 'agent-ar',
            'job_title_id' => $jobTitleId,
            'rank_id' => $rankId,
            'user_id' => $agentUser->id,
            'status' => 'Active',
        ]);
    }
}
