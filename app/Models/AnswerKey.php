<?php
// app/Models/AnswerKey.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AnswerKey extends Model
{
    use HasFactory;

    protected $table = 'answer_keys';

    protected $fillable = [
        'job_id',
        'title',
        'slug',
        'short_description',
        'description',
        'answer_key_date',
        'release_date',
        'exam_name',
        'exam_date',
        'exam_shift',
        'exam_set',
        'official_website',
        'download_link',  // This is a database column
        'answer_key_url',
        'objection_link',
        'answer_key_pdf',
        'answer_key_file',  // Legacy field for backward compatibility
        'instructions',
        'subjects',
        'total_questions',
        'total_marks',
        'correct_marks',
        'negative_marks',
        'question_paper_code',
        'is_active',
        'download_count',
        'views',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'answer_key_date' => 'date',
        'release_date' => 'date',
        'exam_date' => 'date',
        'is_active' => 'boolean',
        'download_count' => 'integer',
        'views' => 'integer',
        'total_questions' => 'integer',
        'total_marks' => 'integer',
        'correct_marks' => 'float',
        'negative_marks' => 'float',
        'subjects' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the job that owns the answer key
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

        static::creating(function ($answerKey) {
            if (empty($answerKey->slug)) {
                $answerKey->slug = static::generateUniqueSlug($answerKey->title);
            }
        });

        static::updating(function ($answerKey) {
            if ($answerKey->isDirty('title') && empty($answerKey->slug)) {
                $answerKey->slug = static::generateUniqueSlug($answerKey->title);
            }
        });
    }

    /**
     * Generate unique slug for answer key
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
     * Get answer key PDF URL
     */
    public function getAnswerKeyPdfUrlAttribute()
    {
        return $this->getFileUrl($this->download_path);
    }

    /**
     * Get file URL (alias for backward compatibility)
     */
    public function getFileUrlAttribute()
    {
        return $this->getAnswerKeyPdfUrlAttribute();
    }

    /**
     * Get the download path for this answer key.
     */
    public function getDownloadPathAttribute()
    {
        return $this->normalizeStoragePath($this->answer_key_pdf ?? $this->answer_key_file);
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
     * Normalize storage file paths to remove any leading public/storage prefixes.
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
     * Get formatted answer key date
     */
    public function getFormattedAnswerKeyDateAttribute()
    {
        return $this->formatDate($this->answer_key_date);
    }

    /**
     * Get formatted release date
     */
    public function getFormattedReleaseDateAttribute()
    {
        return $this->formatDate($this->release_date ?? $this->answer_key_date);
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
     * Get status text
     */
    public function getStatusTextAttribute()
    {
        if (!$this->is_active) {
            return 'Inactive';
        }
        
        $releaseDate = $this->release_date ?? $this->answer_key_date;
        
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
        
        $releaseDate = $this->release_date ?? $this->answer_key_date;
        
        if ($releaseDate && Carbon::parse($releaseDate)->gt(Carbon::today())) {
            return 'warning';
        }
        
        return 'success';
    }

    /**
     * Check if answer key is available for download
     */
    public function getIsAvailableAttribute()
    {
        if (!$this->is_active) {
            return false;
        }
        
        $releaseDate = $this->release_date ?? $this->answer_key_date;
        
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
            return 'Download Answer Key PDF';
        }
        
        if ($this->hasLink()) {
            return 'Download Answer Key Online';
        }
        
        return 'Coming Soon';
    }

    /**
     * Get subjects as list
     */
    public function getSubjectsListAttribute()
    {
        if (!$this->subjects) {
            return 'Not specified';
        }
        
        if (is_array($this->subjects)) {
            return implode(', ', $this->subjects);
        }
        
        if (is_string($this->subjects)) {
            $decoded = json_decode($this->subjects, true);
            if (is_array($decoded)) {
                return implode(', ', $decoded);
            }
            return $this->subjects;
        }
        
        return 'Not specified';
    }

    /**
     * Get subjects array
     */
    public function getSubjectsArrayAttribute()
    {
        if (!$this->subjects) {
            return [];
        }
        
        if (is_array($this->subjects)) {
            return $this->subjects;
        }
        
        if (is_string($this->subjects)) {
            $decoded = json_decode($this->subjects, true);
            if (is_array($decoded)) {
                return $decoded;
            }
            return explode(',', $this->subjects);
        }
        
        return [];
    }

    /**
     * Get formatted exam info
     */
    public function getFormattedExamInfoAttribute()
    {
        $info = [];
        
        if ($this->exam_name) {
            $info[] = $this->exam_name;
        }
        
        if ($this->exam_date) {
            $info[] = 'Exam: ' . $this->formatted_exam_date;
        }
        
        if ($this->exam_shift) {
            $info[] = 'Shift: ' . $this->exam_shift;
        }
        
        if ($this->exam_set) {
            $info[] = 'Set: ' . $this->exam_set;
        }
        
        if ($this->question_paper_code) {
            $info[] = 'Paper Code: ' . $this->question_paper_code;
        }
        
        if ($this->total_questions) {
            $info[] = $this->total_questions . ' Questions';
        }
        
        if ($this->total_marks) {
            $info[] = $this->total_marks . ' Marks';
        }

        return !empty($info) ? implode(' • ', $info) : 'No exam info available';
    }

    /**
     * Get short description (truncated)
     */
    public function getShortDescriptionAttribute($length = 150)
    {
        $description = $this->attributes['short_description'] ?? $this->description;
        
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
     * Ensure answer_key_pdf takes precedence over answer_key_file
     */
    public function setAnswerKeyFileAttribute($value)
    {
        $this->attributes['answer_key_file'] = $value;
        if (empty($this->answer_key_pdf)) {
            $this->attributes['answer_key_pdf'] = $value;
        }
    }

    /**
     * Set subjects as JSON
     */
    public function setSubjectsAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['subjects'] = json_encode($value);
        } else {
            $this->attributes['subjects'] = $value;
        }
    }

    // ========== SCOPES ==========
    
    /**
     * Scope for active answer keys
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for inactive answer keys
     */
    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    /**
     * Scope for available answer keys (release date <= today)
     */
    public function scopeAvailable($query)
    {
        $today = Carbon::today();
        
        return $query->where('is_active', true)
                     ->where(function($q) use ($today) {
                         $q->whereDate('answer_key_date', '<=', $today)
                           ->orWhereDate('release_date', '<=', $today)
                           ->orWhere(function($sub) {
                               $sub->whereNull('answer_key_date')
                                   ->whereNull('release_date');
                           });
                     });
    }

    /**
     * Scope for upcoming answer keys
     */
    public function scopeUpcoming($query)
    {
        $today = Carbon::today();
        
        return $query->where('is_active', true)
                     ->where(function($q) use ($today) {
                         $q->whereDate('answer_key_date', '>', $today)
                           ->orWhereDate('release_date', '>', $today);
                     });
    }

    /**
     * Scope for recent answer keys (within given days)
     */
    public function scopeRecent($query, $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Scope for latest answer keys
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('answer_key_date', 'desc')
                     ->orderBy('release_date', 'desc')
                     ->orderBy('created_at', 'desc');
    }

    /**
     * Scope for answer keys by job
     */
    public function scopeByJob($query, $jobId)
    {
        return $query->where('job_id', $jobId);
    }

    /**
     * Scope for answer keys by exam name
     */
    public function scopeByExam($query, $examName)
    {
        return $query->where('exam_name', 'LIKE', "%{$examName}%");
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
              ->orWhere('exam_name', 'LIKE', "%{$search}%")
              ->orWhere('exam_set', 'LIKE', "%{$search}%")
              ->orWhere('question_paper_code', 'LIKE', "%{$search}%")
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

    /**
     * Scope by subject
     */
    public function scopeBySubject($query, $subject)
    {
        return $query->where('subjects', 'LIKE', "%{$subject}%");
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
     * Increment download count
     */
    public function incrementDownloadCount()
    {
        $this->increment('download_count');
    }

    /**
     * Check if answer key has file
     */
    public function hasFile()
    {
        return !empty($this->download_path);
    }

    /**
     * Check if answer key has a local stored file that exists.
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
     * Check if answer key has link
     */
    public function hasLink()
    {
        return !empty($this->download_link); // Uses the database column directly
    }

    /**
     * Check if answer key has download link (file or link)
     */
    public function hasDownloadLink()
    {
        return $this->hasFile() || $this->hasLink();
    }

    /**
     * Get download link (prefers file, falls back to link)
     * RENAMED to avoid conflict with database column
     */
    public function getPreferredDownloadLinkAttribute()
    {
        if ($this->hasLocalFile()) {
            return $this->answer_key_pdf_url;
        }

        return $this->download_link; // Uses the database column
    }

    /**
     * Get file size in human readable format
     */
    public function getFileSizeAttribute()
    {
        $file = $this->answer_key_pdf ?? $this->answer_key_file;
        
        if (!$file) {
            return null;
        }
        
        $path = storage_path('app/public/' . ltrim($file, '/'));
        
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

    /**
     * Get answer keys grouped by job
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
     * Get popular answer keys (most downloaded)
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
     * Get answer keys by exam
     */
    public static function getByExam($examName, $limit = 10)
    {
        return self::with('job')
                    ->active()
                    ->byExam($examName)
                    ->latest()
                    ->limit($limit)
                    ->get();
    }

    /**
     * Get answer key statistics
     */
    public static function getStatistics()
    {
        return [
            'total' => self::count(),
            'active' => self::active()->count(),
            'available' => self::available()->count(),
            'upcoming' => self::upcoming()->count(),
            'most_downloaded' => self::mostDownloaded()->first(),
            'most_viewed' => self::trending()->first(),
        ];
    }
}