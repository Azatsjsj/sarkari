@extends('layouts.app')

@section('title', 'Expired Admissions - Sarkari Result')
@section('content')
<div class="container py-4">
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body bg-secondary text-white rounded">
            <h2><i class="fas fa-history me-2"></i>Archived / Expired Admission Forms</h2>
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
                        <p class="text-danger small mb-2"><i class="fas fa-times-circle me-1"></i>Closed on: {{ safe_date_format($admission->last_date) }}</p>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5 text-muted">No expired admissions found.</div>
        @endforelse
    </div>
</div>
@endsection
