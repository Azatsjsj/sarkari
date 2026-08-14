<?php
// app/Models/AdmitCard.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AdmitCard extends Model
{
    use HasFactory;

    protected $table = 'admit_cards';

    protected $fillable = [
        'job_id',
        'title',
        'slug',
        'short_description',
        'description',
        'roll_number',
        'admit_card_date',
        'release_date',
        'exam_date',
        'exam_center',
        'exam_venue',
        'official_website',
        'download_link',
        'admit_card_pdf',
        'admit_card_file',  // Legacy field for backward compatibility
        'file_path',        // Added for controller compatibility
        'instructions',
        'required_documents',
        'is_active',
        'download_count',
        'views',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'exam_time',        // Added missing field
    ];

    protected $casts = [
        'admit_card_date' => 'date',
        'release_date' => 'date',
        'exam_date' => 'date',
        'is_active' => 'boolean',
        'download_count' => 'integer',
        'views' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the job that owns the admit card
     */
    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class);
    }

    /**
     * Boot method to handle slug generation
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($admitCard) {
            if (empty($admitCard->slug)) {
                $admitCard->slug = static::generateUniqueSlug($admitCard->title);
            }
        });

        static::updating(function ($admitCard) {
            if ($admitCard->isDirty('title') && empty($admitCard->slug)) {
                $admitCard->slug = static::generateUniqueSlug($admitCard->title);
            }
        });
    }

    /**
     * Generate unique slug for admit card
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

    /**
     * Get route key name for binding
     */
    public function getRouteKeyName()
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

    // ========== ACCESSORS ==========
    
    /**
     * Get admit card PDF URL
     */
    public function getAdmitCardPdfUrlAttribute()
    {
        return $this->getFileUrl($this->download_path);
    }

    /**
     * Get file URL (alias for backward compatibility)
     */
    public function getFileUrlAttribute()
    {
        return $this->getAdmitCardPdfUrlAttribute();
    }

    /**
     * Get the download file path for the admit card.
     */
    public function getDownloadPathAttribute()
    {
        return $this->normalizeStoragePath($this->file_path ?: $this->admit_card_file ?: $this->admit_card_pdf);
    }

    /**
     * Get the download URL for the admit card.
     */
    public function getDownloadUrlAttribute()
    {
        return $this->getFileUrl($this->download_path);
    }

    /**
     * Normalize storage file paths to remove any leading storage or public prefixes.
     */
    protected function normalizeStoragePath($file)
    {
        if (!$file) {
            return null;
        }

        if (filter_var($file, FILTER_VALIDATE_URL)) {
            return $file;
        }

        $file = preg_replace('#^(/)?(storage/|public/)#', '', $file);
        return ltrim($file, '/');
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
        
        // Remove storage prefix if present
        $file = ltrim($file, '/');
        if (str_starts_with($file, 'storage/')) {
            $file = substr($file, 8);
        }
        
        // Return storage URL
        return Storage::url($file);
    }

    /**
     * Get formatted admit card date
     */
    public function getFormattedAdmitCardDateAttribute()
    {
        return $this->formatDate($this->admit_card_date);
    }

    /**
     * Get formatted release date
     */
    public function getFormattedReleaseDateAttribute()
    {
        return $this->formatDate($this->release_date ?? $this->admit_card_date);
    }

    /**
     * Get formatted exam date
     */
    public function getFormattedExamDateAttribute()
    {
        return $this->formatDate($this->exam_date);
    }

    /**
     * Format date for display
     */
    protected function formatDate($date)
    {
        if (!$date) {
            return 'Not Specified';
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
     * Get exam location/venue
     */
    public function getExamLocationAttribute()
    {
        return $this->exam_venue ?? $this->exam_center ?? 'To be announced';
    }

    /**
     * Fallback title used by the public detail page.
     */
    public function getDisplayTitleAttribute()
    {
        return $this->title ?: ($this->job?->title ?? 'Admit Card Details');
    }

    /**
     * Fallback short description used by the public detail page.
     */
    public function getDisplayShortDescriptionAttribute()
    {
        return trim((string) ($this->short_description ?: $this->description ?: ($this->job?->short_description ?? $this->job?->description ?? 'Details will be updated soon.')));
    }

    /**
     * Fallback detailed description used by the public detail page.
     */
    public function getDisplayDescriptionAttribute()
    {
        return trim((string) ($this->description ?: $this->short_description ?: ($this->job?->description ?? $this->job?->short_description ?? 'Details will be updated soon.')));
    }

    /**
     * Fallback exam venue used by the public detail page.
     */
    public function getDisplayExamVenueAttribute()
    {
        return $this->exam_venue ?: ($this->job?->job_location ?? 'To be announced');
    }

    /**
     * Fallback exam date used by the public detail page.
     */
    public function getDisplayExamDateAttribute()
    {
        return $this->exam_date ?: ($this->admit_card_date ?: ($this->job?->exam_date ?: $this->job?->admit_card_date));
    }

    /**
     * Fallback admit card release date used by the public detail page.
     */
    public function getDisplayAdmitCardDateAttribute()
    {
        return $this->admit_card_date ?: ($this->release_date ?: ($this->job?->admit_card_date ?? null));
    }

    /**
     * Fallback exam time used by the public detail page.
     */
    public function getDisplayExamTimeAttribute()
    {
        return $this->exam_time ?: 'To be announced';
    }

    /**
     * Fallback official website used by the public detail page.
     */
    public function getDisplayOfficialWebsiteAttribute()
    {
        return $this->official_website ?: ($this->job?->official_website ?? null);
    }

    /**
     * Fallback instructions used by the public detail page.
     */
    public function getDisplayInstructionsAttribute()
    {
        return $this->instructions ?: ($this->job?->how_to_apply ?? 'Please follow the official notification for complete instructions.');
    }

    /**
     * Fallback required documents used by the public detail page.
     */
    public function getDisplayRequiredDocumentsAttribute()
    {
        return $this->required_documents ?: 'Carry your original ID proof, admit card printout, and any documents mentioned in the official notification.';
    }

    /**
     * Get status text
     */
    public function getStatusTextAttribute()
    {
        if (!$this->is_active) {
            return 'Inactive';
        }
        
        $releaseDate = $this->release_date ?? $this->admit_card_date;
        
        if ($releaseDate && Carbon::parse($releaseDate)->gt(Carbon::today())) {
            return 'Upcoming';
        }
        
        return 'Available';
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeClassAttribute()
    {
        if (!$this->is_active) {
            return 'secondary';
        }
        
        $releaseDate = $this->release_date ?? $this->admit_card_date;
        
        if ($releaseDate && Carbon::parse($releaseDate)->gt(Carbon::today())) {
            return 'warning';
        }
        
        return 'success';
    }

    /**
     * Check if admit card is available for download
     */
    public function getIsAvailableAttribute()
    {
        if (!$this->is_active) {
            return false;
        }
        
        $releaseDate = $this->release_date ?? $this->admit_card_date;
        
        if ($releaseDate && Carbon::parse($releaseDate)->gt(Carbon::today())) {
            return false;
        }
        
        return $this->hasDownloadLink();
    }

    /**
     * Get download button text
     */
    public function getDownloadButtonTextAttribute()
    {
        if ($this->hasFile()) {
            return 'Download Admit Card PDF';
        }
        
        if ($this->hasLink()) {
            return 'Download Admit Card Online';
        }
        
        return 'Coming Soon';
    }

    /**
     * Get truncated description - FIXED: Conflict with attribute
     */
    public function getTruncatedDescriptionAttribute($length = 150)
    {
        $description = $this->short_description ?? $this->description;
        
        if (!$description) {
            return null;
        }
        
        return Str::limit(strip_tags($description), $length);
    }

    // ========== MUTATORS ==========
    
    /**
     * Set slug before saving
     */
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = $value ?: Str::slug($this->title);
    }

    /**
     * Ensure file_path takes precedence
     */
    public function setAdmitCardFileAttribute($value)
    {
        $this->attributes['admit_card_file'] = $value;
        if (empty($this->file_path) && empty($this->admit_card_pdf)) {
            $this->attributes['file_path'] = $value;
        }
    }

    /**
     * Set file_path
     */
    public function setFilePathAttribute($value)
    {
        $this->attributes['file_path'] = $value;
    }

    // ========== SCOPES ==========
    
    /**
     * Scope for active admit cards
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for inactive admit cards
     */
    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    /**
     * Scope for available admit cards (release date <= today)
     */
    public function scopeAvailable($query)
    {
        $today = Carbon::today();
        
        return $query->where('is_active', true)
                     ->where(function($q) use ($today) {
                         $q->whereDate('admit_card_date', '<=', $today)
                           ->orWhereDate('release_date', '<=', $today)
                           ->orWhere(function($sub) {
                               $sub->whereNull('admit_card_date')
                                   ->whereNull('release_date');
                           });
                     });
    }

    /**
     * Scope for upcoming admit cards
     */
    public function scopeUpcoming($query)
    {
        $today = Carbon::today();
        
        return $query->where('is_active', true)
                     ->where(function($q) use ($today) {
                         $q->whereDate('admit_card_date', '>', $today)
                           ->orWhereDate('release_date', '>', $today);
                     });
    }

    /**
     * Scope for recent admit cards (within given days)
     */
    public function scopeRecent($query, $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Scope for latest admit cards
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('admit_card_date', 'desc')
                     ->orderBy('release_date', 'desc')
                     ->orderBy('created_at', 'desc');
    }

    /**
     * Scope for admit cards by job
     */
    public function scopeByJob($query, $jobId)
    {
        return $query->where('job_id', $jobId);
    }

    /**
     * Scope for search
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('title', 'LIKE', "%{$search}%")
              ->orWhere('short_description', 'LIKE', "%{$search}%")
              ->orWhere('description', 'LIKE', "%{$search}%")
              ->orWhere('roll_number', 'LIKE', "%{$search}%")
              ->orWhereHas('job', function($jobQuery) use ($search) {
                  $jobQuery->where('title', 'LIKE', "%{$search}%");
              });
        });
    }

    /**
     * Scope for trending (most viewed)
     */
    public function scopeTrending($query)
    {
        return $query->orderBy('views', 'desc');
    }

    /**
     * Scope for most downloaded
     */
    public function scopeMostDownloaded($query)
    {
        return $query->orderBy('download_count', 'desc');
    }

    // ========== METHODS ==========
    
    /**
     * Increment view count
     */
    public function incrementViews()
    {
        $this->increment('views');
    }

    /**
     * Increment download count (alias for controller compatibility)
     */
    public function incrementDownloads()
    {
        $this->increment('download_count');
    }

    /**
     * Increment download count
     */
    public function incrementDownloadCount()
    {
        $this->increment('download_count');
    }

    /**
     * Check if admit card has file
     */
    public function hasFile()
    {
        return !empty($this->download_path);
    }

    /**
     * Check if admit card has a local stored file that exists.
     */
    public function hasLocalFile()
    {
        $file = $this->download_path;

        if (!$file || filter_var($file, FILTER_VALIDATE_URL)) {
            return false;
        }

        return Storage::disk('public')->exists($file);
    }

    /**
     * Check if admit card has link
     */
    public function hasLink()
    {
        return !empty($this->download_link);
    }

    /**
     * Check if admit card has download link (file or link)
     */
    public function hasDownloadLink()
    {
        return $this->hasFile() || $this->hasLink();
    }

    /**
     * Get file size in human readable format
     */
    public function getFileSizeAttribute()
    {
        $file = $this->file_path ?? $this->admit_card_pdf ?? $this->admit_card_file;
        
        if (!$file) {
            return null;
        }
        
        // Handle full URLs
        if (filter_var($file, FILTER_VALIDATE_URL)) {
            return null;
        }
        
        // Try to get file from storage
        $path = $file;
        if (!str_starts_with($path, '/')) {
            $path = '/' . $path;
        }
        
        $fullPath = Storage::path($path);
        
        if (file_exists($fullPath)) {
            $bytes = filesize($fullPath);
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

    /**
     * Get admit cards grouped by job
     */
    public static function getGroupedByJob($limit = 10)
    {
        return self::with('job')
                    ->active()
                    ->available()
                    ->latest()
                    ->limit($limit)
                    ->get()
                    ->groupBy('job_id');
    }

    /**
     * Get popular admit cards (most downloaded)
     */
    public static function getPopular($limit = 10)
    {
        return self::with('job')
                    ->active()
                    ->available()
                    ->mostDownloaded()
                    ->limit($limit)
                    ->get();
    }

    /**
     * Check if admit card has exam time
     */
    public function hasExamTime()
    {
        return !empty($this->exam_time);
    }
}