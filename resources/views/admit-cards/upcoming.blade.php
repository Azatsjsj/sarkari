@extends('layouts.app')

@section('title', 'Upcoming Exam Admit Cards 2026 - Sarkari Result')
@section('content')
<div class="container py-4">
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body bg-info text-white rounded">
            <h2><i class="fas fa-clock me-2"></i>Upcoming Exam Admit Cards</h2>
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
                        <p class="text-muted small mb-2"><i class="fas fa-calendar me-1"></i>Release Date: {{ safe_date_format($admit->admit_card_date) }}</p>
                        <a href="{{ route('admit-card.show', $admit->slug) }}" class="btn btn-sm btn-info text-white">View Details</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5 text-muted">No upcoming admit cards.</div>
        @endforelse
    </div>
</div>
@endsection
