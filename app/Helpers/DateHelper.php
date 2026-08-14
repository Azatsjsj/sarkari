<?php
// app/Helpers/DateHelper.php

if (!function_exists('safe_date_format')) {
    function safe_date_format($date, $format = 'd M Y') {
        if (!$date) {
            return 'N/A';
        }
        
        if (is_string($date)) {
            try {
                $date = \Carbon\Carbon::parse($date);
            } catch (\Exception $e) {
                return 'Invalid Date';
            }
        }
        
        return $date->format($format);
    }
}

if (!function_exists('safe_carbon')) {
    function safe_carbon($date) {
        if (!$date) {
            return null;
        }

        if ($date instanceof \Carbon\Carbon) {
            return $date;
        }

        if ($date instanceof \DateTimeInterface) {
            return \Carbon\Carbon::instance($date);
        }

        if (is_string($date)) {
            try {
                return \Carbon\Carbon::parse($date);
            } catch (\Exception $e) {
                return null;
            }
        }

        return null;
    }
}

if (!function_exists('is_future_date')) {
    function is_future_date($date) {
        $date = safe_carbon($date);
        return $date ? $date->isFuture() : false;
    }
}

if (!function_exists('is_past_date')) {
    function is_past_date($date) {
        $date = safe_carbon($date);
        return $date ? $date->isPast() : false;
    }
}