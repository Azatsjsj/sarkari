@extends('layouts.app')

@section('title', 'Featured Sarkari Jobs 2026 - Sarkari Result')
@section('content')
<div class="container py-4">
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body bg-danger text-white rounded">
            <h2><i class="fas fa-fire me-2"></i>Featured & Major Vacancies 2026</h2>
        </div>
    </div>
    <div class="row">
        @forelse($jobs ?? [] as $job)
            <div class="col-md-6 mb-3">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="{{ route('job.show', $job->slug) }}" class="text-decoration-none text-dark fw-bold">
                                {{ $job->title }}
                            </a>
                        </h5>
                        <p class="text-muted small mb-2"><i class="fas fa-calendar-alt me-1"></i>Last Date: {{ safe_date_format($job->last_date) }}</p>
                        <a href="{{ route('job.show', $job->slug) }}" class="btn btn-sm btn-danger">Apply Now</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5 text-muted">No featured jobs found.</div>
        @endforelse
    </div>
</div>
@endsection
