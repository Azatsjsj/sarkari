<?php
// app/Providers/AppServiceProvider.php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use App\Models\Category;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share categories with all views (cached for performance)
        View::composer('*', function ($view) {
            static $categories = null;
            if ($categories === null) {
                try {
                    if (Schema::hasTable('categories')) {
                        $categories = Category::where('is_active', true)
                            ->orderBy('name')
                            ->get();
                    } else {
                        $categories = collect();
                    }
                } catch (\Throwable $e) {
                    Log::warning('Unable to load categories for shared view data: ' . $e->getMessage());
                    $categories = collect();
                }
            }
            $view->with('categories', $categories);
        });

        // Share highlightText function
        View::composer('*', function ($view) {
            $view->with('highlightText', function ($text, $query) {
                if (!$query || !$text) {
                    return e($text);
                }

                $words = array_filter(explode(' ', $query), function($word) {
                    return strlen(trim($word)) > 2;
                });

                if (empty($words)) {
                    return e($text);
                }

                $highlightedText = e($text);
                
                foreach ($words as $word) {
                    $word = trim($word);
                    $highlightedText = preg_replace(
                        '/(' . preg_quote($word, '/') . ')/i',
                        '<span class="highlight">$1</span>',
                        $highlightedText
                    );
                }

                return $highlightedText;
            });
        });
    }
}