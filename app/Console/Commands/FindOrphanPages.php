<?php
// app/Console/Commands/FindOrphanPages.php

namespace App\Console\Commands;

use App\Models\Job;
use App\Models\Result;
use App\Models\AdmitCard;
use App\Models\AnswerKey;
use App\Models\Category;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class FindOrphanPages extends Command
{
    protected $signature = 'seo:find-orphans {--fix : Attempt to automatically fix orphan pages}';
    protected $description = 'Find pages with no internal links';

    public function handle()
    {
        $this->info('🔍 Scanning for orphan pages...');
        
        $orphans = [];
        
        // Check Jobs
        $jobs = Job::where('is_active', true)->get();
        foreach ($jobs as $job) {
            $linkCount = DB::table('page_links')
                ->where('linked_url', 'like', "%/job/{$job->slug}%")
                ->count();
            
            if ($linkCount == 0) {
                $orphans[] = [
                    'type' => 'Job',
                    'title' => $job->title,
                    'url' => route('job.show', $job->slug),
                    'id' => $job->id
                ];
            }
        }
        
        // Check Categories
        $categories = Category::where('is_active', true)->get();
        foreach ($categories as $category) {
            $linkCount = DB::table('page_links')
                ->where('linked_url', 'like', "%/category/{$category->slug}%")
                ->count();
            
            if ($linkCount == 0) {
                $orphans[] = [
                    'type' => 'Category',
                    'title' => $category->name,
                    'url' => route('categories.show', $category->slug),
                    'id' => $category->id
                ];
            }
        }
        
        $this->table(['Type', 'Title', 'URL'], $orphans);
        $this->info("Found " . count($orphans) . " orphan pages");
        
        return $orphans;
    }
}