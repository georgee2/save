<?php

namespace Tests\Feature\Security;

use App\Mail\AccountLockedMail;
use App\Models\ActivityLog;
use App\Models\User;
use App\Support\LoginThrottle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter;
use Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect;
use Tests\TestCase;

/**
 * Every login limiter keyed on the IP, so one account had no aggregate ceiling: an attacker
 * rotating addresses got the full per-IP budget again from each one. These assert the
 * account-wide budget, that it is shared between the web and API paths, and that none of it
 * leaks whether an account exists.
 */
class LoginThrottleTest extends TestCase
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

    private function makeCustomer(array $attrs = []): User
    {
        return User::factory()->customer()->create(array_merge([
            'password' => Hash::make(self::PASSWORD),
            'is_active' => true,
        ], $attrs));
    }

    /**
     * Each attempt comes from a different address, which is the whole point: the per-IP
     * limiters never trip, so only an account-wide budget can stop this.
     */
    private function attemptFromRotatingIp(string $email, string $password, int $n)
    {
        return $this->withServerVariables(['REMOTE_ADDR' => '203.0.113.' . ($n % 250 + 1)])
            ->post(route('checkuser'), ['email' => $email, 'password' => $password]);
    }

    /**
     * A browser form post gets a redirect with a session error, not the 429 status - the
     * ->status(429) on the ValidationException only applies to JSON callers. Assert on the
     * message so this cannot be confused with an ordinary bad-credentials rejection.
     */
    private function assertThrottled($response): void
    {
        $response->assertRedirect()->assertSessionHasErrors('email');

        $this->assertStringContainsString(
            'Too many login attempts',
            session('errors')->first('email')
        );
    }

    public function test_rotating_ips_no_longer_grants_unlimited_attempts(): void
    {
        $user = $this->makeCustomer();

        for ($i = 0; $i < LoginThrottle::MAX_ATTEMPTS; $i++) {
            $this->attemptFromRotatingIp($user->email, 'wrong-password', $i);
        }

        $this->assertThrottled(
            $this->attemptFromRotatingIp($user->email, 'wrong-password', 999)
        );
    }

    public function test_the_lockout_is_persisted_so_a_cache_flush_does_not_reset_it(): void
    {
        $user = $this->makeCustomer();

        for ($i = 0; $i < LoginThrottle::MAX_ATTEMPTS; $i++) {
            $this->attemptFromRotatingIp($user->email, 'wrong-password', $i);
        }

        $this->assertTrue($user->fresh()->isLockedOut());

        // Simulate a deploy or cache flush mid-attack: the limiter is gone, the lock is not.
        RateLimiter::clear(LoginThrottle::key($user->email));

        $this->assertThrottled(
            $this->attemptFromRotatingIp($user->email, 'wrong-password', 998)
        );
    }

    public function test_a_locked_account_rejects_even_the_correct_password(): void
    {
        $user = $this->makeCustomer(['locked_until' => now()->addMinutes(30)]);

        $this->assertThrottled($this->post(route('checkuser'), [
            'email' => $user->email,
            'password' => self::PASSWORD,
        ]));

        $this->assertGuest();
    }

    public function test_the_lock_expires_on_its_own(): void
    {
        $user = $this->makeCustomer(['locked_until' => now()->subMinute()]);

        $this->post(route('checkuser'), [
            'email' => $user->email,
            'password' => self::PASSWORD,
        ])->assertRedirect();

        $this->assertAuthenticatedAs($user->fresh());
    }

    public function test_a_successful_login_clears_the_budget(): void
    {
        $user = $this->makeCustomer();

        for ($i = 0; $i < 5; $i++) {
            $this->attemptFromRotatingIp($user->email, 'wrong-password', $i);
        }

        $this->attemptFromRotatingIp($user->email, self::PASSWORD, 50);

        $this->assertSame(0, RateLimiter::attempts(LoginThrottle::key($user->email)));
        $this->assertNull($user->fresh()->locked_until);
    }

    public function test_an_unknown_address_is_throttled_identically(): void
    {
        // If the ceiling only applied to real accounts, hitting it would reveal that the
        // address has one.
        for ($i = 0; $i < LoginThrottle::MAX_ATTEMPTS; $i++) {
            $this->attemptFromRotatingIp('nobody@example.com', 'wrong-password', $i);
        }

        $this->assertThrottled(
            $this->attemptFromRotatingIp('nobody@example.com', 'wrong-password', 997)
        );
    }

    public function test_the_web_budget_carries_over_to_the_api(): void
    {
        $user = $this->makeCustomer();

        for ($i = 0; $i < LoginThrottle::MAX_ATTEMPTS; $i++) {
            $this->attemptFromRotatingIp($user->email, 'wrong-password', $i);
        }

        // Otherwise an attacker just switches channel and starts again.
        $this->postJson('/api/customer/login', [
            'email' => $user->email,
            'password' => self::PASSWORD,
        ])->assertStatus(429);
    }

    public function test_the_owner_is_emailed_when_the_lock_trips(): void
    {
        $user = $this->makeCustomer();

        for ($i = 0; $i < LoginThrottle::MAX_ATTEMPTS; $i++) {
            $this->attemptFromRotatingIp($user->email, 'wrong-password', $i);
        }

        Mail::assertSent(AccountLockedMail::class);

        // Asserted through the cooldown key rather than by counting sends across further
        // requests: Application::terminate() never clears its terminating callbacks, so in
        // a multi-request test the first afterResponse mail re-fires on every later
        // request. That is a harness artifact - production gets a fresh app per request.
        $this->assertFalse(
            Cache::add('lockout-notice:' . strtolower($user->email), true, 600),
            'The notice cooldown should be held, so repeatedly tripping the lock cannot flood the inbox.'
        );
    }

    public function test_failed_attempts_are_audit_logged(): void
    {
        $user = $this->makeCustomer();

        $this->attemptFromRotatingIp($user->email, 'wrong-password', 1);
        $this->attemptFromRotatingIp('nobody@example.com', 'wrong-password', 2);

        $rows = ActivityLog::where('action', 'failed_login')->get();

        $this->assertCount(2, $rows);
        $this->assertSame($user->id, $rows[0]->user_id);
        $this->assertSame('bad_password', $rows[0]->new_values['reason']);

        // Unknown address: unattributable to a user, so the attempted email is the record.
        $this->assertNull($rows[1]->user_id);
        $this->assertSame('nobody@example.com', $rows[1]->new_values['email']);
    }
}
