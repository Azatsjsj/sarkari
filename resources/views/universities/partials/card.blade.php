<!-- resources/views/universities/partials/card.blade.php -->
<div class="card university-card h-100 shadow-sm">
    @if($university->is_featured && ($featured ?? false))
    <div class="featured-badge">
        <span class="badge bg-warning text-dark">
            <i class="fas fa-star me-1"></i>Featured
        </span>
    </div>
    @endif

    <!-- University Image -->
    @if($university->cover_image)
    <div class="card-img-top-container">
        <img src="{{ asset('storage/' . $university->cover_image) }}" 
             alt="{{ $university->name }}" 
             class="card-img-top">
        <div class="position-absolute top-0 start-0 m-2">
            <span class="established-badge">
                Est. {{ $university->established_year }}
            </span>
        </div>
    </div>
    @endif

    <div class="card-body">
        <div class="d-flex align-items-start mb-3">
            @if($university->logo)
            <img src="{{ asset('storage/' . $university->logo) }}" 
                 alt="{{ $university->name }} Logo" 
                 class="university-logo me-3 flex-shrink-0">
            @else
            <div class="university-logo me-3 flex-shrink-0 bg-light d-flex align-items-center justify-content-center">
                <i class="fas fa-university text-muted"></i>
            </div>
            @endif
            <div class="flex-grow-1">
                <h5 class="card-title mb-1">
                    <a href="{{ route('universities.show', $university->slug) }}" 
                       class="text-decoration-none text-dark stretched-link">
                        {{ $university->name }}
                    </a>
                </h5>
                <p class="text-muted small mb-1">
                    <i class="fas fa-map-marker-alt me-1"></i>
                    {{ $university->city }}, {{ $university->state }}
                </p>
                <span class="badge bg-{{ $university->type == 'public' ? 'success' : 'info' }} small">
                    {{ ucfirst($university->type) }} University
                </span>
                @if($university->is_featured && !($featured ?? false))
                <span class="badge bg-warning text-dark small ms-1">
                    <i class="fas fa-star me-1"></i>Featured
                </span>
                @endif
            </div>
        </div>

        <!-- University Stats -->
        <div class="row text-center g-2 mb-3">
            <div class="col-4">
                <div class="border rounded p-2">
                    <h6 class="mb-0 text-primary fw-bold">{{ $university->courses_count ?? 0 }}</h6>
                    <small class="text-muted">Courses</small>
                </div>
            </div>
            <div class="col-4">
                <div class="border rounded p-2">
                    <h6 class="mb-0 text-success fw-bold">{{ $university->admissions_count ?? 0 }}</h6>
                    <small class="text-muted">Admissions</small>
                </div>
            </div>
            <div class="col-4">
                <div class="border rounded p-2">
                    <h6 class="mb-0 text-info fw-bold">
                        @if($university->naac_grade)
                        {{ $university->naac_grade }}
                        @else
                        -
                        @endif
                    </h6>
                    <small class="text-muted">NAAC Grade</small>
                </div>
            </div>
        </div>

        <!-- Short Description -->
        @if($university->short_description)
        <p class="card-text text-muted small">
            {{ Str::limit($university->short_description, 100) }}
        </p>
        @endif

        <!-- Highlights -->
        @if($university->highlight1 || $university->highlight2)
        <div class="mt-2">
            <small class="text-muted">
                @if($university->highlight1)
                <i class="fas fa-check text-success me-1"></i>{{ $university->highlight1 }}<br>
                @endif
                @if($university->highlight2)
                <i class="fas fa-check text-success me-1"></i>{{ $university->highlight2 }}
                @endif
            </small>
        </div>
        @endif
    </div>

    <div class="card-footer bg-transparent">
        <div class="d-flex justify-content-between align-items-center">
            <small class="text-muted">
                <i class="fas fa-eye me-1"></i>{{ $university->views ?? 0 }} views
            </small>
            <div class="d-flex gap-1">
                @if($university->website)
                <a href="{{ $university->website }}" target="_blank" 
                   class="btn btn-outline-primary btn-sm" 
                   data-bs-toggle="tooltip" title="Visit Website">
                    <i class="fas fa-external-link-alt"></i>
                </a>
                @endif
                <a href="{{ route('universities.show', $university->slug) }}" 
                   class="btn btn-primary btn-sm">
                    View Details
                </a>
            </div>
        </div>
    </div>
</div>