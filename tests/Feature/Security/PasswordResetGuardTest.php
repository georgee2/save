<?php

namespace Tests\Feature\Security;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter;
use Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect;
use Tests\TestCase;

/**
 * The public /set-password endpoint serves activation invites (invitations broker) and
 * falls back to the default broker for forgot-password links. The default broker reads the
 * same password_reset_tokens table staff resets use, so without an account-type guard a
 * staff or admin reset token could be redeemed here - and the endpoint then calls
 * Auth::login(), handing out an authenticated session without going through LoginController.
 */
class PasswordResetGuardTest extends TestCase
{
    use RefreshDatabase;

    private const NEW_PASSWORD = 'Str0ngPassw0rd';

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

    private function submitSetPassword(string $email, string $token)
    {
        return $this->post(route('account.password.update'), [
            'token' => $token,
            'email' => $email,
            'password' => self::NEW_PASSWORD,
            'password_confirmation' => self::NEW_PASSWORD,
        ]);
    }

    public function test_staff_reset_token_is_rejected_at_the_customer_endpoint(): void
    {
        $staff = User::factory()->staff()->create([
            'password' => Hash::make('original-staff-password'),
            'is_active' => true,
        ]);

        // Exactly what Modules/Admin ProfileController::sendResetLink() mints.
        $token = Password::broker()->createToken($staff);

        $this->submitSetPassword($staff->email, $token)
            ->assertSessionHasErrors('email');

        $this->assertGuest();
        $this->assertTrue(
            Hash::check('original-staff-password', $staff->fresh()->password),
            'A staff password must not be changeable through the customer endpoint.'
        );
    }

    public function test_the_same_staff_token_still_works_on_the_staff_endpoint(): void
    {
        $staff = User::factory()->staff()->create([
            'password' => Hash::make('original-staff-password'),
            'is_active' => true,
        ]);

        $token = Password::broker()->createToken($staff);

        $this->post(route('staff.password.update'), [
            'token' => $token,
            'email' => $staff->email,
            'password' => self::NEW_PASSWORD,
            'password_confirmation' => self::NEW_PASSWORD,
        ])->assertRedirect(route('login'));

        $this->assertTrue(Hash::check(self::NEW_PASSWORD, $staff->fresh()->password));
    }

    public function test_customer_activation_still_works_end_to_end(): void
    {
        $customer = User::factory()->customer()->create([
            'is_active' => true,
            'password_set_at' => null,
        ]);

        $token = Password::broker('invitations')->createToken($customer);

        $this->submitSetPassword($customer->email, $token)
            ->assertRedirect(route('account.dashboard'));

        $this->assertAuthenticatedAs($customer);
        $this->assertTrue(Hash::check(self::NEW_PASSWORD, $customer->fresh()->password));
    }

    public function test_customer_forgot_password_token_still_works(): void
    {
        $customer = User::factory()->customer()->create(['is_active' => true]);

        $token = Password::broker()->createToken($customer);

        $this->submitSetPassword($customer->email, $token)
            ->assertRedirect(route('account.dashboard'));

        $this->assertAuthenticatedAs($customer);
    }

    public function test_inactive_customer_cannot_reactivate_via_an_old_link(): void
    {
        $customer = User::factory()->customer()->create([
            'is_active' => false,
            'password' => Hash::make('original-password'),
        ]);

        $token = Password::broker('invitations')->createToken($customer);

        $this->submitSetPassword($customer->email, $token)
            ->assertSessionHasErrors('email');

        $this->assertGuest();

        $fresh = $customer->fresh();
        $this->assertFalse((bool) $fresh->is_active, 'set-password must not reactivate a disabled account.');
        $this->assertTrue(Hash::check('original-password', $fresh->password));
    }

    public function test_unknown_email_and_bad_token_are_indistinguishable(): void
    {
        $customer = User::factory()->customer()->create(['is_active' => true]);

        $unknown = $this->from(route('account.password.set', ['token' => 'x']))
            ->submitSetPassword('nobody@example.com', 'invalid-token');

        $badToken = $this->from(route('account.password.set', ['token' => 'x']))
            ->submitSetPassword($customer->email, 'invalid-token');

        $this->assertSame(
            $unknown->getSession()->get('errors')->first('email'),
            $badToken->getSession()->get('errors')->first('email'),
            'Differing messages would reveal whether an address has an account.'
        );
    }
}
