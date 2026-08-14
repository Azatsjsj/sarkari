@extends('layouts.app')

@section('title', ($university->name ?? 'University Detail') . ' - Sarkari Result 2026')
@section('content')
<div class="container py-4">
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body bg-primary text-white rounded">
            <h2><i class="fas fa-university me-2"></i>{{ $university->name ?? 'University Details' }}</h2>
            <p class="mb-0">{{ $university->state ?? 'India' }} &bull; {{ ucfirst($university->type ?? 'Public') }} University</p>
        </div>
    </div>
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <h5>About University</h5>
            <p>{{ $university->description ?? 'Official details and admission portal for ' . ($university->name ?? 'this university') . '.' }}</p>
            @if(isset($university->official_website))
                <a href="{{ $university->official_website }}" target="_blank" class="btn btn-primary"><i class="fas fa-external-link-alt me-1"></i>Official Website</a>
            @endif
        </div>
    </div>
</div>
@endsection
