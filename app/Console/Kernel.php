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
        Commands\CheckZeroSellCode::class,
        Commands\DisableAccount::class,
        Commands\DisableMember::class,
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
        // $schedule->command('cash:movetopending')->everyMinute();

        // $schedule->command('cash:movetopending')
        //         ->wednesdays()
        //         ->at('23:59');

        // $schedule->command('cash:movetopending')
        //         ->sundays()
        //         ->at('23:59');
                
        

        /*
         * Check zero sell code to add to the list of zero sell code
         * schedule is every 1am
         */
        // $schedule->command('sellcode:check')->dailyAt('01:00');
        


        /*
         * disable account or mark as inactive if the account day if 0 sell code is 5 days
         * schedule is every 1:30am
         */
        // $schedule->command('accounts:disable')->dailyAt('01:30');
        


        /*
         * disable member if 3 accounts is inactive
         * mark all acount as available
         * schedule is every 2am
         */
        // $schedule->command('members:disable')->dailyAt('02:00');
        


        /*
         * Send email and sms notification to the list of account with zero sell code
         * schedule is every 2:30am
         */
        // $schedule->command('notification:zerosellcode')->dailyAt('02:30');
        

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
