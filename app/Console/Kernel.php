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
        // Register custom commands here
    \App\Console\Commands\GenerateSitemap::class,
    \App\Console\Commands\ClearOldData::class,
    \App\Console\Commands\UpdateJobStatus::class,
    \App\Console\Commands\SendDailyDigest::class,
    \App\Console\Commands\BackupDatabase::class,
    \App\Console\Commands\OptimizeDatabase::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Generate sitemap daily at 2 AM
        $schedule->command('sitemap:generate')
            ->dailyAt('02:00')
            ->withoutOverlapping()
            ->appendOutputTo(storage_path('logs/sitemap.log'));
        
        
        // In app/Console/Kernel.php
            $schedule->call(function () {
             app(SitemapController::class)->generateAll();
           })->daily()->at('02:00');
    
        // Also generate after new content is added
            $schedule->command('sitemap:generate')->everyFourHours();



        // Clear old data every day at 3 AM
        $schedule->command('clean:old-data')
            ->dailyAt('03:00')
            ->withoutOverlapping()
            ->appendOutputTo(storage_path('logs/cleanup.log'));

        // Update job status (expire old jobs) every hour
        $schedule->command('jobs:update-status')
            ->hourly()
            ->withoutOverlapping()
            ->appendOutputTo(storage_path('logs/jobs-status.log'));

        // Send daily digest to subscribers at 8 AM
        $schedule->command('digest:send')
            ->dailyAt('08:00')
            ->withoutOverlapping()
            ->appendOutputTo(storage_path('logs/digest.log'));

        // Backup database daily at 1 AM
        $schedule->command('backup:database')
            ->dailyAt('01:00')
            ->withoutOverlapping()
            ->appendOutputTo(storage_path('logs/backup.log'));

        // Clear expired sessions every hour
        $schedule->command('session:gc')
            ->hourly();

        // Optimize database weekly on Sunday at 4 AM
        $schedule->command('db:optimize')
            ->weekly()
            ->sundays()
            ->at('04:00')
            ->withoutOverlapping();

        // Cache clear daily at 5 AM
        $schedule->command('cache:clear')
            ->dailyAt('05:00')
            ->environments(['production']);

        // View clear daily at 5:30 AM
        $schedule->command('view:clear')
            ->dailyAt('05:30')
            ->environments(['production']);

        // Route clear daily at 5:45 AM
        $schedule->command('route:clear')
            ->dailyAt('05:45')
            ->environments(['production']);

        // Config clear daily at 6 AM
        $schedule->command('config:clear')
            ->dailyAt('06:00')
            ->environments(['production']);
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

    /**
     * Get the timezone that should be used by default for scheduled events.
     *
     * @return \DateTimeZone|string|null
     */
    protected function scheduleTimezone()
    {
        return 'Asia/Kolkata'; // Indian Standard Time
    }
}