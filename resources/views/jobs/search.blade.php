<!-- resources/views/jobs/search.blade.php -->
@extends('layouts.app')

@section('title', 'Search Jobs - Sarkari Result')
@section('content')
<div class="container mt-4">
    <!-- Search Header -->
    <div class="card bg-light mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-1">
                        <i class="fas fa-search text-primary"></i> Search Jobs
                    </h2>
                    @if($query)
                    <p class="mb-0 text-muted">
                        Showing results for: <strong>"{{ $query }}"</strong>
                        <span class="badge bg-primary ms-2">{{ $jobs->total() }} results found</span>
                    </p>
                    @endif
                </div>
                <div class="col-md-4">
                    <form action="{{ route('jobs.search') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" 
                                   placeholder="Search jobs..." value="{{ $query }}">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                            <a href="{{ route('jobs') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <!-- Search Results -->
            @if($jobs->count() > 0)
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="text-success">Found Jobs</h4>
                <small class="text-muted">
                    Page {{ $jobs->currentPage() }} of {{ $jobs->lastPage() }}
                </small>
            </div>

            @foreach($jobs as $job)
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h5 class="card-title">
                                <a href="{{ route('job.show', $job->slug) }}" class="text-decoration-none text-success">
                                    {{ $job->title }}
                                </a>
                                @if($job->is_featured)
                                <span class="badge bg-warning text-dark ms-2">Featured</span>
                                @endif
                            </h5>
                            
                            <p class="card-text mb-2">
                                <strong>Category:</strong> 
                                <span class="badge bg-info">{{ $job->category->name }}</span>
                            </p>
                            
                            <p class="card-text mb-2">
                                <strong>Total Posts:</strong> 
                                <span class="badge bg-secondary">{{ $job->total_post ?? 'N/A' }}</span>
                            </p>
                            
                            <p class="card-text mb-2">
                                <strong>Last Date:</strong> 
                                <span class="text-primary">
                                    @php
                                        $lastDate = $job->last_date;
                                        if (is_string($lastDate)) {
                                            $lastDate = \Carbon\Carbon::parse($lastDate);
                                        }
                                    @endphp
                                    {{ $lastDate->format('d M Y') }}
                                </span>
                            </p>
                            
                            <p class="card-text text-muted">
                                {{ Str::limit($job->short_description, 200) }}
                            </p>
                        </div>
                        
                        <div class="col-md-4 text-end">
                            <div class="d-grid gap-2">
                                <a href="{{ route('job.show', $job->slug) }}" class="btn btn-primary btn-lg">
                                    <i class="fas fa-info-circle"></i> View Details
                                </a>
                                
                                <a href="{{ $job->application_link }}" target="_blank" rel="nofollow, noopener, noreferrer" class="btn btn-success">
                                    <i class="fas fa-paper-plane"></i> Apply Now
                                </a>
                                
                                @if($job->notification_pdf)
                                <a href="{{ Storage::url($job->notification_pdf) }}" target="_blank" class="btn btn-outline-info btn-sm">
                                    <i class="fas fa-file-pdf"></i> View PDF
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent">
                    <div class="row">
                        <div class="col-md-6">
                            <small class="text-muted">
                                <i class="fas fa-calendar"></i> 
                                Published: 
                                @php
                                    $createdAt = $job->created_at;
                                    if (is_string($createdAt)) {
                                        $createdAt = \Carbon\Carbon::parse($createdAt);
                                    }
                                @endphp
                                {{ $createdAt->format('d M Y') }}
                            </small>
                        </div>
                        <div class="col-md-6 text-end">
                            <small class="text-muted">
                                <i class="fas fa-eye"></i> 
                                {{ $job->views }} views
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $jobs->appends(['q' => $query])->links() }}
            </div>

            @else
            <!-- No Results Found -->
            <div class="card text-center py-5">
                <div class="card-body">
                    <div class="mb-4">
                        <i class="fas fa-search fa-4x text-muted mb-3"></i>
                        <h3 class="text-muted">No Jobs Found</h3>
                    </div>
                    
                    @if($query)
                    <p class="text-muted mb-4">
                        No jobs found for <strong>"{{ $query }}"</strong>. 
                        Try different keywords or browse all jobs.
                    </p>
                    @else
                    <p class="text-muted mb-4">
                        Please enter a search term to find jobs.
                    </p>
                    @endif

                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <!-- Search Form -->
                            <form action="{{ route('jobs.search') }}" method="GET" class="mb-4">
                                <div class="input-group input-group-lg">
                                    <input type="text" name="q" class="form-control" 
                                           placeholder="Try different keywords..." value="{{ $query }}">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-search"></i> Search
                                    </button>
                                </div>
                            </form>

                            <!-- Quick Links -->
                            <div class="mt-4">
                                <p class="mb-2">Or browse by:</p>
                                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                    <a href="{{ route('jobs') }}" class="btn btn-outline-primary btn-sm">
                                        All Jobs
                                    </a>
                                    <a href="{{ route('home') }}" class="btn btn-outline-success btn-sm">
                                        Home Page
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <!-- Categories -->
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-list"></i> Job Categories
                    </h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        @foreach($categories as $category)
                        <a href="{{ route('category', $category->slug) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            {{ $category->name }}
                            <span class="badge bg-primary rounded-pill">{{ $category->jobs_count }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Search Tips -->
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-lightbulb"></i> Search Tips
                    </h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li><i class="fas fa-check text-success me-2"></i>Use specific job titles</li>
                        <li><i class="fas fa-check text-success me-2"></i>Try different spellings</li>
                        <li><i class="fas fa-check text-success me-2"></i>Search by qualification</li>
                        <li><i class="fas fa-check text-success me-2"></i>Use location names</li>
                        <li><i class="fas fa-check text-success me-2"></i>Try category names</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection