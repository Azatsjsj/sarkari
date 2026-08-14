<?php
// app/Console/Commands/ClearOldData.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Job;
use App\Models\Result;
use App\Models\AdmitCard;
use App\Models\AnswerKey;
use Carbon\Carbon;

class ClearOldData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clean:old-data
                            {--days=90 : Number of days to keep data}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear old and expired data from the database';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $days = (int) $this->option('days');
        $cutoffDate = Carbon::now()->subDays($days);
        
        $this->info("Clearing data older than {$days} days...");
        
        // Clear expired jobs (older than cutoff date)
        $expiredJobs = Job::where('last_date', '<', $cutoffDate)
            ->where('is_active', true)
            ->update(['is_active' => false]);
        
        $this->info("Updated {$expiredJobs} expired jobs to inactive.");
        
        // Clear old results (older than cutoff date)
        $oldResults = Result::where('result_date', '<', $cutoffDate)
            ->where('is_active', true)
            ->update(['is_active' => false]);
        
        $this->info("Updated {$oldResults} old results to inactive.");
        
        // Clear old admit cards
        $oldAdmitCards = AdmitCard::where('admit_card_date', '<', $cutoffDate)
            ->where('is_active', true)
            ->update(['is_active' => false]);
        
        $this->info("Updated {$oldAdmitCards} old admit cards to inactive.");
        
        // Clear old answer keys
        $oldAnswerKeys = AnswerKey::where('answer_key_date', '<', $cutoffDate)
            ->where('is_active', true)
            ->update(['is_active' => false]);
        
        $this->info("Updated {$oldAnswerKeys} old answer keys to inactive.");
        
        $this->info('Old data cleanup completed!');
        
        return 0;
    }
}