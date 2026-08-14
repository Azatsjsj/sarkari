@extends('layouts.app')

@section('title', 'State & Location Wise Government Jobs 2026')
@section('content')
<div class="container py-4">
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body bg-dark text-white rounded">
            <h2><i class="fas fa-map-marker-alt me-2"></i>Location Wise Jobs</h2>
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
                        <p class="text-muted small mb-2"><i class="fas fa-map-marker-alt me-1"></i>{{ $job->location ?? 'All India' }}</p>
                        <a href="{{ route('job.show', $job->slug) }}" class="btn btn-sm btn-dark">View Job</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5 text-muted">No jobs found for this location.</div>
        @endforelse
    </div>
</div>
@endsection
