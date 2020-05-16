<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use BrowscapPHP\BrowscapUpdater;
use BrowscapPHP\Helper\IniLoaderInterface;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        # Update the browscap.ini into Redis cache
        $schedule->command('browscap:cache')
            ->daily()
            ->runInBackground()
            ->onOneServer();

        # Notify users about low credits by mail
        $schedule->command('notify:lowcredits')
            ->dailyAt('20:00')
            ->runInBackground()
            ->onOneServer();

        # Substract the credits for active codes
        $schedule->command('pay:codes')
            ->daily()
            ->runInBackground()
            ->onOneServer();

        # Substract the credits for active codes
        $schedule->command('pay:tokens')
            ->daily()
            ->runInBackground()
            ->onOneServer();

        
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
