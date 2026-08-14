@extends('admin.layout')

@section('title', 'View Document - ' . ($document->title ?? 'Document Details'))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Document Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.documents.index') }}" class="btn btn-default btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Documents
                        </a>
                        <a href="{{ route('admin.documents.edit', $document->id) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit"></i> Edit Document
                        </a>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <!-- Basic Information -->
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h4 class="card-title">
                                        <i class="fas fa-info-circle"></i> Basic Information
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th width="200">Title:</th>
                                            <td>{{ $document->title }}</td>
                                        </tr>
                                        <tr>
                                            <th>Slug:</th>
                                            <td><code>{{ $document->slug }}</code></td>
                                        </tr>
                                        <tr>
                                            <th>Document Number:</th>
                                            <td>{{ $document->document_number ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Type:</th>
                                            <td>
                                                <span class="badge badge-{{ $document->type == 'notice' ? 'info' : 'success' }}">
                                                    {{ ucfirst($document->type) }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Category:</th>
                                            <td>{{ $document->category ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Short Description:</th>
                                            <td>{{ $document->short_description ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Description:</th>
                                            <td>{!! nl2br(e($document->description ?? 'N/A')) !!}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <!-- Document File Information -->
                            <div class="card card-success card-outline">
                                <div class="card-header">
                                    <h4 class="card-title">
                                        <i class="fas fa-file"></i> Document File
                                    </h4>
                                </div>
                                <div class="card-body">
                                    @if($document->file_path)
                                        <div class="text-center mb-3">
                                            <i class="fas {{ $document->getFileIcon() }} fa-4x text-{{ $document->getFileColor() }}"></i>
                                        </div>
                                        <table class="table table-bordered">
                                            <tr>
                                                <th width="200">File Name:</th>
                                                <td>{{ $document->file_name ?? basename($document->file_path) }}</td>
                                            </tr>
                                            <tr>
                                                <th>File Size:</th>
                                                <td>{{ $document->getFormattedFileSize() }}</td>
                                            </tr>
                                            <tr>
                                                <th>File Type:</th>
                                                <td>{{ $document->file_type ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>File Path:</th>
                                                <td><code>{{ $document->file_path }}</code></td>
                                            </tr>
                                        </table>
                                        <div class="text-center mt-3">
                                            <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank" class="btn btn-info">
                                                <i class="fas fa-eye"></i> View File
                                            </a>
                                            <a href="{{ route('documents.download', $document->slug) }}" class="btn btn-success">
                                                <i class="fas fa-download"></i> Download File
                                            </a>
                                        </div>
                                    @else
                                        <div class="alert alert-warning text-center">
                                            <i class="fas fa-exclamation-triangle"></i> No file uploaded for this document.
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Additional Information -->
                            <div class="card card-secondary card-outline">
                                <div class="card-header">
                                    <h4 class="card-title">
                                        <i class="fas fa-info"></i> Additional Information
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th width="200">Department:</th>
                                            <td>{{ $document->department ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Issued By:</th>
                                            <td>{{ $document->issued_by ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Language:</th>
                                            <td>
                                                @php
                                                    $languages = [
                                                        'en' => 'English',
                                                        'hi' => 'Hindi',
                                                        'mr' => 'Marathi'
                                                    ];
                                                @endphp
                                                {{ $languages[$document->language] ?? $document->language ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Issue Date:</th>
                                            <td>{{ $document->issue_date ? $document->issue_date->format('d F Y') : 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Valid Upto:</th>
                                            <td>
                                                {{ $document->valid_upto ? $document->valid_upto->format('d F Y') : 'N/A' }}
                                                @if($document->valid_upto && $document->valid_upto->isPast())
                                                    <span class="badge badge-danger ml-2">Expired</span>
                                                @elseif($document->valid_upto && $document->valid_upto->diffInDays(now()) <= 30)
                                                    <span class="badge badge-warning ml-2">Expiring Soon</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Sort Order:</th>
                                            <td>{{ $document->sort_order ?? 0 }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <!-- Status Card -->
                            <div class="card card-{{ $document->is_active ? 'success' : 'danger' }} card-outline">
                                <div class="card-header">
                                    <h4 class="card-title">
                                        <i class="fas fa-toggle-{{ $document->is_active ? 'on' : 'off' }}"></i> Status
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Active Status:</th>
                                            <td>
                                                @if($document->is_active)
                                                    <span class="badge badge-success">Active</span>
                                                @else
                                                    <span class="badge badge-danger">Inactive</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Featured:</th>
                                            <td>
                                                @if($document->is_featured)
                                                    <span class="badge badge-warning">Featured</span>
                                                @else
                                                    <span class="badge badge-secondary">Not Featured</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <!-- Statistics Card -->
                            <div class="card card-info card-outline">
                                <div class="card-header">
                                    <h4 class="card-title">
                                        <i class="fas fa-chart-bar"></i> Statistics
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Download Count:</th>
                                            <td>
                                                <i class="fas fa-download"></i>
                                                {{ number_format($document->download_count ?? 0) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Views:</th>
                                            <td>
                                                <i class="fas fa-eye"></i>
                                                {{ number_format($document->views ?? 0) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Created At:</th>
                                            <td>
                                                <i class="fas fa-calendar-plus"></i>
                                                {{ $document->created_at ? $document->created_at->format('d F Y, h:i A') : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Last Updated:</th>
                                            <td>
                                                <i class="fas fa-calendar-edit"></i>
                                                {{ $document->updated_at ? $document->updated_at->format('d F Y, h:i A') : 'N/A' }}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <!-- Quick Actions Card -->
                            <div class="card card-warning card-outline">
                                <div class="card-header">
                                    <h4 class="card-title">
                                        <i class="fas fa-bolt"></i> Quick Actions
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <div class="btn-group-vertical w-100">
                                        <a href="{{ route('admin.documents.edit', $document->id) }}" class="btn btn-primary mb-2">
                                            <i class="fas fa-edit"></i> Edit Document
                                        </a>
                                        @if($document->file_path)
                                            <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank" class="btn btn-info mb-2">
                                                <i class="fas fa-eye"></i> View File
                                            </a>
                                            <a href="{{ route('documents.download', $document->slug) }}" class="btn btn-success mb-2">
                                                <i class="fas fa-download"></i> Download File
                                            </a>
                                        @endif
                                        <form action="{{ route('admin.documents.destroy', $document->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this document? This action cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger w-100">
                                                <i class="fas fa-trash"></i> Delete Document
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Share Card -->
                            <div class="card card-secondary card-outline">
                                <div class="card-header">
                                    <h4 class="card-title">
                                        <i class="fas fa-share-alt"></i> Share Document
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <div class="input-group mb-3">
                                        <input type="text" id="shareUrl" class="form-control" value="{{ route('documents.show', $document->slug) }}" readonly>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" onclick="copyShareUrl()" type="button">
                                                <i class="fas fa-copy"></i> Copy
                                            </button>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('documents.show', $document->slug)) }}" target="_blank" class="btn btn-primary btn-sm">
                                            <i class="fab fa-facebook"></i> Facebook
                                        </a>
                                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('documents.show', $document->slug)) }}&text={{ urlencode($document->title) }}" target="_blank" class="btn btn-info btn-sm">
                                            <i class="fab fa-twitter"></i> Twitter
                                        </a>
                                        <a href="https://wa.me/?text={{ urlencode($document->title . ' - ' . route('documents.show', $document->slug)) }}" target="_blank" class="btn btn-success btn-sm">
                                            <i class="fab fa-whatsapp"></i> WhatsApp
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-footer">
                    <div class="text-center">
                        <a href="{{ route('admin.documents.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                        <a href="{{ route('admin.documents.edit', $document->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit Document
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
    function copyShareUrl() {
        var copyText = document.getElementById("shareUrl");
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        document.execCommand("copy");
        
        // Show temporary notification
        var btn = event.target;
        var originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check"></i> Copied!';
        setTimeout(function() {
            btn.innerHTML = originalText;
        }, 2000);
    }
</script>
@endpush