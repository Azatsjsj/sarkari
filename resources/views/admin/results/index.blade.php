<!-- resources/views/admin/results/index.blade.php -->
@extends('admin.layout')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Results Management</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.results.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus"></i> Add New Result
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('admin.results.index') }}" method="GET">
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="search" class="form-label">Search</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           value="{{ request('search') }}" placeholder="Search by title...">
                </div>
                <div class="col-md-3">
                    <label for="job" class="form-label">Job</label>
                    <select class="form-select" id="job" name="job">
                        <option value="">All Jobs</option>
                        @foreach($jobs as $job)
                            <option value="{{ $job->id }}" 
                                {{ request('job') == $job->id ? 'selected' : '' }}>
                                {{ Str::limit($job->title, 40) }}
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

<!-- Results Table -->
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th width="50">#</th>
                        <th>Title</th>
                        <th>Job</th>
                        <th>Result Date</th>
                        <th>Status</th>
                        <th>Downloads</th>
                        <th width="180">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($results as $result)
                    <tr>
                        <td>{{ $loop->iteration + ($results->currentPage() - 1) * $results->perPage() }}</td>
                        <td>
                            <div class="d-flex align-items-start">
                                <div>
                                    <h6 class="mb-1">{{ Str::limit($result->title, 60) }}</h6>
                                    <small class="text-muted">
                                        <i class="fas fa-link"></i> {{ $result->slug }}
                                    </small>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($result->job)
                                <span class="badge bg-info" title="{{ $result->job->title }}">
                                    {{ Str::limit($result->job->title, 40) }}
                                </span>
                            @else
                                <span class="badge bg-secondary">No Job</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $resultDate = safe_carbon($result->result_date);
                            @endphp
                            <small class="{{ is_future_date($resultDate) ? 'text-warning' : 'text-muted' }}">
                                <i class="fas fa-calendar me-1"></i>
                                {{ $resultDate ? $resultDate->format('d M Y') : 'N/A' }}
                            </small>
                            @if(is_future_date($resultDate))
                                <br><small class="text-warning">Upcoming</small>
                            @endif
                        </td>
                        <td>
                            <span class="badge {{ $result->is_active ? 'bg-success' : 'bg-secondary' }}">
                                <i class="fas {{ $result->is_active ? 'fa-check' : 'fa-times' }} me-1"></i>
                                {{ $result->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark">
                                <i class="fas fa-download"></i> {{ $result->download_count ?? 0 }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('results.show', $result->slug) }}" 
                                   target="_blank" 
                                   class="btn btn-outline-info" 
                                   title="View on Site"
                                   data-bs-toggle="tooltip">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                                
                                <a href="{{ route('admin.results.edit', $result->id) }}" 
                                   class="btn btn-outline-warning" 
                                   title="Edit"
                                   data-bs-toggle="tooltip">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                <button type="button" 
                                        class="btn {{ $result->is_active ? 'btn-outline-secondary' : 'btn-outline-success' }}"
                                        onclick="toggleResultStatus({{ $result->id }})"
                                        title="{{ $result->is_active ? 'Deactivate' : 'Activate' }}"
                                        data-bs-toggle="tooltip">
                                    <i class="fas {{ $result->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                                </button>
                                
                                <button type="button" 
                                        class="btn btn-outline-danger" 
                                        onclick="confirmDelete({{ $result->id }})"
                                        title="Delete"
                                        data-bs-toggle="tooltip">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            
                            <!-- Status Toggle Form -->
                            <form id="toggle-form-{{ $result->id }}" 
                                  action="{{ route('admin.results.updateStatus', $result->id) }}" 
                                  method="POST" 
                                  class="d-none">
                                @csrf
                                @method('PATCH')
                            </form>
                            
                            <!-- Delete Form -->
                            <form id="delete-form-{{ $result->id }}" 
                                  action="{{ route('admin.results.destroy', $result->id) }}" 
                                  method="POST" 
                                  class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <div class="text-muted">
                                <i class="fas fa-inbox fa-3x mb-3"></i>
                                <h5>No Results Found</h5>
                                <p>Get started by creating your first result.</p>
                                <a href="{{ route('admin.results.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Add New Result
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($results->hasPages())
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="text-muted">
                Showing {{ $results->firstItem() }} to {{ $results->lastItem() }} of {{ $results->total() }} entries
            </div>
            <nav>
                {{ $results->appends(request()->query())->links() }}
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
                        <p class="card-text">Total Results</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-file-alt fa-2x"></i>
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
                        <p class="card-text">Active Results</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h3 class="card-title">{{ $stats['upcoming'] ?? 0 }}</h3>
                        <p class="card-text">Upcoming Results</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-clock fa-2x"></i>
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
                        <h3 class="card-title">{{ $stats['recent'] ?? 0 }}</h3>
                        <p class="card-text">Recent (7 days)</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-star fa-2x"></i>
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

// Toggle result status
function toggleResultStatus(resultId) {
    if (confirm('Are you sure you want to change the status of this result?')) {
        document.getElementById('toggle-form-' + resultId).submit();
    }
}

// Confirm delete
function confirmDelete(resultId) {
    if (confirm('Are you sure you want to delete this result? This action cannot be undone.')) {
        document.getElementById('delete-form-' + resultId).submit();
    }
}

// Bulk actions
function handleBulkAction() {
    const selectedIds = getSelectedIds();
    if (selectedIds.length === 0) {
        alert('Please select at least one result.');
        return;
    }

    const action = document.getElementById('bulk-action').value;
    if (!action) {
        alert('Please select an action.');
        return;
    }

    if (confirm(`Are you sure you want to ${action} ${selectedIds.length} result(s)?`)) {
        document.getElementById('bulk-ids').value = JSON.stringify(selectedIds);
        document.getElementById('bulk-action-form').submit();
    }
}

function getSelectedIds() {
    const checkboxes = document.querySelectorAll('.row-checkbox:checked');
    return Array.from(checkboxes).map(cb => cb.value);
}

function toggleSelectAll(checkbox) {
    const checkboxes = document.querySelectorAll('.row-checkbox');
    checkboxes.forEach(cb => cb.checked = checkbox.checked);
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

.text-muted i {
    opacity: 0.7;
}
</style>
@endpush
