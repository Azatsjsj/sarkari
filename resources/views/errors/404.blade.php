<!-- resources/views/errors/404.blade.php -->
@extends('layouts.app')

@section('title', 'Page Not Found - Sarkari Result')
@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="card shadow-sm">
                <div class="card-body py-5">
                    <div class="mb-4">
                        <i class="fas fa-exclamation-triangle fa-5x text-warning mb-4"></i>
                        <h1 class="display-4 text-muted">404</h1>
                        <h2 class="text-muted">Page Not Found</h2>
                    </div>
                    <p class="lead text-muted mb-4">
                        The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.
                    </p>
                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                        <a href="{{ route('home') }}" class="btn btn-primary">
                            <i class="fas fa-home"></i> Go to Homepage
                        </a>
                        <a href="{{ route('jobs') }}" class="btn btn-success">
                            <i class="fas fa-briefcase"></i> Browse Jobs
                        </a>
                        <a href="{{ route('results') }}" class="btn btn-info">
                            <i class="fas fa-chart-bar"></i> Check Results
                        </a>
                        <button onclick="window.history.back()" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Go Back
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection