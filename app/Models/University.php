<?php
// app/Models/University.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class University extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'code',
        'type',
        'established_year',
        'location',
        'state',
        'website',
        'email',
        'phone',
        'description',
        'logo',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($university) {
            if (empty($university->slug)) {
                $university->slug = Str::slug($university->name);
            }
        });
    }

    public function admissions()
    {
        return $this->hasMany(Admission::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getActiveAdmissionsCountAttribute()
    {
        return $this->admissions()->active()->upcoming()->count();
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}