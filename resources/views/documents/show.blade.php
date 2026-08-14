{{-- resources/views/documents/show.blade.php --}}
@extends('layouts.app')

@section('title', mb_substr($pageDisplayTitle ?? $document->title, 0, 53) . ' - Sarkari Result mobi')
@section('meta_description', Str::limit(strip_tags($pageDisplayDescription ?? ($document->description ?? $document->short_description ?? '')), 160))


@push('styles')
<style>
    .document-detail {
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        overflow: hidden;
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
    
    .document-header {
        background: linear-gradient(135deg, #ab183d 0%, #8b1030 100%);
        color: #fff;
        padding: 20px;
    }
    
    .info-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .info-table td {
        padding: 12px;
        border-bottom: 1px solid #e0e0e0;
    }
    
    .info-table td:first-child {
        width: 180px;
        font-weight: bold;
        background: #f8f9fa;
    }
    
    .preview-container {
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 15px;
        text-align: center;
        background: #f8f9fa;
    }
    
    .preview-container iframe {
        width: 100%;
        height: 600px;
        border: none;
    }
    
    @media (max-width: 768px) {
        .info-table td {
            display: block;
            width: 100%;
        }
        
        .info-table td:first-child {
            width: 100%;
        }
        
        .preview-container iframe {
            height: 400px;
        }
    }
</style>
@endpush

@section('content')
<div class="container mt-4">
        <!-- Breadcrumb -->
    <div class="sarkari-breadcrumb">
        <a href="{{ route('home') }}"><i class="fas fa-home"></i> Home</a> &gt;
        <a href="{{ route('documents.index') }}">Documents</a> &gt;
        @if($document->Document && $document->Document->category)
        <a href="{{ route('category', $document->Document->category->slug) }}">{{ $document->Document->category->name }}</a> &gt;
        @endif
        <span>{{ Str::limit($pageDisplayTitle ?? ($document->title ?: ($document->slug ? Str::of($document->slug)->replace(['_', '-'], ' ')->replaceMatches('/\s+/', ' ')->squish()->title()->toString() : 'Document Details')), 40) }}</span>
    </div>
    
    <div class="row">
        <div class="col-lg-8">
            <div class="document-detail">
                <div class="document-header">
                    <h1 class="h4 mb-0">
                        <i class="fas {{ $document->getFileIcon() }}"></i> 
                        {{ $pageDisplayTitle ?? ($document->title ?: ($document->slug ? Str::of($document->slug)->replace(['_', '-'], ' ')->replaceMatches('/\s+/', ' ')->squish()->title()->toString() : 'Document Details')) }}
                    </h1>
                </div>
                
                <div class="p-4">
                    <table class="info-table">
                        <tr>
                            <td>Document Number:</td>
                            <td><strong>{{ $document->document_number ?? 'N/A' }}</strong></td>
                        </tr>
                        <tr>
                            <td>Type:</td>
                            <td>
                                <span class="badge badge-{{ $document->type == 'notice' ? 'primary' : 'success' }}">
                                    {{ ucfirst($document->type) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>Issue Date:</td>
                            <td>{{ $document->issue_date ? $document->issue_date->format('d M Y') : 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td>Valid Upto:</td>
                            <td>{{ $document->valid_upto ? $document->valid_upto->format('d M Y') : 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td>Department:</td>
                            <td>{{ $document->department ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td>Issued By:</td>
                            <td>{{ $document->issued_by ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td>File Size:</td>
                            <td>{{ $document->getFormattedFileSize() }}</td>
                        </tr>
                        <tr>
                            <td>Downloads:</td>
                            <td>{{ $document->download_count }}</td>
                        </tr>
                    </table>
                    
                    @if($document->description)
                    <div class="mt-4">
                        <h5>Description:</h5>
                        <p>{{ $document->description }}</p>
                    </div>
                    @endif
                    
                    <div class="mt-4">
                        <div class="preview-container">
                            <iframe src="{{ asset('storage/' . $document->file_path) }}#toolbar=0" 
                                    title="{{ $document->title }}">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <!-- Action Buttons -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('documents.download', $document->slug) }}" class="btn btn-success">
                            <i class="fas fa-download"></i> Download Document
                        </a>
                        <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank" class="btn btn-info">
                            <i class="fas fa-eye"></i> View Full Screen
                        </a>
                        <button onclick="window.print()" class="btn btn-secondary">
                            <i class="fas fa-print"></i> Print Document
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Related Documents -->
            @if(isset($relatedDocuments) && $relatedDocuments->count() > 0)
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Related Documents</h5>
                </div>
                <div class="card-body">
                    @foreach($relatedDocuments as $related)
                    <div class="border-bottom pb-2 mb-2">
                        <a href="{{ route('documents.show', $related->slug) }}" class="text-decoration-none">
                            {{ Str::limit($related->title, 50) }}
                        </a>
                        <br>
                        <small class="text-muted">
                            <i class="fas fa-calendar"></i> {{ $related->issue_date ? $related->issue_date->format('d M Y') : 'N/A' }}
                        </small>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection