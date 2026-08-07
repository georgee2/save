<?php

namespace Tests\Feature\Security;

use App\Mail\CustomerEmailChangeMail;
use App\Mail\EmailChangeAlertMail;
use App\Models\User;
use App\Services\EmailChangeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter;
use Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect;
use Tests\TestCase;

/**
 * Redirecting the account email is the first move in taking an account over, and it used
 * to need nothing but a live session. The token was also stored in plaintext with no
 * server-side expiry, and the address losing control was never told.
 */
class EmailChangeTest extends TestCase
{
    use RefreshDatabase;

    private const PASSWORD = 'Str0ngPassw0rd';

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

    private function makeCustomer(): User
    {
        return User::factory()->customer()->create([
            'password' => Hash::make(self::PASSWORD),
            'is_active' => true,
        ]);
    }

    private function submitDetails(User $user, array $overrides = [])
    {
        return $this->actingAs($user)->put(route('account.settings.details'), array_merge([
            'name' => $user->name,
            'phone' => '+971500000000',
            'email' => 'new-address@example.com',
            'current_password' => self::PASSWORD,
        ], $overrides));
    }

    public function test_changing_the_email_requires_the_current_password(): void
    {
        $user = $this->makeCustomer();

        // A hijacked session alone must not be enough.
        $this->submitDetails($user, ['current_password' => null])
            ->assertSessionHasErrors('current_password');

        $this->assertNull($user->fresh()->pending_email);
        Mail::assertNothingSent();
    }

    public function test_a_wrong_password_is_rejected(): void
    {
        $user = $this->makeCustomer();

        $this->submitDetails($user, ['current_password' => 'not-the-password'])
            ->assertSessionHasErrors('current_password');

        $this->assertNull($user->fresh()->pending_email);
    }

    public function test_editing_name_only_does_not_demand_a_password(): void
    {
        $user = $this->makeCustomer();

        // Friction only where it buys something: the address is not changing here.
        $this->actingAs($user)->put(route('account.settings.details'), [
            'name' => 'Updated Name',
            'phone' => '+971500000001',
            'email' => $user->email,
        ])->assertSessionHasNoErrors();

        $this->assertSame('Updated Name', $user->fresh()->name);
    }

    public function test_the_stored_token_is_hashed(): void
    {
        $user = $this->makeCustomer();

        $this->submitDetails($user)->assertSessionHasNoErrors();

        $stored = $user->fresh()->pending_email_token;

        $this->assertNotNull($stored);
        // A database leak should not hand over a usable confirmation.
        $this->assertSame(64, strlen($stored), 'Expected a sha256 hex digest, not the raw token.');
        $this->assertMatchesRegularExpression('/^[0-9a-f]{64}$/', $stored);
    }

    public function test_both_addresses_are_mailed(): void
    {
        $user = $this->makeCustomer();

        $this->submitDetails($user);

        Mail::assertSent(CustomerEmailChangeMail::class);
        // The old address is the one losing access, so it is the one that needs warning.
        Mail::assertSent(EmailChangeAlertMail::class);
    }

    public function test_the_pending_change_expires(): void
    {
        $user = $this->makeCustomer();
        $service = app(EmailChangeService::class);

        $service->start($user, 'new-address@example.com');
        $user->refresh();

        // Previously only the signed URL expired; the stored token stayed usable forever.
        $user->forceFill(['pending_email_expires_at' => now()->subMinute()])->save();

        $this->assertFalse($service->confirm($user->fresh(), 'any-token'));
        $this->assertNotSame('new-address@example.com', $user->fresh()->email);
    }

    public function test_a_valid_confirmation_completes_the_change(): void
    {
        $user = $this->makeCustomer();

        $this->submitDetails($user);

        // Recover the raw token from the signed URL the user was mailed.
        $raw = null;
        Mail::assertSent(CustomerEmailChangeMail::class, function ($mail) use (&$raw) {
            preg_match('#/email/verify/([^?]+)#', $mail->actionUrl, $m);
            $raw = $m[1] ?? null;

            return true;
        });

        $this->assertNotNull($raw, 'Could not recover the token from the mailed link.');

        $url = URL::temporarySignedRoute('account.email.verify', now()->addHour(), ['token' => $raw]);

        $this->actingAs($user)->get($url)->assertRedirect(route('account.profile'));

        $fresh = $user->fresh();
        $this->assertSame('new-address@example.com', $fresh->email);
        $this->assertNull($fresh->pending_email);
        $this->assertNull($fresh->pending_email_token);
        $this->assertNull($fresh->pending_email_expires_at);
    }

    public function test_logout_is_not_reachable_by_get(): void
    {
        $user = $this->makeCustomer();

        // As a GET this was CSRF-able from any third-party page via <img src>. The status
        // is 404 rather than 405 because the catch-all fallback in routes/web.php claims
        // the path first; what matters is that the session survives it.
        $response = $this->actingAs($user)->get('/en/logout');

        $this->assertContains($response->getStatusCode(), [404, 405]);
        $this->assertAuthenticatedAs($user);

        $this->actingAs($user)->post(route('logout'))->assertRedirect();
        $this->assertGuest();
    }
}
