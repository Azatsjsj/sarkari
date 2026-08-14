<?php
// app/Console/Commands/SendDailyDigest.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Job;
use App\Models\Result;
use App\Models\AdmitCard;
use App\Models\AnswerKey;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendDailyDigest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'digest:send
                            {--email= : Send to specific email only}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send daily digest email to subscribers';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Preparing daily digest...');
        
        // Get today's updates
        $today = Carbon::today();
        
        $newJobs = Job::whereDate('created_at', $today)
            ->where('is_active', true)
            ->count();
        
        $newResults = Result::whereDate('created_at', $today)
            ->where('is_active', true)
            ->count();
        
        $newAdmitCards = AdmitCard::whereDate('created_at', $today)
            ->where('is_active', true)
            ->count();
        
        $newAnswerKeys = AnswerKey::whereDate('created_at', $today)
            ->where('is_active', true)
            ->count();
        
        $digestData = [
            'date' => $today->format('d M Y'),
            'newJobs' => $newJobs,
            'newResults' => $newResults,
            'newAdmitCards' => $newAdmitCards,
            'newAnswerKeys' => $newAnswerKeys,
            'recentJobs' => Job::where('is_active', true)->latest()->take(10)->get(),
            'recentResults' => Result::where('is_active', true)->latest()->take(5)->get(),
        ];
        
        // Send to specific email if provided
        if ($this->option('email')) {
            $this->sendDigest($this->option('email'), $digestData);
            $this->info("Digest sent to {$this->option('email')}");
        } else {
            // Send to all subscribers
            $subscribers = Subscriber::where('is_active', true)->get();
            $count = 0;
            
            foreach ($subscribers as $subscriber) {
                $this->sendDigest($subscriber->email, $digestData);
                $count++;
            }
            
            $this->info("Digest sent to {$count} subscribers");
        }
        
        $this->info('Daily digest completed!');
        
        return 0;
    }
    
    /**
     * Send digest email
     */
    private function sendDigest($email, $data)
    {
        try {
            Mail::send('emails.daily-digest', $data, function ($message) use ($email) {
                $message->to($email)
                    ->subject('Sarkari Result Daily Digest - ' . date('d M Y'));
            });
        } catch (\Exception $e) {
            $this->error("Failed to send to {$email}: " . $e->getMessage());
        }
    }
}