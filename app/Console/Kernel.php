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
//        Commands\SendMsg::class,
        Commands\DelFormId::class,
        Commands\TestConsole::class,
        Commands\DailyReport::class,
        Commands\VideoDailyReport::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
//        $schedule->command('laravel:test')->everyMinute();
        $schedule->command('laravel:VideoDailyReport')->everyFiveMinutes();
        $schedule->command("laravel:DelFormId")->hourly();     //删除无用的formId
        $schedule->command('laravel:DailyReport')->dailyAt('01:00');      // 统计是视频转发阅读情况
//        $schedule->command('laravel:VideoDailyReport')->cron('*/5 * * * *');
        //   /usr/local/php/bin/php /data/www/dati/artisan laravel:creatDailyTimes
        //   $schedule->command('laravel:test')->everyMinute();
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
