<?php

namespace Tests\Feature\Security;

use App\Models\ContactUs;
use App\Support\FormGuard;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter;
use Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect;
use Tests\TestCase;

/**
 * The offer and project inquiry forms post into the existing contact intake, carrying a
 * reference to the item they came from. Before this they posted nowhere at all - the offers
 * form had no action and buttons of type="button", and the projects form was a bare <form>
 * whose inputs had no name attributes, so a GET reloaded the page and discarded everything.
 */
class InquiryFormTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware([
            LocaleSessionRedirect::class,
            LaravelLocalizationRedirectFilter::class,
        ]);

        // sendConfirmationEmail() reads ContactInformation::getContactInfo().
        DB::table('contact_information')->insert([
            'tags' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Mail::fake();
    }

    private function makeOffer(string $title = 'Villa Package'): int
    {
        $categoryId = DB::table('offer_categories')->insertGetId([
            'title_english' => 'Residential',
            'title_arabic' => 'residential-ar',
            'slug' => 'residential-' . Str::random(6),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $typeId = DB::table('project_types')->insertGetId([
            'name_english' => 'Villa',
            'name_arabic' => 'villa-ar',
            'slug' => 'villa-' . Str::random(6),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return DB::table('offers')->insertGetId([
            'title_english' => $title,
            'title_arabic' => $title . '-ar',
            'slug' => Str::slug($title) . '-' . Str::random(6),
            'category_id' => $categoryId,
            'type_id' => $typeId,
            'main_image' => 'offers/example.webp',
            'publish_status' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function submit(array $overrides = [])
    {
        return $this->post(route('contact.store'), array_merge([
            FormGuard::TIMESTAMP => FormGuard::signature(time() - 10),
            'name' => 'Sara Ahmed',
            'subject' => 'Schedule a tour - Villa Package',
            'email' => 'sara@example.com',
            'phone' => '+971500000000',
            'message' => 'Hello, I am interested in Villa Package',
            'source' => 'offer_tour',
            'related_type' => 'offer',
            'preferred_date' => now()->addDays(3)->toDateString(),
            'preferred_time' => '10:00',
        ], $overrides));
    }

    public function test_an_offer_tour_request_is_stored_with_its_reference(): void
    {
        $offerId = $this->makeOffer();

        $this->submit(['related_id' => $offerId])->assertSessionHas('success');

        $row = ContactUs::firstOrFail();

        $this->assertSame('offer_tour', $row->source);
        $this->assertSame('offer', $row->related_type);
        $this->assertSame($offerId, (int) $row->related_id);
        $this->assertSame(now()->addDays(3)->toDateString(), $row->preferred_date->toDateString());
        $this->assertSame('10:00', $row->preferred_time);
    }

    public function test_the_new_source_values_are_accepted(): void
    {
        $offerId = $this->makeOffer();

        // These four all 422'd before, because the whitelist was home_inline|contact_page.
        foreach (['offer_tour', 'offer_info', 'project_tour', 'project_info'] as $i => $source) {
            $this->submit([
                'source' => $source,
                'related_id' => $offerId,
                'related_type' => 'offer',
                'email' => "person{$i}@example.com",
            ])->assertSessionHasNoErrors();
        }

        $this->assertSame(4, ContactUs::count());
    }

    public function test_an_unknown_related_type_is_rejected(): void
    {
        $this->submit(['related_type' => 'invoice', 'related_id' => 1])
            ->assertSessionHasErrors('related_type');

        $this->assertSame(0, ContactUs::count());
    }

    public function test_a_reference_to_a_missing_item_is_rejected(): void
    {
        // Otherwise the CRM would render a dead link for a lead nobody can action.
        $this->submit(['related_type' => 'offer', 'related_id' => 999999])
            ->assertSessionHasErrors('related_id');

        $this->assertSame(0, ContactUs::count());
    }

    public function test_a_type_without_an_id_is_rejected(): void
    {
        $this->submit(['related_type' => 'offer', 'related_id' => null])
            ->assertSessionHasErrors('related_id');

        $this->assertSame(0, ContactUs::count());
    }

    public function test_a_past_visit_date_is_rejected(): void
    {
        $offerId = $this->makeOffer();

        $this->submit([
            'related_id' => $offerId,
            'preferred_date' => now()->subDay()->toDateString(),
        ])->assertSessionHasErrors('preferred_date');

        $this->assertSame(0, ContactUs::count());
    }

    public function test_enquiring_about_two_offers_is_not_treated_as_a_duplicate(): void
    {
        $first = $this->makeOffer('Villa Package');
        $second = $this->makeOffer('Townhouse Package');

        // Both forms pre-fill the message, so without the item in the dedupe fingerprint
        // the second enquiry would be silently dropped.
        $this->submit(['related_id' => $first]);
        $this->submit(['related_id' => $second]);

        $this->assertSame(2, ContactUs::count());
    }

    public function test_the_bot_guard_still_applies(): void
    {
        $offerId = $this->makeOffer();

        $this->submit([
            'related_id' => $offerId,
            FormGuard::HONEYPOT => 'http://spam.example',
        ])->assertSessionHas('success')->assertSessionHasNoErrors();

        $this->assertSame(0, ContactUs::count());
    }

    public function test_a_plain_contact_message_still_works_without_a_reference(): void
    {
        $this->submit([
            'source' => 'contact_page',
            'related_type' => null,
            'related_id' => null,
            'preferred_date' => null,
            'preferred_time' => null,
        ])->assertSessionHas('success');

        $row = ContactUs::firstOrFail();

        $this->assertNull($row->related_type);
        $this->assertNull($row->related_id);
    }
}
