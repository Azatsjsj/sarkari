{{-- resources/views/jobs/category.blade.php --}}
@extends('layouts.app')

@section('title', $categoryName . ' Jobs - Sarkari Result 2026')
@section('meta_description', 'Browse all latest government jobs in ' . $categoryName . ' category. Find vacancies, notifications, application details and more.')

@push('styles')
<style>
    /* Sarkari Result Original Style */
    body {
        background: #f5f5f5;
        font-family: Arial, Helvetica, sans-serif;
    }
    
    .sarkari-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 15px;
    }
    
    /* Breadcrumb */
    .sarkari-breadcrumb {
        background: #fff;
        padding: 10px 15px;
        border-radius: 5px;
        margin-bottom: 20px;
        border: 1px solid #e0e0e0;
        font-size: 12px;
    }
    
    .sarkari-breadcrumb a {
        color: #ab183d;
        text-decoration: none;
    }
    
    .sarkari-breadcrumb a:hover {
        text-decoration: underline;
    }
    
    /* Category Header */
    .category-header {
        background: linear-gradient(135deg, #ab183d 0%, #8b1030 100%);
        color: #fff;
        padding: 25px 20px;
        border-radius: 8px;
        margin-bottom: 20px;
    }
    
    .category-header h1 {
        font-size: 22px;
        margin-bottom: 10px;
    }
    
    .category-header p {
        font-size: 13px;
        margin-bottom: 0;
        opacity: 0.9;
    }
    
    /* Stats Row */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        margin-bottom: 20px;
    }
    
    .stat-card {
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        text-align: center;
        padding: 12px;
        transition: all 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    
    .stat-number {
        font-size: 24px;
        font-weight: bold;
        color: #ab183d;
        margin-bottom: 5px;
    }
    
    .stat-label {
        font-size: 11px;
        color: #666;
    }
    
    /* Section Box */
    .section-box {
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        margin-bottom: 20px;
        overflow: hidden;
    }
    
    .section-header {
        background: #ab183d;
        color: #fff;
        padding: 12px 20px;
        font-size: 16px;
        font-weight: bold;
    }
    
    .section-header i {
        margin-right: 10px;
    }
    
    /* Job Item */
    .job-item {
        border-bottom: 1px solid #e0e0e0;
        padding: 15px;
        transition: all 0.2s ease;
    }
    
    .job-item:last-child {
        border-bottom: none;
    }
    
    .job-item:hover {
        background: #f8f9fa;
    }
    
    .job-title {
        font-size: 15px;
        font-weight: bold;
        margin-bottom: 8px;
    }
    
    .job-title a {
        color: #333;
        text-decoration: none;
    }
    
    .job-title a:hover {
        color: #ab183d;
        text-decoration: underline;
    }
    
    .job-meta {
        font-size: 12px;
        color: #666;
        margin-bottom: 8px;
    }
    
    .job-meta i {
        margin-right: 5px;
    }
    
    .job-meta span {
        margin-right: 15px;
    }
    
    .job-desc {
        font-size: 12px;
        color: #555;
        margin-bottom: 10px;
    }
    
    /* Badges */
    .badge-featured {
        background: #ffc107;
        color: #000;
        font-size: 10px;
        padding: 2px 6px;
        border-radius: 4px;
        margin-left: 8px;
    }
    
    .badge-expired {
        background: #dc3545;
        color: #fff;
        font-size: 10px;
        padding: 2px 6px;
        border-radius: 4px;
        margin-left: 8px;
    }
    
    .badge-urgent {
        background: #fd7e14;
        color: #fff;
        font-size: 10px;
        padding: 2px 6px;
        border-radius: 4px;
        margin-left: 8px;
    }
    
    .badge-category {
        background: #6c757d;
        color: #fff;
        font-size: 10px;
        padding: 2px 6px;
        border-radius: 4px;
        margin-right: 5px;
    }
    
    /* Buttons */
    .apply-link {
        color: #28a745;
        font-weight: bold;
        text-decoration: none;
        font-size: 12px;
    }
    
    .apply-link:hover {
        text-decoration: underline;
    }
    
    .view-link {
        color: #ab183d;
        font-weight: bold;
        text-decoration: none;
        font-size: 12px;
    }
    
    /* Sidebar */
    .sidebar-box {
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        margin-bottom: 20px;
        overflow: hidden;
    }
    
    .sidebar-header {
        background: #ab183d;
        color: #fff;
        padding: 10px 15px;
        font-size: 14px;
        font-weight: bold;
    }
    
    .sidebar-content {
        padding: 15px;
    }
    
    /* Category List */
    .category-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .category-list li {
        border-bottom: 1px solid #e0e0e0;
    }
    
    .category-list li:last-child {
        border-bottom: none;
    }
    
    .category-list a {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        text-decoration: none;
        color: #333;
        font-size: 12px;
    }
    
    .category-list a:hover {
        color: #ab183d;
    }
    
    .category-list a.active {
        color: #ab183d;
        font-weight: bold;
    }
    
    .category-count {
        background: #ab183d;
        color: #fff;
        padding: 2px 6px;
        border-radius: 20px;
        font-size: 10px;
    }
    
    /* Pagination */
    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 20px;
        gap: 5px;
    }
    
    .pagination .page-item {
        list-style: none;
    }
    
    .pagination .page-link {
        display: block;
        padding: 6px 10px;
        background: #fff;
        border: 1px solid #e0e0e0;
        color: #ab183d;
        text-decoration: none;
        border-radius: 4px;
        font-size: 12px;
    }
    
    .pagination .page-link:hover {
        background: #ab183d;
        color: #fff;
        border-color: #ab183d;
    }
    
    .pagination .active .page-link {
        background: #ab183d;
        color: #fff;
        border-color: #ab183d;
    }
    
    /* No Results */
    .no-results {
        text-align: center;
        padding: 40px 20px;
    }
    
    .no-results i {
        font-size: 40px;
        color: #ccc;
        margin-bottom: 15px;
    }
    
   
    
    /* Mobile Responsive */
    @media (max-width: 992px) {
        .stats-row {
            grid-template-columns: repeat(3, 1fr);
        }
    }
    
    @media (max-width: 768px) {
        .category-header h1 {
            font-size: 18px;
        }
        
        .stat-number {
            font-size: 20px;
        }
        
        .job-title {
            font-size: 14px;
        }
        
        .job-meta span {
            display: block;
            margin-bottom: 5px;
        }
        
        .job-item .row {
            flex-direction: column;
        }
        
        .job-item .text-end {
            text-align: left !important;
            margin-top: 10px;
        }
        
        .stats-row {
            grid-template-columns: 1fr;
            gap: 10px;
        }
    }
