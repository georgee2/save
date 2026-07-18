<?php

namespace Tests\Feature\Crm;

use App\Mail\CustomerDirectMail;
use App\Models\CustomerComment;
use App\Models\CustomerEmailLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class CustomerActionsTest extends TestCase
{
    use RefreshDatabase;
    use CreatesCrmFixtures;

    protected \App\Models\User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seedRoles();
        $this->seedSiteSingletons();
        $this->withoutLocaleRedirects();
        $this->admin = $this->makeStaff('admin');
    }

    public function test_index_lists_customers(): void
    {
        $customer = $this->makeCustomer(['name' => 'Ada Lovelace']);

        $this->actingAs($this->admin)
            ->get(route('crm-customers.index'))
            ->assertOk()
            ->assertSee('Ada Lovelace');
    }

    public function test_erp_sync_filter_limits_results(): void
    {
        $linked = $this->makeCustomer(['name' => 'Linked Cust', 'erp_customer_id' => 'ERP-001']);
        $unlinked = $this->makeCustomer(['name' => 'Unlinked Cust', 'erp_customer_id' => null]);

        $this->actingAs($this->admin)
            ->get(route('crm-customers.index', ['erp_sync' => 'linked']))
            ->assertOk()
            ->assertSee('Linked Cust')
            ->assertDontSee('Unlinked Cust');
    }

    public function test_show_renders(): void
    {
        $customer = $this->makeCustomer(['name' => 'Grace Hopper']);

        $this->actingAs($this->admin)
            ->get(route('crm-customers.show', ['id' => $customer->id]))
            ->assertOk()
            ->assertSee('Grace Hopper');
    }

    public function test_live_search_returns_matches(): void
    {
        $customer = $this->makeCustomer(['name' => 'Searchable Person', 'email' => 'findme@example.com']);

        $this->actingAs($this->admin)
            ->getJson(route('crm-customers.live-search', ['q' => 'findme']))
            ->assertOk()
            ->assertJsonFragment(['email' => 'findme@example.com']);
    }

    public function test_assign_and_unassign_agent(): void
    {
        $customer = $this->makeCustomer();
        $agent = $this->makeAgent();

        $this->actingAs($this->admin)
            ->post(route('crm-customers.assign-agent', ['id' => $customer->id]), ['assigned_agent_id' => $agent->id]);
        $this->assertEquals($agent->id, $customer->fresh()->assigned_agent_id);

        $this->actingAs($this->admin)
            ->post(route('crm-customers.unassign-agent', ['id' => $customer->id]));
        $this->assertNull($customer->fresh()->assigned_agent_id);
    }

    public function test_comment_store_and_delete(): void
    {
        $customer = $this->makeCustomer();

        $this->actingAs($this->admin)
            ->post(route('crm-customers.store-comment', ['id' => $customer->id]), ['comment' => 'Follow up next week']);

        $comment = CustomerComment::where('customer_id', $customer->id)->first();
        $this->assertNotNull($comment);
        $this->assertDatabaseHas('activity_logs', [
            'model_type' => CustomerComment::class,
            'action' => 'create',
        ]);

        $this->actingAs($this->admin)
            ->post(route('crm-customers.delete-comment', ['id' => $comment->id]));
        $this->assertDatabaseMissing('customer_comments', ['id' => $comment->id]);
    }

    public function test_send_email_logs_and_ccs_agent(): void
    {
        Mail::fake();

        $agent = $this->makeAgent('agent-cc@example.com');
        $customer = $this->makeCustomer(['assigned_agent_id' => $agent->id]);

        $this->actingAs($this->admin)
            ->post(route('crm-customers.send-email', ['id' => $customer->id]), [
                'subject' => 'Project update',
                'body' => 'Here is your update.',
            ])
            ->assertRedirect(route('crm-customers.show', ['id' => $customer->id]));

        Mail::assertSent(CustomerDirectMail::class, function ($mail) use ($customer) {
            return $mail->hasTo($customer->email) && $mail->hasCc('agent-cc@example.com');
        });

        $this->assertDatabaseHas('customer_email_logs', [
            'customer_id' => $customer->id,
            'cc_email' => 'agent-cc@example.com',
            'subject' => 'Project update',
        ]);
    }

    public function test_send_email_respects_opt_out(): void
    {
        Mail::fake();

        $customer = $this->makeCustomer([
            'notification_prefs' => ['email_updates' => false],
        ]);

        $this->actingAs($this->admin)
            ->post(route('crm-customers.send-email', ['id' => $customer->id]), [
                'subject' => 'Blocked',
                'body' => 'Should not send.',
            ])
            ->assertSessionHas('error');

        Mail::assertNothingSent();
        $this->assertDatabaseMissing('customer_email_logs', ['customer_id' => $customer->id]);
    }

    public function test_send_email_requires_consent(): void
    {
        Mail::fake();

        $customer = $this->makeCustomer(['consent_at' => null]);

        $this->actingAs($this->admin)
            ->post(route('crm-customers.send-email', ['id' => $customer->id]), [
                'subject' => 'No consent',
                'body' => 'Should not send.',
            ])
            ->assertSessionHas('error');

        Mail::assertNothingSent();
        $this->assertDatabaseMissing('customer_email_logs', ['customer_id' => $customer->id]);
    }

    public function test_export_report_downloads(): void
    {
        $this->makeCustomer();

        $this->actingAs($this->admin)
            ->get(route('crm-customers.export-report'))
            ->assertOk();
    }
}
