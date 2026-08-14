<!-- resources/views/admin/jobs/index.blade.php -->
@extends('admin.layout')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Jobs Management</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.jobs.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus"></i> Add New Job
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('admin.jobs.index') }}" method="GET">
            <div class="row">
                <div class="col-md-4">
                    <label for="search" class="form-label">Search</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           value="{{ request('search') }}" placeholder="Search by title...">
                </div>
                <div class="col-md-3">
                    <label for="category" class="form-label">Category</label>
                    <select class="form-select" id="category" name="category">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" 
                                {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="featured" {{ request('status') == 'featured' ? 'selected' : '' }}>Featured</option>
                        <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Jobs Table -->
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th width="50">#</th>
                        <th>Job Title</th>
                        <th>Category</th>
                        <th>Start Date</th>
                        <th>Last Date</th>
                        <th>Total Posts</th>
                        <th>Status</th>
                        <th>Views</th>
                        <th width="180">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jobs as $job)
                    <tr>
                        <td>{{ $loop->iteration + ($jobs->currentPage() - 1) * $jobs->perPage() }}</td>
                        <td>
                            <div class="d-flex align-items-start">
                                <div>
                                    <h6 class="mb-1">{{ Str::limit($job->title, 50) }}</h6>
                                    @if($job->is_featured)
                                    <span class="badge bg-warning text-dark">
                                        <i class="fas fa-star"></i> Featured
                                    </span>
                                    @endif
                                    @if($job->last_date < now())
                                    <span class="badge bg-danger">
                                        <i class="fas fa-clock"></i> Expired
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-info">{{ $job->category->name ?? 'N/A' }}</span>
                        </td>
                        <td>
                            <small class="text-muted">
                                {{ $job->start_date->format('d M Y') }}
                            </small>
                        </td>
                        <td>
                            <small class="{{ $job->last_date < now() ? 'text-danger' : 'text-success' }}">
                                {{ $job->last_date->format('d M Y') }}
                            </small>
                        </td>
                        <td>
                            <span class="badge bg-secondary">{{ $job->total_post ?? 'N/A' }}</span>
                        </td>
                        <td>
                            <span class="badge {{ $job->is_active ? 'bg-success' : 'bg-secondary' }}">
                                {{ $job->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark">
                                <i class="fas fa-eye"></i> {{ $job->views ?? 0 }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('job.show', $job->slug) }}" 
                                   target="_blank" 
                                   class="btn btn-outline-info" 
                                   title="View on Site"
                                   data-bs-toggle="tooltip">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                                
                                <a href="{{ route('admin.jobs.edit', $job->id) }}" 
                                   class="btn btn-outline-warning" 
                                   title="Edit"
                                   data-bs-toggle="tooltip">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                <button type="button" 
                                        class="btn {{ $job->is_active ? 'btn-outline-secondary' : 'btn-outline-success' }}"
                                        onclick="toggleJobStatus({{ $job->id }})"
                                        title="{{ $job->is_active ? 'Deactivate' : 'Activate' }}"
                                        data-bs-toggle="tooltip">
                                    <i class="fas {{ $job->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                                </button>
                                
                                <button type="button" 
                                        class="btn btn-outline-danger" 
                                        onclick="confirmDelete({{ $job->id }})"
                                        title="Delete"
                                        data-bs-toggle="tooltip">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            
                            <!-- Status Toggle Form -->
                            <form id="toggle-form-{{ $job->id }}" 
                                  action="{{ route('admin.jobs.updateStatus', $job->id) }}" 
                                  method="POST" 
                                  class="d-none">
                                @csrf
                                @method('PATCH')
                            </form>
                            
                            <!-- Delete Form -->
                            <form id="delete-form-{{ $job->id }}" 
                                  action="{{ route('admin.jobs.destroy', $job->id) }}" 
                                  method="POST" 
                                  class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-4">
                            <div class="text-muted">
                                <i class="fas fa-inbox fa-3x mb-3"></i>
                                <h5>No Jobs Found</h5>
                                <p>Get started by creating your first job posting.</p>
                                <a href="{{ route('admin.jobs.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Add New Job
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($jobs->hasPages())
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="text-muted">
                Showing {{ $jobs->firstItem() }} to {{ $jobs->lastItem() }} of {{ $jobs->total() }} entries
            </div>
            <nav>
                {{ $jobs->appends(request()->query())->links() }}
            </nav>
        </div>
        @endif
    </div>
</div>

<!-- Quick Stats -->
<div class="row mt-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h3 class="card-title">{{ $stats['total'] ?? 0 }}</h3>
                        <p class="card-text">Total Jobs</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-briefcase fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h3 class="card-title">{{ $stats['active'] ?? 0 }}</h3>
                        <p class="card-text">Active Jobs</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-dark">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h3 class="card-title">{{ $stats['featured'] ?? 0 }}</h3>
                        <p class="card-text">Featured Jobs</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-star fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h3 class="card-title">{{ $stats['expired'] ?? 0 }}</h3>
                        <p class="card-text">Expired Jobs</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-clock fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
});

// Toggle job status
function toggleJobStatus(jobId) {
    if (confirm('Are you sure you want to change the status of this job?')) {
        document.getElementById('toggle-form-' + jobId).submit();
    }
}

// Confirm delete
function confirmDelete(jobId) {
    if (confirm('Are you sure you want to delete this job? This action cannot be undone.')) {
        document.getElementById('delete-form-' + jobId).submit();
    }
}
</script>

<style>
.table th {
    border-top: none;
    font-weight: 600;
}

.badge {
    font-size: 0.75em;
}

.btn-group .btn {
    border-radius: 0.375rem;
    margin-right: 2px;
}

.card {
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.card .card-body {
    padding: 1.25rem;
}
</style>
@endpush