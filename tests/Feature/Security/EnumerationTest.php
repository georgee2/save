<?php

namespace Tests\Feature\Security;

use App\Mail\CustomerInviteMail;
use App\Mail\RegistrationAttemptMail;
use App\Models\User;
use App\Support\FormGuard;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter;
use Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect;
use Tests\TestCase;

/**
 * Registration used to answer an existing address with a validation error whose wording
 * distinguished four cases - no account, activated customer, unactivated customer, and
 * staff - making it an oracle for existence, activation state and account type. The staff
 * reset endpoint leaked the same way.
 */
class EnumerationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware([
            LocaleSessionRedirect::class,
            LaravelLocalizationRedirectFilter::class,
        ]);

        DB::table('contact_information')->insert([
            'tags' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Mail::fake();
    }

    private function register(string $email)
    {
        return $this->post(route('account.register.submit'), [
            FormGuard::TIMESTAMP => FormGuard::signature(time() - 10),
            'name' => 'Test Person',
            'email' => $email,
            'phone' => '+971500000000',
            'consent' => '1',
        ]);
    }

    public function test_registering_an_existing_address_looks_like_a_new_signup(): void
    {
        $activated = User::factory()->customer()->create(['is_active' => true]);

        $fresh = $this->register('brand-new@example.com');
        $taken = $this->register($activated->email);

        // Same status, same destination, same flash: nothing distinguishes them.
        $this->assertSame($fresh->getStatusCode(), $taken->getStatusCode());
        $this->assertSame(
            $fresh->headers->get('Location'),
            $taken->headers->get('Location')
        );
        $taken->assertSessionHasNoErrors();
    }

    public function test_activation_state_is_not_revealed(): void
    {
        $activated = User::factory()->customer()->create([
            'is_active' => true,
            'password_set_at' => now(),
        ]);
        $pending = User::factory()->customer()->create([
            'is_active' => true,
            'password_set_at' => null,
        ]);

        $a = $this->register($activated->email);
        $b = $this->register($pending->email);

        $this->assertSame($a->getStatusCode(), $b->getStatusCode());
        $this->assertSame($a->headers->get('Location'), $b->headers->get('Location'));
        $a->assertSessionHasNoErrors();
        $b->assertSessionHasNoErrors();
    }

    public function test_a_staff_address_is_not_revealed(): void
    {
        $staff = User::factory()->staff()->create(['is_active' => true]);

        $response = $this->register($staff->email);

        $response->assertSessionHasNoErrors();
        // No second account was created for that address.
        $this->assertSame(1, User::where('email', $staff->email)->count());
    }

    public function test_the_owner_is_told_by_email_instead(): void
    {
        $activated = User::factory()->customer()->create([
            'is_active' => true,
            'password_set_at' => now(),
        ]);

        $this->register($activated->email);

        // The fact still reaches the person entitled to know it, just not the submitter.
        Mail::assertSent(RegistrationAttemptMail::class);
    }

    public function test_an_unactivated_account_gets_its_invite_resent(): void
    {
        $pending = User::factory()->customer()->create([
            'is_active' => true,
            'password_set_at' => null,
        ]);

        $this->register($pending->email);

        // Almost always what they were actually trying to do.
        Mail::assertSent(CustomerInviteMail::class);
    }

    public function test_the_api_does_not_leak_it_either(): void
    {
        $activated = User::factory()->customer()->create(['is_active' => true]);

        $fresh = $this->postJson('/api/customer/register', [
            'name' => 'Test Person',
            'email' => 'another-new@example.com',
            'consent' => true,
        ]);

        $taken = $this->postJson('/api/customer/register', [
            'name' => 'Test Person',
            'email' => $activated->email,
            'consent' => true,
        ]);

        $taken->assertOk();
        $this->assertSame($fresh->json('success'), $taken->json('success'));
        $this->assertSame($fresh->json('message'), $taken->json('message'));
    }

    public function test_staff_reset_does_not_distinguish_unknown_customer_and_staff(): void
    {
        $customer = User::factory()->customer()->create(['is_active' => true]);
        $staff = User::factory()->staff()->create([
            'is_active' => true,
            'password' => Hash::make('OriginalPassw0rd'),
        ]);

        $messages = [];

        foreach (['nobody@example.com', $customer->email, $staff->email] as $email) {
            $response = $this->from(route('staff.password.reset', ['token' => 'x']))
                ->post(route('staff.password.update'), [
                    'token' => 'invalid-token',
                    'email' => $email,
                    'password' => 'Str0ngPassw0rdXY',
                    'password_confirmation' => 'Str0ngPassw0rdXY',
                ]);

            $response->assertSessionHasErrors('email');
            $messages[] = session('errors')->first('email');
        }

        // Previously: passwords.user for the first two, passwords.token for staff.
        $this->assertCount(1, array_unique($messages), 'All three must answer identically.');
    }
}
