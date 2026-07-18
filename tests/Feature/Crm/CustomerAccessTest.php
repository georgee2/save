<?php

namespace Tests\Feature\Crm;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerAccessTest extends TestCase
{
    use RefreshDatabase;
    use CreatesCrmFixtures;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seedRoles();
        $this->seedSiteSingletons();
        $this->withoutLocaleRedirects();
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get(route('crm-customers.index'))
            ->assertRedirect(route('login'));
    }

    public function test_customer_account_is_blocked_from_crm(): void
    {
        $customer = $this->makeCustomer();

        $this->actingAs($customer)
            ->get(route('crm-customers.index'))
            ->assertRedirect(route('account.dashboard'));
    }

    public function test_staff_without_permission_is_denied(): void
    {
        $staff = $this->makeStaff(); // no role => no customers-* permission

        $this->actingAs($staff)
            ->get(route('crm-customers.index'))
            ->assertStatus(302); // CheckRoutePermission redirects to Admin

        $this->actingAs($staff)
            ->getJson(route('crm-customers.live-search', ['q' => 'x']))
            ->assertStatus(403);
    }

    public function test_viewer_can_read_but_not_edit_or_email(): void
    {
        $viewer = $this->makeStaff('viewer');
        $customer = $this->makeCustomer();
        $agent = $this->makeAgent();

        $this->actingAs($viewer)->get(route('crm-customers.index'))->assertOk();
        $this->actingAs($viewer)->get(route('crm-customers.show', ['id' => $customer->id]))->assertOk();

        // customers-edit required
        $this->actingAs($viewer)
            ->post(route('crm-customers.assign-agent', ['id' => $customer->id]), ['assigned_agent_id' => $agent->id])
            ->assertStatus(302);
        $this->assertNull($customer->fresh()->assigned_agent_id);

        // customers-send_email required
        $this->actingAs($viewer)
            ->post(route('crm-customers.send-email', ['id' => $customer->id]), ['subject' => 'Hi', 'body' => 'Test'])
            ->assertStatus(302);
    }

    public function test_editor_can_edit_but_not_email(): void
    {
        $editor = $this->makeStaff('editor');
        $customer = $this->makeCustomer();
        $agent = $this->makeAgent();

        $this->actingAs($editor)
            ->post(route('crm-customers.assign-agent', ['id' => $customer->id]), ['assigned_agent_id' => $agent->id])
            ->assertRedirect(route('crm-customers.show', ['id' => $customer->id]));
        $this->assertEquals($agent->id, $customer->fresh()->assigned_agent_id);

        // editor lacks customers-send_email
        $this->actingAs($editor)
            ->post(route('crm-customers.send-email', ['id' => $customer->id]), ['subject' => 'Hi', 'body' => 'Test'])
            ->assertStatus(302);
    }

    public function test_admin_can_send_email(): void
    {
        \Illuminate\Support\Facades\Mail::fake();

        $admin = $this->makeStaff('admin');
        $customer = $this->makeCustomer();

        $this->actingAs($admin)
            ->post(route('crm-customers.send-email', ['id' => $customer->id]), ['subject' => 'Hi', 'body' => 'Test'])
            ->assertRedirect(route('crm-customers.show', ['id' => $customer->id]));

        $this->assertDatabaseHas('customer_email_logs', [
            'customer_id' => $customer->id,
            'subject' => 'Hi',
        ]);
    }
}
