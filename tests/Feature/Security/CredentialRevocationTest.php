<?php

namespace Tests\Feature\Security;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter;
use Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect;
use Tests\TestCase;

/**
 * Changing a password used to revoke nothing: reset links stayed valid for up to an hour,
 * invitation links for up to 48 hours, and Sanctum tokens never expired. Someone reacting
 * to a compromise by changing their password did not actually evict the attacker.
 */
class CredentialRevocationTest extends TestCase
{
    use RefreshDatabase;

    private const OLD = 'Str0ngPassw0rd';
    private const NEW = 'Even5tronger';

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
            'password' => Hash::make(self::OLD),
            'is_active' => true,
        ]);
    }

    private function changePasswordViaAccount(User $user)
    {
        return $this->actingAs($user)->put(route('account.settings.password'), [
            'current_password' => self::OLD,
            'password' => self::NEW,
            'password_confirmation' => self::NEW,
        ]);
    }

    public function test_a_pending_reset_link_dies_when_the_password_changes(): void
    {
        $user = $this->makeCustomer();

        // The attacker already holds this.
        $token = Password::broker()->createToken($user);

        $this->changePasswordViaAccount($user);

        $this->assertDatabaseMissing('password_reset_tokens', ['email' => $user->email]);

        // And it cannot be redeemed.
        $this->post(route('account.password.update'), [
            'token' => $token,
            'email' => $user->email,
            'password' => 'AttackerChosen1',
            'password_confirmation' => 'AttackerChosen1',
        ])->assertSessionHasErrors('email');

        $this->assertTrue(Hash::check(self::NEW, $user->fresh()->password));
    }

    public function test_a_pending_invitation_link_dies_too(): void
    {
        $user = $this->makeCustomer();

        // Separate table, 48 hour expiry. Consuming one broker's token used to leave the
        // other's live.
        $token = Password::broker('invitations')->createToken($user);

        $this->changePasswordViaAccount($user);

        $this->assertDatabaseMissing('customer_invitation_tokens', ['email' => $user->email]);

        $this->post(route('account.password.update'), [
            'token' => $token,
            'email' => $user->email,
            'password' => 'AttackerChosen1',
            'password_confirmation' => 'AttackerChosen1',
        ])->assertSessionHasErrors('email');
    }

    public function test_api_tokens_are_revoked_when_the_password_changes(): void
    {
        $user = $this->makeCustomer();

        $user->createToken('stolen-device', ['customer:read', 'customer:write']);
        $this->assertSame(1, $user->tokens()->count());

        $this->changePasswordViaAccount($user);

        $this->assertSame(0, $user->fresh()->tokens()->count());
    }

    public function test_the_remember_cookie_is_invalidated(): void
    {
        $user = $this->makeCustomer();
        $original = $user->remember_token;

        $this->changePasswordViaAccount($user);

        $this->assertNotSame($original, $user->fresh()->remember_token);
    }

    public function test_a_half_finished_email_change_is_abandoned(): void
    {
        $user = $this->makeCustomer();
        $user->forceFill([
            'pending_email' => 'attacker@example.com',
            'pending_email_token' => 'some-token',
        ])->save();

        $this->changePasswordViaAccount($user);

        $fresh = $user->fresh();
        $this->assertNull($fresh->pending_email);
        $this->assertNull($fresh->pending_email_token);
    }

    public function test_the_password_actually_changes_and_the_user_stays_signed_in(): void
    {
        $user = $this->makeCustomer();

        // logoutOtherDevices rewrites the password itself, so this guards against the
        // controller persisting a different hash than the session records.
        $this->changePasswordViaAccount($user)->assertRedirect(route('account.settings'));

        $this->assertTrue(Hash::check(self::NEW, $user->fresh()->password));
        $this->assertAuthenticatedAs($user->fresh());
    }

    public function test_the_api_change_revokes_tokens_and_returns_a_working_one(): void
    {
        $user = $this->makeCustomer();
        $old = $user->createToken('mobile-app', ['customer:read', 'customer:write']);

        $response = $this->withHeader('Authorization', 'Bearer ' . $old->plainTextToken)
            ->putJson('/api/customer/password', [
                'current_password' => self::OLD,
                'password' => self::NEW,
                'password_confirmation' => self::NEW,
            ]);

        $response->assertOk();

        // Exactly one token: the old one is gone, a fresh one was issued so the app is not
        // silently signed out.
        $this->assertSame(1, $user->fresh()->tokens()->count());
        $this->assertNotNull($response->json('token'));

        // The guard caches the user it resolved during the request above, and the test
        // client reuses one application across requests, so without this the next call
        // would authenticate from memory instead of re-reading the token.
        $this->app['auth']->forgetGuards();

        // The old bearer no longer works.
        $this->withHeader('Authorization', 'Bearer ' . $old->plainTextToken)
            ->getJson('/api/customer/me')
            ->assertStatus(401);
    }

    public function test_api_user_no_longer_leaks_bearer_equivalent_fields(): void
    {
        $user = $this->makeCustomer();
        $user->forceFill(['pending_email_token' => 'secret-token'])->save();
        $user->favouritesToken();

        $token = $user->createToken('mobile-app', ['customer:read']);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token->plainTextToken)
            ->getJson('/api/user');

        $response->assertOk();

        $body = $response->json();
        $this->assertArrayNotHasKey('pending_email_token', $body);
        $this->assertArrayNotHasKey('favourites_token', $body);
        $this->assertArrayNotHasKey('erp_customer_id', $body);
        $this->assertSame($user->email, $body['email']);
    }
}
