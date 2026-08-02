<?php

namespace Tests\Feature\Security;

use App\Models\ContactUs;
use App\Services\RecaptchaService;
use App\Support\FormGuard;
use App\Support\RecaptchaOutcome;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter;
use Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect;
use Tests\TestCase;

/**
 * reCAPTCHA used to return a bool that was true on any exception and true when the request
 * carried no token at all, so a bot could bypass it by omitting the field or by making
 * verification fail. check() now distinguishes a genuine rejection from an outage.
 */
class RecaptchaOutcomeTest extends TestCase
{
    use RefreshDatabase;

    private const SITEVERIFY = 'https://www.google.com/recaptcha/api/siteverify';

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

        // phpunit.xml blanks the secret so nothing calls Google by accident; these tests
        // opt back in with a fake one and intercept the HTTP call.
        config(['services.recaptcha.secret_key' => 'test-secret']);

        Mail::fake();
    }

    private function service(): RecaptchaService
    {
        return app(RecaptchaService::class);
    }

    private function fakeGoogle(array $payload, int $status = 200): void
    {
        Http::fake([self::SITEVERIFY => Http::response($payload, $status)]);
    }

    public function test_a_valid_token_passes(): void
    {
        $this->fakeGoogle(['success' => true, 'score' => 0.9, 'action' => 'contact_form']);

        $this->assertSame(
            RecaptchaOutcome::Passed,
            $this->service()->check('token', 'contact_form', '127.0.0.1')
        );
    }

    public function test_a_low_score_fails(): void
    {
        $this->fakeGoogle(['success' => true, 'score' => 0.1, 'action' => 'contact_form']);

        $this->assertSame(
            RecaptchaOutcome::Failed,
            $this->service()->check('token', 'contact_form', '127.0.0.1')
        );
    }

    public function test_a_token_minted_for_another_form_fails(): void
    {
        // Token replay: harvested from the login page, presented to the contact form.
        $this->fakeGoogle(['success' => true, 'score' => 0.9, 'action' => 'login']);

        $this->assertSame(
            RecaptchaOutcome::Failed,
            $this->service()->check('token', 'contact_form', '127.0.0.1')
        );
    }

    public function test_any_of_several_accepted_actions_passes(): void
    {
        $this->fakeGoogle(['success' => true, 'score' => 0.9, 'action' => 'home_contact']);

        $this->assertSame(
            RecaptchaOutcome::Passed,
            $this->service()->check('token', ['contact_form', 'home_contact'], '127.0.0.1')
        );
    }

    public function test_a_missing_token_is_a_failure_not_an_outage(): void
    {
        // The whole bypass: if this returned Unavailable a bot would just omit the token
        // to reach the lenient fail-open branch.
        $this->assertSame(
            RecaptchaOutcome::Failed,
            $this->service()->check(null, 'contact_form', '127.0.0.1')
        );
    }

    /**
     * Outages are simulated with a 5xx rather than a thrown ConnectionException: faking a
     * throwing handler segfaults PHP 8.2 here. Both land on the same Unavailable branch.
     */
    public function test_a_server_error_from_google_is_unavailable_not_a_pass(): void
    {
        $this->fakeGoogle(['error' => 'boom'], 503);

        $this->assertSame(
            RecaptchaOutcome::Unavailable,
            $this->service()->check('token', 'contact_form', '127.0.0.1')
        );
    }

    public function test_a_gateway_timeout_is_unavailable(): void
    {
        $this->fakeGoogle([], 504);

        $this->assertSame(
            RecaptchaOutcome::Unavailable,
            $this->service()->check('token', 'contact_form', '127.0.0.1')
        );
    }

    public function test_no_secret_reports_disabled(): void
    {
        config(['services.recaptcha.secret_key' => '']);

        $this->assertSame(
            RecaptchaOutcome::Disabled,
            $this->service()->check('token', 'contact_form', '127.0.0.1')
        );
    }

    public function test_contact_rejects_a_bad_token(): void
    {
        $this->fakeGoogle(['success' => false]);

        $this->submitContact()->assertSessionHasErrors('recaptcha');

        $this->assertSame(0, ContactUs::count());
    }

    public function test_contact_stays_open_during_an_outage_then_throttles(): void
    {
        $this->fakeGoogle(['error' => 'boom'], 503);

        // Fail open: a Google outage must not stop the business capturing leads.
        $this->submitContact('First enquiry about villas.')->assertSessionHas('success');
        $this->submitContact('Second enquiry about offices.')->assertSessionHas('success');
        $this->assertSame(2, ContactUs::count());

        // But the fail-open path is itself budgeted, so it is not a free bypass.
        $this->submitContact('Third enquiry about warehouses.')
            ->assertSessionHasErrors('recaptcha');

        $this->assertSame(2, ContactUs::count());
    }

    private function submitContact(?string $message = null)
    {
        return $this->post(route('contact.store'), [
            FormGuard::TIMESTAMP => FormGuard::signature(time() - 10),
            'name' => 'Sara Ahmed',
            'subject' => 'Project enquiry',
            'email' => 'sara@example.com',
            'message' => $message ?? 'I would like a quote for a villa in Dubai.',
            'g-recaptcha-response' => 'token',
        ]);
    }
}
