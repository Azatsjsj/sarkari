@extends('admin.layout')

@section('title', 'Result Details')
@section('content')
<div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-chart-bar me-2"></i>{{ $result->title }}</h1>
    <div>
        <a href="{{ route('admin.results.edit', $result->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit me-1"></i>Edit</a>
        <a href="{{ route('admin.results.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Back</a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">Result Information</div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr><th>Title</th><td>{{ $result->title }}</td></tr>
                    <tr><th>Slug</th><td>{{ $result->slug }}</td></tr>
                    <tr><th>Associated Job</th><td>{{ $result->job->title ?? 'N/A' }}</td></tr>
                    <tr><th>Result Date</th><td>{{ safe_date_format($result->result_date) }}</td></tr>
                    <tr><th>Result Link</th><td><a href="{{ $result->result_link }}" target="_blank">{{ $result->result_link }}</a></td></tr>
                </table>
                @if($result->description)
                <div class="mt-3">
                    <h5>Description</h5>
                    <p>{!! nl2br(e($result->description)) !!}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-secondary text-white">Status & Stats</div>
            <div class="card-body">
                <p><strong>Status:</strong> <span class="badge bg-{{ $result->is_active ? 'success' : 'danger' }}">{{ $result->is_active ? 'Active' : 'Inactive' }}</span></p>
                <p><strong>Views:</strong> {{ number_format($result->views ?? 0) }}</p>
                <p><strong>Created At:</strong> {{ safe_date_format($result->created_at, 'd M Y, h:i A') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
