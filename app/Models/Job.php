<?php
// app/Models/Job.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Job extends Model
{
    use HasFactory;

    protected $table = 'jobs';

    protected $fillable = [
        // Basic Information
        'title', 
        'slug', 
        'category_id', 
        'short_description', 
        'description',
        
        // Important Dates
        'start_date', 
        'last_date', 
        'fee_last_date', 
        'correction_date', 
        'exam_date', 
        'admit_card_date', 
        'result_date',
        'age_calculation_date',
        
        // Fee Structure
        'fee_general', 
        'fee_sc_st_female', 
        'fee_other', 
        'payment_mode',
        'application_fee', // Legacy field
        
        // Age Details
        'min_age', 
        'max_age', 
        'age_relaxation',
        'age_limit', // Legacy field
        
        // Job Specifications
        'total_post', 
        'job_location', 
        'qualification', 
        'additional_qualification',
        'experience_required',
        
        // Selection & Application
        'selection_process',
        'how_to_apply',
        
        // Links
        'application_link', 
        'registration_link', 
        'login_link',
        'admit_card_link',
        'result_link',
        'answer_key_link',
        'syllabus_link',
        'official_website',
        
        // PDF Uploads
        'notification_pdf', 
        'short_notification_pdf', 
        'syllabus_pdf',
        
        // Vacancy Details (HTML content)
        'vacancy_details',
        
        // SEO Fields
        'meta_title',
        'meta_description',
        'meta_keywords',
        
        // Status
        'is_active', 
        'is_featured', 
        'views'
    ];

    protected $casts = [
        // Date casts
        'start_date' => 'date',
        'last_date' => 'date',
        'fee_last_date' => 'date',
        'correction_date' => 'date',
        'exam_date' => 'date',
        'admit_card_date' => 'date',
        'result_date' => 'date',
        'age_calculation_date' => 'date',
        
        // Boolean casts
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        
        // Integer casts
        'views' => 'integer',
        
        // Timestamps
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Boot method to handle slug generation
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($job) {
            if (empty($job->slug)) {
                $job->slug = static::generateUniqueSlug($job->title);
            }
        });

        static::updating(function ($job) {
            if ($job->isDirty('title') && empty($job->slug)) {
                $job->slug = static::generateUniqueSlug($job->title);
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

    // ========== ACCESSORS ==========
    
    /**
     * Get notification PDF URL
     */
    public function getNotificationPdfUrlAttribute()
    {
        return $this->getFileUrl($this->notification_pdf);
    }

    /**
     * Get short notification PDF URL
     */
    public function getShortNotificationPdfUrlAttribute()
    {
        return $this->getFileUrl($this->short_notification_pdf);
    }

    /**
     * Get syllabus PDF URL
     */
    public function getSyllabusPdfUrlAttribute()
    {
        return $this->getFileUrl($this->syllabus_pdf);
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
     * Get formatted application fee display
     */
    public function getFormattedFeeAttribute()
    {
        $fees = [];
        
        if ($this->fee_general) {
            $fees[] = "General/OBC/EWS: {$this->fee_general}";
        }
        
        if ($this->fee_sc_st_female) {
            $fees[] = "SC/ST/Female/PH: {$this->fee_sc_st_female}";
        }
        
        if ($this->fee_other) {
            $fees[] = "Other: {$this->fee_other}";
        }
        
        return !empty($fees) ? implode(' | ', $fees) : 'As per notification';
    }

    /**
     * Get structured fee array
     */
    public function getFeeStructureAttribute()
    {
        return [
            'general_obc_ews' => $this->fee_general ?? '₹ 100/-',
            'sc_st_female_ph' => $this->fee_sc_st_female ?? '₹ 0/- (Exempted)',
            'other' => $this->fee_other ?? null,
            'payment_mode' => $this->payment_mode ?? 'Debit Card, Credit Card, Net Banking'
        ];
    }

    /**
     * Get formatted age limit display
     */
    public function getFormattedAgeLimitAttribute()
    {
        if ($this->min_age && $this->max_age) {
            return "{$this->min_age} - {$this->max_age} Years";
        } elseif ($this->min_age) {
            return "Minimum {$this->min_age} Years";
        } elseif ($this->max_age) {
            return "Maximum {$this->max_age} Years";
        } elseif ($this->age_limit) {
            return $this->age_limit;
        }
        
        return 'As per rules';
    }

    /**
     * Get age limit array
     */
    public function getAgeDetailsAttribute()
    {
        return [
            'min_age' => $this->min_age ?? '18 Years',
            'max_age' => $this->max_age ?? '40 Years',
            'relaxation' => $this->age_relaxation ?? 'As per government rules',
            'calculation_date' => $this->age_calculation_date,
            'display' => $this->formatted_age_limit
        ];
    }

    /**
     * Check if job is expired
     */
    public function getIsExpiredAttribute()
    {
        if (!$this->last_date) {
            return false;
        }
        
        return Carbon::parse($this->last_date)->lt(Carbon::today());
    }

    /**
     * Check if job is upcoming (not started)
     */
    public function getIsUpcomingAttribute()
    {
        if (!$this->start_date) {
            return false;
        }
        
        return Carbon::parse($this->start_date)->gt(Carbon::today());
    }

    /**
     * Check if job is active for application
     */
    public function getIsActiveForApplicationAttribute()
    {
        if (!$this->is_active) {
            return false;
        }
        
        if ($this->is_expired) {
            return false;
        }
        
        if ($this->start_date && Carbon::parse($this->start_date)->gt(Carbon::today())) {
            return false;
        }
        
        return true;
    }

    /**
     * Get days remaining for application
     */
    public function getDaysRemainingAttribute()
    {
        if (!$this->last_date || $this->is_expired) {
            return null;
        }
        
        $days = Carbon::today()->diffInDays(Carbon::parse($this->last_date), false);
        return $days > 0 ? $days : 0;
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeClassAttribute()
    {
        if ($this->is_expired) {
            return 'danger';
        }
        
        if ($this->is_upcoming) {
            return 'warning';
        }
        
        if ($this->is_active_for_application) {
            return 'success';
        }
        
        return 'secondary';
    }

    /**
     * Get status text
     */
    public function getStatusTextAttribute()
    {
        if ($this->is_expired) {
            return 'Expired';
        }
        
        if ($this->is_upcoming) {
            return 'Upcoming';
        }
        
        if ($this->is_active_for_application) {
            return 'Active';
        }
        
        return 'Inactive';
    }

    /**
     * Get all important dates as array
     */
    public function getImportantDatesAttribute()
    {
        return [
            'start_date' => $this->start_date,
            'last_date' => $this->last_date,
            'fee_last_date' => $this->fee_last_date,
            'correction_date' => $this->correction_date,
            'exam_date' => $this->exam_date,
            'admit_card_date' => $this->admit_card_date,
            'result_date' => $this->result_date,
        ];
    }

    /**
     * Get all application links
     */
    public function getApplicationLinksAttribute()
    {
        return [
            'apply_online' => $this->application_link,
            'registration' => $this->registration_link,
            'login' => $this->login_link,
            'admit_card' => $this->admit_card_link,
            'result' => $this->result_link,
            'answer_key' => $this->answer_key_link,
            'syllabus' => $this->syllabus_link,
            'official_website' => $this->official_website,
        ];
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
     * Ensure total_post is stored as string (since some posts have "3003 Posts" format)
     */
    public function setTotalPostAttribute($value)
    {
        $this->attributes['total_post'] = $value;
    }

    /**
     * Ensure views is integer
     */
    public function setViewsAttribute($value)
    {
        $this->attributes['views'] = (int) $value;
    }

    // ========== SCOPES ==========
    
    /**
     * Scope for active jobs
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for featured jobs
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope for expired jobs
     */
    public function scopeExpired($query)
    {
        return $query->whereNotNull('last_date')
                     ->where('last_date', '<', Carbon::today());
    }

    /**
     * Scope for upcoming jobs
     */
    public function scopeUpcoming($query)
    {
        return $query->whereNotNull('start_date')
                     ->where('start_date', '>', Carbon::today());
    }

    /**
     * Scope for active (not expired) applications
     */
    public function scopeOpenForApplication($query)
    {
        return $query->where('is_active', true)
                     ->where(function($q) {
                         $q->whereNull('last_date')
                           ->orWhere('last_date', '>=', Carbon::today());
                     });
    }

    /**
     * Scope for jobs by category
     */
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
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
              ->orWhere('qualification', 'LIKE', "%{$search}%")
              ->orWhere('job_location', 'LIKE', "%{$search}%")
              ->orWhere('additional_qualification', 'LIKE', "%{$search}%");
        });
    }

    /**
     * Scope for latest jobs first
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Scope for oldest jobs first
     */
    public function scopeOldest($query)
    {
        return $query->orderBy('created_at', 'asc');
    }

    /**
     * Scope for trending jobs (by views)
     */
    public function scopeTrending($query)
    {
        return $query->orderBy('views', 'desc');
    }

    /**
     * Scope for jobs expiring soon (within next N days)
     */
    public function scopeExpiringSoon($query, $days = 7)
    {
        return $query->whereNotNull('last_date')
                     ->where('last_date', '>=', Carbon::today())
                     ->where('last_date', '<=', Carbon::today()->addDays($days));
    }

    /**
     * Scope for jobs by date range
     */
    public function scopeDateBetween($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    // ========== RELATIONSHIPS ==========
    
    // Add to the relationships section:


/**
 * Get the syllabi for the job
 */
public function syllabi()
{
    return $this->hasMany(Syllabus::class);
}

/**
 * Get the latest syllabus
 */
public function latestSyllabus()
{
    return $this->hasOne(Syllabus::class)->latest();
}

/**
 * Get the latest result
 */
public function latestResult()
{
    return $this->hasOne(Result::class)->latest();
}

/**
 * Get the latest admit card
 */
public function latestAdmitCard()
{
    return $this->hasOne(AdmitCard::class)->latest();
}
    
    
    /**
     * Get the category that owns the job
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the results for the job
     */
    public function results()
    {
        return $this->hasMany(Result::class)->orderBy('declaration_date', 'desc');
    }

    /**
     * Get the admit cards for the job
     */
    public function admitCards()
    {
        return $this->hasMany(AdmitCard::class)->orderBy('release_date', 'desc');;
    }

    /**
     * Get the answer keys for the job
     */
    public function answerKeys()
    {
        return $this->hasMany(AnswerKey::class);
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
     * Get related jobs (same category)
     */
    public function getRelatedJobs($limit = 5)
    {
        return self::where('category_id', $this->category_id)
                    ->where('id', '!=', $this->id)
                    ->where('is_active', true)
                    ->where('last_date', '>=', Carbon::today())
                    ->orderBy('created_at', 'desc')
                    ->limit($limit)
                    ->get();
    }

    /**
     * Get popular jobs
     */
    public static function getPopularJobs($limit = 5)
    {
        return self::where('is_active', true)
                    ->where('last_date', '>=', Carbon::today())
                    ->orderBy('views', 'desc')
                    ->limit($limit)
                    ->get();
    }

    /**
     * Format date for display
     */
    public function formatDate($date, $format = 'd M Y')
    {
        if (!$date) {
            return 'Not Specified';
        }
        
        return Carbon::parse($date)->format($format);
    }

    /**
     * Format datetime for display
     */
    public function formatDateTime($date, $format = 'd M Y h:i A')
    {
        if (!$date) {
            return 'Not Specified';
        }
        
        return Carbon::parse($date)->format($format);
    }

    /**
     * Check if fee is applicable
     */
    public function isFeeApplicable()
    {
        return $this->fee_general && $this->fee_general !== '₹ 0/-' && $this->fee_general !== '0';
    }
}