<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\MoveCashToPending::class,
        Commands\ZeroSellCodeNotification::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        /*
         * move cash to pending every wednesday and sunday 11:59pm / 23:50
         */
        $schedule->command('cash:movetopending')->everyMinute();


        /*
         * Check zero sell code to add to the list of zero sell code
         * schedule is every 3am
         */
        


        /*
         * Send email and sms notification to the list of account with zero sell code
         * schedule is every 12nn
         */
        


        /*
         * disable account or mark as inactive if the account day if 0 sell code is 5 days
         * schedule is every 1am
         */
        


        /*
         * disable member if 3 accounts is inactive
         * mark all acount as available
         * schedule is every 2am
         */

    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
