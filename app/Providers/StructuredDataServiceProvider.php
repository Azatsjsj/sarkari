<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class StructuredDataServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Share structured data helper with all views
        view()->composer('*', function ($view) {
            $view->with('structuredDataHelper', new \App\Services\DynamicStructuredData());
        });
    }

    public function register(): void
    {
        $this->app->singleton('structured-data', function () {
            return new \App\Services\DynamicStructuredData();
        });
    }
}