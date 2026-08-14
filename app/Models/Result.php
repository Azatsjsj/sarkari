<?php
// app/Models/Result.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Result extends Model
{
    use HasFactory;

    protected $table = 'results';

    protected $fillable = [
        'title', 
        'slug', 
        'job_id', 
        'description', 
        'result_link', 
        'result_pdf',  // Changed from 'result_file' to match migration
        'result_date', 
        'declaration_date',  // Added for consistency
        'is_active'
    ];

    // Add date casting
    protected $casts = [
        'result_date' => 'date',
        'declaration_date' => 'date',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Boot method to handle slug generation
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($result) {
            if (empty($result->slug)) {
                $result->slug = static::generateUniqueSlug($result->title);
            }
        });

        static::updating(function ($result) {
            if ($result->isDirty('title') && empty($result->slug)) {
                $result->slug = static::generateUniqueSlug($result->title);
            }
        });
    }

    /**
     * Generate unique slug
     */
    public static function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        while (static::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

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

    /**
     * Get the job that owns the result
     */
    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    // ========== ACCESSORS ==========
    
    /**
     * Get result PDF URL (from result_pdf field)
     */
    public function getResultPdfUrlAttribute()
    {
        return $this->getFileUrl($this->result_pdf);
    }

    /**
     * Get result file URL (alias for result_pdf_url - for backward compatibility)
     */
    public function getFileUrlAttribute()
    {
        return $this->getResultPdfUrlAttribute();
    }

    /**
     * Helper method to get file URL
     */
    protected function getFileUrl($file)
    {
        if (!$file) {
            return null;
        }
        
        // Check if it's already a full URL
        if (filter_var($file, FILTER_VALIDATE_URL)) {
            return $file;
        }
        
        // Return storage URL
        return asset('storage/' . ltrim($file, '/'));
    }

    /**
     * Get formatted result date
     */
    public function getFormattedResultDateAttribute()
    {
        return $this->formatDate($this->result_date);
    }

    /**
     * Get formatted declaration date
     */
    public function getFormattedDeclarationDateAttribute()
    {
        return $this->formatDate($this->declaration_date);
    }

    /**
     * Format date for display
     */
    protected function formatDate($date)
    {
        if (!$date) {
            return 'Not Declared';
        }

        try {
            if (is_string($date)) {
                return Carbon::parse($date)->format('d M Y');
            }
            return $date->format('d M Y');
        } catch (\Exception $e) {
            return 'Invalid Date';
        }
    }

    /**
     * Get result status text
     */
    public function getStatusTextAttribute()
    {
        if (!$this->is_active) {
            return 'Inactive';
        }
        
        if ($this->result_date && Carbon::parse($this->result_date)->gt(Carbon::today())) {
            return 'Upcoming';
        }
        
        return 'Published';
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeClassAttribute()
    {
        if (!$this->is_active) {
            return 'secondary';
        }
        
        if ($this->result_date && Carbon::parse($this->result_date)->gt(Carbon::today())) {
            return 'warning';
        }
        
        return 'success';
    }

    /**
     * Check if result is published
     */
    public function getIsPublishedAttribute()
    {
        if (!$this->is_active) {
            return false;
        }
        
        if ($this->result_date && Carbon::parse($this->result_date)->gt(Carbon::today())) {
            return false;
        }
        
        return true;
    }

    /**
     * Get short description (truncated)
     */
    public function getShortDescriptionAttribute($length = 100)
    {
        if (!$this->description) {
            return null;
        }
        
        return Str::limit(strip_tags($this->description), $length);
    }

    // ========== MUTATORS ==========
    
    /**
     * Set slug before saving
     */
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = $value ?: Str::slug($this->title);
    }

    // ========== SCOPES ==========
    
    /**
     * Scope for active results
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for inactive results
     */
    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    /**
     * Scope for published results (result date <= today or null)
     */
    public function scopePublished($query)
    {
        return $query->where('is_active', true)
                     ->where(function($q) {
                         $q->whereDate('result_date', '<=', now())
                           ->orWhereNull('result_date');
                     });
    }

    /**
     * Scope for upcoming results (result date > today)
     */
    public function scopeUpcoming($query)
    {
        return $query->where('is_active', true)
                     ->whereNotNull('result_date')
                     ->whereDate('result_date', '>', now());
    }

    /**
     * Scope for results by date range
     */
    public function scopeDateBetween($query, $startDate, $endDate)
    {
        return $query->whereBetween('result_date', [$startDate, $endDate]);
    }

    /**
     * Scope for latest results first
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('result_date', 'desc')
                     ->orderBy('created_at', 'desc');
    }

    /**
     * Scope for oldest results first
     */
    public function scopeOldest($query)
    {
        return $query->orderBy('result_date', 'asc');
    }

    /**
     * Scope for search
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('title', 'LIKE', "%{$search}%")
              ->orWhere('description', 'LIKE', "%{$search}%")
              ->orWhereHas('job', function($jobQuery) use ($search) {
                  $jobQuery->where('title', 'LIKE', "%{$search}%");
              });
        });
    }

    // ========== METHODS ==========
    
    /**
     * Get result with job details
     */
    public static function getWithJobDetails($limit = 10)
    {
        return self::with('job')
                    ->active()
                    ->published()
                    ->latest()
                    ->limit($limit)
                    ->get();
    }

    /**
     * Get results by job
     */
    public static function getByJob($jobId, $perPage = 10)
    {
        return self::where('job_id', $jobId)
                    ->active()
                    ->latest()
                    ->paginate($perPage);
    }

    /**
     * Check if result has file
     */
    public function hasFile()
    {
        return !empty($this->result_pdf);
    }

    /**
     * Check if result has link
     */
    public function hasLink()
    {
        return !empty($this->result_link);
    }

    /**
     * Get download link (prefers file, falls back to link)
     */
    public function getDownloadLinkAttribute()
    {
        if ($this->hasFile()) {
            return $this->result_pdf_url;
        }
        
        return $this->result_link;
    }

    /**
     * Get file size in human readable format
     */
    public function getFileSizeAttribute()
    {
        if (!$this->result_pdf) {
            return null;
        }
        
        $path = storage_path('app/public/' . $this->result_pdf);
        
        if (file_exists($path)) {
            $bytes = filesize($path);
            $units = ['B', 'KB', 'MB', 'GB'];
            $i = 0;
            
            while ($bytes >= 1024 && $i < count($units) - 1) {
                $bytes /= 1024;
                $i++;
            }
            
            return round($bytes, 2) . ' ' . $units[$i];
        }
        
        return null;
    }
}