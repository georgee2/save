<?php

namespace Tests\Feature\Security;

use App\Models\Favourite;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter;
use Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect;
use Tests\TestCase;

/**
 * favourite_session_id is the authorization key for every favourites operation, and the
 * share URL publishes its value. While the cookie was excluded from encryption, anyone who
 * received a shared link could set it and take over that list - reading it, deleting it, or
 * overwriting the name/email the CRM shows as the lead identity.
 *
 * Note: the *Json helpers drop all cookies unless withCredentials() is called
 * (MakesHttpRequests::prepareCookiesForJsonRequest), so every request here opts in.
 */
class FavouritesAuthzTest extends TestCase
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
    }

    private function makeList(string $sessionId, array $overrides = []): Favourite
    {
        return Favourite::create(array_merge([
            'session_id' => $sessionId,
            'item_type' => 'project',
            'item_id' => 42,
            'name' => 'Victim Name',
            'email' => 'victim@example.com',
            'expires_at' => now()->addDays(30),
        ], $overrides));
    }

    /**
     * Impersonation attempt: the share URL leaks the session id, so the attacker replays it
     * as a raw cookie value. An encrypted cookie cannot be forged this way.
     */
    private function asAttackerHolding(string $sessionId): self
    {
        return $this->withCredentials()
            ->withUnencryptedCookie('favourite_session_id', $sessionId);
    }

    public function test_forged_cookie_does_not_expose_another_list(): void
    {
        $victimSession = (string) Str::uuid();
        $this->makeList($victimSession);

        $response = $this->asAttackerHolding($victimSession)
            ->getJson(route('favourites.count'));

        $response->assertOk();
        $this->assertSame(0, $response->json('count'));
    }

    public function test_forged_cookie_cannot_overwrite_the_lead_identity(): void
    {
        Mail::fake();

        $victimSession = (string) Str::uuid();
        $this->makeList($victimSession);

        $this->asAttackerHolding($victimSession)
            ->postJson(route('favourites.sendEmail'), [
                'email' => 'attacker@example.com',
                'name' => 'Attacker',
            ]);

        $row = Favourite::where('session_id', $victimSession)->firstOrFail();

        $this->assertSame('victim@example.com', $row->email);
        $this->assertSame('Victim Name', $row->name);
    }

    public function test_forged_cookie_cannot_clear_another_list(): void
    {
        $victimSession = (string) Str::uuid();
        $this->makeList($victimSession);

        $this->asAttackerHolding($victimSession)
            ->deleteJson(route('favourites.clear'));

        $this->assertDatabaseHas('favourites', ['session_id' => $victimSession]);
    }

    public function test_forged_cookie_cannot_exfiltrate_another_list_by_email(): void
    {
        Mail::fake();

        $victimSession = (string) Str::uuid();
        $this->makeList($victimSession);

        $this->asAttackerHolding($victimSession)
            ->postJson(route('favourites.sendEmail'), ['email' => 'attacker@example.com']);

        Mail::assertNothingSent();
    }

    public function test_send_email_on_an_empty_list_stamps_nothing_and_sends_nothing(): void
    {
        Mail::fake();

        $this->makeList((string) Str::uuid());

        // A caller whose own session holds nothing must not write to any row: the details
        // used to be stamped before the empty-list check ran.
        $this->withCredentials()
            ->postJson(route('favourites.sendEmail'), [
                'email' => 'attacker@example.com',
                'name' => 'Attacker',
            ])->assertStatus(422);

        $this->assertSame(0, Favourite::where('email', 'attacker@example.com')->count());
        Mail::assertNothingSent();
    }

    public function test_send_email_is_rate_limited(): void
    {
        Mail::fake();

        for ($i = 0; $i < 3; $i++) {
            $this->withCredentials()
                ->postJson(route('favourites.sendEmail'), ['email' => 'me@example.com']);
        }

        $this->withCredentials()
            ->postJson(route('favourites.sendEmail'), ['email' => 'me@example.com'])
            ->assertStatus(429);
    }

    public function test_toggle_is_rate_limited(): void
    {
        for ($i = 0; $i < 60; $i++) {
            $this->withCredentials()->postJson(route('favourites.toggle'), [
                'item_type' => 'project',
                'item_id' => $i + 1,
            ]);
        }

        $this->withCredentials()->postJson(route('favourites.toggle'), [
            'item_type' => 'project',
            'item_id' => 999,
        ])->assertStatus(429);
    }

    public function test_a_normal_visitor_can_still_use_their_own_list(): void
    {
        $toggle = $this->withCredentials()->postJson(route('favourites.toggle'), [
            'item_type' => 'project',
            'item_id' => 7,
        ]);

        $toggle->assertOk();
        $this->assertTrue($toggle->json('added'));
        $this->assertSame(1, $toggle->json('count'));

        // Replay the encrypted cookie the app issued, exactly as a browser would.
        $issued = $toggle->getCookie('favourite_session_id', false);
        $this->assertNotNull($issued);

        $count = $this->withCredentials()
            ->withUnencryptedCookie('favourite_session_id', $issued->getValue())
            ->getJson(route('favourites.count'));

        $count->assertOk();
        $this->assertSame(1, $count->json('count'));
    }
}