</style>
@endpush

@section('content')
<div class="sarkari-container">
    
    <!-- Breadcrumb -->
    <div class="sarkari-breadcrumb">
        <a href="{{ route('home') }}"><i class="fas fa-home"></i> Home</a> &gt;
        <a href="{{ route('jobs') }}">Latest Jobs</a> &gt;
        <span>{{ $categoryName }}</span>
    </div>
    
    <!-- Category Header -->
    <div class="category-header">
        <h1><i class="fas fa-folder-open"></i> {{ $categoryName }} Jobs - Sarkari Result 2026</h1>
        <p>Browse all government job opportunities in {{ $categoryName }} sector. Find latest vacancies, notifications, and application details.</p>
    </div>
    
    <!-- Quick Stats -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-number">{{ $totalJobs }}</div>
            <div class="stat-label">Total Jobs</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $activeJobs }}</div>
            <div class="stat-label">Active Jobs</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $featuredJobs }}</div>
            <div class="stat-label">Featured Jobs</div>
        </div>
    </div>
    
    <div class="row" style="display: flex; gap: 20px; flex-wrap: wrap;">
        
        <!-- Main Content - Jobs List -->
        <div style="flex: 2.5; min-width: 280px;">
            
            @if($jobs->count() > 0)
            <div class="section-box">
                <div class="section-header">
                    <i class="fas fa-list"></i> {{ $categoryName }} Jobs
                </div>
                <div class="section-content" style="padding: 0;">
                    
                    <div style="padding: 8px 15px; background: #f8f9fa; border-bottom: 1px solid #e0e0e0; font-size: 12px;">
                        <i class="fas fa-info-circle"></i> Showing {{ $jobs->firstItem() }} - {{ $jobs->lastItem() }} of {{ $jobs->total() }} jobs
                    </div>
                    
                    @foreach($jobs as $job)
                    <div class="job-item">
                        <div class="row" style="display: flex; flex-wrap: wrap;">
                            <div style="flex: 2; min-width: 200px;">
                                <div class="job-title">
                                    <a href="{{ route('job.show', $job->slug) }}">
                                        {{ $job->title }}
                                    </a>
                                    @if($job->is_featured)
                                    <span class="badge-featured"><i class="fas fa-star"></i> Featured</span>
                                    @endif
                                    @php
                                        $lastDate = $job->last_date;
                                        if (is_string($lastDate)) {
                                            $lastDate = \Carbon\Carbon::parse($lastDate);
                                        }
                                        $isExpired = $lastDate->lt(now());
                                        $daysLeft = $lastDate->diffInDays(now());
                                    @endphp
                                    @if($isExpired)
                                    <span class="badge-expired">Expired</span>
                                    @elseif($daysLeft <= 3)
                                    <span class="badge-urgent">Urgent</span>
                                    @endif
                                </div>
                                <div class="job-meta">
                                    <span><i class="fas fa-building"></i> {{ $job->category->name ?? 'N/A' }}</span>
                                    @if($job->total_post)
                                    <span><i class="fas fa-users"></i> {{ $job->total_post }} Posts</span>
                                    @endif
                                    @php
                                        $startDate = $job->start_date;
                                        if (is_string($startDate)) {
                                            $startDate = \Carbon\Carbon::parse($startDate);
                                        }
                                    @endphp
                                    <span><i class="fas fa-calendar-check text-success"></i> Start: {{ $startDate->format('d M Y') }}</span>
                                    <span><i class="fas fa-calendar-times text-danger"></i> Last: 
                                        <span class="{{ $isExpired ? 'text-danger' : 'text-success' }}">
                                            {{ $lastDate->format('d M Y') }}
                                        </span>
                                        @if(!$isExpired)
                                        <span class="text-muted">({{ $daysLeft }} days left)</span>
                                        @endif
                                    </span>
                                </div>
                                @if($job->short_description)
                                <div class="job-desc">
                                    {{ Str::limit($job->short_description, 120) }}
                                </div>
                                @endif
                                @if($job->qualification)
                                <div class="job-meta">
                                    <span><i class="fas fa-graduation-cap"></i> Qualification: {{ Str::limit($job->qualification, 60) }}</span>
                                </div>
                                @endif
                                @if($job->job_location)
                                <div class="job-meta">
                                    <span><i class="fas fa-map-marker-alt"></i> Location: {{ $job->job_location }}</span>
                                </div>
                                @endif
                            </div>
                            <div style="flex: 1; min-width: 160px; text-align: right;">
                                @if($job->application_fee)
                                <div style="margin-bottom: 8px;">
                                    <span class="badge-category">Fee: ₹{{ $job->application_fee }}</span>
                                </div>
                                @endif
                                <div style="margin-bottom: 5px;">
                                    <a href="{{ route('job.show', $job->slug) }}" class="view-link">
                                        <i class="fas fa-info-circle"></i> View Details
                                    </a>
                                </div>
                                @if($job->application_link && !$isExpired)
                                <div>
                                    <a href="{{ $job->application_link }}" target="_blank" rel="nofollow, noopener, noreferrer" class="apply-link">
                                        <i class="fas fa-paper-plane"></i> Apply Now
                                    </a>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                    
                    <!-- Pagination -->
                    @if($jobs->hasPages())
                    <div style="padding: 15px; border-top: 1px solid #e0e0e0;">
                        {{ $jobs->appends(request()->query())->links() }}
                    </div>
                    @endif
                </div>
            </div>
            
            @else
            <!-- No Jobs Found -->
            <div class="section-box">
                <div class="section-header">
                    <i class="fas fa-search"></i> No Jobs Found
                </div>
                <div class="no-results">
                    <i class="fas fa-inbox"></i>
                    <h4>No Jobs Found</h4>
                    <p style="color: #666;">
                        There are no active jobs in <strong>{{ $categoryName }}</strong> category at the moment.
                    </p>
                    <div style="display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">
                        <a href="{{ route('jobs') }}" style="background: #ab183d; color: #fff; padding: 8px 15px; border-radius: 5px; text-decoration: none; font-size: 13px;">
                            <i class="fas fa-briefcase"></i> Browse All Jobs
                        </a>
                        <a href="{{ route('home') }}" style="background: #17a2b8; color: #fff; padding: 8px 15px; border-radius: 5px; text-decoration: none; font-size: 13px;">
                            <i class="fas fa-home"></i> Go Home
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </div>
        
        <!-- Sidebar -->
        <div style="flex: 1; min-width: 250px;">
            
            <!-- Category Info -->
            <div class="sidebar-box">
                <div class="sidebar-header">
                    <i class="fas fa-info-circle"></i> Category Info
                </div>
                <div class="sidebar-content">
                    <div class="text-center mb-3">
                        <i class="fas fa-folder fa-3x" style="color: #ab183d;"></i>
                        <h5 style="margin-top: 10px; font-size: 14px;">{{ $categoryName }}</h5>
                    </div>
                    <div class="row text-center mt-3">
                        <div class="col-6">
                            <div style="font-size: 20px; font-weight: bold; color: #ab183d;">{{ $totalJobs }}</div>
                            <div style="font-size: 11px; color: #666;">Total Jobs</div>
                        </div>
                        <div class="col-6">
                            <div style="font-size: 20px; font-weight: bold; color: #28a745;">{{ $activeJobs }}</div>
                            <div style="font-size: 11px; color: #666;">Active Jobs</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- All Categories -->
            <div class="sidebar-box">
                <div class="sidebar-header" style="background: #28a745;">
                    <i class="fas fa-list"></i> All Categories
                </div>
                <div class="sidebar-content" style="padding: 0;">
                    <ul class="category-list">
                        @forelse($categories as $cat)
                        <li>
                            <a href="{{ route('category', $cat->slug) }}" class="{{ $cat->name == $categoryName ? 'active' : '' }}">
                                <span><i class="fas fa-folder"></i> {{ $cat->name }}</span>
                                <span class="category-count">{{ $cat->jobs_count }}</span>
                            </a>
                        </li>
                        @empty
                        <li style="text-align: center; padding: 15px; color: #888;">No categories found</li>
                        @endforelse
                    </ul>
                </div>
            </div>
            
            <!-- Quick Links -->
            <div class="sidebar-box">
                <div class="sidebar-header" style="background: #007bff;">
                    <i class="fas fa-link"></i> Quick Links
                </div>
                <div class="sidebar-content">
                    <div style="display: flex; flex-direction: column; gap: 8px;">
                        <a href="{{ route('jobs') }}" style="display: block; padding: 6px 0; color: #333; text-decoration: none; font-size: 12px;">
                            <i class="fas fa-briefcase"></i> All Jobs
                        </a>
                        <a href="{{ route('results') }}" style="display: block; padding: 6px 0; color: #333; text-decoration: none; font-size: 12px;">
                            <i class="fas fa-chart-bar"></i> Latest Results
                        </a>
                        <a href="{{ route('admit-cards') }}" style="display: block; padding: 6px 0; color: #333; text-decoration: none; font-size: 12px;">
                            <i class="fas fa-ticket-alt"></i> Admit Cards
                        </a>
                        <a href="{{ route('answer-keys') }}" style="display: block; padding: 6px 0; color: #333; text-decoration: none; font-size: 12px;">
                            <i class="fas fa-key"></i> Answer Keys
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Connect with Us -->
            <div class="sidebar-box">
                <div class="sidebar-header" style="background: #ab183d;">
                    <i class="fas fa-share-alt"></i> Connect with Us
                </div>
                <div class="sidebar-content" style="text-align: center;">
                    <div style="display: flex; gap: 8px; justify-content: center; flex-wrap: wrap;">
                        <a href="https://t.me/Sarkari123" target="_blank" rel="nofollow, noopener, noreferrer" style="background: #0088cc; color: #fff; padding: 6px 10px; border-radius: 5px; text-decoration: none; font-size: 11px;">
                            <i class="fab fa-telegram"></i> Telegram
                        </a>
                        <a href="https://whatsapp.com/channel/002" target="_blank" rel="nofollow, noopener, noreferrer" style="background: #25d366; color: #fff; padding: 6px 10px; border-radius: 5px; text-decoration: none; font-size: 11px;">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                        <a href="https://www.facebook.com/SarkariRe/" target="_blank" rel="nofollow, noopener, noreferrer" style="background: #1877f2; color: #fff; padding: 6px 10px; border-radius: 5px; text-decoration: none; font-size: 11px;">
                            <i class="fab fa-facebook"></i> Facebook
                        </a>
                        <a href="https://www.instagram.com/sarkariresul/" target="_blank" rel="nofollow, noopener, noreferrer" style="background: #e4405f; color: #fff; padding: 6px 10px; border-radius: 5px; text-decoration: none; font-size: 11px;">
                            <i class="fab fa-instagram"></i> Instagram
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    
</div>
@endsection