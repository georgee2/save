<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;

class CleanTempEmailAttachments extends Command
{
    protected $signature = 'emails:clean-temp-attachments {--hours=24 : Delete files older than this many hours}';

    protected $description = 'Delete orphaned temp email attachments left in storage/app/temp_email_attachments';

    public function handle(): int
    {
        $dir = storage_path('app/temp_email_attachments');

        if (!File::isDirectory($dir)) {
            $this->info('No temp attachments directory; nothing to clean.');
            return Command::SUCCESS;
        }

        $threshold = Carbon::now()->subHours((int) $this->option('hours'));
        $deleted = 0;

        foreach (File::files($dir) as $file) {
            if (Carbon::createFromTimestamp($file->getMTime())->lessThan($threshold)) {
                @unlink($file->getPathname());
                $deleted++;
            }
        }

        $this->info("Deleted {$deleted} orphaned temp attachment(s).");

        return Command::SUCCESS;
    }
}
