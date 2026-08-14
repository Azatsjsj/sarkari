<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Result;
use App\Models\AdmitCard;
use App\Models\AnswerKey;
use App\Models\Document;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SitemapController extends Controller
{
    /**
     * Cache duration in minutes (720 = 12 hours)
     */
    protected $cacheDuration = 720;
    
    /**
     * Maximum URLs per sitemap (Google limit is 50,000)
     */
    protected $maxUrlsPerSitemap = 25000;
    
    /**
     * Check if route exists
     */
    private function routeExists($name)
    {
        return Route::has($name);
    }
    
    /**
     * Get route URL safely - FIXED to properly handle parameters
     */
    private function getRouteUrl($name, $parameters = [], $fallback = null)
    {
        if ($this->routeExists($name)) {
            try {
                // Ensure parameters are properly passed
                if (!empty($parameters)) {
                    return route($name, $parameters);
                }
                return route($name);
            } catch (\Exception $e) {
                Log::warning("Route {$name} failed: " . $e->getMessage());
                return $fallback ?? url("/{$name}");
            }
        }
        return $fallback ?? url("/{$name}");
    }
    
    /**
     * Main sitemap index
     */
    public function index()
    {
        try {
            $sitemaps = Cache::remember('sitemap.index', $this->cacheDuration, function () {
                $sitemapList = [];
                
                $sitemapConfigs = [
                    ['name' => 'pages', 'route' => 'sitemap.pages', 'priority' => '1.0'],
                    ['name' => 'jobs', 'route' => 'sitemap.jobs', 'priority' => '0.9'],
                    ['name' => 'results', 'route' => 'sitemap.results', 'priority' => '0.8'],
                    ['name' => 'admit-cards', 'route' => 'sitemap.admit-cards', 'priority' => '0.8'],
                    ['name' => 'answer-keys', 'route' => 'sitemap.answer-keys', 'priority' => '0.8'],
                    ['name' => 'documents', 'route' => 'sitemap.documents', 'priority' => '0.7'],
                    ['name' => 'categories', 'route' => 'sitemap.categories', 'priority' => '0.7'],
                ];
                
                foreach ($sitemapConfigs as $config) {
                    if ($this->routeExists($config['route'])) {
                        try {
                            $sitemapList[] = [
                                'loc' => route($config['route']),
                                'lastmod' => now()->toIso8601String(),
                                'priority' => $config['priority']
                            ];
                        } catch (\Exception $e) {
                            Log::warning("Sitemap route {$config['route']} failed: " . $e->getMessage());
                            continue;
                        }
                    }
                }
                
                return $sitemapList;
            });

            return $this->generateSitemapIndexXml($sitemaps);
            
        } catch (\Exception $e) {
            Log::error('Sitemap index generation failed: ' . $e->getMessage());
            return $this->generateErrorSitemap();
        }
    }

    /**
     * Generate sitemap index XML
     */
    private function generateSitemapIndexXml($sitemaps)
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        
        foreach ($sitemaps as $sitemap) {
            $xml .= '  <sitemap>' . "\n";
            $xml .= '    <loc>' . htmlspecialchars($sitemap['loc'], ENT_XML1, 'UTF-8') . '</loc>' . "\n";
            $xml .= '    <lastmod>' . $sitemap['lastmod'] . '</lastmod>' . "\n";
            $xml .= '  </sitemap>' . "\n";
        }
        
        $xml .= '</sitemapindex>';
        
        return response($xml, 200)
            ->header('Content-Type', 'application/xml')
            ->header('X-Robots-Tag', 'index,follow')
            ->header('Cache-Control', 'public, max-age=3600');
    }

    /**
     * Generate error sitemap
     */
    private function generateErrorSitemap()
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        $xml .= '  <url>' . "\n";
        $xml .= '    <loc>' . htmlspecialchars(url('/'), ENT_XML1, 'UTF-8') . '</loc>' . "\n";
        $xml .= '    <lastmod>' . now()->toIso8601String() . '</lastmod>' . "\n";
        $xml .= '    <priority>1.0</priority>' . "\n";
        $xml .= '    <changefreq>daily</changefreq>' . "\n";
        $xml .= '  </url>' . "\n";
        $xml .= '</urlset>';
        
        return response($xml, 200)
            ->header('Content-Type', 'application/xml')
            ->header('X-Robots-Tag', 'index,follow');
    }

    /**
     * Static pages sitemap
     */
    public function pages()
    {
        try {
            $pages = Cache::remember('sitemap.pages', $this->cacheDuration, function () {
                $pageList = [];
                
                $staticPages = [
                    ['route' => 'home', 'priority' => '1.0', 'freq' => 'daily', 'fallback' => '/'],
                    ['route' => 'jobs', 'priority' => '0.9', 'freq' => 'daily', 'fallback' => '/jobs'],
                    ['route' => 'admit-cards', 'priority' => '0.8', 'freq' => 'daily', 'fallback' => '/admit-cards'],
                    ['route' => 'answer-keys', 'priority' => '0.8', 'freq' => 'daily', 'fallback' => '/answer-keys'],
                    ['route' => 'results', 'priority' => '0.8', 'freq' => 'daily', 'fallback' => '/results'],
                    ['route' => 'documents.index', 'priority' => '0.7', 'freq' => 'daily', 'fallback' => '/documents'],
                    ['route' => 'blog.index', 'priority' => '0.7', 'freq' => 'weekly', 'fallback' => '/blog'],
                    ['route' => 'admissions', 'priority' => '0.7', 'freq' => 'weekly', 'fallback' => '/admissions'],
                    ['route' => 'universities.index', 'priority' => '0.6', 'freq' => 'weekly', 'fallback' => '/universities'],
                    ['route' => 'about', 'priority' => '0.5', 'freq' => 'monthly', 'fallback' => '/about'],
                    ['route' => 'contact', 'priority' => '0.5', 'freq' => 'monthly', 'fallback' => '/contact'],
                    ['route' => 'privacy-policy', 'priority' => '0.3', 'freq' => 'monthly', 'fallback' => '/privacy-policy'],
                    ['route' => 'terms-of-service', 'priority' => '0.3', 'freq' => 'monthly', 'fallback' => '/terms-of-service'],
                    ['route' => 'disclaimer', 'priority' => '0.3', 'freq' => 'monthly', 'fallback' => '/disclaimer'],
                ];
                
                foreach ($staticPages as $page) {
                    $url = $this->getRouteUrl($page['route'], [], $page['fallback']);
                    
                    $pageList[] = [
                        'loc' => $url,
                        'lastmod' => now()->toIso8601String(),
                        'priority' => $page['priority'],
                        'changefreq' => $page['freq']
                    ];
                }
                
                return $pageList;
            });

            return $this->generateSitemapXml($pages);
            
        } catch (\Exception $e) {
            Log::error('Pages sitemap generation failed: ' . $e->getMessage());
            return $this->generateErrorSitemap();
        }
    }

    /**
     * Jobs sitemap - FIXED with proper route parameters
     */
    public function jobs()
    {
        try {
            $jobs = Cache::remember('sitemap.jobs', $this->cacheDuration, function () {
                $jobsCollection = [];
                
                $routeExists = $this->routeExists('job.show');
                
                Job::where('is_active', true)
                    ->select('id', 'slug', 'updated_at', 'created_at', 'last_date', 'views', 'is_featured')
                    ->orderByRaw('CASE WHEN is_featured = 1 THEN 1 ELSE 2 END')
                    ->orderBy('created_at', 'desc')
                    ->chunk(500, function ($chunk) use (&$jobsCollection, $routeExists) {
                        foreach ($chunk as $job) {
                            if ($routeExists) {
                                try {
                                    $url = route('job.show', ['slug' => $job->slug]);
                                } catch (\Exception $e) {
                                    $url = url("/job/{$job->slug}");
                                }
                            } else {
                                $url = url("/job/{$job->slug}");
                            }
                            
                            $priority = $job->is_featured ? '0.9' : '0.8';
                                
                            $jobsCollection[] = [
                                'loc' => $url,
                                'lastmod' => $job->updated_at->toIso8601String(),
                                'priority' => $priority,
                                'changefreq' => 'daily'
                            ];
                        }
                    });
                
                return $jobsCollection;
            });

            return $this->generateSitemapXml($jobs);
            
        } catch (\Exception $e) {
            Log::error('Jobs sitemap generation failed: ' . $e->getMessage());
            return $this->generateErrorSitemap();
        }
    }

    /**
     * Results sitemap - FIXED with proper route parameters
     */
    public function results()
    {
        try {
            $results = Cache::remember('sitemap.results', $this->cacheDuration, function () {
                $resultsCollection = [];
                $routeExists = $this->routeExists('results.show');
                
                Result::where('is_active', true)
                    ->select('id', 'slug', 'updated_at', 'created_at', 'result_date', 'views')
                    ->orderBy('result_date', 'desc')
                    ->limit($this->maxUrlsPerSitemap)
                    ->chunk(500, function ($chunk) use (&$resultsCollection, $routeExists) {
                        foreach ($chunk as $result) {
                            if ($routeExists) {
                                try {
                                    $url = route('results.show', ['result' => $result->slug]);
                                } catch (\Exception $e) {
                                    $url = url("/results/{$result->slug}");
                                }
                            } else {
                                $url = url("/results/{$result->slug}");
                            }
                                
                            $lastmod = $result->result_date && $result->result_date > $result->updated_at 
                                ? $result->result_date->toIso8601String() 
                                : $result->updated_at->toIso8601String();
                                
                            $resultsCollection[] = [
                                'loc' => $url,
                                'lastmod' => $lastmod,
                                'priority' => '0.8',
                                'changefreq' => 'weekly'
                            ];
                        }
                    });
                
                return $resultsCollection;
            });

            return $this->generateSitemapXml($results);
            
        } catch (\Exception $e) {
            Log::error('Results sitemap generation failed: ' . $e->getMessage());
            return $this->generateErrorSitemap();
        }
    }

    /**
     * Admit Cards sitemap - FIXED with proper route parameters
     */
    public function admitCards()
    {
        try {
            $admitCards = Cache::remember('sitemap.admit-cards', $this->cacheDuration, function () {
                $admitCardsCollection = [];
                $routeExists = $this->routeExists('admit-card.show');
                
                AdmitCard::where('is_active', true)
                    ->select('id', 'slug', 'updated_at', 'created_at', 'exam_date')
                    ->orderBy('exam_date', 'desc')
                    ->limit($this->maxUrlsPerSitemap)
                    ->chunk(500, function ($chunk) use (&$admitCardsCollection, $routeExists) {
                        foreach ($chunk as $admitCard) {
                            // FIXED: Properly pass slug as parameter
                            if ($routeExists) {
                                try {
                                    $url = route('admit-card.show', ['slug' => $admitCard->slug]);
                                } catch (\Exception $e) {
                                    $url = url("/admit-card/{$admitCard->slug}");
                                }
                            } else {
                                $url = url("/admit-card/{$admitCard->slug}");
                            }
                                
                            $admitCardsCollection[] = [
                                'loc' => $url,
                                'lastmod' => $admitCard->updated_at->toIso8601String(),
                                'priority' => '0.8',
                                'changefreq' => 'daily'
                            ];
                        }
                    });
                
                return $admitCardsCollection;
            });

            return $this->generateSitemapXml($admitCards);
            
        } catch (\Exception $e) {
            Log::error('Admit Cards sitemap generation failed: ' . $e->getMessage());
            return $this->generateErrorSitemap();
        }
    }

    /**
     * Answer Keys sitemap - FIXED with proper route parameters
     */
    public function answerKeys()
    {
        try {
            $answerKeys = Cache::remember('sitemap.answer-keys', $this->cacheDuration, function () {
                $answerKeysCollection = [];
                $routeExists = $this->routeExists('answer-key.show');
                
                AnswerKey::where('is_active', true)
                    ->select('id', 'slug', 'updated_at', 'created_at')
                    ->orderBy('created_at', 'desc')
                    ->limit($this->maxUrlsPerSitemap)
                    ->chunk(500, function ($chunk) use (&$answerKeysCollection, $routeExists) {
                        foreach ($chunk as $answerKey) {
                            // FIXED: Properly pass slug as parameter
                            if ($routeExists) {
                                try {
                                    $url = route('answer-key.show', ['slug' => $answerKey->slug]);
                                } catch (\Exception $e) {
                                    $url = url("/answer-key/{$answerKey->slug}");
                                }
                            } else {
                                $url = url("/answer-key/{$answerKey->slug}");
                            }
                                
                            $answerKeysCollection[] = [
                                'loc' => $url,
                                'lastmod' => $answerKey->updated_at->toIso8601String(),
                                'priority' => '0.7',
                                'changefreq' => 'weekly'
                            ];
                        }
                    });
                
                return $answerKeysCollection;
            });

            return $this->generateSitemapXml($answerKeys);
            
        } catch (\Exception $e) {
            Log::error('Answer Keys sitemap generation failed: ' . $e->getMessage());
            return $this->generateErrorSitemap();
        }
    }

    /**
     * Documents sitemap - FIXED with proper route parameters
     */
    public function documents()
    {
        try {
            $documents = Cache::remember('sitemap.documents', $this->cacheDuration, function () {
                $documentsCollection = [];
                $routeExists = $this->routeExists('documents.show');
                
                Document::where('is_active', true)
                    ->select('id', 'slug', 'updated_at', 'created_at', 'issue_date', 'type')
                    ->orderBy('issue_date', 'desc')
                    ->limit($this->maxUrlsPerSitemap)
                    ->chunk(500, function ($chunk) use (&$documentsCollection, $routeExists) {
                        foreach ($chunk as $document) {
                            if ($routeExists) {
                                try {
                                    $url = route('documents.show', ['document' => $document->slug]);
                                } catch (\Exception $e) {
                                    $url = url("/documents/{$document->slug}");
                                }
                            } else {
                                $url = url("/documents/{$document->slug}");
                            }
                                
                            $priority = $document->type === 'notice' ? '0.7' : '0.6';
                            $documentsCollection[] = [
                                'loc' => $url,
                                'lastmod' => ($document->issue_date ?? $document->updated_at)->toIso8601String(),
                                'priority' => $priority,
                                'changefreq' => 'weekly'
                            ];
                        }
                    });
                
                return $documentsCollection;
            });

            return $this->generateSitemapXml($documents);
            
        } catch (\Exception $e) {
            Log::error('Documents sitemap generation failed: ' . $e->getMessage());
            return $this->generateErrorSitemap();
        }
    }

    /**
     * Categories sitemap - FIXED with proper route parameters
     */
    public function categories()
    {
        try {
            $categories = Cache::remember('sitemap.categories', $this->cacheDuration, function () {
                $categoriesCollection = [];
                $routeExists = $this->routeExists('categories.show');
                
                Category::where('is_active', true)
                    ->select('id', 'slug', 'name', 'updated_at', 'created_at')
                    ->withCount('jobs')
                    ->having('jobs_count', '>', 0)
                    ->chunk(200, function ($chunk) use (&$categoriesCollection, $routeExists) {
                        foreach ($chunk as $category) {
                            if ($routeExists) {
                                try {
                                    $url = route('categories.show', ['slug' => $category->slug]);
                                } catch (\Exception $e) {
                                    $url = url("/categories/{$category->slug}");
                                }
                            } else {
                                $url = url("/categories/{$category->slug}");
                            }

                            $categoriesCollection[] = [
                                'loc' => $url,
                                'lastmod' => $category->updated_at->toIso8601String(),
                                'priority' => '0.7',
                                'changefreq' => 'weekly'
                            ];
                        }
                    });
                
                return $categoriesCollection;
            });

            return $this->generateSitemapXml($categories);
            
        } catch (\Exception $e) {
            Log::error('Categories sitemap generation failed: ' . $e->getMessage());
            return $this->generateErrorSitemap();
        }
    }

    /**
     * Generate sitemap XML from array
     */
    private function generateSitemapXml($urls)
    {
        if (empty($urls)) {
            $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
            $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
            $xml .= '</urlset>';
            return response($xml, 200)->header('Content-Type', 'application/xml');
        }
        
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">' . "\n";
        
        foreach ($urls as $url) {
            $xml .= '  <url>' . "\n";
            $xml .= '    <loc>' . htmlspecialchars($url['loc'], ENT_XML1, 'UTF-8') . '</loc>' . "\n";
            $xml .= '    <lastmod>' . $url['lastmod'] . '</lastmod>' . "\n";
            $xml .= '    <priority>' . $url['priority'] . '</priority>' . "\n";
            $xml .= '    <changefreq>' . $url['changefreq'] . '</changefreq>' . "\n";
            $xml .= '  </url>' . "\n";
        }
        
        $xml .= '</urlset>';
        
        return response($xml, 200)
            ->header('Content-Type', 'application/xml')
            ->header('X-Robots-Tag', 'index,follow')
            ->header('Cache-Control', 'public, max-age=3600');
    }

    /**
     * Generate all sitemaps at once
     */
    public function generateAll(Request $request)
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
            
            // Set last generated timestamp
            Cache::put('sitemap.last_generated', now()->toIso8601String(), $this->cacheDuration);
            
            // Force regenerate by calling each method
            $this->pages();
            $this->jobs();
            $this->results();
            $this->admitCards();
            $this->answerKeys();
            $this->documents();
            $this->categories();
            
            // Update robots.txt
            $this->updateRobotsTxt();
            
            // Ping search engines (only if requested)
            if ($request->get('ping', false)) {
                $this->pingSearchEngines();
            }
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'All sitemaps generated successfully!',
                    'sitemap_url' => route('sitemap.index')
                ]);
            }
            
            return redirect()->back()->with('success', 'All sitemaps generated successfully!');
            
        } catch (\Exception $e) {
            Log::error('Sitemap generation failed: ' . $e->getMessage());
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sitemap generation failed: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Sitemap generation failed: ' . $e->getMessage());
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
    
    /**
     * Clear all sitemap caches
     */
    public function clearCache()
    {
        try {
            Cache::forget('sitemap.index');
            Cache::forget('sitemap.pages');
            Cache::forget('sitemap.jobs');
            Cache::forget('sitemap.results');
            Cache::forget('sitemap.admit-cards');
            Cache::forget('sitemap.answer-keys');
            Cache::forget('sitemap.documents');
            Cache::forget('sitemap.categories');
            Cache::forget('sitemap.last_generated');
            
            if (request()->expectsJson()) {
                return response()->json(['success' => true, 'message' => 'Sitemap cache cleared successfully!']);
            }
            
            return redirect()->back()->with('success', 'Sitemap cache cleared successfully!');
            
        } catch (\Exception $e) {
            Log::error('Sitemap cache clear failed: ' . $e->getMessage());
            
            if (request()->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Failed to clear cache: ' . $e->getMessage()], 500);
            }
            
            return redirect()->back()->with('error', 'Failed to clear cache: ' . $e->getMessage());
        }
    }
    
    /**
     * Get sitemap statistics
     */
    public function stats()
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
                'cache_duration' => $this->cacheDuration . ' minutes',
                'total_urls' => 0,
            ];
            
            // Calculate total URLs
            $total = 0;
            $total += $stats['jobs'];
            $total += $stats['results'];
            $total += $stats['admit_cards'];
            $total += $stats['answer_keys'];
            $total += $stats['documents'];
            $total += $stats['categories'];
            $stats['total_urls'] = $total;
            
            return response()->json($stats);
            
        } catch (\Exception $e) {
            Log::error('Sitemap stats failed: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to get stats: ' . $e->getMessage()], 500);
        }
    }
}
