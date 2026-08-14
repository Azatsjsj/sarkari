<?php
// app/Console/Commands/UpdateJobStatus.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Job;
use Carbon\Carbon;

class UpdateJobStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jobs:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update job status based on last date';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Updating job statuses...');
        
        // Expire jobs where last date has passed
        $expiredCount = Job::where('last_date', '<', Carbon::now())
            ->where('is_active', true)
            ->update(['is_active' => false]);
        
        $this->info("Expired {$expiredCount} jobs.");
        
        // Activate jobs where last date is in future but were inactive
        $activeCount = Job::where('last_date', '>=', Carbon::now())
            ->where('is_active', false)
            ->update(['is_active' => true]);
        
        $this->info("Activated {$activeCount} jobs.");
        
        // Send notifications for jobs expiring in 3 days
        $expiringSoon = Job::where('last_date', '>=', Carbon::now())
            ->where('last_date', '<=', Carbon::now()->addDays(3))
            ->where('is_active', true)
            ->count();
        
        if ($expiringSoon > 0) {
            $this->info("{$expiringSoon} jobs are expiring within 3 days.");
            // You can add email notification logic here
        }
        
        $this->info('Job status update completed!');
        
        return 0;
    }
}