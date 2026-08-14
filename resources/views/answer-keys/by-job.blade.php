@extends('layouts.app')

@section('title', 'Answer Keys for ' . ($job->title ?? 'Job') . ' - Sarkari Result 2026')
@section('content')
<div class="container py-4">
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body bg-dark text-white rounded">
            <h2><i class="fas fa-key me-2"></i>Answer Keys for {{ $job->title ?? 'Exam' }}</h2>
        </div>
    </div>
    <div class="row">
        @forelse($answerKeys ?? [] as $key)
            <div class="col-md-6 mb-3">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="{{ route('answer-key.show', $key->slug) }}" class="text-decoration-none text-dark fw-bold">
                                {{ $key->title }}
                            </a>
                        </h5>
                        <p class="text-muted small mb-2"><i class="fas fa-calendar me-1"></i>Date: {{ safe_date_format($key->answer_key_date) }}</p>
                        <a href="{{ route('answer-key.show', $key->slug) }}" class="btn btn-sm btn-dark">View Answer Key</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5 text-muted">No answer keys found for this job.</div>
        @endforelse
    </div>
</div>
@endsection
