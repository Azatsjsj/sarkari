{{-- resources/views/results/show.blade.php --}}
@extends('layouts.app')

@section('title', mb_substr($result->title, 0, 53) . ' - Sarkari Result 2026')
@section('meta_description', Str::limit(strip_tags($result->description ?? $result->short_description ?? ''), 160))

@push('styles')
<style>
    /* Sarkari Result Original Style - Keeping your existing styles */
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
        color: #28a745;
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
        background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
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
        color: #d63031;
        background: #fff5f5;
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
        background: #28a745;
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
    
    /* Important Links Buttons */
    .important-links {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    
    .imp-link-btn {
        display: block;
        padding: 12px 15px;
        background: #f8f9fa;
        border-left: 4px solid #28a745;
        text-decoration: none;
        color: #333;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s ease;
        border-radius: 5px;
    }
    
    .imp-link-btn:hover {
        background: #28a745;
        color: #fff;
        border-left-color: #fff;
    }
    
    .imp-link-btn i {
        margin-right: 8px;
        width: 20px;
    }
    
    /* Result Button */
    .result-btn {
        display: block;
        background: #28a745;
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
    
    .result-btn:hover {
        background: #1e7e34;
        color: #fff;
    }
    
    .download-btn {
        display: block;
        background: #007bff;
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
    
    .download-btn:hover {
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
        color: #28a745;
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
    
    /* Related Results */
    .related-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }
    
    .related-item {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 12px;
        transition: all 0.3s ease;
    }
    
    .related-item:hover {
        background: #f8f9fa;
        transform: translateY(-2px);
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
        color: #28a745;
    }
    
    .related-date {
        font-size: 11px;
        color: #888;
    }
    
    /* Mobile Responsive */
    @media (max-width: 992px) {
        .two-col-grid {
            flex-direction: column;
        }
        
        .info-table td:first-child {
            width: 120px;
        }
        
        .related-grid {
            grid-template-columns: 1fr;
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
        
        .result-btn {
            font-size: 16px;
            padding: 12px;
        }
    }
    
    /* Badge Styles */
    .badge-new {
        background: #28a745;
        color: #fff;
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 11px;
        margin-left: 10px;
    }
    
    /* Loading animation */
    .disabled {
        pointer-events: none;
        opacity: 0.6;
    }
    
    /* Safe HTML content */
    .safe-html-content {
        word-wrap: break-word;
        overflow-wrap: break-word;
    }
    
    .safe-html-content img {
        max-width: 100%;
        height: auto;
    }
    
    .safe-html-content iframe {
        max-width: 100%;
    }
    
</style>
@endpush

@section('content')
<div class="sarkari-container">
    
    <!-- Breadcrumb -->
    <div class="sarkari-breadcrumb">
        <a href="{{ route('home') }}"><i class="fas fa-home"></i> Home</a> &gt;
        <a href="{{ route('results') }}">Results</a> &gt;
        @if(isset($result->job) && isset($result->job->category))
        <a href="{{ route('category', $result->job->category->slug) }}">{{ e($result->job->category->name) }}</a> &gt;
        @endif
        <span>{{ Str::limit($result->title, 40) }}</span>
    </div>
    
    <div class="two-col-grid">
        
        <!-- Left Column - Main Content -->
        <div class="col-left">
            
            <!-- Post Header -->
            <div class="post-header">
                <div class="post-title">
                    <h1>
                        <i class="fas fa-chart-bar"></i> 
                        {{ e($result->title) }}
                        @php
                            $resultDate = $result->result_date ?? now();
                            if (is_string($resultDate)) {
                                try {
                                    $resultDate = \Carbon\Carbon::parse($resultDate);
                                } catch (\Exception $e) {
                                    $resultDate = now();
                                }
                            }
                            $isRecent = $resultDate->diffInDays(now()) <= 7;
                        @endphp
                        @if($isRecent)
                        <span class="badge-new"><i class="fas fa-newspaper"></i> New Result</span>
                        @endif
                    </h1>
                </div>
                <div class="post-meta">
                    <table class="info-table">
                        <tr>
                            <td>Name of Result:</td>
                            <td><strong>{{ e($result->title) }}</strong></td>
                        </tr>
                        <tr>
                            <td>Post Date / Update:</td>
                            <td>
                                @php
                                    $updateDate = $result->updated_at ?? $result->created_at ?? now();
                                    if (is_string($updateDate)) {
                                        try {
                                            $updateDate = \Carbon\Carbon::parse($updateDate);
                                        } catch (\Exception $e) {
                                            $updateDate = now();
                                        }
                                    }
                                @endphp
                                {{ $updateDate->format('d M Y') }} | {{ $updateDate->format('h:i A') }}
                            </td>
                        </tr>
                        @if(isset($result->job))
                        <tr>
                            <td>Exam Name:</td>
                            <td>{{ e($result->job->title ?? 'N/A') }}</td>
                        </tr>
                        @endif
                        @if(isset($result->job) && isset($result->job->category))
                        <tr>
                            <td>Organization:</td>
                            <td>{{ e($result->job->category->name ?? 'N/A') }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td>Result Date:</td>
                            <td><strong>{{ $resultDate->format('d M Y') }}</strong></td>
                        </tr>
                        <tr>
                            <td>Status:</td>
                            <td><span style="color: #28a745;"><i class="fas fa-check-circle"></i> Declared</span></td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <!-- Result Information Section -->
            <div class="section-box">
                <div class="section-header">
                    <i class="fas fa-info-circle"></i> Result Information
                </div>
                <div class="section-content">
                    @if(!empty($result->short_description))
                    <p>{{ e($result->short_description) }}</p>
                    @endif
                    
                    @if(!empty($result->description))
                    <div class="safe-html-content" style="margin-top: 15px;">
                        {!! $result->description !!}
                    </div>
                    @endif
                    
                    @if(isset($result->job) && (!empty($result->job->total_post) || !empty($result->job->qualification)))
                    <div style="margin-top: 15px;">
                        <table class="info-table" style="width: 100%;">
                            @if(!empty($result->job->total_post))
                            <tr>
                                <td style="width: 180px;">Total Vacancies:</td>
                                <td>{{ e($result->job->total_post) }} Posts</td>
                            </tr>
                            @endif
                            @if(!empty($result->job->qualification))
                            <tr>
                                <td>Qualification:</td>
                                <td>{{ e($result->job->qualification) }}</td>
                            </tr>
                            @endif
                            @if(!empty($result->job->age_limit))
                            <tr>
                                <td>Age Limit:</td>
                                <td>{{ e($result->job->age_limit) }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- How to Check Result -->
            <div class="section-box">
                <div class="section-header">
                    <i class="fas fa-search"></i> How to Check Result
                </div>
                <div class="section-content">
                    <ol style="margin-left: 20px;">
                        <li>Click on the "View Result" button given below</li>
                        <li>Enter your Roll Number / Registration Number</li>
                        <li>Enter your Date of Birth / Password</li>
                        <li>Click on Submit Button</li>
                        <li>Your result will appear on the screen</li>
                        <li>Download and take a printout for future reference</li>
                    </ol>
                </div>
            </div>
            
            <!-- Important Links Section -->
            <div class="section-box">
                <div class="section-header">
                    <i class="fas fa-link"></i> Important Links
                </div>
                <div class="section-content">
                    <table class="info-table" style="width: 100%;">
                        @if(!empty($result->result_link))
                        <tr>
                            <td style="width: 200px;">View Result:</td>
                            <td>
                                <a href="{{ $result->result_link }}" target="_blank" rel="noopener noreferrer" class="result-link" style="color: #28a745; font-weight: bold;">
                                    Click Here
                                </a>
                            </td>
                        </tr>
                        @endif
                        @if(!empty($result->result_file))
                        <tr>
                            <td>Download Result PDF:</td>
                            <td>
                                <a href="{{ Storage::url($result->result_file) }}" target="_blank" class="result-link" style="color: #28a745; font-weight: bold;">
                                    Click Here
                                </a>
                            </td>
                        </tr>
                        @endif
                        @if(isset($result->job) && !empty($result->job->notification_pdf))
                        <tr>
                            <td>Download Notification:</td>
                            <td>
                                <a href="{{ Storage::url($result->job->notification_pdf) }}" target="_blank" class="result-link" style="color: #28a745; font-weight: bold;">
                                    Click Here
                                </a>
                            </td>
                        </tr>
                        @endif
                        @if(isset($result->job) && !empty($result->job->answer_key_link))
                        <tr>
                            <td>Answer Key:</td>
                            <td>
                                <a href="{{ $result->job->answer_key_link }}" target="_blank" rel="noopener noreferrer" class="result-link" style="color: #28a745; font-weight: bold;">
                                    Click Here
                                </a>
                            </td>
                        </tr>
                        @endif
                        @if(isset($result->job) && !empty($result->job->official_website))
                        <tr>
                            <td>Official Website:</td>
                            <td>
                                <a href="{{ $result->job->official_website }}" target="_blank" rel="noopener noreferrer" class="result-link" style="color: #28a745; font-weight: bold;">
                                    Click Here
                                </a>
                            </td>
                        </tr>
                        @endif
                        <tr>
                            <td>Join Telegram Channel:</td>
                            <td>
                                <a href="https://t.me/SarkariResult" target="_blank" rel="noopener noreferrer" class="result-link" style="color: #28a745; font-weight: bold;">
                                    Click Here
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>Download Android App:</td>
                            <td>
                                <a href="{{ url('/') }}" target="_blank" class="result-link" style="color: #28a745; font-weight: bold;">
                                    Click Here
                                </a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <!-- Important Instructions -->
            <div class="note-box">
                <strong><i class="fas fa-exclamation-triangle"></i> Important Instructions:</strong>
                <ul>
                    <li>Keep your Roll Number / Registration Number ready</li>
                    <li>Download the result and take a printout</li>
                    <li>Verify all details mentioned in the result</li>
                    <li>For any discrepancy, contact the official authorities</li>
                    <li>Beware of fake result websites</li>
                </ul>
            </div>
            
            <!-- Related Results -->
            @if(isset($relatedResults) && $relatedResults->count() > 0)
            <div class="section-box">
                <div class="section-header">
                    <i class="fas fa-link"></i> Related Results ({{ $relatedResults->count() }})
                </div>
                <div class="section-content">
                    <div class="related-grid">
                        @foreach($relatedResults as $related)
                        <div class="related-item">
                            <div class="related-title">
                                <a href="{{ route('results.show', $related->slug) }}">
                                    {{ Str::limit($related->title, 50) }}
                                </a>
                            </div>
                            <div class="related-date">
                                <i class="fas fa-calendar-alt"></i> 
                                @php
                                    $relatedDate = $related->result_date ?? now();
                                    if (is_string($relatedDate)) {
                                        try {
                                            $relatedDate = \Carbon\Carbon::parse($relatedDate);
                                        } catch (\Exception $e) {
                                            $relatedDate = now();
                                        }
                                    }
                                @endphp
                                {{ $relatedDate->format('d M Y') }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
        
        <!-- Right Column - Sidebar -->
        <div class="col-right">
            
            <!-- View Result Button -->
            <div class="section-box">
                <div class="section-header">
                    <i class="fas fa-hand-pointer"></i> Quick Action
                </div>
                <div class="section-content">
                    @if(!empty($result->result_link))
                    <a href="{{ $result->result_link }}" target="_blank" rel="noopener noreferrer" class="result-btn result-link">
                        <i class="fas fa-external-link-alt"></i> View Result
                    </a>
                    @endif
                    
                    @if(!empty($result->result_file))
                    <a href="{{ Storage::url($result->result_file) }}" target="_blank" class="download-btn result-link">
                        <i class="fas fa-file-pdf"></i> Download Result PDF
                    </a>
                    @endif
                    
                    @if(isset($result->job) && !empty($result->job->notification_pdf))
                    <a href="{{ Storage::url($result->job->notification_pdf) }}" target="_blank" class="download-btn result-link" style="background: #17a2b8;">
                        <i class="fas fa-file-pdf"></i> Download Notification
                    </a>
                    @endif
                </div>
            </div>
            
            <!-- Important Dates Sidebar -->
            <div class="section-box">
                <div class="section-header">
                    <i class="fas fa-calendar-check"></i> Important Dates
                </div>
                <div class="section-content">
                    <ul class="date-list">
                        @if(isset($result->job) && !empty($result->job->start_date))
                        <li>
                            <span class="date-label">Application Start:</span>
                            <span class="date-value">
                                @php
                                    $appStart = $result->job->start_date;
                                    if (is_string($appStart)) {
                                        try {
                                            $appStart = \Carbon\Carbon::parse($appStart);
                                        } catch (\Exception $e) {
                                            $appStart = null;
                                        }
                                    }
                                @endphp
                                {{ $appStart ? $appStart->format('d/m/Y') : 'N/A' }}
                            </span>
                        </li>
                        @endif
                        @if(isset($result->job) && !empty($result->job->last_date))
                        <li>
                            <span class="date-label">Last Date Apply:</span>
                            <span class="date-value">
                                @php
                                    $lastDate = $result->job->last_date;
                                    if (is_string($lastDate)) {
                                        try {
                                            $lastDate = \Carbon\Carbon::parse($lastDate);
                                        } catch (\Exception $e) {
                                            $lastDate = null;
                                        }
                                    }
                                @endphp
                                {{ $lastDate ? $lastDate->format('d/m/Y') : 'N/A' }}
                            </span>
                        </li>
                        @endif
                        @if(isset($result->job) && !empty($result->job->exam_date))
                        <li>
                            <span class="date-label">Exam Date:</span>
                            <span class="date-value">
                                @php
                                    $examDate = $result->job->exam_date;
                                    if (is_string($examDate)) {
                                        try {
                                            $examDate = \Carbon\Carbon::parse($examDate);
                                        } catch (\Exception $e) {
                                            $examDate = null;
                                        }
                                    }
                                @endphp
                                {{ $examDate ? $examDate->format('d/m/Y') : 'N/A' }}
                            </span>
                        </li>
                        @endif
                        <li>
                            <span class="date-label">Result Date:</span>
                            <span class="date-value text-success">
                                {{ $resultDate->format('d/m/Y') }}
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Job Summary -->
            @if(isset($result->job))
            <div class="section-box">
                <div class="section-header">
                    <i class="fas fa-briefcase"></i> Job Summary
                </div>
                <div class="section-content">
                    <ul class="date-list">
                        <li>
                            <span class="date-label">Organization:</span>
                            <span class="date-value">{{ e($result->job->category->name ?? 'N/A') }}</span>
                        </li>
                        <li>
                            <span class="date-label">Total Posts:</span>
                            <span class="date-value">{{ e($result->job->total_post ?? 'Not Specified') }}</span>
                        </li>
                        <li>
                            <span class="date-label">Job Location:</span>
                            <span class="date-value">{{ e($result->job->job_location ?? 'All India') }}</span>
                        </li>
                        @if(!empty($result->job->application_fee))
                        <li>
                            <span class="date-label">Application Fee:</span>
                            <span class="date-value">{{ e($result->job->application_fee) }}</span>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
            @endif
            
            <!-- Connect with Us -->
            <div class="section-box">
                <div class="section-header" style="background: #ab183d;">
                    <i class="fas fa-share-alt"></i> Connect with Us
                </div>
                <div class="section-content" style="text-align: center;">
                    <div style="display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">
                        <a href="https://t.me/SarkariResult" target="_blank" rel="noopener noreferrer" style="background: #0088cc; color: #fff; padding: 8px 12px; border-radius: 5px; text-decoration: none; font-size: 12px;">
                            <i class="fab fa-telegram"></i> Telegram
                        </a>
                        <a href="https://whatsapp.com/channel/" target="_blank" rel="noopener noreferrer" style="background: #25d366; color: #fff; padding: 8px 12px; border-radius: 5px; text-decoration: none; font-size: 12px;">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                        <a href="https://www.facebook.com/SarkariResult/" target="_blank" rel="noopener noreferrer" style="background: #1877f2; color: #fff; padding: 8px 12px; border-radius: 5px; text-decoration: none; font-size: 12px;">
                            <i class="fab fa-facebook"></i> Facebook
                        </a>
                        <a href="https://www.instagram.com/sarkariresult/" target="_blank" rel="noopener noreferrer" style="background: #e4405f; color: #fff; padding: 8px 12px; border-radius: 5px; text-decoration: none; font-size: 12px;">
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
document.addEventListener('DOMContentLoaded', function() {
    // Add loading effect on result links
    const links = document.querySelectorAll('.result-link');
    
    links.forEach(link => {
        link.addEventListener('click', function(e) {
            if (this.href && !this.href.includes('#') && !this.classList.contains('disabled')) {
                e.preventDefault();
                const originalText = this.innerHTML;
                const originalHref = this.href;
                
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
                this.classList.add('disabled');
                this.style.opacity = '0.7';
                
                // Open link after short delay to show loading state
                setTimeout(() => {
                    window.open(originalHref, '_blank');
                    this.innerHTML = originalText;
                    this.classList.remove('disabled');
                    this.style.opacity = '';
                }, 300);
            }
        });
    });
});
</script>
@endpush
