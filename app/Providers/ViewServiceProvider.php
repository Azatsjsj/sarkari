<?php
// app/Providers/ViewServiceProvider.php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Share categories with all views
        View::composer('*', function ($view) {
            $view->with('categories', \App\Models\Category::where('is_active', true)->get());
        });

        // Share search helper function
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