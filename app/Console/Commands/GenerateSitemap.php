<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Log;
use Exception;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate
                            {--type=all : Type of sitemap to generate (all, pages, jobs, results, admit-cards, answer-keys, documents, admissions, courses, categories)}
                            {--force : Force generation even if cache exists}
                            {--ping : Ping search engines after generation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate XML sitemaps for the website';

    /**
     * Available sitemap types
     */
    protected $availableTypes = [
        'all',
        'pages',
        'jobs',
        'categories',
        'results',
        'admit-cards',
        'answer-keys',
        'documents',
        'admissions',
        'courses'
    ];

    /**
     * Execute the console command.
     *
     * @param  SitemapController  $controller
     * @return int
     */
    public function handle(SitemapController $controller)
    {
        try {
            $type = $this->option('type');
            $force = $this->option('force');
            $ping = $this->option('ping');
            
            // Validate type
            if (!in_array($type, $this->availableTypes)) {
                $this->error("Invalid sitemap type: {$type}");
                $this->info("Available types: " . implode(', ', $this->availableTypes));
                return 1;
            }
            
            $this->info('🚀 Starting sitemap generation...');
            $this->newLine();
            
            $startTime = microtime(true);
            
            if ($type === 'all') {
                $this->generateAllSitemaps($controller);
            } else {
                $this->generateSingleSitemap($controller, $type, $force);
            }
            
            $endTime = microtime(true);
            $executionTime = round($endTime - $startTime, 2);
            
            $this->newLine();
            $this->info("✅ Sitemap generation completed in {$executionTime} seconds!");
            
            // Ping search engines if requested
            if ($ping) {
                $this->pingSearchEngines();
            }
            
            // Show statistics
            $this->showStatistics($controller);
            
            return 0;
            
        } catch (Exception $e) {
            $this->error('❌ Error: ' . $e->getMessage());
            Log::error('Sitemap generation command failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return 1;
        }
    }

    /**
     * Generate all sitemaps
     *
     * @param SitemapController $controller
     * @return void
     */
    private function generateAllSitemaps(SitemapController $controller)
    {
        $this->info('Generating all sitemaps...');
        $this->withProgressBar($this->getSitemapTypes(), function ($type) use ($controller) {
            $this->generateSingleSitemap($controller, $type, false);
        });
        $this->newLine(2);
    }

    /**
     * Generate single sitemap
     *
     * @param SitemapController $controller
     * @param string $type
     * @param bool $force
     * @return void
     */
    private function generateSingleSitemap(SitemapController $controller, string $type, bool $force = false)
    {
        try {
            $method = $this->convertToMethodName($type);
            
            if (!method_exists($controller, $method)) {
                throw new Exception("Method {$method} does not exist in SitemapController");
            }
            
            $this->info("Generating {$type} sitemap...");
            
            // Clear cache if force option is used
            if ($force) {
                $this->clearSitemapCache($type);
                $this->line("  ↳ Cache cleared for {$type}");
            }
            
            // Generate sitemap
            $response = $controller->$method();
            
            // Check if generation was successful
            if ($response && $response->getStatusCode() === 200) {
                $this->line("  ✅ {$type} sitemap generated successfully");
                
                // Get file size if exists
                $filePath = public_path("sitemaps/sitemap-{$type}.xml");
                if (file_exists($filePath)) {
                    $size = $this->formatBytes(filesize($filePath));
                    $this->line("  📊 File size: {$size}");
                }
            } else {
                $this->warn("  ⚠️ {$type} sitemap generation returned unexpected response");
            }
            
        } catch (Exception $e) {
            $this->error("  ❌ Failed to generate {$type} sitemap: " . $e->getMessage());
            Log::error("Sitemap generation failed for {$type}: " . $e->getMessage());
        }
    }

    /**
     * Convert sitemap type to controller method name
     *
     * @param string $type
     * @return string
     */
    private function convertToMethodName(string $type): string
    {
        // Convert kebab-case to camelCase
        if (str_contains($type, '-')) {
            $parts = explode('-', $type);
            $method = $parts[0];
            for ($i = 1; $i < count($parts); $i++) {
                $method .= ucfirst($parts[$i]);
            }
            return $method;
        }
        
        return $type;
    }

    /**
     * Get list of sitemap types (excluding 'all')
     *
     * @return array
     */
    private function getSitemapTypes(): array
    {
        return array_filter($this->availableTypes, function ($type) {
            return $type !== 'all';
        });
    }

    /**
     * Clear sitemap cache for specific type
     *
     * @param string $type
     * @return void
     */
    private function clearSitemapCache(string $type): void
    {
        try {
            $cacheKey = "sitemap.{$type}";
            if (cache()->has($cacheKey)) {
                cache()->forget($cacheKey);
            }
        } catch (Exception $e) {
            $this->warn("  ⚠️ Could not clear cache: " . $e->getMessage());
        }
    }

    /**
     * Ping search engines about sitemap updates
     *
     * @return void
     */
    private function pingSearchEngines(): void
    {
        $this->newLine();
        $this->info('📡 Pinging search engines...');
        
        $sitemapUrl = url('/sitemap.xml');
        $searchEngines = [
            'Google' => "https://www.google.com/ping?sitemap=" . urlencode($sitemapUrl),
            'Bing' => "https://www.bing.com/ping?sitemap=" . urlencode($sitemapUrl),
            'Yandex' => "https://webmaster.yandex.com/ping/?sitemap=" . urlencode($sitemapUrl),
        ];
        
        foreach ($searchEngines as $name => $url) {
            $this->line("  Pinging {$name}...");
            $success = $this->sendPing($url);
            
            if ($success) {
                $this->line("  ✅ {$name} pinged successfully");
            } else {
                $this->warn("  ⚠️ Could not ping {$name}");
            }
        }
    }

    /**
     * Send ping to search engine
     *
     * @param string $url
     * @return bool
     */
    private function sendPing(string $url): bool
    {
        try {
            if (!function_exists('curl_init')) {
                return false;
            }
            
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            
            return $httpCode === 200;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Show sitemap statistics
     *
     * @param SitemapController $controller
     * @return void
     */
    private function showStatistics(SitemapController $controller): void
    {
        $this->newLine();
        $this->info('📊 Sitemap Statistics:');
        $this->line(str_repeat('-', 50));
        
        try {
            $stats = $controller->stats()->getData();
            
            $this->table(
                ['Type', 'Count'],
                [
                    ['Jobs', $stats->jobs ?? 0],
                    ['Categories', $stats->categories ?? 0],
                    ['Results', $stats->results ?? 0],
                    ['Admit Cards', $stats->admit_cards ?? 0],
                    ['Answer Keys', $stats->answer_keys ?? 0],
                    ['Documents', $stats->documents ?? 0],
                    ['Admissions', $stats->admissions ?? 0],
                    ['Courses', $stats->courses ?? 0],
                ]
            );
            
            if (isset($stats->cache_size)) {
                $this->line("💾 Total cache size: {$stats->cache_size}");
            }
            
            if (isset($stats->last_generated) && $stats->last_generated !== 'Never') {
                $this->line("🕒 Last generated: {$stats->last_generated}");
            }
            
        } catch (Exception $e) {
            $this->warn("Could not fetch statistics: " . $e->getMessage());
        }
    }

    /**
     * Format bytes to human readable format
     *
     * @param int $bytes
     * @param int $precision
     * @return string
     */
    private function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}