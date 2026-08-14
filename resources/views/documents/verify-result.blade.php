@extends('layouts.app')

@section('title', 'Document Verification Result - Sarkari Result')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-shield-alt me-2"></i>Verification Result</h4>
                </div>
                <div class="card-body">
                    @if(isset($document) && $document)
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i>Document verified successfully!
                        </div>
                        <table class="table table-bordered">
                            <tr><th>Document Title</th><td>{{ $document->title }}</td></tr>
                            <tr><th>Document Number</th><td>{{ $document->document_number ?? 'N/A' }}</td></tr>
                            <tr><th>Issued By</th><td>{{ $document->issued_by ?? 'Official Department' }}</td></tr>
                            <tr><th>Issue Date</th><td>{{ safe_date_format($document->issue_date) }}</td></tr>
                        </table>
                    @else
                        <div class="alert alert-danger">
                            <i class="fas fa-times-circle me-2"></i>Document record not found or invalid verification number.
                        </div>
                    @endif
                    <a href="{{ route('documents.verify-form') }}" class="btn btn-outline-primary mt-3"><i class="fas fa-arrow-left me-1"></i>Verify Another Document</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
