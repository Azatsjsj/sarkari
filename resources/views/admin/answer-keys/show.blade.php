@extends('admin.layout')

@section('title', 'Answer Key Details')
@section('content')
<div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-key me-2"></i>{{ $answerKey->title }}</h1>
    <div>
        <a href="{{ route('admin.answer-keys.edit', $answerKey->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit me-1"></i>Edit</a>
        <a href="{{ route('admin.answer-keys.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Back</a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">Answer Key Information</div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr><th>Title</th><td>{{ $answerKey->title }}</td></tr>
                    <tr><th>Slug</th><td>{{ $answerKey->slug }}</td></tr>
                    <tr><th>Answer Key Date</th><td>{{ safe_date_format($answerKey->answer_key_date) }}</td></tr>
                    <tr><th>Exam Date</th><td>{{ safe_date_format($answerKey->exam_date) }}</td></tr>
                    <tr><th>Official Website</th><td><a href="{{ $answerKey->official_website }}" target="_blank">{{ $answerKey->official_website }}</a></td></tr>
                    <tr><th>Download Link</th><td><a href="{{ $answerKey->download_link }}" target="_blank">{{ $answerKey->download_link }}</a></td></tr>
                </table>
                @if($answerKey->description)
                <div class="mt-3">
                    <h5>Description</h5>
                    <p>{!! nl2br(e($answerKey->description)) !!}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-secondary text-white">Status & Stats</div>
            <div class="card-body">
                <p><strong>Status:</strong> <span class="badge bg-{{ $answerKey->is_active ? 'success' : 'danger' }}">{{ $answerKey->is_active ? 'Active' : 'Inactive' }}</span></p>
                <p><strong>Views:</strong> {{ number_format($answerKey->views ?? 0) }}</p>
                <p><strong>Downloads:</strong> {{ number_format($answerKey->download_count ?? 0) }}</p>
                <p><strong>Created At:</strong> {{ safe_date_format($answerKey->created_at, 'd M Y, h:i A') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
