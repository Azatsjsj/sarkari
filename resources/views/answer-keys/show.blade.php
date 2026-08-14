@extends('layouts.app')

@section('title', mb_substr($pageDisplayTitle ?? $answerKey->title, 0, 53) . ' - Sarkari Result 2026')
@section('meta_description', trim((string) ($pageDisplayDescription ?? ($answerKey->short_description ?: ($answerKey->description ?: 'Download answer key for ' . $answerKey->title)))))

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
    
    /* Post Header */
    .post-header {
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        margin-bottom: 20px;
        overflow: hidden;
    }
    
    .post-title {
        background: linear-gradient(135deg, #fd7e14 0%, #e66a0a 100%);
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
        color: #fd7e14;
        background: #fff8f0;
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
        background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
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
        background: #17a2b8;
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
        border-bottom: 1px dashed #e0e0e0;
        display: flex;
        justify-content: space-between;
    }
    
    .date-list li:last-child {
        border-bottom: none;
    }
    
    .date-label {
        font-weight: bold;
        color: #fd7e14;
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
        color: #fd7e14;
    }
    
    .related-date {
        font-size: 11px;
        color: #888;
    }
    
    /* Badge Styles */
    .badge-upcoming {
        background: #ffc107;
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
</style>
@endpush

@section('content')
<div class="sarkari-container">
    
    <!-- Breadcrumb -->
    <div class="sarkari-breadcrumb">
        <a href="{{ route('home') }}"><i class="fas fa-home"></i> Home</a> &gt;
        <a href="{{ route('answer-keys') }}">Answer Keys</a> &gt;
        @if($answerKey->job && $answerKey->job->category)
        <a href="{{ route('category', $answerKey->job->category->slug) }}">{{ $answerKey->job->category->name }}</a> &gt;
        @endif
        <span>{{ Str::limit($pageDisplayTitle ?? ($answerKey->title ?: ($answerKey->slug ? Str::of($answerKey->slug)->replace(['_', '-'], ' ')->replaceMatches('/\s+/', ' ')->squish()->title()->toString() : 'Answer Key Details')), 40) }}</span>
    </div>
    
    <div class="two-col-grid">
        
        <!-- Left Column - Main Content -->
        <div class="col-left">
            
            <!-- Post Header -->
            <div class="post-header">
                <div class="post-title">
                    <h1>
                        <i class="fas fa-key"></i> 
                        {{ $pageDisplayTitle ?? ($answerKey->title ?: ($answerKey->slug ? Str::of($answerKey->slug)->replace(['_', '-'], ' ')->replaceMatches('/\s+/', ' ')->squish()->title()->toString() : 'Answer Key Details')) }}
                        @php
                            $answerKeyDate = safe_carbon($answerKey->answer_key_date);
                            $isUpcoming = is_future_date($answerKeyDate);
                        @endphp
                        @if($isUpcoming)
                        <span class="badge-upcoming"><i class="fas fa-clock"></i> Upcoming</span>
                        @endif
                    </h1>
                </div>
                <div class="post-meta">
                    <table class="info-table">
                        <tr>
                            <td>Name of Answer Key:</td>
                            <td><strong>{{ $answerKey->title }}</strong></td>
                        </tr>
                        <tr>
                            <td>Post Date / Update:</td>
                            <td>
                                @php
                                    $updateDate = safe_carbon($answerKey->updated_at ?? $answerKey->created_at);
                                @endphp
                                @if($updateDate)
                                    {{ safe_date_format($updateDate, 'd M Y') }} | {{ safe_date_format($updateDate, 'h:i A') }}
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                        @if($answerKey->exam_name)
                        <tr>
                            <td>Exam Name:</td>
                            <td>{{ $answerKey->exam_name }}</td>
                        </tr>
                        @endif
                        @if($answerKey->job)
                        <tr>
                            <td>Organization:</td>
                            <td>{{ $answerKey->job->category->name ?? 'N/A' }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td>Answer Key Date:</td>
                            <td>
                                <strong>
                                    {{ safe_date_format($answerKeyDate, 'd M Y') }}
                                </strong>
                            </td>
                        </tr>
                        <tr>
                            <td>Status:</td>
                            <td><span style="color: #28a745;"><i class="fas fa-check-circle"></i> Available</span></td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <!-- Answer Key Information -->
            <div class="section-box">
                <div class="section-header">
                    <i class="fas fa-info-circle"></i> Answer Key Information
                </div>
                <div class="section-content">
                    @if($answerKey->short_description)
                    <p>{{ $answerKey->short_description }}</p>
                    @endif
                    
                    @if($answerKey->description)
                    <div style="margin-top: 15px;">
                        {!! nl2br(e($answerKey->description)) !!}
                    </div>
                    @endif
                    
                    @if($answerKey->instructions)
                    <div style="margin-top: 15px;">
                        <strong><i class="fas fa-list-ol"></i> Instructions:</strong>
                        <div style="margin-top: 10px;">
                            {!! nl2br(e($answerKey->instructions)) !!}
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Interactive Answer Key Marks Calculator (Calculate Marks Manual) -->
            <div class="section-box shadow-sm" style="border: 1px solid #ffe8cc;">
                <div class="section-header" style="background: linear-gradient(135deg, #fd7e14 0%, #d9480f 100%); color: #ffffff;">
                    <i class="fas fa-calculator me-2"></i> Calculate Marks Manual (Answer Key Score Calculator)
                </div>
                <div class="section-content p-3" style="background: #fffdfa;">
                    <p style="color: #666; font-size: 13px; margin-bottom: 15px;">
                        Enter your attempted, correct, and incorrect questions below to calculate your estimated net score and percentage:
                    </p>

                    <div style="display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 15px;">
                        <div style="flex: 1; min-width: 140px;">
                            <label style="font-weight: bold; font-size: 12px; display: block; margin-bottom: 4px;">Total Questions</label>
                            <input type="number" id="calcTotalQuestions" class="form-control" value="{{ $answerKey->total_questions ?? 100 }}" min="1" oninput="window.calculateAnswerKeyScore()" style="width: 100%; padding: 6px 10px; border-radius: 4px; border: 1px solid #ccc;">
                        </div>
                        <div style="flex: 1; min-width: 140px;">
                            <label style="font-weight: bold; font-size: 12px; color: #28a745; display: block; margin-bottom: 4px;"><i class="fas fa-check-circle"></i> Correct</label>
                            <input type="number" id="calcCorrectAnswers" class="form-control" value="70" min="0" oninput="window.calculateAnswerKeyScore()" style="width: 100%; padding: 6px 10px; border-radius: 4px; border: 1px solid #28a745;">
                        </div>
                        <div style="flex: 1; min-width: 140px;">
                            <label style="font-weight: bold; font-size: 12px; color: #dc3545; display: block; margin-bottom: 4px;"><i class="fas fa-times-circle"></i> Incorrect</label>
                            <input type="number" id="calcWrongAnswers" class="form-control" value="15" min="0" oninput="window.calculateAnswerKeyScore()" style="width: 100%; padding: 6px 10px; border-radius: 4px; border: 1px solid #dc3545;">
                        </div>
                        <div style="flex: 1; min-width: 120px;">
                            <label style="font-weight: bold; font-size: 12px; display: block; margin-bottom: 4px;">Marks / Right</label>
                            <input type="number" step="0.25" id="calcMarksPerRight" class="form-control" value="{{ $answerKey->correct_marks ?? 1.00 }}" min="0" oninput="window.calculateAnswerKeyScore()" style="width: 100%; padding: 6px 10px; border-radius: 4px; border: 1px solid #ccc;">
                        </div>
                        <div style="flex: 1; min-width: 140px;">
                            <label style="font-weight: bold; font-size: 12px; color: #fd7e14; display: block; margin-bottom: 4px;">Negative Penalty</label>
                            <select id="calcNegativePenalty" class="form-select" onchange="window.calculateAnswerKeyScore()" style="width: 100%; padding: 6px 10px; border-radius: 4px; border: 1px solid #ccc;">
                                <option value="0.25" {{ ($answerKey->negative_marks ?? 0.25) == 0.25 ? 'selected' : '' }}>0.25 (1/4th)</option>
                                <option value="0.33" {{ ($answerKey->negative_marks ?? 0.25) == 0.33 ? 'selected' : '' }}>0.33 (1/3rd)</option>
                                <option value="0.50" {{ ($answerKey->negative_marks ?? 0.25) == 0.50 ? 'selected' : '' }}>0.50 (1/2)</option>
                                <option value="1.00" {{ ($answerKey->negative_marks ?? 0.25) == 1.00 ? 'selected' : '' }}>1.00 (1 Mark)</option>
                                <option value="0.00" {{ ($answerKey->negative_marks ?? 0.25) == 0.00 ? 'selected' : '' }}>0.00 (No Negative)</option>
                            </select>
                        </div>
                    </div>

                    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                        <button type="button" class="btn btn-warning" onclick="window.calculateAnswerKeyScore()" style="flex: 2; min-width: 200px; background: #fd7e14; color: #fff; font-weight: bold; padding: 10px; border: none; border-radius: 5px; cursor: pointer;">
                            <i class="fas fa-calculator me-1"></i> Calculate My Score Now
                        </button>
                        @if($answerKey->answer_key_url || $answerKey->download_link)
                        <a href="{{ $answerKey->answer_key_url ?: $answerKey->download_link }}" target="_blank" style="flex: 1; min-width: 180px; background: #28a745; color: #fff; font-weight: bold; padding: 10px; border-radius: 5px; text-decoration: none; text-align: center; display: inline-block;">
                            <i class="fas fa-external-link-alt me-1"></i> Open Answer Key URL
                        </a>
                        @endif
                    </div>

                    <div id="scoreResultBox" style="margin-top: 15px; padding: 12px; background: #f8f9fa; border-radius: 6px; border: 1px solid #e9ecef;">
                    </div>

                    <script>
                        window.calculateAnswerKeyScore = function() {
                            const totalQInput = document.getElementById('calcTotalQuestions');
                            const correctInput = document.getElementById('calcCorrectAnswers');
                            const wrongInput = document.getElementById('calcWrongAnswers');
                            const rightMarksInput = document.getElementById('calcMarksPerRight');
                            const negPenaltyInput = document.getElementById('calcNegativePenalty');
                            const box = document.getElementById('scoreResultBox');

                            if (!box) return;

                            const totalQ = Math.max(1, parseFloat(totalQInput?.value) || 100);
                            const correct = Math.max(0, parseFloat(correctInput?.value) || 0);
                            const wrong = Math.max(0, parseFloat(wrongInput?.value) || 0);
                            const markPerRight = parseFloat(rightMarksInput?.value) || 1.0;
                            const negPenalty = parseFloat(negPenaltyInput?.value) || 0;

                            const unattempted = Math.max(0, totalQ - (correct + wrong));
                            const positiveMarks = correct * markPerRight;
                            const negativeDeduction = wrong * negPenalty;
                            const netScore = positiveMarks - negativeDeduction;
                            const maxMarks = totalQ * markPerRight;
                            const percentage = maxMarks > 0 ? ((netScore / maxMarks) * 100).toFixed(2) : '0.00';

                            let ratingColor = '#28a745';
                            let ratingText = 'Excellent / High Selection Chance';
                            if (percentage < 40) {
                                ratingColor = '#dc3545';
                                ratingText = 'Needs Improvement';
                            } else if (percentage < 60) {
                                ratingColor = '#fd7e14';
                                ratingText = 'Average / Borderline Score';
                            }

                            box.innerHTML = `
                                <div style="display: flex; gap: 10px; text-align: center; margin-bottom: 12px; flex-wrap: wrap;">
                                    <div style="flex: 1; min-width: 100px; background: #e8f5e9; padding: 8px; border-radius: 5px; border: 1px solid #c8e6c9;">
                                        <small style="color: #2e7d32; display: block; font-size: 11px;">Positive Score</small>
                                        <strong style="color: #2e7d32; font-size: 16px;">+${positiveMarks.toFixed(2)}</strong>
                                    </div>
                                    <div style="flex: 1; min-width: 100px; background: #ffebee; padding: 8px; border-radius: 5px; border: 1px solid #ffcdd2;">
                                        <small style="color: #c62828; display: block; font-size: 11px;">Negative Penalty</small>
                                        <strong style="color: #c62828; font-size: 16px;">-${negativeDeduction.toFixed(2)}</strong>
                                    </div>
                                    <div style="flex: 1; min-width: 100px; background: #e3f2fd; padding: 8px; border-radius: 5px; border: 1px solid #bbdefb;">
                                        <small style="color: #1565c0; display: block; font-size: 11px;">Net Total Score</small>
                                        <strong style="color: #1565c0; font-size: 16px;">${netScore.toFixed(2)} / ${maxMarks.toFixed(2)}</strong>
                                    </div>
                                </div>
                                <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #dee2e6; margin-top: 10px; padding-top: 10px; flex-wrap: wrap; gap: 8px;">
                                    <div>
                                        <strong style="font-size: 14px;">Score Percentage: <span style="color: #1565c0;">${percentage}%</span></strong>
                                        <small style="display: block; color: #6c757d; font-size: 11px;">Unattempted: ${unattempted} Questions</small>
                                    </div>
                                    <div>
                                        <span style="background: ${ratingColor}; color: #fff; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: bold;">
                                            ${ratingText}
                                        </span>
                                    </div>
                                </div>
                            `;
                        };

                        if (document.readyState === 'loading') {
                            document.addEventListener('DOMContentLoaded', window.calculateAnswerKeyScore);
                        } else {
                            window.calculateAnswerKeyScore();
                        }
                    </script>
                </div>
            </div>
            
            <!-- Important Links Section -->
            <div class="section-box">
                <div class="section-header">
                    <i class="fas fa-link"></i> Important Links &amp; URLs
                </div>
                <div class="section-content">
                    <table class="info-table" style="width: 100%;">
                        @php
                            $downloadLink = null;
                            if ($answerKey->hasLocalFile()) {
                                $downloadLink = route('answer-keys.download', $answerKey->slug ?? $answerKey->id);
                            } elseif (!empty($answerKey->answer_key_url)) {
                                $downloadLink = $answerKey->answer_key_url;
                            } elseif (!empty($answerKey->download_link)) {
                                $downloadLink = $answerKey->download_link;
                            }
                        @endphp
                        <tr>
                            <td style="width: 220px;">Official Answer Key URL:</td>
                            <td>
                                @if($downloadLink)
                                <a href="{{ $downloadLink }}" target="_blank" style="color: #28a745; font-weight: bold;">
                                    <i class="fas fa-external-link-alt me-1"></i> Click Here to Open Answer Key
                                </a>
                                @else
                                <span class="text-muted">Link Coming Soon</span>
                                @endif
                            </td>
                        </tr>
                        @if($answerKey->objection_link || $answerKey->official_website)
                        <tr>
                            <td>Submit Online Objection:</td>
                            <td>
                                <a href="{{ $answerKey->objection_link ?: $answerKey->official_website }}" target="_blank" rel="nofollow, noopener" style="color: #dc3545; font-weight: bold;">
                                    <i class="fas fa-edit me-1"></i> Submit Objection Online
                                </a>
                            </td>
                        </tr>
                        @endif
                        
                        @if($answerKey->job && $answerKey->job->notification_pdf)
                        <tr>
                            <td>Download Notification:</td>
                            <td>
                                <a href="{{ Storage::url($answerKey->job->notification_pdf) }}" target="_blank" style="color: #28a745; font-weight: bold;">
                                    Click Here
                                </a>
                            </td>
                        </tr>
                        @endif
                        
                        @if($answerKey->official_website)
                        <tr>
                            <td>Official Website:</td>
                            <td>
                                <a href="{{ $answerKey->official_website }}" target="_blank" rel="nofollow, noopener, noreferrer" style="color: #28a745; font-weight: bold;">
                                    Click Here
                                </a>
                            </td>
                        </tr>
                        @endif
                        
                        <tr>
                            <td>Join Telegram Channel:</td>
                            <td>
                                <a href="https://t.me/SarkariResult2012" target="_blank" rel="nofollow, noopener, noreferrer" style="color: #28a745; font-weight: bold;">
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
                    <i class="fas fa-download"></i> How to Check Answer Key &amp; Raise Objections
                </div>
                <div class="section-content">
                    <ol style="margin-left: 20px;">
                        <li>Click on the "Official Answer Key URL" link given above</li>
                        <li>Log in using your Roll Number / User ID and Password</li>
                        <li>View your Candidate Response Sheet &amp; Official Master Key</li>
                        <li>Use the "Calculate Marks Manual" tool above to calculate your net score</li>
                        <li>Click "Submit Online Objection" if you find any incorrect answers</li>
                    </ol>
                </div>
            </div>
            
            <!-- Important Instructions -->
            <div class="note-box">
                <strong><i class="fas fa-exclamation-triangle"></i> Important Instructions:</strong>
                <ul>
                    <li>This answer key is for candidate score verification and official objection filing</li>
                    <li>Verify set-wise answer key against your response sheet carefully</li>
                    <li>Submit objections within the official window specified by the board</li>
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
                    @php
                        $downloadButtonLink = $answerKey->answer_key_url ?: ($answerKey->download_link ?: null);
                    @endphp
                    @if($downloadButtonLink)
                    <a href="{{ $downloadButtonLink }}" target="_blank" class="download-btn" style="background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%); color: #fff; display: block; text-align: center; padding: 12px; border-radius: 5px; text-decoration: none; font-weight: bold; margin-bottom: 10px;">
                        <i class="fas fa-key"></i> Open Official Answer Key URL
                    </a>
                    @endif

                    @if($answerKey->objection_link)
                    <a href="{{ $answerKey->objection_link }}" target="_blank" class="official-btn" style="background: linear-gradient(135deg, #fd7e14 0%, #d9480f 100%); color: #fff; display: block; text-align: center; padding: 12px; border-radius: 5px; text-decoration: none; font-weight: bold; margin-bottom: 10px;">
                        <i class="fas fa-edit"></i> Raise Objections Online
                    </a>
                    @elseif(!$downloadButtonLink)
                    <div class="alert alert-warning text-center mb-0">
                        <i class="fas fa-clock"></i> Answer Key Coming Soon
                    </div>
                    @endif
                    
                    @if($answerKey->job && $answerKey->job->notification_pdf)
                    <a href="{{ Storage::url($answerKey->job->notification_pdf) }}" target="_blank" class="official-btn" style="background: #17a2b8; margin-top: 10px;">
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
                                @if(isset($answerKey->is_active) && $answerKey->is_active)
                                <span class="text-success"><i class="fas fa-check-circle"></i> Active</span>
                                @else
                                <span class="text-danger"><i class="fas fa-times-circle"></i> Inactive</span>
                                @endif
                            </span>
                        </li>
                        <li>
                            <span class="date-label">Published:</span>
                            <span class="date-value">
                                @php
                                    $createdAt = $answerKey->created_at;
                                    if (is_string($createdAt)) {
                                        try {
                                            $createdAt = \Carbon\Carbon::parse($createdAt);
                                        } catch (\Exception $e) {
                                            $createdAt = null;
                                        }
                                    }
                                @endphp
                                @if($createdAt)
                                    {{ $createdAt->format('d M Y') }}
                                @else
                                    N/A
                                @endif
                            </span>
                        </li>
                        <li>
                            <span class="date-label">Downloads:</span>
                            <span class="date-value">{{ number_format($answerKey->download_count ?? 0) }}</span>
                        </li>
                        <li>
                            <span class="date-label">Views:</span>
                            <span class="date-value">{{ number_format($answerKey->views ?? 0) }}</span>
                        </li>
                        @if(isset($answerKey->file_size) && $answerKey->file_size)
                        <li>
                            <span class="date-label">File Size:</span>
                            <span class="date-value">{{ $answerKey->file_size }}</span>
                        </li>
                        @endif
                        @if(isset($answerKey->total_questions) && $answerKey->total_questions)
                        <li>
                            <span class="date-label">Total Questions:</span>
                            <span class="date-value">{{ $answerKey->total_questions }}</span>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
            
            <!-- Related Answer Keys -->
            @if(isset($relatedAnswerKeys) && $relatedAnswerKeys->count() > 0)
            <div class="section-box">
                <div class="section-header" style="background: #6c757d;">
                    <i class="fas fa-link"></i> Related Answer Keys
                </div>
                <div class="section-content">
                    <div class="related-grid">
                        @foreach($relatedAnswerKeys as $related)
                        <div class="related-item">
                            <div class="related-title">
                                <a href="{{ route('answer-key.show', $related->slug ?? $related->id) }}">
                                    <i class="fas fa-key" style="color: #fd7e14;"></i>
                                    {{ Str::limit($related->title, 50) }}
                                </a>
                            </div>
                            <div class="related-date">
                                <i class="fas fa-calendar-alt"></i> 
                                @php
                                    $relatedDate = null;
                                    if (!empty($related->answer_key_date)) {
                                        try {
                                            if (is_string($related->answer_key_date)) {
                                                $relatedDate = \Carbon\Carbon::parse($related->answer_key_date);
                                            } elseif ($related->answer_key_date instanceof \Carbon\Carbon) {
                                                $relatedDate = $related->answer_key_date;
                                            }
                                        } catch (\Exception $e) {
                                            $relatedDate = null;
                                        }
                                    }
                                @endphp
                                @if($relatedDate)
                                    {{ $relatedDate->format('d M Y') }}
                                @else
                                    N/A
                                @endif
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
                    <i class="fas fa-share-alt"></i> Share This Answer Key
                </div>
                <div class="section-content">
                    <div class="share-buttons">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                           target="_blank" rel="nofollow, noopener, noreferrer" class="share-btn facebook">
                            <i class="fab fa-facebook-f"></i> Facebook
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($answerKey->title) }}" 
                           target="_blank" rel="nofollow, noopener, noreferrer" class="share-btn twitter">
                            <i class="fab fa-twitter"></i> Twitter
                        </a>
                        <a href="https://wa.me/?text={{ urlencode($answerKey->title . ' - ' . url()->current()) }}" 
                           target="_blank" rel="nofollow, noopener, noreferrer" class="share-btn whatsapp">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                        <a href="https://t.me/share/url?url={{ urlencode(url()->current()) }}&text={{ urlencode($answerKey->title) }}" 
                           target="_blank" rel="nofollow, noopener, noreferrer" class="share-btn telegram">
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
                        <a href="https://t.me/SarkariResult" target="_blank" rel="nofollow, noopener, noreferrer" style="background: #0088cc; color: #fff; padding: 8px 12px; border-radius: 5px; text-decoration: none; font-size: 12px;">
                            <i class="fab fa-telegram"></i> Telegram
                        </a>
                        <a href="https://whatsapp.com/channel/0029Va5IElw" target="_blank" rel="nofollow, noopener, noreferrer" style="background: #25d366; color: #fff; padding: 8px 12px; border-radius: 5px; text-decoration: none; font-size: 12px;">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                        <a href="https://www.facebook.com/SarkariResult/" target="_blank" rel="nofollow, noopener, noreferrer" style="background: #1877f2; color: #fff; padding: 8px 12px; border-radius: 5px; text-decoration: none; font-size: 12px;">
                            <i class="fab fa-facebook"></i> Facebook
                        </a>
                        <a href="https://www.instagram.com/sarkariresult/" target="_blank" rel="nofollow, noopener, noreferrer" style="background: #e4405f; color: #fff; padding: 8px 12px; border-radius: 5px; text-decoration: none; font-size: 12px;">
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
function trackDownload() {
    console.log('Download initiated for: ' + @json($answerKey->title));
    
    // Show loading state
    const btn = document.querySelector('.download-btn');
    if (btn) {
        const originalHTML = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Preparing Download...';
        btn.style.opacity = '0.7';
        
        setTimeout(() => {
            btn.innerHTML = originalHTML;
            btn.style.opacity = '1';
        }, 2000);
    }
}

// Copy URL to clipboard
function copyToClipboard() {
    const url = window.location.href;
    navigator.clipboard.writeText(url).then(() => {
        // Show temporary notification
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
// Calculate Marks Manual Score Calculator
function calculateAnswerKeyScore() {
    const totalQ = parseFloat(document.getElementById('calcTotalQuestions')?.value) || 0;
    const correct = parseFloat(document.getElementById('calcCorrectAnswers')?.value) || 0;
    const wrong = parseFloat(document.getElementById('calcWrongAnswers')?.value) || 0;
    const markPerRight = parseFloat(document.getElementById('calcMarksPerRight')?.value) || 1.0;
    const negPenalty = parseFloat(document.getElementById('calcNegativePenalty')?.value) || 0;

    const unattempted = Math.max(0, totalQ - (correct + wrong));
    const positiveMarks = correct * markPerRight;
    const negativeDeduction = wrong * negPenalty;
    const netScore = positiveMarks - negativeDeduction;
    const maxMarks = totalQ * markPerRight;
    const percentage = maxMarks > 0 ? ((netScore / maxMarks) * 100).toFixed(2) : '0.00';

    let ratingColor = '#28a745';
    let ratingText = 'Excellent / High Selection Chance';
    if (percentage < 40) {
        ratingColor = '#dc3545';
        ratingText = 'Needs Improvement';
    } else if (percentage < 60) {
        ratingColor = '#fd7e14';
        ratingText = 'Average / Borderline Score';
    }

    const html = `
        <div style="display: flex; gap: 10px; text-align: center; margin-bottom: 12px;">
            <div style="flex: 1; background: #e8f5e9; padding: 8px; border-radius: 5px; border: 1px solid #c8e6c9;">
                <small style="color: #2e7d32; display: block; font-size: 11px;">Positive Score</small>
                <strong style="color: #2e7d32; font-size: 16px;">+${positiveMarks.toFixed(2)}</strong>
            </div>
            <div style="flex: 1; background: #ffebee; padding: 8px; border-radius: 5px; border: 1px solid #ffcdd2;">
                <small style="color: #c62828; display: block; font-size: 11px;">Negative Penalty</small>
                <strong style="color: #c62828; font-size: 16px;">-${negativeDeduction.toFixed(2)}</strong>
            </div>
            <div style="flex: 1; background: #e3f2fd; padding: 8px; border-radius: 5px; border: 1px solid #bbdefb;">
                <small style="color: #1565c0; display: block; font-size: 11px;">Net Total Score</small>
                <strong style="color: #1565c0; font-size: 16px;">${netScore.toFixed(2)} / ${maxMarks.toFixed(2)}</strong>
            </div>
        </div>
        <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #dee2e6; pt-2; margin-top: 10px; padding-top: 10px;">
            <div>
                <strong style="font-size: 14px;">Score Percentage: <span style="color: #1565c0;">${percentage}%</span></strong>
                <small style="display: block; color: #6c757d; font-size: 11px;">Unattempted: ${unattempted} Questions</small>
            </div>
            <div>
                <span style="background: ${ratingColor}; color: #fff; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: bold;">
                    ${ratingText}
                </span>
            </div>
        </div>
    `;

    const box = document.getElementById('scoreResultBox');
    if (box) {
        box.innerHTML = html;
    }
}

document.addEventListener('DOMContentLoaded', function() {
    calculateAnswerKeyScore();
});
</script>
@endpush