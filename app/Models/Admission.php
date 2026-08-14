<?php
// app/Models/Admission.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Admission extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'short_description',
        'description',
        'university_id',
        'course_id',
        'start_date',
        'last_date',
        'exam_date',
        'application_fee',
        'total_seats',
        'eligibility',
        'application_process',
        'important_dates',
        'contact_info',
        'official_website',
        'brochure_url',
        'apply_url',
        'is_active',
        'is_featured',
        'meta_title',
        'meta_description',
        'views'
    ];

    protected $casts = [
        'start_date' => 'date',
        'last_date' => 'date',
        'exam_date' => 'date',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'important_dates' => 'array',
        'contact_info' => 'array',
        'application_fee' => 'decimal:2'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($admission) {
            if (empty($admission->slug)) {
                $admission->slug = Str::slug($admission->title);
            }
        });
    }

    public function university(): BelongsTo
    {
        return $this->belongsTo(University::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('last_date', '>=', now());
    }

    public function isExpired(): bool
    {
        return $this->last_date->isPast();
    }

    public function daysLeft(): int
    {
        return now()->diffInDays($this->last_date, false);
    }

    public function getStatusAttribute(): string
    {
        if ($this->isExpired()) {
            return 'expired';
        } elseif ($this->daysLeft() <= 7) {
            return 'last_week';
        } else {
            return 'active';
        }
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Retrieve the model for a bound value with flexible slug & ID matching.
     */
    public function resolveRouteBinding($value, $field = null)
    {
        $field = $field ?? $this->getRouteKeyName();
        $stringValue = (string) $value;
        $decodedValue = urldecode($stringValue);
        $cleanSlug = Str::slug($decodedValue);

        $found = $this->where($field, $stringValue)
            ->orWhere($field, $decodedValue)
            ->orWhere($field, $cleanSlug)
            ->orWhere('id', $stringValue)
            ->first();

        if (!$found && !empty($cleanSlug)) {
            $keywords = explode('-', $cleanSlug);
            $query = $this->query();
            foreach ($keywords as $kw) {
                if (strlen($kw) > 2) {
                    $query->orWhere('title', 'like', "%{$kw}%");
                }
            }
            $found = $query->first();
        }

        return $found ?? abort(404);
    }
}