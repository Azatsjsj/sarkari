<?php

return [

    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | Most templating systems load templates from disk. Here you may specify
    | an array of paths that should be checked for your views. Of course
    | the usual Laravel view path has already been registered for you.
    |
    */

    'paths' => [
        resource_path('views'),
        resource_path('views/admin'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Compiled View Path
    |--------------------------------------------------------------------------
    |
    | This option determines where all the compiled Blade templates will be
    | stored for your application. Typically, this is within the storage
    | directory. However, as usual, you are free to change this value.
    |
    */

    'compiled' => env(
        'VIEW_COMPILED_PATH',
        realpath(storage_path('framework/views'))
    ),

    /*
    |--------------------------------------------------------------------------
    | View Cache
    |--------------------------------------------------------------------------
    |
    | This option controls whether views are cached. In production, views
    | should be cached to improve performance. In development, it's
    | usually better to disable caching to see changes immediately.
    |
    */

    'cache' => env('VIEW_CACHE', false),

    /*
    |--------------------------------------------------------------------------
    | View Cache Path
    |--------------------------------------------------------------------------
    |
    | This option specifies the path where cached views will be stored.
    | By default, Laravel stores them in the storage/framework/views directory.
    |
    */

    'cache_path' => env('VIEW_CACHE_PATH', storage_path('framework/views')),

    /*
    |--------------------------------------------------------------------------
    | View Namespace
    |--------------------------------------------------------------------------
    |
    | This option sets the default namespace for your views. This is useful
    | when using packages that require views to be registered with a
    | specific namespace.
    |
    */

    'namespace' => env('VIEW_NAMESPACE', null),

    /*
    |--------------------------------------------------------------------------
    | View Components
    |--------------------------------------------------------------------------
    |
    | This option configures the view component paths and namespaces for
    | your application. You can specify component classes and their
    | corresponding namespace.
    |
    */

    'components' => [
        'paths' => [
            app_path('View/Components'),
        ],
        'namespace' => 'App\\View\\Components',
    ],

];