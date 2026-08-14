{{-- resources/views/jobs/show.blade.php --}}
{{-- 
    ==================================================
    JOB DETAIL PAGE - SARKARI RESULT MODERN STYLE
    ==================================================
    This template displays detailed information about a single job posting.
    Includes job details, important dates, eligibility, application links,
    and a sidebar with quick actions and related jobs.
--}}

@extends('layouts.app')

@section('title', mb_substr($job->title, 0, 53) . ' - Sarkari Result')
@section('meta_description', Str::limit(strip_tags($job->description ?? $job->short_description ?? ''), 160))

@push('styles')
<style>
    /* ==================================================
       SARKARI RESULT MODERN STYLE - Updated Design
       ================================================== */
    
    :root {
        --sarkari-primary: #ab183d;
        --sarkari-primary-dark: #8b1030;
        --sarkari-primary-light: #fce8ed;
        --sarkari-success: #28a745;
        --sarkari-info: #17a2b8;
        --sarkari-warning: #ffc107;
        --sarkari-danger: #dc3545;
        --sarkari-border: #e0e0e0;
        --sarkari-bg-light: #f5f5f5;
        --sarkari-bg-white: #ffffff;
        --sarkari-text: #1e293b;
        --sarkari-text-muted: #64748b;
    }

    /* Job Detail Container */
    .job-detail-wrapper {
        max-width: 1280px;
        margin: 0 auto;
        padding: 20px 15px 40px;
        background: var(--sarkari-bg-white);
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    }

    /* ========== BREADCRUMB ========== */
    .job-breadcrumb {
        background: var(--sarkari-bg-light);
        padding: 12px 18px;
        border-radius: 12px;
        margin-bottom: 24px;
        font-size: 13px;
        border: 1px solid var(--sarkari-border);
    }
    
    .job-breadcrumb a {
        color: var(--sarkari-primary);
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s;
    }
    
    .job-breadcrumb a:hover {
        color: var(--sarkari-primary-dark);
        text-decoration: underline;
    }
    
    .job-breadcrumb .separator {
        color: #aaa;
        margin: 0 6px;
    }
    
    .job-breadcrumb .current {
        color: var(--sarkari-text-muted);
    }

    /* ========== POST HEADER ========== */
    .job-header {
        background: linear-gradient(135deg, var(--sarkari-primary) 0%, var(--sarkari-primary-dark) 100%);
        border-radius: 16px;
        margin-bottom: 24px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(171, 24, 61, 0.25);
    }
    
    .job-header-content {
        padding: 20px 25px;
    }
    
    .job-header h1 {
        font-size: 22px;
        font-weight: 700;
        color: #fff;
        margin: 0;
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }
    
    .job-header h1 i {
        color: #f4c542;
    }
    
    .featured-badge {
        background: var(--sarkari-warning);
        color: #000;
        padding: 4px 14px;
        border-radius: 40px;
        font-size: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    
    .expired-badge-header {
        background: var(--sarkari-danger);
        color: #fff;
        padding: 4px 14px;
        border-radius: 40px;
        font-size: 12px;
        font-weight: 600;
    }
    
    .job-header-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 16px 30px;
        margin-top: 10px;
        color: rgba(255, 255, 255, 0.85);
        font-size: 14px;
    }
    
    .job-header-meta i {
        margin-right: 6px;
        color: #f4c542;
    }
    
    .job-header-meta strong {
        color: #fff;
    }

    /* ========== TWO COLUMN GRID ========== */
    .job-two-col {
        display: flex;
        gap: 24px;
    }
    
    .job-main-col {
        flex: 2;
        min-width: 0;
    }
    
    .job-sidebar-col {
        flex: 1;
        min-width: 280px;
    }

    /* ========== SECTION BOX ========== */
    .job-section {
        background: var(--sarkari-bg-white);
        border: 1px solid var(--sarkari-border);
        border-radius: 16px;
        margin-bottom: 20px;
        overflow: hidden;
        transition: box-shadow 0.25s ease;
    }
    
    .job-section:hover {
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
    }
    
    .job-section-header {
        background: var(--sarkari-primary);
        color: #fff;
        padding: 12px 20px;
        font-size: 17px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .job-section-header i {
        font-size: 18px;
    }
    
    .job-section-body {
        padding: 18px 20px;
        background: #fff;
    }

    /* ========== INFO TABLE ========== */
    .job-info-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }
    
    .job-info-table tr {
        border-bottom: 1px solid #f1f5f9;
    }
    
    .job-info-table tr:last-child {
        border-bottom: none;
    }
    
    .job-info-table td {
        padding: 10px 8px;
        vertical-align: top;
    }
    
    .job-info-table .label-cell {
        width: 200px;
        font-weight: 600;
        color: var(--sarkari-primary);
        background: var(--sarkari-primary-light);
        padding: 10px 14px;
        border-radius: 4px;
    }
    
    .job-info-table .value-cell {
        color: var(--sarkari-text);
        padding: 10px 14px;
    }
    
    .job-info-table .value-cell strong {
        color: var(--sarkari-primary-dark);
    }
    
    .text-success {
        color: var(--sarkari-success) !important;
    }
    
    .text-danger {
        color: var(--sarkari-danger) !important;
    }
    
    .expired-badge {
        background: var(--sarkari-danger);
        color: #fff;
        padding: 2px 12px;
        border-radius: 40px;
        font-size: 11px;
        font-weight: 600;
        margin-left: 8px;
        display: inline-block;
    }

    /* ========== VACANCY TABLE ========== */
    .vacancy-table-modern {
        width: 100%;
        border-collapse: collapse;
        margin: 10px 0;
        font-size: 14px;
        border-radius: 12px;
        overflow: hidden;
    }
    
    .vacancy-table-modern th {
        background: var(--sarkari-primary);
        color: #fff;
        padding: 12px 14px;
        text-align: left;
        font-weight: 600;
    }
    
    .vacancy-table-modern td {
        padding: 10px 14px;
        border-bottom: 1px solid #f1f5f9;
    }
    
    .vacancy-table-modern tr:nth-child(even) {
        background: #fafafa;
    }
    
    .vacancy-table-modern tr:last-child td {
        border-bottom: none;
    }

    /* ========== DATE LIST ========== */
    .date-list-modern {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .date-list-modern li {
        padding: 10px 0;
        border-bottom: 1px dashed #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 14px;
    }
    
    .date-list-modern li:last-child {
        border-bottom: none;
    }
    
    .date-label {
        font-weight: 600;
        color: var(--sarkari-text-muted);
    }
    
    .date-value {
        color: var(--sarkari-text);
        font-weight: 500;
    }

    /* ========== BUTTONS ========== */
    .btn-apply {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        background: linear-gradient(135deg, var(--sarkari-success), #218838);
        color: #fff;
        text-align: center;
        padding: 14px 20px;
        border-radius: 12px;
        text-decoration: none;
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 12px;
        transition: all 0.3s ease;
        border: none;
        width: 100%;
        cursor: pointer;
    }
    
    .btn-apply:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(40, 167, 69, 0.35);
        color: #fff;
    }
    
    .btn-download {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        background: #0f2b4b;
        color: #fff;
        text-align: center;
        padding: 12px 18px;
        border-radius: 12px;
        text-decoration: none;
        font-size: 15px;
        font-weight: 600;
        margin-bottom: 10px;
        transition: all 0.3s ease;
        width: 100%;
    }
    
    .btn-download:hover {
        background: #1a4a7a;
        transform: translateY(-2px);
        color: #fff;
    }
    
    .btn-official {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        background: var(--sarkari-info);
        color: #fff;
        text-align: center;
        padding: 12px 18px;
        border-radius: 12px;
        text-decoration: none;
        font-size: 15px;
        font-weight: 600;
        transition: all 0.3s ease;
        width: 100%;
    }
    
    .btn-official:hover {
        background: #138496;
        transform: translateY(-2px);
        color: #fff;
    }

    /* ========== SHARE BUTTONS ========== */
    .share-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
    }
    
    .share-btn-modern {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 8px 12px;
        border-radius: 10px;
        text-decoration: none;
        font-size: 13px;
        color: #fff;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .share-btn-modern:hover {
        opacity: 0.85;
        transform: translateY(-2px);
        color: #fff;
    }
    
    .share-fb { background: #1877f2; }
    .share-twitter { background: #1da1f2; }
    .share-wa { background: #25d366; }
    .share-telegram { background: #0088cc; }

    /* ========== RELATED JOBS ========== */
    .related-job-modern {
        padding: 12px 0;
        border-bottom: 1px solid #f1f5f9;
    }
    
    .related-job-modern:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
    
    .related-job-modern a {
        color: var(--sarkari-text);
        text-decoration: none;
        font-weight: 500;
        font-size: 14px;
        display: block;
        transition: color 0.2s;
    }
    
    .related-job-modern a:hover {
        color: var(--sarkari-primary);
    }
    
    .related-job-modern .meta-small {
        font-size: 12px;
        color: var(--sarkari-text-muted);
    }

    /* ========== NOTE BOX ========== */
    .note-box-modern {
        background: #fef9f2;
        border-left: 4px solid var(--sarkari-warning);
        padding: 14px 18px;
        margin: 14px 0;
        border-radius: 8px;
        font-size: 13px;
        color: #78350f;
    }

    /* ========== SOCIAL CONNECT ========== */
    .social-connect-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
    }
    
    .social-connect-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 8px 10px;
        border-radius: 10px;
        text-decoration: none;
        font-size: 12px;
        font-weight: 600;
        color: #fff;
        transition: all 0.3s ease;
    }
    
    .social-connect-btn:hover {
        transform: translateY(-2px);
        opacity: 0.9;
        color: #fff;
    }
    
    .social-tg { background: #0088cc; }
    .social-wa { background: #25d366; }
    .social-fb { background: #1877f2; }
    .social-x { background: #000; }

    /* ========== RESPONSIVE ========== */
    @media (max-width: 992px) {
        .job-two-col {
            flex-direction: column;
        }
        
        .job-sidebar-col {
            min-width: 0;
        }
        
        .job-info-table .label-cell {
            width: 140px;
        }
    }
    
    @media (max-width: 768px) {
        .job-detail-wrapper {
            padding: 12px 10px 30px;
        }
        
        .job-header-content {
            padding: 16px 18px;
        }
        
        .job-header h1 {
            font-size: 18px;
        }
        
        .job-header-meta {
            font-size: 13px;
            gap: 10px 20px;
        }
        
        .job-section-header {
            font-size: 15px;
            padding: 10px 16px;
        }
        
        .job-section-body {
            padding: 14px 16px;
        }
        
        .job-info-table td {
            display: block;
            width: 100%;
            padding: 6px 8px;
        }
        
        .job-info-table .label-cell {
            width: 100%;
            background: transparent;
            padding: 6px 8px;
            font-size: 12px;
            color: var(--sarkari-text-muted);
        }
        
        .job-info-table .value-cell {
            padding: 2px 8px 10px 8px;
        }
        
        .job-info-table tr {
            border-bottom: 1px solid #f1f5f9;
            display: block;
        }
        
        .share-grid {
            grid-template-columns: 1fr 1fr;
        }
        
        .social-connect-grid {
            grid-template-columns: 1fr 1fr;
        }
        
        .vacancy-table-modern {
            font-size: 13px;
        }
        
        .vacancy-table-modern th,
        .vacancy-table-modern td {
            padding: 8px 10px;
        }
        
        .btn-apply {
            font-size: 16px;
            padding: 12px 16px;
        }
        
        .date-list-modern li {
            font-size: 13px;
        }
    }
    
    @media (max-width: 480px) {
        .job-header h1 {
            font-size: 16px;
        }
        
        .share-grid {
            grid-template-columns: 1fr 1fr;
        }
        
        .social-connect-grid {
            grid-template-columns: 1fr 1fr;
        }
        
        .share-btn-modern {
            font-size: 11px;
            padding: 6px 8px;
        }
    }

    /* ========== PRINT STYLES ========== */
    @media print {
        .job-sidebar-col,
        .share-grid,
        .btn-apply,
        .btn-download,
        .btn-official,
        .social-connect-grid {
            display: none !important;
        }
        
        .job-two-col {
            display: block;
        }
        
        .job-section {
            break-inside: avoid;
            border: 1px solid #ddd;
        }
        
        .job-header {
            background: #ab183d !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
    }
</style>
@endpush

@section('content')
<div class="job-detail-wrapper">
    
    {{-- ========== BREADCRUMB ========== --}}
    <div class="job-breadcrumb">
        <a href="{{ route('home') }}"><i class="fas fa-home"></i> Home</a>
        <span class="separator">›</span>
        <a href="{{ route('jobs') }}">Latest Jobs</a>
        @if($job->category)
            <span class="separator">›</span>
            <a href="{{ route('category', $job->category->slug) }}">{{ $job->category->name }}</a>
        @endif
        <span class="separator">›</span>
        <span class="current">{{ Str::limit($job->title, 45) }}</span>
    </div>
    
    {{-- ========== JOB HEADER ========== --}}
    @php
        $startDate = $job->start_date ? \Carbon\Carbon::parse($job->start_date) : null;
        $lastDate = $job->last_date ? \Carbon\Carbon::parse($job->last_date) : null;
        $isExpired = $lastDate ? $lastDate->lt(now()) : false;
        $updateDate = $job->updated_at ?? $job->created_at;
        if (is_string($updateDate)) {
            $updateDate = \Carbon\Carbon::parse($updateDate);
        }
    @endphp
    
    <div class="job-header">
        <div class="job-header-content">
            <h1>
                <i class="fas fa-briefcase"></i>
                {{ $job->title }}
                @if($job->is_featured)
                    <span class="featured-badge"><i class="fas fa-star"></i> Featured</span>
                @endif
                @if($isExpired)
                    <span class="expired-badge-header"><i class="fas fa-times-circle"></i> Expired</span>
                @endif
            </h1>
            <div class="job-header-meta">
                <span><i class="fas fa-calendar-alt"></i> Updated: <strong>{{ $updateDate->format('d M Y, h:i A') }}</strong></span>
                @if($lastDate)
                    <span><i class="fas fa-clock"></i> Last Date: <strong class="{{ $isExpired ? 'text-danger' : 'text-success' }}">{{ $lastDate->format('d M Y') }}</strong></span>
                @endif
                @if($job->total_post)
                    <span><i class="fas fa-users"></i> Total Posts: <strong>{{ $job->total_post }}</strong></span>
                @endif
            </div>
        </div>
    </div>
    
    {{-- ========== TWO COLUMN LAYOUT ========== --}}
    <div class="job-two-col">
        
        {{-- ===== LEFT COLUMN - MAIN CONTENT ===== --}}
        <div class="job-main-col">
            
            {{-- IMPORTANT DATES & APPLICATION FEE --}}
            <div class="job-section">
                <div class="job-section-header">
                    <i class="fas fa-calendar-alt"></i> Important Dates & Application Fee
                </div>
                <div class="job-section-body">
                    <table class="job-info-table">
                        <tr>
                            <td class="label-cell">Application Begin:</td>
                            <td class="value-cell"><strong>{{ $startDate ? $startDate->format('d/m/Y') : 'Not Specified' }}</strong></td>
                        </tr>
                        <tr>
                            <td class="label-cell">Last Date for Registration:</td>
                            <td class="value-cell">
                                <strong class="{{ $isExpired ? 'text-danger' : 'text-success' }}">
                                    {{ $lastDate ? $lastDate->format('d/m/Y') : 'Not Specified' }}
                                </strong>
                                @if($isExpired)
                                    <span class="expired-badge">Expired</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="label-cell">Fee Payment Last Date:</td>
                            <td class="value-cell">
                                <strong>
                                    @php
                                        $feeLastDate = $job->fee_last_date ? \Carbon\Carbon::parse($job->fee_last_date) : null;
                                    @endphp
                                    {{ $feeLastDate ? $feeLastDate->format('d/m/Y') : ($lastDate ? $lastDate->format('d/m/Y') : 'Not Specified') }}
                                </strong>
                            </td>
                        </tr>
                        @if($job->correction_date)
                        <tr>
                            <td class="label-cell">Correction Date:</td>
                            <td class="value-cell"><strong>{{ \Carbon\Carbon::parse($job->correction_date)->format('d/m/Y') }}</strong></td>
                        </tr>
                        @endif
                        @if($job->exam_date)
                        <tr>
                            <td class="label-cell">Exam Date:</td>
                            <td class="value-cell">{{ \Carbon\Carbon::parse($job->exam_date)->format('d/m/Y') }}</td>
                        </tr>
                        @endif
                        @if($job->admit_card_date)
                        <tr>
                            <td class="label-cell">Admit Card Release:</td>
                            <td class="value-cell">{{ \Carbon\Carbon::parse($job->admit_card_date)->format('d/m/Y') }}</td>
                        </tr>
                        @endif
                        @if($job->result_date)
                        <tr>
                            <td class="label-cell">Result Declaration:</td>
                            <td class="value-cell">{{ \Carbon\Carbon::parse($job->result_date)->format('d/m/Y') }}</td>
                        </tr>
                        @endif
                    </table>
                    
                    {{-- Application Fee --}}
                    <div style="margin-top: 18px;">
                        <h4 style="font-size: 15px; font-weight: 700; color: var(--sarkari-primary); margin-bottom: 10px;">
                            <i class="fas fa-money-bill-wave"></i> Application Fee
                        </h4>
                        <table class="job-info-table">
                            <tr>
                                <td class="label-cell">General / OBC / EWS:</td>
                                <td class="value-cell"><strong>{{ $job->fee_general ?? '₹ 100/-' }}</strong></td>
                            </tr>
                            <tr>
                                <td class="label-cell">SC / ST / Female / PH:</td>
                                <td class="value-cell"><strong>{{ $job->fee_sc_st_female ?? '₹ 0/- (Exempted)' }}</strong></td>
                            </tr>
                            @if($job->fee_other)
                            <tr>
                                <td class="label-cell">Other Categories:</td>
                                <td class="value-cell"><strong>{{ $job->fee_other }}</strong></td>
                            </tr>
                            @endif
                            @if($job->payment_mode)
                            <tr>
                                <td class="label-cell">Payment Mode:</td>
                                <td class="value-cell"><strong>{{ $job->payment_mode }}</strong></td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
            
            {{-- AGE LIMIT & VACANCY DETAILS --}}
            <div class="job-section">
                <div class="job-section-header">
                    <i class="fas fa-user-clock"></i> Age Limit & Vacancy Details
                </div>
                <div class="job-section-body">
                    <table class="job-info-table">
                        <tr>
                            <td class="label-cell">Minimum Age:</td>
                            <td class="value-cell"><strong>{{ $job->min_age ?? '18 Years' }}</strong></td>
                        </tr>
                        <tr>
                            <td class="label-cell">Maximum Age:</td>
                            <td class="value-cell"><strong>{{ $job->max_age ?? '40 Years' }}</strong></td>
                        </tr>
                        @if($job->age_calculation_date)
                        <tr>
                            <td class="label-cell">Age As On Date:</td>
                            <td class="value-cell">{{ \Carbon\Carbon::parse($job->age_calculation_date)->format('d/m/Y') }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td class="label-cell">Age Relaxation:</td>
                            <td class="value-cell">{{ $job->age_relaxation ?? 'As per government rules' }}</td>
                        </tr>
                        <tr>
                            <td class="label-cell">Total Vacancies:</td>
                            <td class="value-cell"><strong>{{ $job->total_post ?? 'Not Specified' }} Posts</strong></td>
                        </tr>
                    </table>
                </div>
            </div>
            
            {{-- VACANCY & ELIGIBILITY DETAILS --}}
            <div class="job-section">
                <div class="job-section-header">
                    <i class="fas fa-chart-pie"></i> Vacancy & Eligibility Details
                </div>
                <div class="job-section-body">
                    @if($job->vacancy_details)
                        {!! $job->vacancy_details !!}
                    @else
                        <table class="vacancy-table-modern">
                            <thead>
                                <tr>
                                    <th>Post Name</th>
                                    <th>Total Posts</th>
                                    <th>Eligibility Criteria</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>{{ $job->title }}</strong></td>
                                    <td>{{ $job->total_post ?? 'Not Specified' }}</td>
                                    <td>
                                        <strong>Educational Qualification:</strong><br>
                                        {{ $job->qualification ?? 'As per official notification' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
            
            {{-- ELIGIBILITY CRITERIA --}}
            <div class="job-section">
                <div class="job-section-header">
                    <i class="fas fa-graduation-cap"></i> Eligibility Criteria
                </div>
                <div class="job-section-body">
                    <p style="margin-bottom: 6px;"><strong>Educational Qualification:</strong></p>
                    <p style="color: var(--sarkari-text);">{{ $job->qualification ?: 'As per official notification' }}</p>
                    
                    @if($job->additional_qualification)
                        <p style="margin-top: 12px; margin-bottom: 6px;"><strong>Additional Qualification:</strong></p>
                        <p style="color: var(--sarkari-text);">{{ $job->additional_qualification }}</p>
                    @endif
                    
                    @if($job->experience_required)
                        <p style="margin-top: 12px; margin-bottom: 6px;"><strong>Experience Required:</strong></p>
                        <p style="color: var(--sarkari-text);">{{ $job->experience_required }}</p>
                    @endif
                </div>
            </div>
            
            {{-- SELECTION PROCESS --}}
            @if($job->selection_process)
            <div class="job-section">
                <div class="job-section-header">
                    <i class="fas fa-check-circle"></i> Selection Process
                </div>
                <div class="job-section-body">
                    {!! nl2br(e($job->selection_process)) !!}
                </div>
            </div>
            @endif
            
            {{-- HOW TO APPLY --}}
            <div class="job-section">
                <div class="job-section-header">
                    <i class="fas fa-edit"></i> How to Apply
                </div>
                <div class="job-section-body">
                    <p style="color: var(--sarkari-text);">{{ $job->how_to_apply ?? 'Interested candidates can apply online through the official website or the link provided below.' }}</p>
                    <ul style="margin: 10px 0 0 20px; color: var(--sarkari-text);">
                        <li>Read the full notification carefully before applying</li>
                        <li>Keep ready all required documents - Photo, Signature, ID Proof</li>
                        <li>Check and verify all details before final submission</li>
                        <li>Take a printout of the final submitted form for future reference</li>
                        <li>More information regularly visit <a href="{{ route('jobs') }}" rel="index follow">Government Jobs</a> at SarkariResult.mobi</li>
                    </ul>
                </div>
            </div>
            
            {{-- JOB DESCRIPTION --}}
            @if($job->description)
            <div class="job-section">
                <div class="job-section-header">
                    <i class="fas fa-file-alt"></i> Job Description
                </div>
                <div class="job-section-body">
                    {!! $job->description !!}
                </div>
            </div>
            @endif
            
            {{-- IMPORTANT LINKS --}}
            <div class="job-section">
                <div class="job-section-header">
                    <i class="fas fa-link"></i> Some Useful Important Links
                </div>
                <div class="job-section-body">
                    <table class="job-info-table">
                        @if($job->application_link)
                        <tr>
                            <td class="label-cell">Apply Online:</td>
                            <td class="value-cell">
                                <a href="{{ $job->application_link }}" rel="nofollow noopener noreferrer" target="_blank" style="color: var(--sarkari-primary); font-weight: 600;">
                                    Click Here <i class="fas fa-external-link-alt" style="font-size: 12px;"></i>
                                </a>
                            </td>
                        </tr>
                        @endif
                        @if($job->registration_link)
                        <tr>
                            <td class="label-cell">New Registration:</td>
                            <td class="value-cell">
                                <a href="{{ $job->registration_link }}" rel="nofollow noopener noreferrer" target="_blank" style="color: var(--sarkari-primary); font-weight: 600;">
                                    Click Here <i class="fas fa-external-link-alt" style="font-size: 12px;"></i>
                                </a>
                            </td>
                        </tr>
                        @endif
                        @if($job->login_link)
                        <tr>
                            <td class="label-cell">Login for Apply:</td>
                            <td class="value-cell">
                                <a href="{{ $job->login_link }}" rel="nofollow noopener noreferrer" target="_blank" style="color: var(--sarkari-primary); font-weight: 600;">
                                    Click Here <i class="fas fa-external-link-alt" style="font-size: 12px;"></i>
                                </a>
                            </td>
                        </tr>
                        @endif
                        @if(!empty($job->notification_pdf) && Storage::disk('public')->exists($job->notification_pdf))
                        <tr>
                            <td class="label-cell">Download Notification:</td>
                            <td class="value-cell">
                                <a href="{{ Storage::url($job->notification_pdf) }}" target="_blank" style="color: var(--sarkari-primary); font-weight: 600;">
                                    Click Here <i class="fas fa-file-pdf" style="color: #dc3545;"></i>
                                </a>
                            </td>
                        </tr>
                        @endif
                        @if(!empty($job->short_notification_pdf) && Storage::disk('public')->exists($job->short_notification_pdf))
                        <tr>
                            <td class="label-cell">Short Notification:</td>
                            <td class="value-cell">
                                <a href="{{ Storage::url($job->short_notification_pdf) }}" target="_blank" style="color: var(--sarkari-primary); font-weight: 600;">
                                    Click Here <i class="fas fa-file-pdf" style="color: #dc3545;"></i>
                                </a>
                            </td>
                        </tr>
                        @endif
                        @if($job->official_website)
                        <tr>
                            <td class="label-cell">Official Website:</td>
                            <td class="value-cell">
                                <a href="{{ $job->official_website }}" rel="nofollow noopener noreferrer" target="_blank" style="color: var(--sarkari-primary); font-weight: 600;">
                                    Click Here <i class="fas fa-external-link-alt" style="font-size: 12px;"></i>
                                </a>
                            </td>
                        </tr>
                        @endif
                        @if(!empty($job->syllabus_pdf) && Storage::disk('public')->exists($job->syllabus_pdf))
                        <tr>
                            <td class="label-cell">Download Syllabus:</td>
                            <td class="value-cell">
                                <a href="{{ Storage::url($job->syllabus_pdf) }}" target="_blank" style="color: var(--sarkari-primary); font-weight: 600;">
                                    Click Here <i class="fas fa-file-pdf" style="color: #dc3545;"></i>
                                </a>
                            </td>
                        </tr>
                        @endif
                        @if($job->syllabus_link)
                        <tr>
                            <td class="label-cell">Syllabus Link:</td>
                            <td class="value-cell">
                                <a href="{{ $job->syllabus_link }}" rel="nofollow noopener noreferrer" target="_blank" style="color: var(--sarkari-primary); font-weight: 600;">
                                    Click Here <i class="fas fa-external-link-alt" style="font-size: 12px;"></i>
                                </a>
                            </td>
                        </tr>
                        @endif
                        @if($job->answer_key_link)
                        <tr>
                            <td class="label-cell">Answer Key:</td>
                            <td class="value-cell">
                                <a href="{{ $job->answer_key_link }}" rel="nofollow noopener noreferrer" target="_blank" style="color: var(--sarkari-primary); font-weight: 600;">
                                    Click Here <i class="fas fa-external-link-alt" style="font-size: 12px;"></i>
                                </a>
                            </td>
                        </tr>
                        @endif
                        @if($job->admit_card_link)
                        <tr>
                            <td class="label-cell">Admit Card:</td>
                            <td class="value-cell">
                                <a href="{{ $job->admit_card_link }}" rel="nofollow noopener noreferrer" target="_blank" style="color: var(--sarkari-primary); font-weight: 600;">
                                    Click Here <i class="fas fa-external-link-alt" style="font-size: 12px;"></i>
                                </a>
                            </td>
                        </tr>
                        @endif
                        @if($job->result_link)
                        <tr>
                            <td class="label-cell">Result Link:</td>
                            <td class="value-cell">
                                <a href="{{ $job->result_link }}" rel="nofollow noopener noreferrer" target="_blank" style="color: var(--sarkari-primary); font-weight: 600;">
                                    Click Here <i class="fas fa-external-link-alt" style="font-size: 12px;"></i>
                                </a>
                            </td>
                        </tr>
                        @endif
                        <tr>
                            <td class="label-cell">Join Telegram Channel:</td>
                            <td class="value-cell">
                                <a href="https://t.me/SarkariResult2012" rel="nofollow noopener noreferrer" target="_blank" style="color: var(--sarkari-primary); font-weight: 600;">
                                    Click Here <i class="fab fa-telegram"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-cell">Download Android App:</td>
                            <td class="value-cell">
                                <a href="/" style="color: var(--sarkari-primary); font-weight: 600;">
                                    Click Here <i class="fab fa-android"></i>
                                </a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            
        </div>
        
        {{-- ===== RIGHT COLUMN - SIDEBAR ===== --}}
        <div class="job-sidebar-col">
            
            {{-- QUICK APPLY BUTTONS --}}
            <div class="job-section">
                <div class="job-section-header">
                    <i class="fas fa-hand-pointer"></i> Quick Apply
                </div>
                <div class="job-section-body">
                    @if($job->application_link)
                        <a href="{{ $job->application_link }}" rel="nofollow noopener noreferrer" target="_blank" class="btn-apply">
                            <i class="fas fa-paper-plane"></i> Apply Online
                        </a>
                    @endif
                    
                    @if(!empty($job->notification_pdf) && Storage::disk('public')->exists($job->notification_pdf))
                        <a href="{{ Storage::url($job->notification_pdf) }}" target="_blank" class="btn-download">
                            <i class="fas fa-file-pdf"></i> Download Notification
                        </a>
                    @endif
                    
                    @if($job->official_website)
                        <a href="{{ $job->official_website }}" rel="nofollow noopener noreferrer" target="_blank" class="btn-official">
                            <i class="fas fa-globe"></i> Official Website
                        </a>
                    @endif
                    
                    @if(!$job->application_link && !$job->official_website)
                        <div class="note-box-modern">
                            <i class="fas fa-info-circle"></i> Application links will be available soon. Please check the official notification.
                        </div>
                    @endif
                </div>
            </div>
            
            {{-- SHARE THIS JOB --}}
            <div class="job-section">
                <div class="job-section-header">
                    <i class="fas fa-share-alt"></i> Share this Job
                </div>
                <div class="job-section-body">
                    <div class="share-grid">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" rel="nofollow noopener noreferrer" target="_blank" class="share-btn-modern share-fb">
                            <i class="fab fa-facebook-f"></i> Facebook
                        </a>
                        <a href="https://twitter.com/intent/tweet?text={{ urlencode($job->title) }}&url={{ urlencode(url()->current()) }}" rel="nofollow noopener noreferrer" target="_blank" class="share-btn-modern share-twitter">
                            <i class="fab fa-twitter"></i> Twitter
                        </a>
                        <a href="https://wa.me/?text={{ urlencode($job->title . ' - ' . url()->current()) }}" rel="nofollow noopener noreferrer" target="_blank" class="share-btn-modern share-wa">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                        <a href="https://t.me/share/url?url={{ urlencode(url()->current()) }}&text={{ urlencode($job->title) }}" rel="nofollow noopener noreferrer" target="_blank" class="share-btn-modern share-telegram">
                            <i class="fab fa-telegram-plane"></i> Telegram
                        </a>
                    </div>
                </div>
            </div>
            
            {{-- IMPORTANT DATES SIDEBAR --}}
            <div class="job-section">
                <div class="job-section-header">
                    <i class="fas fa-calendar-check"></i> Important Dates
                </div>
                <div class="job-section-body">
                    <ul class="date-list-modern">
                        <li>
                            <span class="date-label">Application Start:</span>
                            <span class="date-value">{{ $startDate ? $startDate->format('d/m/Y') : 'Not Specified' }}</span>
                        </li>
                        <li>
                            <span class="date-label">Last Date Apply:</span>
                            <span class="date-value {{ $isExpired ? 'text-danger' : 'text-success' }}">
                                {{ $lastDate ? $lastDate->format('d/m/Y') : 'Not Specified' }}
                            </span>
                        </li>
                        <li>
                            <span class="date-label">Fee Last Date:</span>
                            <span class="date-value">
                                @php
                                    $feeLastDate = $job->fee_last_date ? \Carbon\Carbon::parse($job->fee_last_date) : null;
                                @endphp
                                {{ $feeLastDate ? $feeLastDate->format('d/m/Y') : ($lastDate ? $lastDate->format('d/m/Y') : 'Not Specified') }}
                            </span>
                        </li>
                        @if($job->correction_date)
                        <li>
                            <span class="date-label">Correction Date:</span>
                            <span class="date-value">{{ \Carbon\Carbon::parse($job->correction_date)->format('d/m/Y') }}</span>
                        </li>
                        @endif
                        @if($job->exam_date)
                        <li>
                            <span class="date-label">Exam Date:</span>
                            <span class="date-value">{{ \Carbon\Carbon::parse($job->exam_date)->format('d/m/Y') }}</span>
                        </li>
                        @endif
                        <li>
                            <span class="date-label">Admit Card:</span>
                            <span class="date-value">{{ $job->admit_card_date ? \Carbon\Carbon::parse($job->admit_card_date)->format('d/m/Y') : 'Available Soon' }}</span>
                        </li>
                        <li>
                            <span class="date-label">Result:</span>
                            <span class="date-value">{{ $job->result_date ? \Carbon\Carbon::parse($job->result_date)->format('d/m/Y') : 'Available Soon' }}</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            {{-- JOB SUMMARY --}}
            <div class="job-section">
                <div class="job-section-header">
                    <i class="fas fa-info-circle"></i> Job Summary
                </div>
                <div class="job-section-body">
                    <ul class="date-list-modern">
                        <li>
                            <span class="date-label">Organization:</span>
                            <span class="date-value">{{ $job->category->name ?? 'Government Organization' }}</span>
                        </li>
                        <li>
                            <span class="date-label">Total Posts:</span>
                            <span class="date-value">{{ $job->total_post ?? 'Not Specified' }}</span>
                        </li>
                        <li>
                            <span class="date-label">Job Location:</span>
                            <span class="date-value">{{ $job->job_location ?? 'All India' }}</span>
                        </li>
                        <li>
                            <span class="date-label">Application Fee:</span>
                            <span class="date-value" style="font-size: 12px;">
                                Gen/OBC/EWS: {{ $job->fee_general ?? '₹ 100' }}<br>
                                SC/ST/Female/PH: {{ $job->fee_sc_st_female ?? '₹ 0' }}
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
            
            {{-- RELATED JOBS --}}
            @if(isset($relatedJobs) && $relatedJobs->count() > 0)
                <div class="job-section">
                    <div class="job-section-header">
                        <i class="fas fa-briefcase"></i> Related Jobs
                    </div>
                    <div class="job-section-body">
                        @foreach($relatedJobs as $relatedJob)
                            <div class="related-job-modern">
                                <a href="{{ route('job.show', $relatedJob->slug) }}">
                                    <i class="fas fa-angle-right" style="color: var(--sarkari-primary);"></i>
                                    {{ Str::limit($relatedJob->title, 45) }}
                                </a>
                                <div class="meta-small">
                                    <i class="fas fa-calendar-alt"></i> Last: 
                                    @php
                                        $relLastDate = $relatedJob->last_date ? \Carbon\Carbon::parse($relatedJob->last_date) : null;
                                    @endphp
                                    {{ $relLastDate ? $relLastDate->format('d M Y') : 'Not Specified' }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            
            {{-- CONNECT WITH US --}}
            <div class="job-section">
                <div class="job-section-header">
                    <i class="fas fa-share-alt"></i> Connect with Us
                </div>
                <div class="job-section-body">
                    <div class="social-connect-grid">
                        <a href="https://t.me/SarkariResult" rel="nofollow noopener noreferrer" target="_blank" class="social-connect-btn social-tg">
                            <i class="fab fa-telegram"></i> Telegram
                        </a>
                        <a href="https://whatsapp.com/channel/" rel="nofollow noopener noreferrer" target="_blank" class="social-connect-btn social-wa">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                        <a href="https://www.facebook.com/SarkariResult/" rel="nofollow noopener noreferrer" target="_blank" class="social-connect-btn social-fb">
                            <i class="fab fa-facebook-f"></i> Facebook
                        </a>
                        <a href="https://twitter.com/SarkariResult" rel="nofollow noopener noreferrer" target="_blank" class="social-connect-btn social-x">
                            <i class="fab fa-twitter"></i> X
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
    // ==========================================
    // BUTTON LOADING STATES
    // ==========================================
    const actionButtons = document.querySelectorAll('.btn-apply, .btn-download, .btn-official');
    
    actionButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href && href.startsWith('http') && !href.includes(window.location.hostname)) {
                // External link - show loading state
                const originalHtml = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
                this.style.opacity = '0.7';
                this.style.pointerEvents = 'none';
                
                setTimeout(() => {
                    this.innerHTML = originalHtml;
                    this.style.opacity = '';
                    this.style.pointerEvents = '';
                }, 3000);
            }
        });
    });
    
    // ==========================================
    // SMOOTH SCROLL FOR ANCHOR LINKS
    // ==========================================
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            const target = document.querySelector(targetId);
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });
    
    // ==========================================
    // EXTERNAL LINK INDICATOR
    // ==========================================
    document.querySelectorAll('.job-info-table a[target="_blank"]').forEach(link => {
        if (!link.querySelector('.fa-external-link-alt') && !link.querySelector('.fa-file-pdf')) {
            link.innerHTML += ' <i class="fas fa-external-link-alt" style="font-size: 11px; opacity: 0.7;"></i>';
        }
    });
    
    // ==========================================
    // PRINT BUTTON (Optional)
    // ==========================================
    console.log('Job Detail Page loaded successfully.');
});
</script>
@endpush