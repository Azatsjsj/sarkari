{{-- resources/views/admin/admit-cards/index.blade.php --}}
@extends('admin.layout')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Admit Cards Management</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.admit-cards.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus"></i> Add New Admit Card
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

<!-- Quick Stats -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h3 class="card-title">{{ $stats['total'] ?? 0 }}</h3>
                        <p class="card-text">Total Admit Cards</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-ticket-alt fa-2x"></i>
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
                        <p class="card-text">Active</p>
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
                        <h3 class="card-title">{{ $stats['upcoming'] ?? 0 }}</h3>
                        <p class="card-text">Upcoming</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-clock fa-2x"></i>
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

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('admin.admit-cards.index') }}" method="GET">
            <div class="row g-3">
                <div class="col-md-3">
                    <label for="search" class="form-label">Search</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           value="{{ request('search') }}" placeholder="Search by title...">
                </div>
                <div class="col-md-3">
                    <label for="job" class="form-label">Job</label>
                    <select class="form-select" id="job" name="job">
                        <option value="">All Jobs</option>
                        @forelse($jobs ?? [] as $job)
                            <option value="{{ $job->id }}" 
                                {{ request('job') == $job->id ? 'selected' : '' }}>
                                {{ Str::limit($job->title, 40) }}
                            </option>
                        @empty
                            <option disabled>No jobs available</option>
                        @endforelse
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="date" class="form-label">Date</label>
                    <select class="form-select" id="date" name="date">
                        <option value="">All Dates</option>
                        <option value="upcoming" {{ request('date') == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                        <option value="past" {{ request('date') == 'past' ? 'selected' : '' }}>Past</option>
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

<!-- Admit Cards Table -->
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th width="50">#</th>
                        <th>Title</th>
                        <th>Job</th>
                        <th>Admit Card Date</th>
                        <th>Exam Date</th>
                        <th>Status</th>
                        <th>Downloads</th>
                        <th width="180">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($admitCards ?? [] as $admitCard)
                    <tr>
                        <td>{{ $loop->iteration + (($admitCards->currentPage() ?? 1) - 1) * ($admitCards->perPage() ?? 10) }}</td>
                        <td>
                            <div class="d-flex align-items-start">
                                <div>
                                    <h6 class="mb-1">{{ Str::limit($admitCard->title, 60) }}</h6>
                                    <small class="text-muted">
                                        <i class="fas fa-link"></i> {{ $admitCard->slug }}
                                    </small>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($admitCard->job)
                                <span class="badge bg-info" title="{{ $admitCard->job->title }}">
                                    {{ Str::limit($admitCard->job->title, 40) }}
                                </span>
                            @else
                                <span class="badge bg-secondary">No Job</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $admitCardDate = safe_carbon($admitCard->admit_card_date);
                            @endphp
                            <small class="{{ is_future_date($admitCardDate) ? 'text-warning' : 'text-muted' }}">
                                <i class="fas fa-calendar me-1"></i>
                                {{ $admitCardDate ? $admitCardDate->format('d M Y') : 'N/A' }}
                            </small>
                            @if(is_future_date($admitCardDate))
                                <br><small class="text-warning">Upcoming</small>
                            @endif
                        </td>
                        <td>
                            @if($admitCard->exam_date)
                                @php
                                    $examDate = $admitCard->exam_date instanceof \Carbon\Carbon 
                                        ? $admitCard->exam_date 
                                        : \Carbon\Carbon::parse($admitCard->exam_date);
                                @endphp
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>
                                    {{ $examDate->format('d M Y') }}
                                </small>
                            @else
                                <small class="text-muted">N/A</small>
                            @endif
                        </td>
                        <td>
                            <span class="badge {{ $admitCard->is_active ? 'bg-success' : 'bg-secondary' }}">
                                <i class="fas {{ $admitCard->is_active ? 'fa-check' : 'fa-times' }} me-1"></i>
                                {{ $admitCard->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark">
                                <i class="fas fa-download"></i> {{ $admitCard->download_count ?? 0 }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ $admitCard->slug ? route('admit-card.show', $admitCard->slug) : route('admit-cards') }}" 
                                   target="_blank" 
                                   class="btn btn-outline-info" 
                                   title="View on Site"
                                   data-bs-toggle="tooltip">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                                
                                <a href="{{ route('admin.admit-cards.edit', $admitCard->id) }}" 
                                   class="btn btn-outline-warning" 
                                   title="Edit"
                                   data-bs-toggle="tooltip">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                <button type="button" 
                                        class="btn {{ $admitCard->is_active ? 'btn-outline-secondary' : 'btn-outline-success' }}"
                                        onclick="toggleAdmitCardStatus({{ $admitCard->id }})"
                                        title="{{ $admitCard->is_active ? 'Deactivate' : 'Activate' }}"
                                        data-bs-toggle="tooltip">
                                    <i class="fas {{ $admitCard->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                                </button>
                                
                                <button type="button" 
                                        class="btn btn-outline-danger" 
                                        onclick="confirmDelete({{ $admitCard->id }})"
                                        title="Delete"
                                        data-bs-toggle="tooltip">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            
                            <!-- Status Toggle Form -->
                            <form id="toggle-form-{{ $admitCard->id }}" 
                                  action="{{ route('admin.admit-cards.updateStatus', $admitCard->id) }}" 
                                  method="POST" 
                                  class="d-none">
                                @csrf
                                @method('PATCH')
                            </form>
                            
                            <!-- Delete Form -->
                            <form id="delete-form-{{ $admitCard->id }}" 
                                  action="{{ route('admin.admit-cards.destroy', $admitCard->id) }}" 
                                  method="POST" 
                                  class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4">
                            <div class="text-muted">
                                <i class="fas fa-inbox fa-3x mb-3"></i>
                                <h5>No Admit Cards Found</h5>
                                <p>Get started by creating your first admit card.</p>
                                <a href="{{ route('admin.admit-cards.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Add New Admit Card
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if(isset($admitCards) && $admitCards->hasPages())
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="text-muted">
                Showing {{ $admitCards->firstItem() }} to {{ $admitCards->lastItem() }} of {{ $admitCards->total() }} entries
            </div>
            <nav>
                {{ $admitCards->appends(request()->query())->links() }}
            </nav>
        </div>
        @endif
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

// Toggle admit card status
function toggleAdmitCardStatus(admitCardId) {
    if (confirm('Are you sure you want to change the status of this admit card?')) {
        document.getElementById('toggle-form-' + admitCardId).submit();
    }
}

// Confirm delete
function confirmDelete(admitCardId) {
    if (confirm('Are you sure you want to delete this admit card? This action cannot be undone.')) {
        document.getElementById('delete-form-' + admitCardId).submit();
    }
}
</script>
@endpush