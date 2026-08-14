{{-- resources/views/admit-cards/show.blade.php --}}
@extends('layouts.app')

@section('title', mb_substr($pageDisplayTitle ?? $admitCard->title, 0, 53) . ' - Sarkari Result 2026')
@section('meta_description', Str::limit($pageDisplayDescription ?? ($admitCard->short_description ?? $admitCard->title), 160))
@section('meta_keywords', $admitCard->meta_keywords ?? $admitCard->job->category->name ?? 'admit card, sarkari result, exam hall ticket')

@push('styles')
<style>
    /* Sarkari Result Original Style - Optimized with CSS variables */
    :root {
        --primary-gold: #ffc107;
        --primary-gold-dark: #e6a800;
        --success-green: #28a745;
        --success-green-dark: #1e7e34;
        --info-blue: #17a2b8;
        --dark-gray: #333;
        --light-bg: #f5f5f5;
        --border-color: #e0e0e0;
    }

    body {
        background: var(--light-bg);
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
        border: 1px solid var(--border-color);
        font-size: 12px;
    }
    
    .sarkari-breadcrumb a {
        color: var(--primary-gold-dark);
        text-decoration: none;
    }
    
    .sarkari-breadcrumb a:hover {
        text-decoration: underline;
    }
    
    /* Post Header */
    .post-header {
        background: #fff;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        margin-bottom: 20px;
        overflow: hidden;
    }
    
    .post-title {
        background: linear-gradient(135deg, var(--primary-gold) 0%, var(--primary-gold-dark) 100%);
        color: #000;
        padding: 15px 20px;
    }
    
    .post-title h1 {
        font-size: 20px;
        margin: 0;
        font-weight: bold;
    }
    
    .post-meta {
        padding: 15px 20px;
        background: #fff;
    }
    
    /* Info Table Style */
    .info-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }
    
    .info-table tr {
        border-bottom: 1px solid var(--border-color);
    }
    
    .info-table td {
        padding: 12px 8px;
        vertical-align: top;
    }
    
    .info-table td:first-child {
        width: 180px;
        font-weight: bold;
        color: var(--primary-gold-dark);
        background: #fff8e8;
    }
    
    .info-table td:last-child {
        color: var(--dark-gray);
    }
    
    /* Section Box */
    .section-box {
        background: #fff;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        margin-bottom: 20px;
        overflow: hidden;
    }
    
    .section-header {
        background: var(--primary-gold);
        color: #000;
        padding: 12px 20px;
        font-size: 18px;
        font-weight: bold;
    }
    
    .section-header i {
        margin-right: 10px;
    }
    
    .section-content {
        padding: 20px;
    }
    
    /* Two Column Grid */
    .two-col-grid {
        display: flex;
        gap: 20px;
    }
    
    .two-col-grid .col-left {
        flex: 2;
    }
    
    .two-col-grid .col-right {
        flex: 1;
    }
    
    /* Download Button */
    .download-btn {
        display: block;
        background: linear-gradient(135deg, var(--success-green) 0%, var(--success-green-dark) 100%);
        color: #fff;
        text-align: center;
        padding: 15px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 15px;
        transition: all 0.3s ease;
    }
    
    .download-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
        color: #fff;
    }
    
    .official-btn {
        display: block;
        background: var(--info-blue);
        color: #fff;
        text-align: center;
        padding: 12px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 16px;
        font-weight: bold;
        transition: all 0.3s ease;
    }
    
    .official-btn:hover {
        background: #138496;
        color: #fff;
    }
    
    /* Date List */
    .date-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .date-list li {
        padding: 10px 0;
        border-bottom: 1px dashed var(--border-color);
        display: flex;
        justify-content: space-between;
    }
    
    .date-list li:last-child {
        border-bottom: none;
    }
    
    .date-label {
        font-weight: bold;
        color: var(--primary-gold-dark);
    }
    
    .date-value {
        color: var(--dark-gray);
    }
    
    /* Note Box */
    .note-box {
        background: #fff3cd;
        border-left: 4px solid var(--primary-gold);
        padding: 15px;
        margin: 15px 0;
        font-size: 13px;
    }
    
    .note-box ul {
        margin: 10px 0 0 20px;
    }
    
    /* Related Items */
    .related-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 10px;
    }
    
    .related-item {
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 12px;
        transition: all 0.3s ease;
    }
    
    .related-item:hover {
        background: #f8f9fa;
        transform: translateX(5px);
    }
    
    .related-title {
        font-size: 13px;
        font-weight: 500;
        margin-bottom: 8px;
    }
    
    .related-title a {
        color: var(--dark-gray);
        text-decoration: none;
    }
    
    .related-title a:hover {
        color: var(--primary-gold-dark);
    }
    
    .related-date {
        font-size: 11px;
        color: #888;
    }
    
    /* Badge Styles */
    .badge-upcoming {
        background: var(--primary-gold);
        color: #000;
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 11px;
        margin-left: 10px;
        display: inline-block;
    }
    
    /* Mobile Responsive */
    @media (max-width: 992px) {
        .two-col-grid {
            flex-direction: column;
        }
        
        .info-table td:first-child {
            width: 120px;
        }
    }
    
    @media (max-width: 768px) {
        .sarkari-container {
            padding: 0 10px;
        }
        
        .post-title h1 {
            font-size: 16px;
        }
        
        .info-table td {
            display: block;
            width: 100%;
        }
        
        .info-table td:first-child {
            width: 100%;
            background: #f0f0f0;
        }
        
        .section-header {
            font-size: 16px;
        }
        
        .download-btn {
            font-size: 16px;
            padding: 12px;
        }
    }
    
    /* Share Buttons */
    .share-buttons {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 15px;
    }
    
    .share-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 15px;
        border-radius: 5px;
        text-decoration: none;
        font-size: 13px;
        transition: all 0.3s ease;
    }
    
    .share-btn.facebook {
        background: #1877f2;
        color: #fff;
    }
    
    .share-btn.twitter {
        background: #1da1f2;
        color: #fff;
    }
    
    .share-btn.whatsapp {
        background: #25d366;
        color: #fff;
    }
    
    .share-btn.telegram {
        background: #0088cc;
        color: #fff;
    }
    
    .share-btn:hover {
        transform: translateY(-2px);
        opacity: 0.9;
        color: #fff;
    }
    
    /* Instructions List */
    .instructions-list {
        margin: 0;
        padding-left: 20px;
    }
    
    .instructions-list li {
        margin-bottom: 8px;
        font-size: 13px;
    }
