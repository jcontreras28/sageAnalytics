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

        Commands\getArticleDataFromUrls::class,
        Commands\makeGADataArray::class,
        Commands\getRealtimeGAData::class,

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
        
            //Publication::getArticleDataTask()->hourly();
            //$schedule->command('articleData:get')->everyFiveMinutes()->withoutOverlapping();

            $schedule->command('article:getGAData')->everyMinute()->withoutOverlapping();
            $schedule->command('article:getGARealtimeData')->everyMinute()->withoutOverlapping();

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
