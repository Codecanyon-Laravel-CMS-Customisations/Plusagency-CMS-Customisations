<?php

namespace App\Console;

use App\BasicExtra;
use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\ImportProductImages;
use App\Console\Commands\SubscriptionChecker;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //App\Console\Commands\ImportProductImages::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $bex = BasicExtra::first();
        if ($bex->recurring_billing == 1) {
            $schedule->command('subscription:check')->daily();
        }
        // $schedule->command('import:product-images')->everyFiveMinutes();
        $schedule->command('import:product-images')->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