</style>
@endpush

@section('content')
<div class="sarkari-container">
    
    <!-- Breadcrumb -->
    <div class="sarkari-breadcrumb">
        <a href="{{ route('home') }}"><i class="fas fa-home"></i> Home</a> &gt;
        <a href="{{ route('admit-cards') }}">Admit Cards</a> &gt;
        @if($admitCard->job && $admitCard->job->category)
        <a href="{{ route('category', $admitCard->job->category->slug) }}">{{ $admitCard->job->category->name }}</a> &gt;
        @endif
        <span>{{ Str::limit($admitCard->title, 40) }}</span>
    </div>
    
    <div class="two-col-grid">
        
        <!-- Left Column - Main Content -->
        <div class="col-left">
            
            <!-- Post Header -->
            <div class="post-header">
                <div class="post-title">
                    <h1>
                        <i class="fas fa-ticket-alt"></i> 
                        {{ $admitCard->title }}
                        @php
                            $admitCardDate = safe_carbon($admitCard->admit_card_date);
                            $isUpcoming = is_future_date($admitCardDate);
                        @endphp
                        @if($isUpcoming)
                        <span class="badge-upcoming"><i class="fas fa-clock"></i> Upcoming</span>
                        @endif
                    </h1>
                </div>
                <div class="post-meta">
                    <table class="info-table">
                        <tr>
                            <td>Name of Admit Card:</td>
                            <td><strong>{{ $admitCard->title }}</strong></td>
                        </tr>
                        <tr>
                            <td>Post Date / Update:</td>
                            <td>
                                @php
                                    $updateDate = safe_carbon($admitCard->updated_at ?? $admitCard->created_at);
                                @endphp
                                @if($updateDate)
                                    {{ safe_date_format($updateDate, 'd M Y') }} | {{ safe_date_format($updateDate, 'h:i A') }}
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                        @if($admitCard->job)
                        <tr>
                            <td>Organization:</td>
                            <td>{{ $admitCard->job->category->name ?? 'N/A' }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td>Admit Card Date:</td>
                            <td>
                                <strong>
                                    {{ safe_date_format($admitCardDate, 'd M Y') }}
                                </strong>
                            </td>
                        </tr>
                        @if($admitCard->exam_date)
                        <tr>
                            <td>Exam Date:</td>
                            <td>
                                @php
                                    $examDate = safe_carbon($admitCard->exam_date);
                                @endphp
                                {{ safe_date_format($examDate, 'd M Y') }}
                            </td>
                        </tr>
                        @endif
                        <tr>
                            <td>Status:</td>
                            <td>
                                @if($admitCardDate && $admitCardDate->isPast())
                                <span style="color: #28a745;"><i class="fas fa-check-circle"></i> Available</span>
                                @elseif($admitCardDate && $admitCardDate->isFuture())
                                <span style="color: #ffc107;"><i class="fas fa-clock"></i> Coming Soon</span>
                                @else
                                <span style="color: #6c757d;"><i class="fas fa-info-circle"></i> Not Available</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <!-- Admit Card Information -->
            <div class="section-box">
                <div class="section-header">
                    <i class="fas fa-info-circle"></i> Admit Card Information
                </div>
                <div class="section-content">
                    @if($admitCard->short_description)
                    <p>{{ $admitCard->short_description }}</p>
                    @endif
                    
                    @if($admitCard->description)
                    <div style="margin-top: 15px;">
                        {!! nl2br(e($admitCard->description)) !!}
                    </div>
                    @endif
                    
                    @if($admitCard->exam_venue)
                    <div style="margin-top: 15px;">
                        <strong><i class="fas fa-map-marker-alt"></i> Exam Venue:</strong>
                        <p>{{ $admitCard->exam_venue }}</p>
                    </div>
                    @endif
                    
                    @if($admitCard->exam_time)
                    <div style="margin-top: 15px;">
                        <strong><i class="fas fa-clock"></i> Exam Time:</strong>
                        <p>{{ $admitCard->exam_time }}</p>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Important Links Section -->
            <div class="section-box">
                <div class="section-header">
                    <i class="fas fa-link"></i> Important Links
                </div>
                <div class="section-content">
                    <table class="info-table" style="width: 100%;">
                        @if(isset($admitCard->file_path) && $admitCard->file_path)
                        <tr>
                            <td style="width: 200px;">Download Admit Card:</td>
                            <td>
                                <a href="{{ route('admit-card.download', $admitCard->slug ?? $admitCard->id) }}" 
                                   style="color: #28a745; font-weight: bold;" 
                                   onclick="trackDownload('pdf')">
                                    Click Here
                                </a>
                            </td>
                        </tr>
                        @elseif(isset($admitCard->download_link) && $admitCard->download_link)
                        <tr>
                            <td style="width: 200px;">Download Admit Card:</td>
                            <td>
                                <a href="{{ $admitCard->download_link }}" target="_blank" rel="nofollow noopener" style="color: #28a745; font-weight: bold;">
                                    Click Here
                                </a>
                            </td>
                        </tr>
                        @endif
                        
                        @if($admitCard->job && $admitCard->job->notification_pdf)
                        <tr>
                            <td>Download Notification:</td>
                            <td>
                                <a href="{{ Storage::url($admitCard->job->notification_pdf) }}" target="_blank" style="color: #28a745; font-weight: bold;">
                                    Click Here
                                </a>
                            </td>
                        </tr>
                        @endif
                        
                        @if($admitCard->job && $admitCard->job->official_website)
                        <tr>
                            <td>Official Website:</td>
                            <td>
                                <a href="{{ $admitCard->job->official_website }}" target="_blank" rel="nofollow noopener" style="color: #28a745; font-weight: bold;">
                                    {{ $admitCard->job->official_website }}
                                </a>
                            </td>
                        </tr>
                        @endif
                        
                        <tr>
                            <td>Join Telegram Channel:</td>
                            <td>
                                <a href="https://t.me/SarkariResult" target="_blank" rel="nofollow noopener" style="color: #28a745; font-weight: bold;">
                                    Click Here
                                </a>
                            </td>
                        </tr>
                        
                        <tr>
                            <td>Download Android App:</td>
                            <td>
                                <a href="https://play.google.com/store/apps/details" target="_blank" rel="nofollow noopener" style="color: #28a745; font-weight: bold;">
                                    Click Here
                                </a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <!-- How to Download -->
            <div class="section-box">
                <div class="section-header">
                    <i class="fas fa-download"></i> How to Download Admit Card
                </div>
                <div class="section-content">
                    <ol style="margin-left: 20px;">
                        <li>Click on the "Download Admit Card" button given above</li>
                        <li>Enter your Registration Number / Roll Number</li>
                        <li>Enter your Date of Birth / Password</li>
                        <li>Click on Submit Button</li>
                        <li>Your admit card will appear on the screen</li>
                        <li>Download and take a printout for future reference</li>
                    </ol>
                </div>
            </div>
            
            <!-- Important Instructions -->
            <div class="note-box">
                <strong><i class="fas fa-exclamation-triangle"></i> Important Instructions:</strong>
                <ul>
                    <li>Download admit card well in advance before the exam</li>
                    <li>Verify all details carefully before downloading</li>
                    <li>Carry original ID proof to exam center</li>
                    <li>Reach exam center at least 1 hour before time</li>
                    <li>Take a printout of admit card (color print recommended)</li>
                    <li>Do not carry prohibited items to exam center</li>
                </ul>
            </div>
        </div>
        
        <!-- Right Column - Sidebar -->
        <div class="col-right">
            
            <!-- Download Button -->
            <div class="section-box">
                <div class="section-header">
                    <i class="fas fa-hand-pointer"></i> Quick Action
                </div>
                <div class="section-content">
                    @if(isset($admitCard->file_path) && $admitCard->file_path)
                    <a href="{{ route('admit-card.download', $admitCard->slug ?? $admitCard->id) }}" 
                       class="download-btn" 
                       onclick="trackDownload('pdf')">
                        <i class="fas fa-download"></i> Download Admit Card
                    </a>
                    @elseif(isset($admitCard->download_link) && $admitCard->download_link)
                    <a href="{{ $admitCard->download_link }}" target="_blank" class="download-btn">
                        <i class="fas fa-external-link-alt"></i> Download Admit Card
                    </a>
                    @else
                    <div class="alert alert-warning text-center mb-0">
                        <i class="fas fa-clock"></i> Admit Card Coming Soon
                    </div>
                    @endif
                    
                    @if($admitCard->job && $admitCard->job->notification_pdf)
                    <a href="{{ Storage::url($admitCard->job->notification_pdf) }}" target="_blank" class="official-btn" style="background: #17a2b8; margin-top: 10px;">
                        <i class="fas fa-file-pdf"></i> Download Notification
                    </a>
                    @endif
                </div>
            </div>
            
            <!-- Quick Info -->
            <div class="section-box">
                <div class="section-header">
                    <i class="fas fa-info-circle"></i> Quick Info
                </div>
                <div class="section-content">
                    <ul class="date-list">
                        <li>
                            <span class="date-label">Status:</span>
                            <span class="date-value">
                                @if($admitCardDate && $admitCardDate->isPast())
                                <span class="text-success"><i class="fas fa-check-circle"></i> Available</span>
                                @elseif($admitCardDate && $admitCardDate->isFuture())
                                <span class="text-warning"><i class="fas fa-clock"></i> Coming Soon</span>
                                @else
                                <span class="text-muted"><i class="fas fa-info-circle"></i> Not Available</span>
                                @endif
                            </span>
                        </li>
                        <li>
                            <span class="date-label">Published:</span>
                            <span class="date-value">
                                {{ safe_date_format(safe_carbon($admitCard->created_at), 'd M Y') }}
                            </span>
                        </li>
                        <li>
                            <span class="date-label">Downloads:</span>
                            <span class="date-value">{{ number_format($admitCard->download_count ?? 0) }}</span>
                        </li>
                        <li>
                            <span class="date-label">Views:</span>
                            <span class="date-value">{{ number_format($admitCard->views ?? 0) }}</span>
                        </li>
                        @if($admitCard->exam_date)
                        <li>
                            <span class="date-label">Exam Date:</span>
                            <span class="date-value">
                                {{ safe_date_format(safe_carbon($admitCard->exam_date), 'd M Y') }}
                            </span>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
            
            <!-- Related Admit Cards -->
            @if(isset($relatedAdmitCards) && $relatedAdmitCards->count() > 0)
            <div class="section-box">
                <div class="section-header" style="background: #6c757d;">
                    <i class="fas fa-link"></i> Related Admit Cards
                </div>
                <div class="section-content">
                    <div class="related-grid">
                        @foreach($relatedAdmitCards as $related)
                        <div class="related-item">
                            <div class="related-title">
                                <a href="{{ $related->slug ? route('admit-card.show', $related->slug) : route('admit-cards') }}">
                                    <i class="fas fa-ticket-alt" style="color: #ffc107;"></i>
                                    {{ Str::limit($related->title, 50) }}
                                </a>
                            </div>
                            <div class="related-date">
                                <i class="fas fa-calendar-alt"></i> 
                                {{ safe_date_format(safe_carbon($related->admit_card_date), 'd M Y') }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
            
            <!-- Share Section -->
            <div class="section-box">
                <div class="section-header" style="background: #ab183d;">
                    <i class="fas fa-share-alt"></i> Share This Admit Card
                </div>
                <div class="section-content">
                    <div class="share-buttons">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                           target="_blank" class="share-btn facebook">
                            <i class="fab fa-facebook-f"></i> Facebook
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($admitCard->title) }}" 
                           target="_blank" class="share-btn twitter">
                            <i class="fab fa-twitter"></i> Twitter
                        </a>
                        <a href="https://wa.me/?text={{ urlencode($admitCard->title . ' - ' . url()->current()) }}" 
                           target="_blank" class="share-btn whatsapp">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                        <a href="https://t.me/share/url?url={{ urlencode(url()->current()) }}&text={{ urlencode($admitCard->title) }}" 
                           target="_blank" class="share-btn telegram">
                            <i class="fab fa-telegram"></i> Telegram
                        </a>
                    </div>
                    <div class="text-center mt-3">
                        <button onclick="copyToClipboard()" class="btn btn-outline-secondary btn-sm w-100">
                            <i class="fas fa-copy"></i> Copy Link
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Connect with Us -->
            <div class="section-box">
                <div class="section-header" style="background: #ab183d;">
                    <i class="fas fa-users"></i> Connect with Us
                </div>
                <div class="section-content" style="text-align: center;">
                    <div style="display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">
                        <a href="https://t.me/SarkariResult" target="_blank" rel="nofollow noopener" style="background: #0088cc; color: #fff; padding: 8px 12px; border-radius: 5px; text-decoration: none; font-size: 12px;">
                            <i class="fab fa-telegram"></i> Telegram
                        </a>
                        <a href="https://whatsapp.com/channel/" target="_blank" rel="nofollow noopener" style="background: #25d366; color: #fff; padding: 8px 12px; border-radius: 5px; text-decoration: none; font-size: 12px;">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                        <a href="https://www.facebook.com/SarkariResult./" target="_blank" rel="nofollow noopener" style="background: #1877f2; color: #fff; padding: 8px 12px; border-radius: 5px; text-decoration: none; font-size: 12px;">
                            <i class="fab fa-facebook"></i> Facebook
                        </a>
                        <a href="https://www.instagram.com/sarkariresult./" target="_blank" rel="nofollow noopener" style="background: #e4405f; color: #fff; padding: 8px 12px; border-radius: 5px; text-decoration: none; font-size: 12px;">
                            <i class="fab fa-instagram"></i> Instagram
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    
</div>
@endsection

