<?php

namespace Tests\Feature\Security;

use App\Models\JobApplication;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter;
use Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect;
use Tests\TestCase;

/**
 * Job-application CVs carry applicant PII and used to be written to the public disk under a
 * client-supplied filename, which made every CV downloadable without authentication and
 * allowed a "cv.php.pdf" polyglot to land in a web-served directory.
 */
class ResumeUploadTest extends TestCase
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

        Storage::fake('local');
        Storage::fake('public');
    }

    private function makeOpenJob(): int
    {
        $jobTitleId = DB::table('job_titles')->insertGetId([
            'name_english' => 'Structural Engineer',
            'name_arabic' => 'title-ar',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $categoryId = DB::table('job_categories')->insertGetId([
            'name_english' => 'Engineering',
            'name_arabic' => 'cat-ar',
            'status' => 'Active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return DB::table('jobs_postings')->insertGetId([
            'job_title_id' => $jobTitleId,
            'job_category_id' => $categoryId,
            'job_type' => 'Full Time',
            'code' => 'JOB-' . Str::random(6),
            'show_salary' => false,
            'registration_start_date' => now()->subDay()->toDateString(),
            'registration_end_date' => now()->addMonth()->toDateString(),
            'job_description_en' => 'desc',
            'job_description_ar' => 'desc-ar',
            'status' => 'Publish',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function applyWith(int $jobId, UploadedFile $resume)
    {
        return $this->post(route('careers.apply', $jobId), [
            'applicant_name' => 'Sara Ahmed',
            'email' => 'sara@example.com',
            'phone' => '+971500000000',
            'resume' => $resume,
            'cover_letter' => 'Please consider my application.',
        ]);
    }

    public function test_cv_is_stored_on_the_private_disk_not_the_public_one(): void
    {
        $jobId = $this->makeOpenJob();

        $this->applyWith($jobId, UploadedFile::fake()->create('My CV.pdf', 100, 'application/pdf'));

        $application = JobApplication::firstOrFail();

        Storage::disk('local')->assertExists($application->resume);
        $this->assertEmpty(
            Storage::disk('public')->allFiles(),
            'Nothing may be written to the public disk - it is served at /storage without auth.'
        );
    }

    public function test_stored_filename_is_generated_and_discards_the_client_name(): void
    {
        $jobId = $this->makeOpenJob();

        $this->applyWith($jobId, UploadedFile::fake()->create('My CV.pdf', 100, 'application/pdf'));

        $application = JobApplication::firstOrFail();

        $this->assertStringStartsWith('resumes/', $application->resume);
        $this->assertStringNotContainsString('My CV', $application->resume);
        $this->assertSame('My CV.pdf', $application->resume_original_name);

        // resumes/<uuid>.<ext>
        $this->assertMatchesRegularExpression(
            '#^resumes/[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}\.[a-z0-9]+$#',
            $application->resume
        );
    }

    public function test_double_extension_filename_cannot_produce_a_php_path(): void
    {
        $jobId = $this->makeOpenJob();

        $this->applyWith($jobId, UploadedFile::fake()->create('evil.php.pdf', 100, 'application/pdf'));

        $application = JobApplication::firstOrFail();

        $this->assertStringNotContainsString('.php', $application->resume);
        $this->assertStringEndsWith('.pdf', $application->resume);
    }

    public function test_apply_route_is_rate_limited(): void
    {
        $jobId = $this->makeOpenJob();

        for ($i = 0; $i < 5; $i++) {
            $this->applyWith($jobId, UploadedFile::fake()->create("cv{$i}.pdf", 10, 'application/pdf'));
        }

        $this->applyWith($jobId, UploadedFile::fake()->create('cv6.pdf', 10, 'application/pdf'))
            ->assertStatus(429);
    }

    public function test_cover_letter_length_is_bounded(): void
    {
        $jobId = $this->makeOpenJob();

        $this->post(route('careers.apply', $jobId), [
            'applicant_name' => 'Sara Ahmed',
            'email' => 'sara@example.com',
            'phone' => '+971500000000',
            'resume' => UploadedFile::fake()->create('cv.pdf', 10, 'application/pdf'),
            'cover_letter' => str_repeat('a', 5001),
        ])->assertSessionHasErrors('cover_letter');

        $this->assertSame(0, JobApplication::count());
    }

    public function test_guest_cannot_download_a_cv(): void
    {
        $jobId = $this->makeOpenJob();
        $this->applyWith($jobId, UploadedFile::fake()->create('cv.pdf', 10, 'application/pdf'));

        $application = JobApplication::firstOrFail();

        $response = $this->get(route('crm-job-applications.download', $application->id));

        $this->assertContains($response->getStatusCode(), [302, 401, 403]);
    }
}
