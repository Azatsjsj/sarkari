@extends('admin.layout')

@section('title', 'Admit Card Details')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Admit Card Details</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.admit-cards.index') }}" class="btn btn-sm btn-secondary me-2">
            <i class="fas fa-arrow-left"></i> Back to Admit Cards
        </a>
        <a href="{{ route('admin.admit-cards.edit', $admitCard->id) }}" class="btn btn-sm btn-warning me-2">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ $admitCard->slug ? route('admit-card.show', $admitCard->slug) : route('admit-cards') }}" target="_blank" class="btn btn-sm btn-info">
            <i class="fas fa-external-link-alt"></i> View on Site
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Basic Information</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="30%">Title</th>
                        <td>{{ $admitCard->title }}</td>
                    </tr>
                    <tr>
                        <th>Slug</th>
                        <td><code>{{ $admitCard->slug }}</code></td>
                    </tr>
                    <tr>
                        <th>Related Job</th>
                        <td>{{ optional($admitCard->job)->title ?? 'No related job' }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <span class="badge {{ $admitCard->is_active ? 'bg-success' : 'bg-secondary' }}">
                                {{ $admitCard->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Downloads</th>
                        <td>{{ number_format($admitCard->download_count ?? 0) }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Dates</h5>
            </div>
            <div class="card-body">
                @php
                    $admitCardDate = $admitCard->admit_card_date instanceof \Carbon\Carbon ? $admitCard->admit_card_date : \Carbon\Carbon::parse($admitCard->admit_card_date);
                    $examDate = $admitCard->exam_date ? ($admitCard->exam_date instanceof \Carbon\Carbon ? $admitCard->exam_date : \Carbon\Carbon::parse($admitCard->exam_date)) : null;
                @endphp
                <table class="table table-borderless">
                    <tr>
                        <th width="30%">Admit Card Date</th>
                        <td>{{ $admitCardDate->format('d M Y') }}</td>
                    </tr>
                    <tr>
                        <th>Exam Date</th>
                        <td>{{ $examDate ? $examDate->format('d M Y') : 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Created At</th>
                        <td>{{ $admitCard->created_at ? $admitCard->created_at->format('d M Y H:i') : 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Updated At</th>
                        <td>{{ $admitCard->updated_at ? $admitCard->updated_at->format('d M Y H:i') : 'N/A' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">Content</h5>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <h6 class="mb-2">Short Description</h6>
                    <p class="text-muted">{{ $admitCard->short_description ?? 'N/A' }}</p>
                </div>
                <div class="mb-4">
                    <h6 class="mb-2">Description</h6>
                    <div class="bg-light p-3 rounded">
                        {!! nl2br(e($admitCard->description ?: 'No description available.')) !!}
                    </div>
                </div>
                <div class="mb-4">
                    <h6 class="mb-2">Instructions</h6>
                    <div class="bg-light p-3 rounded">
                        {!! nl2br(e($admitCard->instructions ?: 'No instructions provided.')) !!}
                    </div>
                </div>
                <div>
                    <h6 class="mb-2">Required Documents</h6>
                    <div class="bg-light p-3 rounded">
                        {!! nl2br(e($admitCard->required_documents ?: 'No required documents specified.')) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">Download & Links</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="40%">Official Website</th>
                        <td>
                            @if($admitCard->official_website)
                                <a href="{{ $admitCard->official_website }}" target="_blank">Open Link</a>
                            @else
                                N/A
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Download Link</th>
                        <td>
                            @if($admitCard->download_link)
                                <a href="{{ $admitCard->download_link }}" target="_blank">Open Download</a>
                            @else
                                N/A
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>File</th>
                        <td>
                            @if($admitCard->admit_card_file)
                                <a href="{{ route('admin.admit-cards.download', $admitCard->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-download"></i> Download File
                                </a>
                            @else
                                No uploaded file
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0">Metadata</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="40%">Meta Title</th>
                        <td>{{ $admitCard->meta_title ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Meta Description</th>
                        <td>{{ $admitCard->meta_description ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Meta Keywords</th>
                        <td>{{ $admitCard->meta_keywords ?? 'N/A' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
