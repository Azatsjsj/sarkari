{{-- resources/views/answer-keys/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Latest Answer Keys - Sarkari Result 2026')
@section('meta_description', 'Download latest answer keys for various government exams. Get official answer sheets, solutions, and response sheets for SSC, UPSC, Railway, Bank, Police and more.')

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
    
    /* Header Section */
    .sarkari-header {
        background: linear-gradient(135deg, #fd7e14 0%, #e66a0a 100%);
        color: #fff;
        padding: 25px 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        text-align: center;
    }
    
    .sarkari-header h1 {
        font-size: 24px;
        margin-bottom: 10px;
    }
    
    .sarkari-header p {
        font-size: 14px;
        margin-bottom: 0;
        opacity: 0.9;
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
        color: #fd7e14;
        text-decoration: none;
    }
    
    .sarkari-breadcrumb a:hover {
        text-decoration: underline;
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
        background: #fd7e14;
        color: #fff;
        padding: 10px 15px;
        margin: -20px -20px 20px -20px;
        border-radius: 8px 8px 0 0;
        font-size: 16px;
        font-weight: bold;
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
        color: #fd7e14;
        margin-bottom: 5px;
    }
    
    .stat-label {
        font-size: 12px;
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
        background: #fd7e14;
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
    
    /* Answer Key Item */
    .answer-key-item {
        border-bottom: 1px solid #e0e0e0;
        padding: 15px;
        transition: all 0.2s ease;
    }
    
    .answer-key-item:last-child {
        border-bottom: none;
    }
    
    .answer-key-item:hover {
        background: #f8f9fa;
    }
    
    .answer-key-title {
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 8px;
    }
    
    .answer-key-title a {
        color: #333;
        text-decoration: none;
    }
    
    .answer-key-title a:hover {
        color: #fd7e14;
        text-decoration: underline;
    }
    
    .answer-key-meta {
        font-size: 12px;
        color: #666;
        margin-bottom: 8px;
    }
    
    .answer-key-meta i {
        margin-right: 5px;
    }
    
    .answer-key-meta span {
        margin-right: 15px;
    }
    
    .answer-key-desc {
        font-size: 13px;
        color: #555;
        margin-bottom: 10px;
    }
    
    /* Badges */
    .badge-upcoming {
        background: #ffc107;
        color: #000;
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
    
    .badge-new {
        background: #28a745;
        color: #fff;
        font-size: 10px;
        padding: 2px 6px;
        border-radius: 4px;
        margin-left: 8px;
    }
    
    /* Download Button */
    .download-link {
        color: #28a745;
        font-weight: bold;
        text-decoration: none;
        font-size: 13px;
    }
    
    .download-link:hover {
        text-decoration: underline;
    }
    
    .view-link {
        color: #fd7e14;
        font-weight: bold;
        text-decoration: none;
        font-size: 13px;
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
        background: #fd7e14;
        color: #fff;
        padding: 12px 15px;
        font-size: 16px;
        font-weight: bold;
    }
    
    .sidebar-content {
        padding: 15px;
    }
    
    .recent-item {
        border-bottom: 1px solid #e0e0e0;
        padding: 10px 0;
    }
    
    .recent-item:last-child {
        border-bottom: none;
    }
    
    .recent-title {
        font-size: 13px;
        font-weight: 500;
        margin-bottom: 5px;
    }
    
    .recent-title a {
        color: #333;
        text-decoration: none;
    }
    
    .recent-title a:hover {
        color: #fd7e14;
    }
    
    .recent-date {
        font-size: 11px;
        color: #888;
    }
    
    /* Notice Box */
    .notice-box {
        background: #fff3cd;
        border-left: 4px solid #ffc107;
        padding: 15px;
        margin-top: 15px;
        font-size: 12px;
    }
    
    .notice-box ul {
        margin: 10px 0 0 20px;
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
        color: #fd7e14;
        text-decoration: none;
        border-radius: 4px;
        font-size: 13px;
    }
    
    .pagination .page-link:hover {
        background: #fd7e14;
        color: #fff;
        border-color: #fd7e14;
    }
    
    .pagination .active .page-link {
        background: #fd7e14;
        color: #fff;
        border-color: #fd7e14;
    }
    
    /* Info Text */
    .info-text {
        background: #d4edda;
        border-left: 4px solid #28a745;
        padding: 10px 15px;
        font-size: 13px;
        margin-bottom: 20px;
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
            grid-template-columns: repeat(3, 1fr);
        }
    }
    
    @media (max-width: 768px) {
        .sarkari-header h1 {
            font-size: 18px;
        }
        
        .sarkari-header p {
            font-size: 12px;
        }
        
        .stat-number {
            font-size: 22px;
        }
        
        .stat-label {
            font-size: 10px;
        }
        
        .answer-key-title {
            font-size: 14px;
        }
        
        .answer-key-meta span {
            display: block;
            margin-bottom: 5px;
        }
        
        .answer-key-item .row {
            flex-direction: column;
        }
        
        .answer-key-item .text-end {
            text-align: left !important;
            margin-top: 10px;
        }
        
        .section-header {
            font-size: 16px;
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
        <span>Answer Keys</span>
    </div>
    
    <!-- Header -->
    <div class="sarkari-header">
        <h1><i class="fas fa-key"></i> Latest Answer Keys - Sarkari Result 2026</h1>
        <p>Download official answer keys for government exams. Get question paper solutions, response sheets, and objection submission details.</p>
    </div>
    
    <!-- Search Box -->
    <div class="search-box">
        <div class="search-title">
            <i class="fas fa-search"></i> Search Answer Keys
        </div>
        <form action="{{ route('answer-keys') }}" method="GET">
            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <div style="flex: 3; min-width: 200px;">
                    <input type="text" name="search" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;" 
                           placeholder="Search answer keys by exam name, job title, or keywords..."
                           value="{{ request('search') }}">
                </div>
                <div style="flex: 1; min-width: 150px;">
                    <select name="filter" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                        <option value="">All Answer Keys</option>
                        <option value="latest" {{ request('filter') == 'latest' ? 'selected' : '' }}>Latest First</option>
                        <option value="upcoming" {{ request('filter') == 'upcoming' ? 'selected' : '' }}>Upcoming Answer Keys</option>
                    </select>
                </div>
                <div>
                    <button type="submit" class="btn" style="background: #fd7e14; color: #fff; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">
                        <i class="fas fa-search"></i> Search
                    </button>
                    @if(request()->hasAny(['search', 'filter']))
                    <a href="{{ route('answer-keys') }}" style="background: #6c757d; color: #fff; padding: 10px 15px; border-radius: 5px; text-decoration: none; display: inline-block;">
                        <i class="fas fa-times"></i> Reset
                    </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
    
    <!-- Quick Stats -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-number">{{ $answerKeys->total() ?? 0 }}</div>
            <div class="stat-label">Total Answer Keys</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $recentCount ?? 0 }}</div>
            <div class="stat-label">Recent Keys</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $upcomingCount ?? 0 }}</div>
            <div class="stat-label">Upcoming Keys</div>
        </div>
    </div>
    
    <div class="row" style="display: flex; gap: 20px; flex-wrap: wrap;">
        
        <!-- Main Content - Answer Keys List -->
        <div style="flex: 2.5; min-width: 280px;">
            
            @if(isset($answerKeys) && $answerKeys->count() > 0)
            <div class="section-box">
                <div class="section-header">
                    <i class="fas fa-list"></i> All Answer Keys
                    @if(request()->has('search'))
                    <span style="font-size: 12px; background: rgba(255,255,255,0.2); padding: 2px 8px; border-radius: 20px; margin-left: 10px;">
                        Search: "{{ request('search') }}"
                    </span>
                    @endif
                </div>
                <div class="section-content">
                    
                    <div style="padding: 10px 15px; background: #f8f9fa; border-bottom: 1px solid #e0e0e0; font-size: 13px;">
                        <i class="fas fa-info-circle"></i> Showing {{ $answerKeys->firstItem() }} - {{ $answerKeys->lastItem() }} of {{ $answerKeys->total() }} answer keys
                    </div>
                    
                    @foreach($answerKeys as $answerKey)
                    <div class="answer-key-item">
                        <div class="row" style="display: flex; flex-wrap: wrap;">
                            <div style="flex: 2; min-width: 200px;">
                                <div class="answer-key-title">
                                    <a href="{{ route('answer-key.show', $answerKey->slug) }}">
                                        <i class="fas fa-key" style="color: #fd7e14;"></i>
                                        {{ $answerKey->title }}
                                    </a>
                                    @php
                                        $answerKeyDate = safe_carbon($answerKey->answer_key_date);
                                        $isUpcoming = is_future_date($answerKeyDate);
                                        $isRecent = $answerKeyDate && $answerKeyDate->diffInDays(now()) <= 7 && !$isUpcoming;
                                    @endphp
                                    @if($isUpcoming)
                                    <span class="badge-upcoming"><i class="fas fa-clock"></i> Upcoming</span>
                                    @endif
                                    @if($isRecent)
                                    <span class="badge-new"><i class="fas fa-newspaper"></i> New</span>
                                    @endif
                                </div>
                                <div class="answer-key-meta">
                                    @if($answerKey->job && $answerKey->job->category)
                                    <span><i class="fas fa-building"></i> {{ $answerKey->job->category->name }}</span>
                                    @endif
                                    @if($answerKey->job)
                                    <span><i class="fas fa-briefcase"></i> {{ Str::limit($answerKey->job->title, 40) }}</span>
                                    @endif
                                    <span><i class="fas fa-calendar-alt"></i> Date: {{ $answerKeyDate->format('d M Y') }}</span>
                                </div>
                                @if($answerKey->exam_name)
                                <div class="answer-key-meta">
                                    <span><i class="fas fa-graduation-cap"></i> Exam: {{ $answerKey->exam_name }}</span>
                                </div>
                                @endif
                                @if($answerKey->short_description)
                                <div class="answer-key-desc">
                                    {{ Str::limit($answerKey->short_description, 100) }}
                                </div>
                                @endif
                                <div class="answer-key-meta">
                                    <span><i class="fas fa-eye"></i> Views: {{ $answerKey->views ?? 0 }}</span>
                                    <span><i class="fas fa-download"></i> Downloads: {{ $answerKey->download_count ?? 0 }}</span>
                                    @if($answerKey->total_questions)
                                    <span><i class="fas fa-question-circle"></i> Questions: {{ $answerKey->total_questions }}</span>
                                    @endif
                                </div>
                            </div>
                            <div style="flex: 1; min-width: 180px; text-align: right;">
                                <div style="margin-bottom: 8px;">
                                    @if(isset($answerKey->file_path) && $answerKey->file_path)
                                    <a href="{{ route('answer-keys.download', $answerKey->slug ?? $answerKey->id) }}" 
                                       class="download-link" 
                                       style="display: inline-block; margin-bottom: 8px;"
                                       onclick="trackDownload({{ $answerKey->id }})">
                                        <i class="fas fa-download"></i> Download Answer Key
                                    </a>
                                    @elseif(isset($answerKey->download_link) && $answerKey->download_link)
                                    <a href="{{ $answerKey->download_link }}" target="_blank" class="download-link">
                                        <i class="fas fa-external-link-alt"></i> Download Answer Key
                                    </a>
                                    @endif
                                </div>
                                <div>
                                    <a href="{{ route('answer-key.show', $answerKey->slug) }}" class="view-link">
                                        <i class="fas fa-eye"></i> View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    
                    <!-- Pagination -->
                    @if($answerKeys->hasPages())
                    <div style="padding: 15px; border-top: 1px solid #e0e0e0;">
                        {{ $answerKeys->appends(request()->query())->links() }}
                    </div>
                    @endif
                </div>
            </div>
            
            @else
            <!-- No Answer Keys Found -->
            <div class="section-box">
                <div class="section-header">
                    <i class="fas fa-search"></i> No Answer Keys Found
                </div>
                <div class="no-results">
                    <i class="fas fa-key"></i>
                    <h4>No Answer Keys Found</h4>
                    <p style="color: #666;">
                        @if(request()->has('search'))
                        No answer keys found for "{{ request('search') }}". Try different keywords or browse all answer keys.
                        @else
                        There are no answer keys published yet. Please check back later for updates.
                        @endif
                    </p>
                    <div style="display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">
                        @if(request()->has('search'))
                        <a href="{{ route('answer-keys') }}" style="background: #fd7e14; color: #fff; padding: 10px 20px; border-radius: 5px; text-decoration: none;">
                            <i class="fas fa-sync"></i> View All Answer Keys
                        </a>
                        @endif
                        <a href="{{ route('jobs') }}" style="background: #17a2b8; color: #fff; padding: 10px 20px; border-radius: 5px; text-decoration: none;">
                            <i class="fas fa-briefcase"></i> Browse Jobs
                        </a>
                        <a href="{{ route('results') }}" style="background: #28a745; color: #fff; padding: 10px 20px; border-radius: 5px; text-decoration: none;">
                            <i class="fas fa-chart-bar"></i> Check Results
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </div>
        
        <!-- Sidebar -->
        <div style="flex: 1; min-width: 250px;">
            
            <!-- Recent Answer Keys -->
            <div class="sidebar-box">
                <div class="sidebar-header">
                    <i class="fas fa-clock"></i> Recent Answer Keys
                </div>
                <div class="sidebar-content">
                    @forelse(($recentAnswerKeys ?? []) as $recent)
                    <div class="recent-item">
                        <div class="recent-title">
                            <a href="{{ route('answer-key.show', $recent->slug) }}">
                                {{ Str::limit($recent->title, 45) }}
                            </a>
                        </div>
                        <div class="recent-date">
                            <i class="fas fa-calendar-alt"></i> 
                            @php
                                $recentDate = $recent->answer_key_date;
                                if (is_string($recentDate)) {
                                    $recentDate = \Carbon\Carbon::parse($recentDate);
                                }
                            @endphp
                            {{ $recentDate->format('d M Y') }}
                        </div>
                    </div>
                    @empty
                    <div style="text-align: center; color: #888; padding: 20px;">
                        No recent answer keys
                    </div>
                    @endforelse
                </div>
            </div>
            
            <!-- Upcoming Answer Keys -->
            @if(isset($upcomingAnswerKeys) && $upcomingAnswerKeys->count() > 0)
            <div class="sidebar-box">
                <div class="sidebar-header" style="background: #ffc107; color: #000;">
                    <i class="fas fa-bell"></i> Upcoming Answer Keys
                </div>
                <div class="sidebar-content">
                    @foreach($upcomingAnswerKeys as $upcoming)
                    <div class="recent-item">
                        <div class="recent-title">
                            <a href="{{ route('answer-key.show', $upcoming->slug) }}">
                                {{ Str::limit($upcoming->title, 40) }}
                            </a>
                        </div>
                        <div class="recent-date">
                            <i class="fas fa-calendar text-warning"></i> 
                            @php
                                $upcomingDate = $upcoming->answer_key_date;
                                if (is_string($upcomingDate)) {
                                    $upcomingDate = \Carbon\Carbon::parse($upcomingDate);
                                }
                            @endphp
                            Expected: {{ $upcomingDate->format('d M Y') }}
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
                    </div>
                </div>
            </div>
            
            <!-- Important Notice -->
            <div class="sidebar-box">
                <div class="sidebar-header" style="background: #dc3545;">
                    <i class="fas fa-exclamation-triangle"></i> Important Notice
                </div>
                <div class="sidebar-content">
                    <ul style="margin: 0; padding-left: 20px; font-size: 12px; color: #555;">
                        <li>Download official answer keys only</li>
                        <li>Check objection submission dates</li>
                        <li>Verify answers carefully</li>
                        <li>Keep copy for future reference</li>
                        <li>Follow official instructions</li>
                    </ul>
                </div>
            </div>
            
            <!-- Social Links -->
            <div class="sidebar-box">
                <div class="sidebar-header" style="background: #ab183d;">
                    <i class="fas fa-share-alt"></i> Connect with Us
                </div>
                <div class="sidebar-content" style="text-align: center;">
                    <div style="display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">
                        <a href="https://t.me/Sarkari" target="_blank" rel="nofollow, noopener, noreferrer" style="background: #0088cc; color: #fff; padding: 8px 12px; border-radius: 5px; text-decoration: none; font-size: 12px;">
                            <i class="fab fa-telegram"></i> Telegram
                        </a>
                        <a href="https://whatsapp.com/channel/" target="_blank" rel="nofollow, noopener, noreferrer" style="background: #25d366; color: #fff; padding: 8px 12px; border-radius: 5px; text-decoration: none; font-size: 12px;">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                        <a href="https://www.facebook.com/SarkariResult./" target="_blank" rel="nofollow, noopener, noreferrer" style="background: #1877f2; color: #fff; padding: 8px 12px; border-radius: 5px; text-decoration: none; font-size: 12px;">
                            <i class="fab fa-facebook"></i> Facebook
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    
    <!-- Info Box -->
    <div class="info-text">
        <i class="fas fa-info-circle"></i> <strong>Note:</strong> Always verify answer keys from the official website. SarkariResult.Mobi provides information for reference purposes only.
    </div>
    
</div>
@endsection

@push('scripts')
<script>
function trackDownload(answerKeyId) {
    console.log('Download initiated for answer key:', answerKeyId);
    
    // Show loading state
    const btn = event.currentTarget;
    if (btn) {
        const originalHTML = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Preparing...';
        btn.style.opacity = '0.7';
        
        setTimeout(() => {
            btn.innerHTML = originalHTML;
            btn.style.opacity = '1';
        }, 2000);
    }
    
    // Send to Google Analytics if available
    if (typeof gtag !== 'undefined') {
        gtag('event', 'download', {
            'event_category': 'answer_key',
            'event_label': 'Answer Key ID: ' + answerKeyId
        });
    }
}
</script>
@endpush