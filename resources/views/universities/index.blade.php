<!-- resources/views/universities/index.blade.php -->
@extends('layouts.app')

@section('title', 'Universities - Browse Top Universities & Colleges')
@section('meta_description', 'Explore top universities and colleges. Find detailed information about courses, admissions, fees, rankings, and facilities.')

@section('content')
<div class="container mt-4">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-primary text-white shadow-lg overflow-hidden">
                <div class="card-body py-4 position-relative">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h1 class="display-6 fw-bold mb-3">
                                <i class="fas fa-university me-2"></i>Universities & Colleges
                            </h1>
                            <p class="lead mb-0">
                                Discover top universities, explore courses, and find the perfect institution for your future
                            </p>
                        </div>
                        <div class="col-md-4 text-center">
                            <i class="fas fa-graduation-cap fa-7x text-white-50"></i>
                        </div>
                    </div>
                </div>
                <!-- Stats Bar -->
                <div class="card-footer bg-white py-3">
                    <div class="row text-center">
                        <div class="col-md-3 col-6 border-end">
                            <h4 class="mb-0 text-primary fw-bold">{{ $totalUniversities }}</h4>
                            <small class="text-muted">Total Universities</small>
                        </div>
                        <div class="col-md-3 col-6 border-end">
                            <h4 class="mb-0 text-success fw-bold">{{ $publicUniversities }}</h4>
                            <small class="text-muted">Public Universities</small>
                        </div>
                        <div class="col-md-3 col-6 border-end">
                            <h4 class="mb-0 text-info fw-bold">{{ $privateUniversities }}</h4>
                            <small class="text-muted">Private Universities</small>
                        </div>
                        <div class="col-md-3 col-6">
                            <h4 class="mb-0 text-warning fw-bold">{{ $featuredUniversities }}</h4>
                            <small class="text-muted">Featured</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('universities.index') }}" method="GET" class="row g-3">
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white">
                                    <i class="fas fa-search"></i>
                                </span>
                                <input type="text" name="search" class="form-control" 
                                       placeholder="Search universities..." 
                                       value="{{ request('search') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select name="type" class="form-select">
                                <option value="">All Types</option>
                                <option value="public" {{ request('type') == 'public' ? 'selected' : '' }}>Public</option>
                                <option value="private" {{ request('type') == 'private' ? 'selected' : '' }}>Private</option>
                                <option value="deemed" {{ request('type') == 'deemed' ? 'selected' : '' }}>Deemed University</option>
                                <option value="state" {{ request('type') == 'state' ? 'selected' : '' }}>State University</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="state" class="form-select">
                                <option value="">All States</option>
                                @foreach($states as $state)
                                <option value="{{ $state }}" {{ request('state') == $state ? 'selected' : '' }}>
                                    {{ $state }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-filter me-1"></i>Filter
                            </button>
                        </div>
                    </form>
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="d-flex flex-wrap gap-2 justify-content-center">
                                <a href="{{ route('universities.index') }}" class="btn btn-outline-primary btn-sm">
                                    All Universities
                                </a>
                                <a href="{{ route('universities.featured') }}" class="btn btn-outline-warning btn-sm">
                                    <i class="fas fa-star me-1"></i>Featured
                                </a>
                                <a href="{{ route('universities.public') }}" class="btn btn-outline-success btn-sm">
                                    Public Universities
                                </a>
                                <a href="{{ route('universities.private') }}" class="btn btn-outline-info btn-sm">
                                    Private Universities
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Universities Section -->
    @if($featuredUniversitiesList->count() > 0)
    <div class="row mb-5">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="text-primary">
                    <i class="fas fa-star me-2"></i>Featured Universities
                </h3>
                <a href="{{ route('universities.featured') }}" class="btn btn-outline-primary btn-sm">
                    View All <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="row">
                @foreach($featuredUniversitiesList as $university)
                <div class="col-lg-4 col-md-6 mb-4">
                    @include('universities.partials.card', ['university' => $university, 'featured' => true])
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- All Universities Section -->
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="text-primary">
                    <i class="fas fa-list me-2"></i>All Universities
                    <span class="badge bg-primary ms-2">{{ $universities->total() }}</span>
                </h3>
                <div class="d-flex gap-2">
                    <select id="sortSelect" class="form-select form-select-sm" onchange="window.location.href = this.value">
                        <option value="{{ route('universities.index', array_merge(request()->query(), ['sort' => 'name'])) }}" 
                                {{ request('sort') == 'name' ? 'selected' : '' }}>Sort by Name</option>
                        <option value="{{ route('universities.index', array_merge(request()->query(), ['sort' => 'latest'])) }}" 
                                {{ !request('sort') || request('sort') == 'latest' ? 'selected' : '' }}>Sort by Latest</option>
                        <option value="{{ route('universities.index', array_merge(request()->query(), ['sort' => 'rank'])) }}" 
                                {{ request('sort') == 'rank' ? 'selected' : '' }}>Sort by Rank</option>
                        <option value="{{ route('universities.index', array_merge(request()->query(), ['sort' => 'established'])) }}" 
                                {{ request('sort') == 'established' ? 'selected' : '' }}>Sort by Established</option>
                    </select>
                </div>
            </div>

            @if($universities->count() > 0)
            <div class="row">
                @foreach($universities as $university)
                <div class="col-lg-4 col-md-6 mb-4">
                    @include('universities.partials.card', ['university' => $university])
                </div>
                @endforeach
            </div>
            @else
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-university fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">No Universities Found</h4>
                    <p class="text-muted mb-3">We couldn't find any universities matching your criteria.</p>
                    <div class="d-flex justify-content-center gap-2">
                        <a href="{{ route('universities.index') }}" class="btn btn-primary">
                            <i class="fas fa-refresh me-1"></i>Show All Universities
                        </a>
                        <a href="{{ route('admissions') }}" class="btn btn-outline-primary">
                            <i class="fas fa-graduation-cap me-1"></i>Browse Admissions
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Pagination -->
    @if($universities->hasPages())
    <div class="row mt-4">
        <div class="col-12">
            <div class="d-flex justify-content-center">
                {{ $universities->links() }}
            </div>
        </div>
    </div>
    @endif

    <!-- Call to Action -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card bg-light border-0">
                <div class="card-body text-center py-4">
                    <h4 class="mb-3">Looking for Specific Information?</h4>
                    <p class="text-muted mb-3">Can't find what you're looking for? Contact us for personalized assistance.</p>
                    <div class="d-flex justify-content-center gap-2 flex-wrap">
                        <a href="{{ route('contact') }}" class="btn btn-primary">
                            <i class="fas fa-envelope me-1"></i>Contact Us
                        </a>
                        <a href="{{ route('admissions') }}" class="btn btn-outline-primary">
                            <i class="fas fa-graduation-cap me-1"></i>View Admissions
                        </a>
                        <a href="{{ route('courses.index') }}" class="btn btn-outline-info">
                            <i class="fas fa-book me-1"></i>Browse Courses
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.university-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    border: 1px solid #e9ecef;
    height: 100%;
}

.university-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
}

.university-logo {
    width: 60px;
    height: 60px;
    object-fit: contain;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    padding: 4px;
    background: white;
}

.featured-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    z-index: 2;
}

.card-img-top-container {
    height: 140px;
    overflow: hidden;
    position: relative;
}

.card-img-top-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.established-badge {
    background: rgba(0, 0, 0, 0.7);
    color: white;
    padding: 2px 8px;
    border-radius: 4px;
    font-size: 0.75rem;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .display-6 {
        font-size: 1.5rem;
    }
    
    .fa-7x {
        font-size: 4em;
    }
    
    .university-logo {
        width: 50px;
        height: 50px;
    }
    
    .card-img-top-container {
        height: 120px;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add animation to cards when they come into view
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    // Observe all university cards
    document.querySelectorAll('.university-card').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        observer.observe(card);
    });
});
</script>
@endpush