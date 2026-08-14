<?php
// app/Models/Document.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Document extends Model
{
    use HasFactory;
    use SoftDeletes; // Added SoftDeletes for better data management

    protected $table = 'documents'; // Explicitly define table name

    protected $fillable = [
        'title', 
        'slug', 
        'document_number', 
        'short_description', 
        'description',
        'type', 
        'category', 
        'file_path', 
        'file_name', 
        'file_size', 
        'file_type',
        'issue_date', 
        'valid_upto', 
        'is_featured', 
        'is_active',
        'download_count', 
        'views', 
        'department', 
        'issued_by', 
        'language', 
        'sort_order'
    ];

    protected $casts = [
        'issue_date' => 'date',
        'valid_upto' => 'date',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'download_count' => 'integer',
        'views' => 'integer',
        'sort_order' => 'integer',
        'file_size' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $dates = [
        'issue_date',
        'valid_upto',
        'deleted_at'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($document) {
            if (empty($document->slug)) {
                $document->slug = Str::slug($document->title) . '-' . uniqid();
            }
        });

        // Auto-increment views when accessed
        static::retrieved(function ($document) {
            // You can add logic here if needed
        });
    }

    // Scopes
    public function scopeNotices($query)
    {
        return $query->where('type', 'notice');
    }

    public function scopeCertificates($query)
    {
        return $query->where('type', 'certificate');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeRecent($query, $limit = 10)
    {
        return $query->orderBy('created_at', 'desc')->limit($limit);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    // Helper methods
    public function getFormattedFileSize()
    {
        if (!$this->file_size || $this->file_size <= 0) {
            return 'N/A';
        }
        
        $bytes = (int) $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $i = 0;
        
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    // Fixed getFileIcon method with null safety
    public function getFileIcon()
    {
        $fileName = $this->file_name ?? $this->file_path ?? '';
        
        if (empty($fileName)) {
            return 'fa-file-alt';
        }
        
        $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        
        // Return appropriate icon based on file extension
        switch($extension) {
            case 'pdf':
                return 'fa-file-pdf';
            case 'jpg':
            case 'jpeg':
            case 'png':
            case 'gif':
            case 'webp':
            case 'bmp':
                return 'fa-file-image';
            case 'doc':
            case 'docx':
                return 'fa-file-word';
            case 'xls':
            case 'xlsx':
            case 'csv':
                return 'fa-file-excel';
            case 'ppt':
            case 'pptx':
                return 'fa-file-powerpoint';
            case 'zip':
            case 'rar':
            case '7z':
            case 'tar':
            case 'gz':
                return 'fa-file-archive';
            case 'txt':
            case 'rtf':
                return 'fa-file-alt';
            case 'mp3':
            case 'wav':
            case 'ogg':
                return 'fa-file-audio';
            case 'mp4':
            case 'avi':
            case 'mov':
            case 'wmv':
                return 'fa-file-video';
            default:
                return 'fa-file-alt';
        }
    }

    // Fixed getFileColor method with null safety
    public function getFileColor()
    {
        $fileName = $this->file_name ?? $this->file_path ?? '';
        
        if (empty($fileName)) {
            return 'secondary';
        }
        
        $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        
        switch($extension) {
            case 'pdf':
                return 'danger';
            case 'jpg':
            case 'jpeg':
            case 'png':
            case 'gif':
            case 'webp':
                return 'info';
            case 'doc':
            case 'docx':
                return 'primary';
            case 'xls':
            case 'xlsx':
                return 'success';
            case 'ppt':
            case 'pptx':
                return 'warning';
            case 'zip':
            case 'rar':
                return 'dark';
            default:
                return 'secondary';
        }
    }

    // Get document type badge class
    public function getTypeBadgeClass()
    {
        switch($this->type) {
            case 'notice':
                return 'warning';
            case 'certificate':
                return 'success';
            case 'syllabus':
                return 'info';
            case 'result':
                return 'danger';
            default:
                return 'secondary';
        }
    }

    // Get document type icon
    public function getTypeIcon()
    {
        switch($this->type) {
            case 'notice':
                return 'fa-bullhorn';
            case 'certificate':
                return 'fa-certificate';
            case 'syllabus':
                return 'fa-book';
            case 'result':
                return 'fa-chart-line';
            default:
                return 'fa-file-alt';
        }
    }

    // Check if document is expired
    public function isExpired()
    {
        if ($this->valid_upto) {
            return $this->valid_upto->isPast();
        }
        return false;
    }

    // Check if document is newly added (within 7 days)
    public function isNew()
    {
        return $this->created_at && $this->created_at->diffInDays(now()) <= 7;
    }

    // Increment download count
    public function incrementDownloadCount()
    {
        $this->increment('download_count');
    }

    // Increment views
    public function incrementViews()
    {
        $this->increment('views');
    }

    // Get full file URL
    public function getFileUrl()
    {
        if ($this->file_path) {
            if (filter_var($this->file_path, FILTER_VALIDATE_URL)) {
                return $this->file_path;
            }
            return asset('storage/' . $this->file_path);
        }
        return null;
    }

    // Get file name for download
    public function getFileNameForDownload()
    {
        if ($this->file_name) {
            return $this->file_name;
        }
        
        if ($this->title) {
            return Str::slug($this->title) . '.' . pathinfo($this->file_path ?? '', PATHINFO_EXTENSION);
        }
        
        return 'document-' . $this->id;
    }

    // Relationships (if any)
    public function relatedJobs()
    {
        return $this->belongsToMany(Job::class, 'document_job');
    }

    // Accessor for formatted issue date
    public function getFormattedIssueDateAttribute()
    {
        if ($this->issue_date) {
            return $this->issue_date->format('d M, Y');
        }
        return 'N/A';
    }

    // Accessor for formatted valid upto
    public function getFormattedValidUptoAttribute()
    {
        if ($this->valid_upto) {
            return $this->valid_upto->format('d M, Y');
        }
        return 'N/A';
    }

    // Query helper for getting documents by date range
    public function scopeDateBetween($query, $startDate, $endDate)
    {
        return $query->whereBetween('issue_date', [$startDate, $endDate]);
    }

    // Get documents that are expiring soon (within 30 days)
    public function scopeExpiringSoon($query)
    {
        return $query->where('valid_upto', '>=', now())
                     ->where('valid_upto', '<=', now()->addDays(30));
    }
}