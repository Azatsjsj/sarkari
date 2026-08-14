@extends('layouts.app')

@section('title', 'Sitemap - Sarkari Result 2026')
@section('content')
<div class="container py-4">
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body bg-dark text-white rounded">
            <h2><i class="fas fa-sitemap me-2"></i>Website Sitemap</h2>
            <p class="mb-0">Complete sitemap directory of all sections on SarkariResult.mobi.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-header bg-primary text-white font-weight-bold">Quick Navigation</div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><a href="{{ route('home') }}" class="text-decoration-none"><i class="fas fa-home me-2"></i>Home</a></li>
                        <li class="mb-2"><a href="{{ route('home') }}" class="text-decoration-none"><i class="fas fa-briefcase me-2"></i>Latest Jobs</a></li>
                        <li class="mb-2"><a href="{{ route('admit-cards') }}" class="text-decoration-none"><i class="fas fa-ticket-alt me-2"></i>Admit Cards</a></li>
                        <li class="mb-2"><a href="{{ route('results') }}" class="text-decoration-none"><i class="fas fa-chart-bar me-2"></i>Results</a></li>
                        <li class="mb-2"><a href="{{ route('answer-keys') }}" class="text-decoration-none"><i class="fas fa-key me-2"></i>Answer Keys</a></li>
                        <li class="mb-2"><a href="{{ route('admissions') }}" class="text-decoration-none"><i class="fas fa-graduation-cap me-2"></i>Admissions</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
