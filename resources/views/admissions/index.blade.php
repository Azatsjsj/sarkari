{{-- resources/views/admissions/index.blade.php --}}
@extends('layouts.app')

@section('title', 'University Admissions - Latest Admission Notifications - Sarkari Result 2026')
@section('meta_description', 'Get latest university admission notifications, application dates, eligibility criteria and admission procedures for various courses like B.Tech, MBA, BCA, MCA, B.Ed, and more.')

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
        color: #17a2b8;
        text-decoration: none;
    }
    
    .sarkari-breadcrumb a:hover {
        text-decoration: underline;
    }
    
    /* Header Section */
    .admission-header {
        background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
        color: #fff;
        padding: 25px 20px;
        border-radius: 8px;
        margin-bottom: 20px;
    }
    
    .admission-header h1 {
        font-size: 24px;
        margin-bottom: 10px;
    }
    
    .admission-header p {
        font-size: 14px;
        margin-bottom: 0;
        opacity: 0.9;
    }
    
    /* Stats Row */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
        margin-bottom: 20px;
    }
    
    .stat-card {
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        text-align: center;
        padding: 15px;
        transition: all 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    
    .stat-number {
        font-size: 28px;
        font-weight: bold;
        color: #17a2b8;
        margin-bottom: 5px;
    }
    
    .stat-label {
        font-size: 12px;
        color: #666;
    }
    
    /* Search Box */
    .search-box {
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
    }
    
    .search-title {
        background: #17a2b8;
        color: #fff;
        padding: 10px 15px;
        margin: -20px -20px 20px -20px;
        border-radius: 8px 8px 0 0;
        font-size: 16px;
        font-weight: bold;
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
        background: #17a2b8;
        color: #fff;
        padding: 12px 20px;
        font-size: 18px;
        font-weight: bold;
    }
    
    .section-header i {
        margin-right: 10px;
    }
    
    .section-content {
        padding: 0;
    }
    
    /* Admission Card */
    .admission-card {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        margin-bottom: 20px;
        overflow: hidden;
        transition: all 0.3s ease;
        background: #fff;
    }
    
    .admission-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    
    .admission-header-bar {
        background: #f8f9fa;
        padding: 12px 15px;
        border-bottom: 1px solid #e0e0e0;
    }
    
    .university-name {
        font-weight: bold;
        font-size: 14px;
        color: #17a2b8;
    }
    
    .admission-body {
        padding: 15px;
    }
    
    .admission-title {
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 10px;
    }
    
    .admission-title a {
        color: #333;
        text-decoration: none;
    }
    
    .admission-title a:hover {
        color: #17a2b8;
        text-decoration: underline;
    }
    
    .admission-meta {
        font-size: 12px;
        color: #666;
        margin-bottom: 10px;
    }
    
    .admission-meta i {
        margin-right: 5px;
    }
    
    .admission-meta span {
        margin-right: 15px;
    }
    
    .admission-desc {
        font-size: 13px;
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
        display: inline-block;
    }
    
    .badge-expired {
        background: #dc3545;
        color: #fff;
        font-size: 10px;
        padding: 2px 6px;
        border-radius: 4px;
        margin-left: 8px;
        display: inline-block;
    }
    
    .badge-urgent {
        background: #fd7e14;
        color: #fff;
        font-size: 10px;
        padding: 2px 6px;
        border-radius: 4px;
        margin-left: 8px;
        display: inline-block;
    }
    
    .badge-active {
        background: #28a745;
        color: #fff;
        font-size: 10px;
        padding: 2px 6px;
        border-radius: 4px;
        margin-left: 8px;
        display: inline-block;
    }
    
    /* Progress Bar */
    .progress {
        height: 5px;
        border-radius: 5px;
        margin-bottom: 10px;
        background: #e9ecef;
    }
    
    .progress-bar {
        border-radius: 5px;
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
        background: #17a2b8;
        color: #fff;
        padding: 12px 15px;
        font-size: 16px;
        font-weight: bold;
    }
    
    .sidebar-content {
        padding: 15px;
    }
    
    .university-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .university-list li {
        border-bottom: 1px solid #e0e0e0;
    }
    
    .university-list li:last-child {
        border-bottom: none;
    }
    
    .university-list a {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        text-decoration: none;
        color: #333;
        font-size: 13px;
    }
    
    .university-list a:hover {
        color: #17a2b8;
    }
    
    .university-count {
        background: #17a2b8;
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
        padding: 8px 12px;
        background: #fff;
        border: 1px solid #e0e0e0;
        color: #17a2b8;
        text-decoration: none;
        border-radius: 4px;
        font-size: 13px;
    }
    
    .pagination .page-link:hover {
        background: #17a2b8;
        color: #fff;
        border-color: #17a2b8;
    }
    
    .pagination .active .page-link {
        background: #17a2b8;
        color: #fff;
        border-color: #17a2b8;
    }
    
    /* No Results */
    .no-results {
        text-align: center;
        padding: 50px 20px;
    }
    
    .no-results i {
        font-size: 48px;
        color: #ccc;
        margin-bottom: 15px;
    }
    
  
    
    /* Mobile Responsive */
    @media (max-width: 992px) {
        .stats-row {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    
    @media (max-width: 768px) {
        .admission-header h1 {
            font-size: 18px;
        }
        
        .admission-header p {
            font-size: 12px;
        }
        
        .stat-number {
            font-size: 22px;
        }
        
        .stat-label {
            font-size: 10px;
        }
        
        .admission-title {
            font-size: 14px;
        }
        
        .admission-meta span {
            display: block;
            margin-bottom: 5px;
        }
        
        .stats-row {
            grid-template-columns: 1fr;
            gap: 10px;
        }
        
        .sarkari-footer {
            padding: 15px;
            font-size: 10px;
        }
    }
</style>
@endpush

@section('content')
<div class="sarkari-container">
    
    <!-- Breadcrumb -->
    <div class="sarkari-breadcrumb">
        <a href="{{ route('home') }}"><i class="fas fa-home"></i> Home</a> &gt;
        <span>Admissions</span>
    </div>
    
    <!-- Header -->
    <div class="admission-header">
        <h1><i class="fas fa-graduation-cap"></i> University Admissions - Sarkari Result 2026</h1>
        <p>Find latest admission notifications, application dates, and eligibility criteria for various courses from top universities.</p>
    </div>
    
    <!-- Quick Stats -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-number">{{ $totalAdmissions ?? 0 }}</div>
            <div class="stat-label">Total Admissions</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $activeAdmissions ?? 0 }}</div>
            <div class="stat-label">Active Now</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $universities->count() ?? 0 }}</div>
            <div class="stat-label">Universities</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $featuredAdmissions ?? 0 }}</div>
            <div class="stat-label">Featured</div>
        </div>
    </div>
    
    <!-- Search Box -->
    <div class="search-box">
        <div class="search-title">
            <i class="fas fa-search"></i> Search Admissions
        </div>
        <form action="{{ route('admissions') }}" method="GET">
            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <div style="flex: 2; min-width: 200px;">
                    <input type="text" name="search" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;" 
                           placeholder="Search by course, university, or keywords..."
                           value="{{ request('search') }}">
                </div>
                <div style="flex: 1; min-width: 150px;">
                    <select name="university" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                        <option value="">All Universities</option>
                        @foreach($universities as $university)
                        <option value="{{ $university->id }}" {{ request('university') == $university->id ? 'selected' : '' }}>
                            {{ $university->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <button type="submit" class="btn" style="background: #17a2b8; color: #fff; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">
                        <i class="fas fa-search"></i> Search
                    </button>
                    @if(request()->hasAny(['search', 'university']))
                    <a href="{{ route('admissions') }}" style="background: #6c757d; color: #fff; padding: 10px 15px; border-radius: 5px; text-decoration: none; display: inline-block;">
                        <i class="fas fa-times"></i> Reset
                    </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
    
    <div class="row" style="display: flex; gap: 20px; flex-wrap: wrap;">
        
        <!-- Main Content - Admissions List -->
        <div style="flex: 2.5; min-width: 280px;">
            
            @if(isset($admissions) && $admissions->count() > 0)
            
            <div style="padding: 10px 0; margin-bottom: 10px; font-size: 13px; color: #666;">
                <i class="fas fa-info-circle"></i> Showing {{ $admissions->firstItem() }} - {{ $admissions->lastItem() }} of {{ $admissions->total() }} admissions
            </div>
            
            @foreach($admissions as $admission)
            <div class="admission-card">
                <div class="admission-header-bar">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-university" style="color: #17a2b8;"></i>
                            <span class="university-name">{{ $admission->university->name ?? 'N/A' }}</span>
                        </div>
                        @php
                            $lastDate = $admission->last_date;
                            if (is_string($lastDate)) {
                                $lastDate = \Carbon\Carbon::parse($lastDate);
                            }
                            $isExpired = $lastDate->lt(now());
                            $daysLeft = $lastDate->diffInDays(now());
                        @endphp
                        @if($isExpired)
                        <span class="badge-expired"><i class="fas fa-clock"></i> Expired</span>
                        @elseif($daysLeft <= 3)
                        <span class="badge-urgent"><i class="fas fa-exclamation-triangle"></i> Urgent</span>
                        @elseif($daysLeft <= 7)
                        <span class="badge-urgent"><i class="fas fa-clock"></i> Last Week</span>
                        @else
                        <span class="badge-active"><i class="fas fa-check"></i> Active</span>
                        @endif
                    </div>
                </div>
                <div class="admission-body">
                    <div class="admission-title">
                        <a href="{{ route('admissions.show', $admission->slug) }}">
                            {{ $admission->title }}
                        </a>
                        @if($admission->is_featured)
                        <span class="badge-featured"><i class="fas fa-star"></i> Featured</span>
                        @endif
                    </div>
                    
                    <div class="admission-meta">
                        <span><i class="fas fa-graduation-cap"></i> {{ $admission->course->name ?? 'N/A' }}</span>
                        <span><i class="fas fa-calendar-check text-success"></i> Start: {{ \Carbon\Carbon::parse($admission->start_date)->format('d M Y') }}</span>
                        <span><i class="fas fa-calendar-times text-danger"></i> Last: 
                            <span class="{{ $isExpired ? 'text-danger' : 'text-success' }}">
                                {{ $lastDate->format('d M Y') }}
                            </span>
                        </span>
                    </div>
                    
                    @if(!$isExpired && $daysLeft <= 30)
                    <div class="progress">
                        @php
                            $totalDays = \Carbon\Carbon::parse($admission->start_date)->diffInDays($lastDate);
                            $daysPassed = \Carbon\Carbon::parse($admission->start_date)->diffInDays(now());
                            $progressPercent = ($daysPassed / $totalDays) * 100;
                        @endphp
                        <div class="progress-bar {{ $daysLeft <= 3 ? 'bg-danger' : ($daysLeft <= 7 ? 'bg-warning' : 'bg-success') }}" 
                             role="progressbar" 
                             style="width: {{ min(100, $progressPercent) }}%">
                        </div>
                    </div>
                    @endif
                    
                    @if($admission->short_description)
                    <div class="admission-desc">
                        {{ Str::limit($admission->short_description, 120) }}
                    </div>
                    @endif
                    
                    <div class="admission-meta">
                        @if($admission->application_fee)
                        <span><i class="fas fa-rupee-sign"></i> Fee: ₹{{ number_format($admission->application_fee, 2) }}</span>
                        @endif
                        <span><i class="fas fa-eye"></i> Views: {{ $admission->views ?? 0 }}</span>
                    </div>
                </div>
                <div style="background: #f8f9fa; padding: 12px 15px; border-top: 1px solid #e0e0e0;">
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('admissions.show', $admission->slug) }}" class="btn btn-sm" style="background: #17a2b8; color: #fff; border-radius: 5px; padding: 5px 12px; text-decoration: none;">
                            <i class="fas fa-info-circle"></i> View Details
                        </a>
                        @if($admission->apply_url && !$isExpired)
                        <a href="{{ $admission->apply_url }}" rel="noopener noreferrer" target="_blank" class="btn btn-sm" style="background: #28a745; color: #fff; border-radius: 5px; padding: 5px 12px; text-decoration: none;">
                            <i class="fas fa-paper-plane"></i> Apply Now
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
            
            <!-- Pagination -->
            @if($admissions->hasPages())
            <div style="margin-top: 20px;">
                {{ $admissions->appends(request()->query())->links() }}
            </div>
            @endif
            
            @else
            <!-- No Admissions Found -->
            <div class="section-box">
                <div class="section-header">
                    <i class="fas fa-search"></i> No Admissions Found
                </div>
                <div class="no-results">
                    <i class="fas fa-graduation-cap"></i>
                    <h4>No Admissions Found</h4>
                    <p style="color: #666;">
                        @if(request()->hasAny(['search', 'university']))
                        No admissions found for your search criteria. Try different keywords or browse all admissions.
                        @else
                        There are no admissions published yet. Please check back later for updates.
                        @endif
                    </p>
                    <div style="display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">
                        @if(request()->hasAny(['search', 'university']))
                        <a href="{{ route('admissions') }}" style="background: #17a2b8; color: #fff; padding: 10px 20px; border-radius: 5px; text-decoration: none;">
                            <i class="fas fa-sync"></i> View All Admissions
                        </a>
                        @endif
                        <a href="{{ route('jobs') }}" style="background: #28a745; color: #fff; padding: 10px 20px; border-radius: 5px; text-decoration: none;">
                            <i class="fas fa-briefcase"></i> Browse Jobs
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </div>
        
        <!-- Sidebar -->
        <div style="flex: 1; min-width: 250px;">
            
            <!-- Filter by University -->
            <div class="sidebar-box">
                <div class="sidebar-header">
                    <i class="fas fa-university"></i> Universities
                </div>
                <div class="sidebar-content" style="padding: 0;">
                    <ul class="university-list">
                        @forelse($universities as $uni)
                        <li>
                            <a href="{{ route('admissions') }}?university={{ $uni->id }}">
                                <span><i class="fas fa-university"></i> {{ Str::limit($uni->name, 30) }}</span>
                                <span class="university-count">{{ $uni->admissions_count ?? 0 }}</span>
                            </a>
                        </li>
                        @empty
                        <li style="text-align: center; padding: 15px; color: #888;">No universities found</li>
                        @endforelse
                    </ul>
                </div>
            </div>
            
            <!-- Upcoming Deadlines -->
            @php
                $upcomingDeadlines = \App\Models\Admission::where('is_active', true)
                    ->where('last_date', '>=', now())
                    ->where('last_date', '<=', now()->addDays(15))
                    ->orderBy('last_date', 'asc')
                    ->take(5)
                    ->get();
            @endphp
            @if($upcomingDeadlines->count() > 0)
            <div class="sidebar-box">
                <div class="sidebar-header" style="background: #dc3545;">
                    <i class="fas fa-clock"></i> Upcoming Deadlines
                </div>
                <div class="sidebar-content" style="padding: 0;">
                    @foreach($upcomingDeadlines as $deadline)
                    <div style="border-bottom: 1px solid #e0e0e0; padding: 10px;">
                        <div style="font-size: 12px; font-weight: 500; margin-bottom: 5px;">
                            <a href="{{ route('admissions.show', $deadline->slug) }}" style="color: #333; text-decoration: none;">
                                {{ Str::limit($deadline->title, 40) }}
                            </a>
                        </div>
                        <div style="font-size: 11px; color: #dc3545;">
                            <i class="fas fa-calendar-alt"></i> 
                            @php
                                $dlDate = $deadline->last_date;
                                if (is_string($dlDate)) {
                                    $dlDate = \Carbon\Carbon::parse($dlDate);
                                }
                            @endphp
                            Deadline: {{ $dlDate->format('d M Y') }}
                            <span class="text-muted">({{ $dlDate->diffInDays(now()) }} days left)</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
            
            <!-- Quick Links -->
            <div class="sidebar-box">
                <div class="sidebar-header" style="background: #007bff;">
                    <i class="fas fa-link"></i> Quick Links
                </div>
                <div class="sidebar-content">
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        <a href="{{ route('jobs') }}" style="display: block; padding: 8px 12px; background: #f8f9fa; color: #333; text-decoration: none; border-radius: 5px; font-size: 13px;">
                            <i class="fas fa-briefcase"></i> Latest Jobs
                        </a>
                        <a href="{{ route('results') }}" style="display: block; padding: 8px 12px; background: #f8f9fa; color: #333; text-decoration: none; border-radius: 5px; font-size: 13px;">
                            <i class="fas fa-chart-bar"></i> Check Results
                        </a>
                        <a href="{{ route('admit-cards') }}" style="display: block; padding: 8px 12px; background: #f8f9fa; color: #333; text-decoration: none; border-radius: 5px; font-size: 13px;">
                            <i class="fas fa-ticket-alt"></i> Admit Cards
                        </a>
                        <a href="{{ route('answer-keys') }}" style="display: block; padding: 8px 12px; background: #f8f9fa; color: #333; text-decoration: none; border-radius: 5px; font-size: 13px;">
                            <i class="fas fa-key"></i> Answer Keys
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Important Notice -->
            <div class="sidebar-box">
                <div class="sidebar-header" style="background: #ffc107; color: #000;">
                    <i class="fas fa-exclamation-triangle"></i> Important Notice
                </div>
                <div class="sidebar-content">
                    <ul style="margin: 0; padding-left: 20px; font-size: 12px; color: #555;">
                        <li>Verify all details before applying</li>
                        <li>Check eligibility criteria carefully</li>
                        <li>Keep documents ready for upload</li>
                        <li>Apply before the last date</li>
                        <li>Save application form for future reference</li>
                    </ul>
                </div>
            </div>
            
            <!-- Connect with Us -->
            <div class="sidebar-box">
                <div class="sidebar-header" style="background: #ab183d;">
                    <i class="fas fa-share-alt"></i> Connect with Us
                </div>
                <div class="sidebar-content" style="text-align: center;">
                    <div style="display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">
                        <a href="https://t.me/Sarkarult201" rel="noopener noreferrer" target="_blank" style="background: #0088cc; color: #fff; padding: 8px 12px; border-radius: 5px; text-decoration: none; font-size: 12px;">
                            <i class="fab fa-telegram"></i> Telegram
                        </a>
                        <a href="https://whatsapp.com/channel/002a18" rel="noopener noreferrer" target="_blank" style="background: #25d366; color: #fff; padding: 8px 12px; border-radius: 5px; text-decoration: none; font-size: 12px;">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                        <a href="https://www.facebook.com/SarkariResucial/" rel="noopener noreferrer" target="_blank" style="background: #1877f2; color: #fff; padding: 8px 12px; border-radius: 5px; text-decoration: none; font-size: 12px;">
                            <i class="fab fa-facebook"></i> Facebook
                        </a>
                        <a href="https://www.instagram.com/sarkariresuicial/"  rel="noopener noreferrer" target="_blank" style="background: #e4405f; color: #fff; padding: 8px 12px; border-radius: 5px; text-decoration: none; font-size: 12px;">
                            <i class="fab fa-instagram"></i> Instagram
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    
</div>
@endsection