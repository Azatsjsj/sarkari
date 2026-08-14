<?php
// app/Helpers/PaginationHelper.php

if (!function_exists('is_paginated')) {
    function is_paginated($items) {
        return $items instanceof \Illuminate\Pagination\AbstractPaginator;
    }
}

if (!function_exists('safe_links')) {
    function safe_links($items, $view = null) {
        if (is_paginated($items)) {
            return $items->appends(request()->query())->links($view);
        }
        return '';
    }
}

if (!function_exists('pagination_info')) {
    function pagination_info($items) {
        if ($items instanceof \Illuminate\Pagination\LengthAwarePaginator) {
            return [
                'first' => $items->firstItem(),
                'last' => $items->lastItem(),
                'total' => $items->total(),
                'current_page' => $items->currentPage(),
                'last_page' => $items->lastPage(),
                'has_pages' => $items->hasPages(),
                'per_page' => $items->perPage()
            ];
        }
        return null;
    }
}

if (!function_exists('safe_pagination_display')) {
    function safe_pagination_display($items) {
        $info = pagination_info($items);
        
        if ($info && $info['has_pages']) {
            return "Showing {$info['first']} to {$info['last']} of {$info['total']} entries";
        }
        
        return "Showing " . count($items) . " entries";
    }
}