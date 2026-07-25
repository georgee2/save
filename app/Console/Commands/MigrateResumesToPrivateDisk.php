<?php

namespace App\Console\Commands;

use App\Models\JobApplication;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Moves job-application CVs off the public disk.
 *
 * Applications used to be stored as `/uploads/resumes/<time()>_<client filename>` on the
 * `public` disk, which is served straight out of public/storage — every CV was downloadable
 * without authentication, and the client-supplied filename was preserved verbatim. This
 * relocates each file to the private `local` disk under a generated UUID name and records
 * the applicant's original filename separately.
 *
 * Safe to run more than once: rows already in the new format are skipped.
 */
class MigrateResumesToPrivateDisk extends Command
{
    protected $signature = 'resumes:migrate-private {--dry-run : List what would change without touching disk or database}';

    protected $description = 'Move job application CVs from the public disk to the private local disk';

    public function handle(): int
    {
        $dryRun = (bool) $this->option('dry-run');

        if ($dryRun) {
            $this->info('Dry run - no files or database rows will be modified.');
        }

        $migrated = $skipped = $missing = 0;

        JobApplication::query()
            ->whereNotNull('resume')
            ->where('resume', '!=', '')
            ->orderBy('id')
            ->chunkById(100, function ($applications) use ($dryRun, &$migrated, &$skipped, &$missing) {
                foreach ($applications as $application) {
                    // Legacy rows look like "/uploads/resumes/1735000000_My CV.pdf"; anything
                    // else is either already migrated or was never a public-disk path.
                    $legacyPath = ltrim((string) $application->resume, '/');

                    if (! Str::startsWith($legacyPath, 'uploads/resumes/')) {
                        $skipped++;
                        continue;
                    }

                    if (! Storage::disk('public')->exists($legacyPath)) {
                        $this->warn("Application #{$application->id}: file not found on the public disk ({$legacyPath})");
                        $missing++;
                        continue;
                    }

                    $basename = basename($legacyPath);
                    // Strip the "<time()>_" prefix the old code prepended to recover the
                    // applicant's own filename. Fall back to the whole basename if absent.
                    $originalName = preg_replace('/^\d{9,}_/', '', $basename) ?: $basename;

                    $extension = pathinfo($basename, PATHINFO_EXTENSION) ?: 'pdf';
                    $newPath = 'resumes/' . Str::uuid() . '.' . strtolower($extension);

                    $this->line("Application #{$application->id}: {$legacyPath} -> {$newPath}");

                    if ($dryRun) {
                        $migrated++;
                        continue;
                    }

                    $contents = Storage::disk('public')->get($legacyPath);

                    if ($contents === null) {
                        $this->warn("Application #{$application->id}: could not read the file, leaving it in place");
                        $missing++;
                        continue;
                    }

                    Storage::disk('local')->put($newPath, $contents);

                    $application->forceFill([
                        'resume' => $newPath,
                        'resume_original_name' => $originalName,
                    ])->save();

                    // Only remove the public copy once the private one is committed.
                    Storage::disk('public')->delete($legacyPath);

                    $migrated++;
                }
            });

        $this->newLine();
        $this->info("Migrated: {$migrated}");
        $this->info("Already private / not a public path: {$skipped}");

        if ($missing > 0) {
            $this->warn("Missing or unreadable files: {$missing}");
        }

        if ($dryRun && $migrated > 0) {
            $this->newLine();
            $this->comment('Re-run without --dry-run to apply.');
        }

        if (! $dryRun && $migrated > 0) {
            $this->newLine();
            $this->comment('Now delete any leftovers under storage/app/public/uploads/resumes so nothing stays web-reachable.');
        }

        return self::SUCCESS;
    }
}
