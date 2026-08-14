{{-- resources/views/documents/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Government Notices & Certificates - SarkariResult.mobi')
@section('meta_description', 'Download official government notices, certificates, and important documents from various departments. Get all official documents at one place.')

@push('styles')
<style>
    /* Sarkari Result Document Section Styles */
    .documents-container {
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
    
    .doc-header {
        background: linear-gradient(135deg, #ab183d 0%, #8b1030 100%);
        color: #fff;
        padding: 25px 20px;
        border-radius: 8px;
        margin-bottom: 20px;
    }
    
    .doc-header h1 {
        font-size: 24px;
        margin-bottom: 10px;
    }
    
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
    
    .stat-card.notice .stat-number { color: #007bff; }
    .stat-card.certificate .stat-number { color: #28a745; }
    .stat-card.total .stat-number { color: #ab183d; }
    
    .stat-number {
        font-size: 28px;
        font-weight: bold;
    }
    
    .stat-label {
        font-size: 14px;
        color: #666;
        margin-top: 5px;
    }
    
    .document-item {
        border-bottom: 1px solid #e0e0e0;
        padding: 15px;
        transition: all 0.2s ease;
    }
    
    .document-item:hover {
        background: #f8f9fa;
    }
    
    .document-title {
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 8px;
    }
    
    .document-title a {
        color: #333;
        text-decoration: none;
    }
    
    .document-title a:hover {
        color: #ab183d;
    }
    
    .document-meta {
        font-size: 12px;
        color: #666;
        margin-bottom: 8px;
    }
    
    .document-meta span {
        margin-right: 15px;
        display: inline-block;
    }
    
    .document-meta i {
        margin-right: 5px;
    }
    
    .badge-notice {
        background: #007bff;
        color: #fff;
        padding: 2px 8px;
        border-radius: 4px;
        font-size: 10px;
        margin-left: 8px;
        display: inline-block;
    }
    
    .badge-certificate {
        background: #28a745;
        color: #fff;
        padding: 2px 8px;
        border-radius: 4px;
        font-size: 10px;
        margin-left: 8px;
        display: inline-block;
    }
    
    .btn-download {
        background: #28a745;
        color: #fff;
        padding: 6px 12px;
        border-radius: 5px;
        text-decoration: none;
        font-size: 12px;
        display: inline-block;
        transition: all 0.2s ease;
    }
    
    .btn-download:hover {
        background: #1e7e34;
        color: #fff;
        transform: translateY(-1px);
    }
    
    .text-danger { color: #dc3545; }
    .text-primary { color: #007bff; }
    .text-info { color: #17a2b8; }
    .text-success { color: #28a745; }
    .text-secondary { color: #6c757d; }
    
    .w-100 { width: 100%; }
    .py-5 { padding: 3rem 0; }
    .text-center { text-align: center; }
    .text-muted { color: #6c757d; }
    .mb-0 { margin-bottom: 0; }
    .mb-3 { margin-bottom: 1rem; }
    .mt-3 { margin-top: 1rem; }
    
    @media (max-width: 768px) {
        .stats-row {
            grid-template-columns: 1fr;
        }
        
        .document-title {
            font-size: 14px;
        }
        
        .document-item .row {
            flex-direction: column;
        }
        
        .document-item .row > div:last-child {
            text-align: left !important;
            margin-top: 10px;
        }
        
        .document-meta span {
            display: block;
            margin-bottom: 5px;
        }
    }
</style>
@endpush

@section('content')
<div class="documents-container">
    
     <!-- Breadcrumb -->
    <div class="sarkari-breadcrumb">
        <a href="{{ route('home') }}"><i class="fas fa-home"></i> Home</a> &gt;
        <span>Documents</span>
    </div>
    
    
    <!-- Header -->
    <div class="doc-header">
        <h1><i class="fas fa-file-alt"></i> Government Notices & Certificates</h1>
        <p>Download official government notices, certificates, and important documents from various departments</p>
    </div>
    
    <!-- Stats -->
    <div class="stats-row">
        <div class="stat-card notice">
            <div class="stat-number">{{ $totalNotices ?? 0 }}</div>
            <div class="stat-label">Total Notices</div>
        </div>
        <div class="stat-card certificate">
            <div class="stat-number">{{ $totalCertificates ?? 0 }}</div>
            <div class="stat-label">Total Certificates</div>
        </div>
        <div class="stat-card total">
            <div class="stat-number">{{ $documents->total() ?? 0 }}</div>
            <div class="stat-label">Total Documents</div>
        </div>
    </div>
    
    <!-- Search Box -->
    <div class="search-box" style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 20px; margin-bottom: 20px;">
        <form action="{{ route('documents.index') }}" method="GET">
            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <div style="flex: 2; min-width: 200px;">
                    <input type="text" name="search" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;" 
                           placeholder="Search by title, document number, or department..." 
                           value="{{ request('search') }}">
                </div>
                <div style="flex: 1; min-width: 150px;">
                    <select name="type" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                        <option value="">All Types</option>
                        <option value="notice" {{ request('type') == 'notice' ? 'selected' : '' }}>Notice</option>
                        <option value="certificate" {{ request('type') == 'certificate' ? 'selected' : '' }}>Certificate</option>
                    </select>
                </div>
                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="btn" style="background: #ab183d; color: #fff; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">
                        <i class="fas fa-search"></i> Search
                    </button>
                    @if(request()->hasAny(['search', 'type']))
                    <a href="{{ route('documents.index') }}" style="background: #6c757d; color: #fff; padding: 10px 15px; border-radius: 5px; text-decoration: none; display: inline-block;">
                        <i class="fas fa-times"></i> Reset
                    </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
    
    <div class="row" style="display: flex; gap: 20px; flex-wrap: wrap;">
        
        <!-- Main Content -->
        <div style="flex: 2.5; min-width: 250px;">
            <div class="section-box" style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden;">
                <div class="section-header" style="background: #ab183d; color: #fff; padding: 12px 20px;">
                    <i class="fas fa-list"></i> All Documents
                </div>
                <div class="section-content" style="padding: 0;">
                    
                    @forelse($documents as $document)
                    <div class="document-item">
                        <div class="row" style="display: flex; flex-wrap: wrap; gap: 15px;">
                            <div style="flex: 2;">
                                <div class="document-title">
                                    <a href="{{ route('documents.show', $document->slug) }}">
                                        <i class="fas {{ $document->getFileIcon() }} text-{{ $document->getFileColor() }}"></i>
                                        {{ $document->title }}
                                    </a>
                                    @if($document->type == 'notice')
                                    <span class="badge-notice">Notice</span>
                                    @elseif($document->type == 'certificate')
                                    <span class="badge-certificate">Certificate</span>
                                    @endif
                                </div>
                                <div class="document-meta">
                                    @if($document->document_number)
                                    <span><i class="fas fa-hashtag"></i> {{ $document->document_number }}</span>
                                    @endif
                                    @if($document->issue_date)
                                    <span><i class="fas fa-calendar-alt"></i> Issued: {{ $document->issue_date->format('d M Y') }}</span>
                                    @endif
                                    @if($document->department)
                                    <span><i class="fas fa-building"></i> {{ $document->department }}</span>
                                    @endif
                                    @if($document->download_count !== null)
                                    <span><i class="fas fa-download"></i> {{ number_format($document->download_count) }} downloads</span>
                                    @endif
                                </div>
                                @if($document->short_description)
                                <div class="document-meta">
                                    {{ Str::limit($document->short_description, 100) }}
                                </div>
                                @endif
                            </div>
                            <div style="flex: 0.5; text-align: right; min-width: 120px;">
                                <a href="{{ route('documents.download', $document->slug) }}" class="btn-download">
                                    <i class="fas fa-download"></i> Download
                                </a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-5">
                        <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                        <h5>No documents found</h5>
                        <p class="text-muted">Please check back later for updates.</p>
                        @if(request()->hasAny(['search', 'type']))
                        <a href="{{ route('documents.index') }}" class="btn-download mt-3" style="background: #ab183d;">
                            <i class="fas fa-arrow-left"></i> Clear Filters
                        </a>
                        @endif
                    </div>
                    @endforelse
                    
                    <!-- Pagination -->
                    @if($documents->hasPages())
                    <div style="padding: 15px; border-top: 1px solid #e0e0e0;">
                        {{ $documents->appends(request()->query())->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div style="flex: 1; min-width: 250px;">
            
            <!-- Quick Links -->
            <div class="sidebar-box" style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; margin-bottom: 20px;">
                <div class="sidebar-header" style="background: #28a745; color: #fff; padding: 12px 15px;">
                    <i class="fas fa-link"></i> Quick Links
                </div>
                <div class="sidebar-content" style="padding: 15px;">
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        <a href="{{ route('documents.notices') }}" style="color: #007bff; text-decoration: none;">
                            <i class="fas fa-bullhorn"></i> Government Notices
                        </a>
                        <a href="{{ route('documents.certificates') }}" style="color: #28a745; text-decoration: none;">
                            <i class="fas fa-certificate"></i> Download Certificates
                        </a>
                        @if(Route::has('documents.verify-form'))
                        <a href="{{ route('documents.verify-form') }}" style="color: #ab183d; text-decoration: none;">
                            <i class="fas fa-check-circle"></i> Verify Certificate
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Certificate Verification -->
            @if(Route::has('documents.verify'))
            <div class="sidebar-box" style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; margin-bottom: 20px;">
                <div class="sidebar-header" style="background: #ffc107; color: #000; padding: 12px 15px;">
                    <i class="fas fa-shield-alt"></i> Verify Certificate
                </div>
                <div class="sidebar-content" style="padding: 15px;">
                    <form action="{{ route('documents.verify') }}" method="POST">
                        @csrf
                        <input type="text" name="certificate_number" class="form-control" style="width: 100%; padding: 8px; margin-bottom: 10px; border: 1px solid #ddd; border-radius: 5px;" 
                               placeholder="Enter Certificate Number" required>
                        <button type="submit" class="btn btn-warning w-100" style="background: #ffc107; border: none; padding: 8px; cursor: pointer;">
                            <i class="fas fa-search"></i> Verify Now
                        </button>
                    </form>
                </div>
            </div>
            @endif
            
            <!-- Important Notice -->
            <div class="sidebar-box" style="background: #fff3cd; border-left: 4px solid #ffc107; padding: 15px; border-radius: 8px;">
                <strong><i class="fas fa-exclamation-triangle"></i> Important Notes:</strong>
                <ul style="margin: 10px 0 0 20px; font-size: 12px; padding-left: 0;">
                    <li style="margin-bottom: 5px;">✓ Always download official documents from trusted sources</li>
                    <li style="margin-bottom: 5px;">✓ Verify certificates on the official portal before use</li>
                    <li style="margin-bottom: 5px;">✓ Keep a printed copy for future reference</li>
                    <li style="margin-bottom: 5px;">✓ Check document validity period if mentioned</li>
                </ul>
            </div>

            <!-- Popular Documents Section (Optional) -->
            @php
                $popularDocs = \App\Models\Document::where('is_active', true)
                                ->orderBy('download_count', 'desc')
                                ->limit(5)
                                ->get();
            @endphp
            
            @if($popularDocs->count() > 0)
            <div class="sidebar-box" style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; margin-top: 20px;">
                <div class="sidebar-header" style="background: #17a2b8; color: #fff; padding: 12px 15px;">
                    <i class="fas fa-fire"></i> Most Popular
                </div>
                <div class="sidebar-content" style="padding: 15px;">
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        @foreach($popularDocs as $popular)
                        <div>
                            <a href="{{ route('documents.show', $popular->slug) }}" style="color: #333; text-decoration: none; font-size: 13px;">
                                <i class="fas {{ $popular->getFileIcon() }} text-{{ $popular->getFileColor() }}"></i>
                                {{ Str::limit($popular->title, 50) }}
                            </a>
                            <div style="font-size: 11px; color: #666; margin-top: 3px;">
                                <i class="fas fa-download"></i> {{ number_format($popular->download_count) }} downloads
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
        
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Add any JavaScript functionality if needed
    document.addEventListener('DOMContentLoaded', function() {
        // Smooth scroll to top when pagination is used
        const paginationLinks = document.querySelectorAll('.pagination a');
        paginationLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        });
    });
</script>
@endpush