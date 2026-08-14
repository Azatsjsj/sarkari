@extends('layouts.app')

@section('title', 'Admit Cards for ' . ($job->title ?? 'Job Exam') . ' - Sarkari Result 2026')
@section('content')
<div class="container py-4">
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body bg-warning text-dark rounded">
            <h2><i class="fas fa-ticket-alt me-2"></i>Admit Cards for {{ $job->title ?? 'Exam' }}</h2>
        </div>
    </div>
    <div class="row">
        @forelse($admitCards ?? [] as $admit)
            <div class="col-md-6 mb-3">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="{{ route('admit-card.show', $admit->slug) }}" class="text-decoration-none text-dark fw-bold">
                                {{ $admit->title }}
                            </a>
                        </h5>
                        <p class="text-muted small mb-2"><i class="fas fa-calendar-alt me-1"></i>Admit Card Date: {{ safe_date_format($admit->admit_card_date) }}</p>
                        <a href="{{ route('admit-card.show', $admit->slug) }}" class="btn btn-sm btn-warning text-dark">Download Admit Card</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5 text-muted">No admit cards found for this job.</div>
        @endforelse
    </div>
</div>
@endsection
