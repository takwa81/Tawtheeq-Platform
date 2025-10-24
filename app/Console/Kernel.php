<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('subscriptions:deactivate-expired')->daily();
        $schedule->command('trends:update-status')->everyMinute();
        $schedule->command('vet-appointments:update-status')->everyThirtyMinutes();
    }
}
