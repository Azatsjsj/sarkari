@php
    if (class_exists('App\Services\DynamicStructuredData')) {
        echo (new \App\Services\DynamicStructuredData())->generate();
    }
@endphp