<?php
// app/Http/Controllers/Admin/AdminSitemapController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Result;
use App\Models\AdmitCard;
use App\Models\AnswerKey;
use App\Models\Document;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class AdminSitemapController extends Controller
{
    /**
     * Display sitemap management dashboard
     */
    public function index()
    {
        // Get sitemap statistics
        $stats = [
            'jobs' => Job::where('is_active', true)->count(),
            'results' => Result::where('is_active', true)->count(),
            'admit_cards' => AdmitCard::where('is_active', true)->count(),
            'answer_keys' => AnswerKey::where('is_active', true)->count(),
            'documents' => Document::where('is_active', true)->count(),
            'categories' => Category::where('is_active', true)->has('jobs')->count(),
            'total_urls' => 0,
            'last_generated' => Cache::get('sitemap.last_generated', 'Never'),
            'cache_duration' => '12 hours',
        ];
        
        // Calculate total
        $stats['total_urls'] = $stats['jobs'] + $stats['results'] + $stats['admit_cards'] + 
                              $stats['answer_keys'] + $stats['documents'] + $stats['categories'];
        
        // Get sitemap URLs
        $sitemapUrls = [
            'index' => route('sitemap.index'),
            'pages' => route('sitemap.pages'),
            'jobs' => route('sitemap.jobs'),
            'results' => route('sitemap.results'),
            'admit_cards' => route('sitemap.admit-cards'),
            'answer_keys' => route('sitemap.answer-keys'),
            'documents' => route('sitemap.documents'),
            'categories' => route('sitemap.categories'),
        ];
        
        return view('admin.sitemap.index', compact('stats', 'sitemapUrls'));
    }
    
    /**
     * Generate all sitemaps
     */
    public function generate(Request $request)
    {
        try {
            // Clear all sitemap caches
            Cache::forget('sitemap.index');
            Cache::forget('sitemap.pages');
            Cache::forget('sitemap.jobs');
            Cache::forget('sitemap.results');
            Cache::forget('sitemap.admit-cards');
            Cache::forget('sitemap.answer-keys');
            Cache::forget('sitemap.documents');
            Cache::forget('sitemap.categories');
            Cache::forget('sitemap.last_generated');
            
            // Set last generated timestamp
            Cache::put('sitemap.last_generated', now()->toIso8601String(), 720);
            
            // Generate all sitemaps by calling the main sitemap controller
            $sitemapController = app(\App\Http\Controllers\SitemapController::class);
            
            // Generate each sitemap
            $sitemapController->pages();
            $sitemapController->jobs();
            $sitemapController->results();
            $sitemapController->admitCards();
            $sitemapController->answerKeys();
            $sitemapController->documents();
            $sitemapController->categories();
            
            // Update robots.txt
            $this->updateRobotsTxt();
            
            // Ping search engines if requested
            if ($request->has('ping') && $request->ping == 'true') {
                $this->pingSearchEngines();
                $message = 'All sitemaps generated successfully and search engines notified!';
            } else {
                $message = 'All sitemaps generated successfully!';
            }
            
            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'sitemap_url' => route('sitemap.index'),
                    'last_generated' => now()->toIso8601String()
                ]);
            }
            
            return redirect()->route('admin.sitemap.index')
                ->with('success', $message);
                
        } catch (\Exception $e) {
            Log::error('Sitemap generation failed: ' . $e->getMessage());
            
            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sitemap generation failed: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->route('admin.sitemap.index')
                ->with('error', 'Sitemap generation failed: ' . $e->getMessage());
        }
    }
    
    /**
     * Generate specific sitemap type
     */
    public function generateSpecific(Request $request, $type)
    {
        try {
            $allowedTypes = ['pages', 'jobs', 'results', 'admit-cards', 'answer-keys', 'documents', 'categories'];
            
            if (!in_array($type, $allowedTypes)) {
                throw new \Exception('Invalid sitemap type: ' . $type);
            }
            
            $methodMap = [
                'pages' => 'pages',
                'jobs' => 'jobs',
                'results' => 'results',
                'admit-cards' => 'admitCards',
                'answer-keys' => 'answerKeys',
                'documents' => 'documents',
                'categories' => 'categories'
            ];
            
            // Clear specific cache
            Cache::forget('sitemap.' . $type);
            
            // Generate specific sitemap
            $sitemapController = app(\App\Http\Controllers\SitemapController::class);
            $method = $methodMap[$type];
            $sitemapController->$method();
            
            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => ucfirst($type) . ' sitemap generated successfully!',
                    'url' => route('sitemap.' . $type)
                ]);
            }
            
            return redirect()->route('admin.sitemap.index')
                ->with('success', ucfirst($type) . ' sitemap generated successfully!');
                
        } catch (\Exception $e) {
            Log::error('Specific sitemap generation failed: ' . $e->getMessage());
            
            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to generate ' . $type . ' sitemap: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->route('admin.sitemap.index')
                ->with('error', 'Failed to generate ' . $type . ' sitemap: ' . $e->getMessage());
        }
    }
    
    /**
     * Clear sitemap cache
     */
    public function clearCache(Request $request)
    {
        try {
            $cacheKeys = [
                'sitemap.index',
                'sitemap.pages',
                'sitemap.jobs',
                'sitemap.results',
                'sitemap.admit-cards',
                'sitemap.answer-keys',
                'sitemap.documents',
                'sitemap.categories',
                'sitemap.last_generated'
            ];
            
            foreach ($cacheKeys as $key) {
                Cache::forget($key);
            }
            
            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Sitemap cache cleared successfully!'
                ]);
            }
            
            return redirect()->route('admin.sitemap.index')
                ->with('success', 'Sitemap cache cleared successfully!');
                
        } catch (\Exception $e) {
            Log::error('Sitemap cache clear failed: ' . $e->getMessage());
            
            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to clear cache: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->route('admin.sitemap.index')
                ->with('error', 'Failed to clear cache: ' . $e->getMessage());
        }
    }
    
    /**
     * Get sitemap statistics via AJAX
     */
    public function stats(Request $request)
    {
        try {
            $stats = [
                'jobs' => Job::where('is_active', true)->count(),
                'results' => Result::where('is_active', true)->count(),
                'admit_cards' => AdmitCard::where('is_active', true)->count(),
                'answer_keys' => AnswerKey::where('is_active', true)->count(),
                'documents' => Document::where('is_active', true)->count(),
                'categories' => Category::where('is_active', true)->has('jobs')->count(),
                'last_generated' => Cache::get('sitemap.last_generated', 'Never'),
                'cache_duration' => '12 hours',
                'total_urls' => 0,
            ];
            
            $stats['total_urls'] = $stats['jobs'] + $stats['results'] + $stats['admit_cards'] + 
                                  $stats['answer_keys'] + $stats['documents'] + $stats['categories'];
            
            return response()->json($stats);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to get stats: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Update robots.txt file
     */
    private function updateRobotsTxt()
    {
        try {
            $robotsPath = public_path('robots.txt');
            $sitemapUrl = route('sitemap.index');
            
            $content = "User-agent: *\n";
            $content .= "Allow: /\n";
            $content .= "Disallow: /admin/\n";
            $content .= "Disallow: /login\n";
            $content .= "Disallow: /register\n";
            $content .= "Disallow: /password/\n";
            $content .= "Disallow: /api/\n";
            $content .= "Disallow: /storage/\n";
            $content .= "Disallow: /vendor/\n";
            $content .= "Disallow: /debugbar/\n";
            $content .= "Disallow: /_debugbar/\n";
            $content .= "Sitemap: {$sitemapUrl}\n";
            $content .= "\n";
            $content .= "# Crawl delay for heavy sites\n";
            $content .= "Crawl-delay: 1\n";
            $content .= "\n";
            $content .= "# Host\n";
            $content .= "Host: " . url('/') . "\n";
            
            file_put_contents($robotsPath, $content);
            
        } catch (\Exception $e) {
            Log::warning('Could not update robots.txt: ' . $e->getMessage());
        }
    }
    
    /**
     * Ping search engines
     */
    private function pingSearchEngines()
    {
        try {
            $sitemapUrl = urlencode(route('sitemap.index'));
            
            $searchEngines = [
                "https://www.google.com/ping?sitemap={$sitemapUrl}",
                "https://www.bing.com/ping?sitemap={$sitemapUrl}",
                "https://www.baidu.com/ping?sitemap={$sitemapUrl}",
                "https://yandex.com/ping?sitemap={$sitemapUrl}",
            ];
            
            foreach ($searchEngines as $engine) {
                try {
                    $ch = curl_init($engine);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; SitemapPinger/1.0)');
                    curl_exec($ch);
                    curl_close($ch);
                } catch (\Exception $e) {
                    Log::warning("Failed to ping search engine: {$engine}", ['error' => $e->getMessage()]);
                }
            }
            
        } catch (\Exception $e) {
            Log::warning('Failed to ping search engines: ' . $e->getMessage());
        }
    }
}