@push('scripts')
<script>
function trackDownload(type) {
    console.log('Download initiated for admit card: {{ $admitCard->id }} - Type: ' + type);
    
    // Show loading state
    const btn = document.querySelector('.download-btn');
    if (btn && btn.href) {
        const originalHTML = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Preparing Download...';
        btn.style.opacity = '0.7';
        
        setTimeout(() => {
            btn.innerHTML = originalHTML;
            btn.style.opacity = '1';
        }, 2000);
    }
    
    // Send to Google Analytics if available
    if (typeof gtag !== 'undefined') {
        gtag('event', 'download', {
            'event_category': 'admit_card',
            'event_label': 'Admit Card ID: {{ $admitCard->id }} - Type: ' + type
        });
    }
}

// Copy URL to clipboard
function copyToClipboard() {
    const url = window.location.href;
    navigator.clipboard.writeText(url).then(() => {
        const notification = document.createElement('div');
        notification.className = 'alert alert-success position-fixed top-0 start-50 translate-middle-x mt-3';
        notification.style.zIndex = '9999';
        notification.style.background = '#28a745';
        notification.style.color = '#fff';
        notification.style.padding = '10px 20px';
        notification.style.borderRadius = '5px';
        notification.innerHTML = '<i class="fas fa-check-circle me-2"></i> Link copied to clipboard!';
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 2000);
    }).catch(() => {
        alert('Failed to copy link. Please copy manually.');
    });
}
</script>
@endpush