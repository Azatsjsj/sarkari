<?php
// app/Helpers/SearchHelper.php

if (!function_exists('highlightText')) {
    function highlightText($text, $query) {
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
    }
}