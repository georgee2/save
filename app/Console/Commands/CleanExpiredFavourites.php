<?php

namespace App\Console\Commands;

use App\Models\Favourite;
use Illuminate\Console\Command;

class CleanExpiredFavourites extends Command
{
    protected $signature = 'favourites:clean-expired';
    protected $description = 'Delete expired favourite records that are not permanent';

    public function handle()
    {
        $count = Favourite::expired()->delete();
        $this->info("Deleted {$count} expired favourite(s).");
        return Command::SUCCESS;
    }
}
