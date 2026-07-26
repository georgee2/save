<?php

namespace Tests\Feature\Security;

use App\Models\ContactUs;
use App\Support\FormGuard;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter;
use Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect;
use Tests\TestCase;

/**
 * The contact form's bot layers used to be opt-in for the attacker: the time-trap was
 * written as `if ($formLoaded > 0 && ...)`, so omitting the field skipped it, and the
 * timestamp was an unsigned client-supplied time() that could be forged even when sent.
 */
class FormGuardTest extends TestCase
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

    /**
     * @param  array<string,mixed>  $overrides
     */
    private function submit(array $overrides = [], ?string $message = null)
    {
        return $this->post(route('contact.store'), array_merge([
            FormGuard::TIMESTAMP => FormGuard::signature(time() - 10),
            'name' => 'Sara Ahmed',
            'subject' => 'Project enquiry',
            'email' => 'sara@example.com',
            'phone' => '+971500000000',
            'message' => $message ?? 'I would like a quote for a villa in Dubai.',
        ], $overrides));
    }

    public function test_a_genuine_submission_is_stored_with_attribution(): void
    {
        $this->submit()->assertSessionHas('success');

        $row = ContactUs::firstOrFail();

        $this->assertSame('sara@example.com', $row->email);
        $this->assertNotNull($row->ip_address);
        $this->assertSame('contact_page', $row->source);
    }

    public function test_omitting_the_timestamp_is_rejected(): void
    {
        // The exact bypass: send nothing at all for the guard field.
        $this->submit([FormGuard::TIMESTAMP => null])
            ->assertSessionHasErrors();

        $this->assertSame(0, ContactUs::count());
    }

    public function test_a_forged_signature_is_rejected(): void
    {
        $forged = (time() - 10) . '|' . str_repeat('a', 64);

        $this->submit([FormGuard::TIMESTAMP => $forged])
            ->assertSessionHasErrors();

        $this->assertSame(0, ContactUs::count());
    }

    public function test_an_unsigned_timestamp_is_rejected(): void
    {
        // What the old implementation accepted.
        $this->submit([FormGuard::TIMESTAMP => (string) (time() - 10)])
            ->assertSessionHasErrors();

        $this->assertSame(0, ContactUs::count());
    }

    public function test_an_expired_signature_is_rejected(): void
    {
        $this->submit([FormGuard::TIMESTAMP => FormGuard::signature(time() - 90000)])
            ->assertSessionHasErrors();

        $this->assertSame(0, ContactUs::count());
    }

    public function test_instant_submission_looks_successful_but_stores_nothing(): void
    {
        // Bot signal, so the response must be indistinguishable from a real success or the
        // bot learns where the threshold is.
        $this->submit([FormGuard::TIMESTAMP => FormGuard::signature()])
            ->assertSessionHas('success')
            ->assertSessionHasNoErrors();

        $this->assertSame(0, ContactUs::count());
    }

    public function test_filling_the_honeypot_looks_successful_but_stores_nothing(): void
    {
        $this->submit([FormGuard::HONEYPOT => 'http://spam.example'])
            ->assertSessionHas('success')
            ->assertSessionHasNoErrors();

        $this->assertSame(0, ContactUs::count());
    }

    public function test_duplicate_submissions_are_dropped(): void
    {
        $this->submit()->assertSessionHas('success');
        $this->submit()->assertSessionHas('success');

        $this->assertSame(1, ContactUs::count());
    }

    public function test_a_different_message_from_the_same_person_is_kept(): void
    {
        $this->submit(message: 'First question about villas.');
        $this->submit(message: 'Second, unrelated question about offices.');

        $this->assertSame(2, ContactUs::count());
    }

    public function test_the_confirmation_email_is_capped_per_address(): void
    {
        $this->submit(message: 'First question about villas.');

        Mail::assertSentCount(1);

        // Asserted through the cooldown key rather than by sending twice and counting:
        // Application::terminate() does not clear its terminating callbacks, so in a test
        // that issues several requests against one app instance the first afterResponse
        // mail re-fires on every later request. That is a test-harness artifact - each
        // production request gets a fresh application - but it makes a second
        // assertSentCount meaningless here.
        $this->assertFalse(
            Cache::add('contact-confirm:sara@example.com', true, 600),
            'The per-address cooldown should be held after the first auto-reply.'
        );

        // A second, different message is still captured as a lead.
        $this->submit(message: 'Second, unrelated question about offices.');
        $this->assertSame(2, ContactUs::count());
    }
}
