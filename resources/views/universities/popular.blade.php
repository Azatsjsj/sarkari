@extends('layouts.app')

@section('title', 'Popular Universities in India 2026 - Sarkari Result')
@section('content')
<div class="container py-4">
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body bg-success text-white rounded">
            <h2><i class="fas fa-fire me-2"></i>Popular Universities</h2>
        </div>
    </div>
    <div class="row">
        @forelse($universities ?? [] as $uni)
            <div class="col-md-6 mb-3">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">{{ $uni->name }}</h5>
                        <p class="text-muted small mb-2"><i class="fas fa-map-marker-alt me-1"></i>{{ $uni->state ?? 'India' }}</p>
                        <a href="{{ route('university.show', $uni->slug ?? $uni->id) }}" class="btn btn-sm btn-success">View Details</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5 text-muted">No popular universities found.</div>
        @endforelse
    </div>
</div>
@endsection
