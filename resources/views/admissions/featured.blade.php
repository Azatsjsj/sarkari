@extends('layouts.app')

@section('title', 'Featured Admissions 2026 - Sarkari Result')
@section('content')
<div class="container py-4">
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body bg-warning text-dark rounded">
            <h2><i class="fas fa-star me-2"></i>Featured Admission Forms 2026</h2>
            <p class="mb-0">Top university admissions, entrance test forms & counseling updates.</p>
        </div>
    </div>
    <div class="row">
        @forelse($admissions ?? [] as $admission)
            <div class="col-md-6 mb-3">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="{{ route('admissions.show', $admission->slug) }}" class="text-decoration-none text-dark fw-bold">
                                {{ $admission->title }}
                            </a>
                        </h5>
                        <p class="text-muted small mb-2"><i class="fas fa-calendar-alt me-1"></i>Last Date: {{ safe_date_format($admission->last_date) }}</p>
                        <a href="{{ route('admissions.show', $admission->slug) }}" class="btn btn-sm btn-outline-warning text-dark">Apply Now</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5 text-muted">No featured admissions available right now.</div>
        @endforelse
    </div>
</div>
@endsection
