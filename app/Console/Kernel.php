<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('favourites:clean-expired')->daily();
        $schedule->command('emails:clean-temp-attachments')->daily();

        // Sanctum tokens now expire; this clears the dead rows out of
        // personal_access_tokens so the table does not grow without bound.
        // Requires `schedule:run` to be on cron - see the deployment notes.
        $schedule->command('sanctum:prune-expired --hours=24')->daily();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
