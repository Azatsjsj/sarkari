@extends('layouts.app')

@section('title', ($university->name ?? 'University Admissions') . ' - Sarkari Result 2026')
@section('content')
<div class="container py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admissions') }}">Admissions</a></li>
            <li class="breadcrumb-item active">{{ $university->name ?? 'University' }}</li>
        </ol>
    </nav>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body bg-primary text-white rounded">
            <h2><i class="fas fa-university me-2"></i>{{ $university->name ?? 'University Admissions' }}</h2>
            <p class="mb-0">{{ $university->description ?? 'Latest admissions, courses and entrance forms.' }}</p>
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
                        <a href="{{ route('admissions.show', $admission->slug) }}" class="btn btn-sm btn-outline-primary">View Details</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5 text-muted">No admissions found for this university.</div>
        @endforelse
    </div>
</div>
@endsection
