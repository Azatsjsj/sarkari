{{-- resources/views/admissions/show.blade.php --}}
@extends('layouts.app')

@section('title', $admission->title . ' - University Admission - Sarkari Result 2026')
@section('meta_description', $admission->meta_description ?? Str::limit($admission->short_description, 160))

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
    
    /* Post Header */
    .post-header {
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        margin-bottom: 20px;
        overflow: hidden;
    }
    
    .post-title {
        background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
        color: #fff;
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
        border-bottom: 1px solid #e0e0e0;
    }
    
    .info-table td {
        padding: 12px 8px;
        vertical-align: top;
    }
    
    .info-table td:first-child {
        width: 180px;
        font-weight: bold;
        color: #17a2b8;
        background: #e8f4f8;
    }
    
    .info-table td:last-child {
        color: #333;
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
    
    /* Apply Button */
    .apply-btn {
        display: block;
        background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
        color: #fff;
        text-align: center;
        padding: 14px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 15px;
        transition: all 0.3s ease;
    }
    
    .apply-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
        color: #fff;
    }
    
    .brochure-btn {
        display: block;
        background: #17a2b8;
        color: #fff;
        text-align: center;
        padding: 12px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 10px;
        transition: all 0.3s ease;
    }
    
    .brochure-btn:hover {
        background: #138496;
        color: #fff;
    }
    
    .official-btn {
        display: block;
        background: #007bff;
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
        background: #0056b3;
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
        border-bottom: 1px dashed #e0e0e0;
        display: flex;
        justify-content: space-between;
    }
    
    .date-list li:last-child {
        border-bottom: none;
    }
    
    .date-label {
        font-weight: bold;
        color: #17a2b8;
    }
    
    .date-value {
        color: #333;
    }
    
    /* Note Box */
    .note-box {
        background: #fff3cd;
        border-left: 4px solid #ffc107;
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
        border: 1px solid #e0e0e0;
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
        color: #333;
        text-decoration: none;
    }
    
    .related-title a:hover {
        color: #17a2b8;
    }
    
    .related-date {
        font-size: 11px;
        color: #888;
    }
    
    /* Badge Styles */
    .badge-featured {
        background: #ffc107;
        color: #000;
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 11px;
        margin-left: 10px;
        display: inline-block;
    }
    
    .badge-expired {
        background: #dc3545;
        color: #fff;
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
        
        .apply-btn {
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
</style>
@endpush

@section('content')
<div class="sarkari-container">
    
    <!-- Breadcrumb -->
    <div class="sarkari-breadcrumb">
        <a href="{{ route('home') }}"><i class="fas fa-home"></i> Home</a> &gt;
        <a href="{{ route('admissions') }}">Admissions</a> &gt;
        @if($admission->university)
        <a href="{{ route('university.show', $admission->university->slug) }}">{{ $admission->university->name }}</a> &gt;
        @endif
        <span>{{ Str::limit($admission->title, 40) }}</span>
    </div>
    
    <div class="two-col-grid">
        
        <!-- Left Column - Main Content -->
        <div class="col-left">
            
            <!-- Post Header -->
            <div class="post-header">
                <div class="post-title">
                    <h1>
                        <i class="fas fa-graduation-cap"></i> 
                        {{ $admission->title }}
                        @php
                            $lastDate = $admission->last_date;
                            if (is_string($lastDate)) {
                                $lastDate = \Carbon\Carbon::parse($lastDate);
                            }
                            $isExpired = $lastDate->lt(now());
                        @endphp
                        @if($admission->is_featured)
                        <span class="badge-featured"><i class="fas fa-star"></i> Featured</span>
                        @endif
                        @if($isExpired)
                        <span class="badge-expired"><i class="fas fa-clock"></i> Expired</span>
                        @endif
                    </h1>
                </div>
                <div class="post-meta">
                    <table class="info-table">
                        <tr>
                            <td>Name of Admission:</td>
                            <td><strong>{{ $admission->title }}</strong></td>
                        </tr>
                        <tr>
                            <td>Post Date / Update:</td>
                            <td>
                                @php
                                    $updateDate = $admission->updated_at ?? $admission->created_at;
                                    if (is_string($updateDate)) {
                                        $updateDate = \Carbon\Carbon::parse($updateDate);
                                    }
                                @endphp
                                {{ $updateDate->format('d M Y') }} | {{ $updateDate->format('h:i A') }}
                            </td>
                        </tr>
                        @if($admission->university)
                        <tr>
                            <td>University:</td>
                            <td>{{ $admission->university->name }}</td>
                        </tr>
                        @endif
                        @if($admission->course)
                        <tr>
                            <td>Course:</td>
                            <td>{{ $admission->course->name }} (@if($admission->degree_type){{ $admission->degree_type }}@endif)</td>
                        </tr>
                        @endif
                        <tr>
                            <td>Application Start Date:</td>
                            <td><strong class="text-success">{{ \Carbon\Carbon::parse($admission->start_date)->format('d M Y') }}</strong></td>
                        </tr>
                        <tr>
                            <td>Application Last Date:</td>
                            <td>
                                <strong class="{{ $isExpired ? 'text-danger' : 'text-warning' }}">
                                    {{ $lastDate->format('d M Y') }}
                                </strong>
                                @if(!$isExpired)
                                <span class="text-muted">({{ $lastDate->diffInDays(now()) }} days left)</span>
                                @endif
                            </td>
                        </tr>
                        @if($admission->exam_date)
                        <tr>
                            <td>Exam Date:</td>
                            <td>{{ \Carbon\Carbon::parse($admission->exam_date)->format('d M Y') }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td>Status:</td>
                            <td>
                                @if($isExpired)
                                <span style="color: #dc3545;"><i class="fas fa-times-circle"></i> Closed</span>
                                @elseif($lastDate->diffInDays(now()) <= 7)
                                <span style="color: #fd7e14;"><i class="fas fa-exclamation-triangle"></i> Last Week</span>
                                @else
                                <span style="color: #28a745;"><i class="fas fa-check-circle"></i> Active</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <!-- Admission Information -->
            <div class="section-box">
                <div class="section-header">
                    <i class="fas fa-info-circle"></i> Admission Information
                </div>
                <div class="section-content">
                    @if($admission->short_description)
                    <p>{{ $admission->short_description }}</p>
                    @endif
                    
                    @if($admission->description)
                    <div style="margin-top: 15px;">
                        {!! nl2br(e($admission->description)) !!}
                    </div>
                    @endif
                    
                    @if($admission->total_seats)
                    <div style="margin-top: 15px;">
                        <strong><i class="fas fa-users"></i> Total Seats:</strong> {{ $admission->total_seats }}
                    </div>
                    @endif
                    
                    @if($admission->application_fee)
                    <div style="margin-top: 10px;">
                        <strong><i class="fas fa-rupee-sign"></i> Application Fee:</strong> ₹{{ number_format($admission->application_fee, 2) }}
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Eligibility Criteria -->
            @if($admission->eligibility)
            <div class="section-box">
                <div class="section-header">
                    <i class="fas fa-check-circle"></i> Eligibility Criteria
                </div>
                <div class="section-content">
                    {!! nl2br(e($admission->eligibility)) !!}
                </div>
            </div>
            @endif
            
            <!-- Application Process -->
            @if($admission->application_process)
            <div class="section-box">
                <div class="section-header">
                    <i class="fas fa-list-ol"></i> Application Process
                </div>
                <div class="section-content">
                    {!! nl2br(e($admission->application_process)) !!}
                </div>
            </div>
            @endif
            
            <!-- Important Links Section -->
            <div class="section-box">
                <div class="section-header">
                    <i class="fas fa-link"></i> Important Links
                </div>
                <div class="section-content">
                    <table class="info-table" style="width: 100%;">
                        @if($admission->apply_url && !$isExpired)
                        <tr>
                            <td style="width: 200px;">Apply Online:</td>
                            <td>
                                <a href="{{ $admission->apply_url }}" rel="noopener noreferrer" target="_blank" style="color: #28a745; font-weight: bold;">
                                    Click Here
                                </a>
                            </td>
                        </tr>
                        @endif
                        
                        @if($admission->brochure_url)
                        <tr>
                            <td>Download Brochure:</td>
                            <td>
                                <a href="{{ $admission->brochure_url }}" rel="noopener noreferrer" target="_blank" style="color: #28a745; font-weight: bold;">
                                    Click Here
                                </a>
                            </td>
                        </tr>
                        @endif
                        
                        @if($admission->official_website)
                        <tr>
                            <td>Official Website:</td>
                            <td>
                                <a href="{{ $admission->official_website }}" target="_blank" style="color: #28a745; font-weight: bold;">
                                    {{ $admission->official_website }}
                                </a>
                            </td>
                        </tr>
                        @endif
                        
                        <tr>
                            <td>Join Telegram Channel:</td>
                            <td>
                                <a href="https://t.me/SarkariResult2012" target="_blank" rel="noopener noreferrer" style="color: #28a745; font-weight: bold;">
                                    Click Here
                                </a>
                            </td>
                        </tr>
                        
                        <tr>
                            <td>Download Android App:</td>
                            <td>
                                <a href="https://play.google.com/store/apps/details?id=com.app.app14f269771c01" rel="noopener noreferrer" target="_blank" style="color: #28a745; font-weight: bold;">
                                    Click Here
                                </a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <!-- How to Apply -->
            <div class="section-box">
                <div class="section-header">
                    <i class="fas fa-download"></i> How to Apply
                </div>
                <div class="section-content">
                    <ol style="margin-left: 20px;">
                        <li>Click on the "Apply Online" button given above</li>
                        <li>Register yourself on the official portal</li>
                        <li>Fill the application form with correct details</li>
                        <li>Upload required documents (Photo, Signature, Certificates)</li>
                        <li>Pay the application fee online</li>
                        <li>Submit the form and take a printout</li>
                    </ol>
                </div>
            </div>
            
            <!-- Important Instructions -->
            <div class="note-box">
                <strong><i class="fas fa-exclamation-triangle"></i> Important Instructions:</strong>
                <ul>
                    <li>Read the official notification carefully before applying</li>
                    <li>Check eligibility criteria before filling the form</li>
                    <li>Keep all required documents ready for upload</li>
                    <li>Apply before the last date to avoid last-minute issues</li>
                    <li>Save the application form and fee receipt for future reference</li>
                </ul>
            </div>
        </div>
        
        <!-- Right Column - Sidebar -->
        <div class="col-right">
            
            <!-- Apply Button -->
            <div class="section-box">
                <div class="section-header">
                    <i class="fas fa-hand-pointer"></i> Quick Action
                </div>
                <div class="section-content">
                    @if($admission->apply_url && !$isExpired)
                    <a href="{{ $admission->apply_url }}" rel="noopener noreferrer" target="_blank" class="apply-btn">
                        <i class="fas fa-paper-plane"></i> Apply Online
                    </a>
                    @endif
                    
                    @if($admission->brochure_url)
                    <a href="{{ $admission->brochure_url }}" rel="noopener noreferrer" target="_blank" class="brochure-btn">
                        <i class="fas fa-download"></i> Download Brochure
                    </a>
                    @endif
                    
                    @if($admission->official_website)
                    <a href="{{ $admission->official_website }}"  rel="noopener noreferrer" target="_blank" class="official-btn">
                        <i class="fas fa-globe"></i> Official Website
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
                                @if($isExpired)
                                <span class="text-danger"><i class="fas fa-times-circle"></i> Closed</span>
                                @else
                                <span class="text-success"><i class="fas fa-check-circle"></i> Active</span>
                                @endif
                            </span>
                        </li>
                        <li>
                            <span class="date-label">University:</span>
                            <span class="date-value">{{ $admission->university->name ?? 'N/A' }}</span>
                        </li>
                        <li>
                            <span class="date-label">Course:</span>
                            <span class="date-value">{{ $admission->course->name ?? 'N/A' }}</span>
                        </li>
                        @if($admission->total_seats)
                        <li>
                            <span class="date-label">Total Seats:</span>
                            <span class="date-value">{{ $admission->total_seats }}</span>
                        </li>
                        @endif
                        @if($admission->application_fee)
                        <li>
                            <span class="date-label">Application Fee:</span>
                            <span class="date-value">₹{{ number_format($admission->application_fee, 2) }}</span>
                        </li>
                        @endif
                        <li>
                            <span class="date-label">Views:</span>
                            <span class="date-value">{{ number_format($admission->views ?? 0) }}</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Related Admissions -->
            @if(isset($relatedAdmissions) && $relatedAdmissions->count() > 0)
            <div class="section-box">
                <div class="section-header" style="background: #6c757d;">
                    <i class="fas fa-link"></i> Related Admissions
                </div>
                <div class="section-content">
                    <div class="related-grid">
                        @foreach($relatedAdmissions as $related)
                        <div class="related-item">
                            <div class="related-title">
                                <a href="{{ route('admissions.show', $related->slug) }}">
                                    <i class="fas fa-graduation-cap" style="color: #17a2b8;"></i>
                                    {{ Str::limit($related->title, 50) }}
                                </a>
                            </div>
                            <div class="related-date">
                                <i class="fas fa-calendar-alt"></i> 
                                @php
                                    $relatedDate = $related->last_date;
                                    if (is_string($relatedDate)) {
                                        $relatedDate = \Carbon\Carbon::parse($relatedDate);
                                    }
                                @endphp
                                Last Date: {{ $relatedDate->format('d M Y') }}
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
                    <i class="fas fa-share-alt"></i> Share This Admission
                </div>
                <div class="section-content">
                    <div class="share-buttons">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                           rel="noopener noreferrer" target="_blank" class="share-btn facebook">
                            <i class="fab fa-facebook-f"></i> Facebook
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($admission->title) }}" 
                          rel="noopener noreferrer"  target="_blank" class="share-btn twitter">
                            <i class="fab fa-twitter"></i> Twitter
                        </a>
                        <a href="https://wa.me/?text={{ urlencode($admission->title . ' - ' . url()->current()) }}" 
                          rel="noopener noreferrer"  target="_blank" class="share-btn whatsapp">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                        <a href="https://t.me/share/url?url={{ urlencode(url()->current()) }}&text={{ urlencode($admission->title) }}" 
                         rel="noopener noreferrer"   target="_blank" class="share-btn telegram">
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
                        <a href="https://t.me/SarkariResult2012" target="_blank" rel="noopener noreferrer" style="background: #0088cc; color: #fff; padding: 8px 12px; border-radius: 5px; text-decoration: none; font-size: 12px;">
                            <i class="fab fa-telegram"></i> Telegram
                        </a>
                        <a href="https://whatsapp.com/channel/0029Va5" rel="noopener noreferrer" target="_blank" style="background: #25d366; color: #fff; padding: 8px 12px; border-radius: 5px; text-decoration: none; font-size: 12px;">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                        <a href="https://www.facebook.com/Sarkari/" rel="noopener noreferrer" target="_blank" style="background: #1877f2; color: #fff; padding: 8px 12px; border-radius: 5px; text-decoration: none; font-size: 12px;">
                            <i class="fab fa-facebook"></i> Facebook
                        </a>
                        <a href="https://www.instagram.com/sarkari/" rel="noopener noreferrer" target="_blank" style="background: #e4405f; color: #fff; padding: 8px 12px; border-radius: 5px; text-decoration: none; font-size: 12px;">
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