<!-- resources/views/results/search.blade.php -->
@extends('layouts.app')

@section('title', 'Search Results - Sarkari Result')
@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <!-- Search Header -->
            <div class="card bg-light mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 class="mb-1">
                                <i class="fas fa-search text-primary"></i> Search Results
                            </h2>
                            @if($query)
                            <p class="mb-0 text-muted">
                                Showing results for: <strong>"{{ $query }}"</strong>
                                <span class="badge bg-primary ms-2">{{ $results->total() }} results found</span>
                            </p>
                            @endif
                        </div>
                        <div class="col-md-4">
                            <form action="{{ route('results.search') }}" method="GET">
                                <div class="input-group">
                                    <input type="text" name="q" class="form-control" 
                                           placeholder="Search results..." value="{{ $query }}">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <a href="{{ route('results') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search Results -->
            @if($results->count() > 0)
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-success">Found Results</h4>
                        <small class="text-muted">
                            Page {{ $results->currentPage() }} of {{ $results->lastPage() }}
                        </small>
                    </div>

                    @foreach($results as $result)
                    <div class="card mb-4 shadow-sm result-card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <h5 class="card-title">
                                        <a href="{{ route('results.show', $result->slug) }}" 
                                           class="text-decoration-none text-success">
                                            {!! highlightText($result->title, $query) !!}
                                        </a>
                                    </h5>
                                    
                                    <p class="card-text mb-2">
                                        <strong>Job:</strong> 
                                        <a href="{{ route('job.show', $result->job->slug) }}" 
                                           class="text-decoration-none">
                                            {!! highlightText($result->job->title, $query) !!}
                                        </a>
                                    </p>
                                    
                                    <p class="card-text mb-2">
                                        <strong>Category:</strong> 
                                        <span class="badge bg-info">{{ $result->job->category->name }}</span>
                                    </p>
                                    
                                    <p class="card-text mb-2">
                                        <strong>Result Date:</strong> 
                                        <span class="text-primary">
                                            {{ $result->result_date->format('d M Y') }}
                                        </span>
                                    </p>
                                    
                                    @if($result->description)
                                    <p class="card-text text-muted">
                                        {!! highlightText(Str::limit($result->description, 200), $query) !!}
                                    </p>
                                    @endif
                                </div>
                                
                                <div class="col-md-4 text-end">
                                    <div class="d-grid gap-2">
                                        <a href="{{ $result->result_link }}" 
                                           target="_blank"  rel="nofollow, noopener, noreferrer"
                                           class="btn btn-success btn-lg">
                                            <i class="fas fa-download"></i> View Result
                                        </a>
                                        
                                        @if($result->result_file)
                                        <a href="{{ Storage::url($result->result_file) }}" 
                                           download 
                                           class="btn btn-outline-primary">
                                            <i class="fas fa-file-download"></i> Download PDF
                                        </a>
                                        @endif
                                        
                                        <a href="{{ route('results.show', $result->slug) }}" 
                                           class="btn btn-outline-info">
                                            <i class="fas fa-info-circle"></i> Full Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="row">
                                <div class="col-md-6">
                                    <small class="text-muted">
                                        <i class="fas fa-calendar"></i> 
                                        Published: {{ $result->created_at->format('d M Y') }}
                                    </small>
                                </div>
                                <div class="col-md-6 text-end">
                                    <small class="text-muted">
                                        <i class="fas fa-eye"></i> 
                                        {{ $result->job->views }} views
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $results->appends(['q' => $query])->links() }}
                    </div>
                </div>
            </div>

            @else
            <!-- No Results Found -->
            <div class="row">
                <div class="col-12">
                    <div class="card text-center py-5">
                        <div class="card-body">
                            <div class="mb-4">
                                <i class="fas fa-search fa-4x text-muted mb-3"></i>
                                <h3 class="text-muted">No Results Found</h3>
                            </div>
                            
                            @if($query)
                            <p class="text-muted mb-4">
                                No results found for <strong>"{{ $query }}"</strong>. 
                                Try different keywords or browse all results.
                            </p>
                            @else
                            <p class="text-muted mb-4">
                                Please enter a search term to find results.
                            </p>
                            @endif

                            <div class="row justify-content-center">
                                <div class="col-md-6">
                                    <!-- Search Form -->
                                    <form action="{{ route('results.search') }}" method="GET" class="mb-4">
                                        <div class="input-group input-group-lg">
                                            <input type="text" name="q" class="form-control" 
                                                   placeholder="Try different keywords..." value="{{ $query }}">
                                            <button class="btn btn-primary" type="submit">
                                                <i class="fas fa-search"></i> Search
                                            </button>
                                        </div>
                                    </form>

                                    <!-- Suggestions -->
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0">Search Tips</h6>
                                        </div>
                                        <div class="card-body text-start">
                                            <ul class="list-unstyled mb-0">
                                                <li><i class="fas fa-check text-success me-2"></i>Check your spelling</li>
                                                <li><i class="fas fa-check text-success me-2"></i>Try more general keywords</li>
                                                <li><i class="fas fa-check text-success me-2"></i>Use job titles or categories</li>
                                                <li><i class="fas fa-check text-success me-2"></i>Search by organization name</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <!-- Quick Links -->
                                    <div class="mt-4">
                                        <p class="mb-2">Or browse by:</p>
                                        <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                            <a href="{{ route('results') }}" class="btn btn-outline-primary btn-sm">
                                                All Results
                                            </a>
                                            <a href="{{ route('jobs') }}" class="btn btn-outline-success btn-sm">
                                                Latest Jobs
                                            </a>
                                            <a href="{{ route('home') }}" class="btn btn-outline-info btn-sm">
                                                Home Page
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Related Searches -->
            @if($results->count() > 0)
            <div class="row mt-5">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">
                                <i class="fas fa-lightbulb"></i> Related Searches
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Popular Job Categories:</h6>
                                    <div class="d-flex flex-wrap gap-2">
                                        <a href="{{ route('results.search') }}?q=SSC" 
                                           class="btn btn-outline-primary btn-sm">SSC</a>
                                        <a href="{{ route('results.search') }}?q=Bank" 
                                           class="btn btn-outline-primary btn-sm">Bank</a>
                                        <a href="{{ route('results.search') }}?q=RRB" 
                                           class="btn btn-outline-primary btn-sm">RRB</a>
                                        <a href="{{ route('results.search') }}?q=UPSC" 
                                           class="btn btn-outline-primary btn-sm">UPSC</a>
                                        <a href="{{ route('results.search') }}?q=Teacher" 
                                           class="btn btn-outline-primary btn-sm">Teacher</a>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h6>Search by Organization:</h6>
                                    <div class="d-flex flex-wrap gap-2">
                                        <a href="{{ route('results.search') }}?q=State%20Government" 
                                           class="btn btn-outline-success btn-sm">State Government</a>
                                        <a href="{{ route('results.search') }}?q=Central%20Government" 
                                           class="btn btn-outline-success btn-sm">Central Government</a>
                                        <a href="{{ route('results.search') }}?q=University" 
                                           class="btn btn-outline-success btn-sm">University</a>
                                        <a href="{{ route('results.search') }}?q=Public%20Sector" 
                                           class="btn btn-outline-success btn-sm">Public Sector</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
.result-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    border-left: 4px solid #28a745;
}

.result-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.highlight {
    background-color: #fff3cd;
    padding: 0.1em 0.2em;
    border-radius: 3px;
    font-weight: bold;
}
</style>
@endsection
