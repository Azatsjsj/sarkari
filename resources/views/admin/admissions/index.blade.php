<!-- resources/views/admin/admissions/index.blade.php -->
@extends('admin.layout')

@section('title', 'Manage Admissions - Admin Panel')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-graduation-cap text-primary"></i> Manage Admissions
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.admissions.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Add New Admission
        </a>
    </div>
</div>

<!-- Filters and Search -->
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('admin.admissions.index') }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Search admissions..." 
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                    <option value="featured" {{ request('status') == 'featured' ? 'selected' : '' }}>Featured</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-filter me-1"></i> Filter
                </button>
                <a href="{{ route('admin.admissions.index') }}" class="btn btn-secondary">
                    <i class="fas fa-refresh me-1"></i> Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Bulk Actions -->
<form id="bulk-action-form" method="POST" action="{{ route('admin.admissions.bulk-action') }}">
    @csrf
    <div class="card mb-4">
        <div class="card-header bg-light">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Admissions List</h5>
                <div class="d-flex gap-2">
                    <select name="action" class="form-select form-select-sm" id="bulk-action">
                        <option value="">Bulk Actions</option>
                        <option value="delete">Delete</option>
                        <option value="activate">Activate</option>
                        <option value="deactivate">Deactivate</option>
                        <option value="feature">Feature</option>
                        <option value="unfeature">Unfeature</option>
                    </select>
                    <button type="button" class="btn btn-sm btn-primary" id="apply-bulk-action">
                        Apply
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th width="30">
                                <input type="checkbox" id="select-all">
                            </th>
                            <th>Title</th>
                            <th>University</th>
                            <th>Course</th>
                            <th>Last Date</th>
                            <th>Status</th>
                            <th>Views</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($admissions as $admission)
                        <tr>
                            <td>
                                <input type="checkbox" name="ids[]" value="{{ $admission->id }}" class="row-checkbox">
                            </td>
                            <td>
                                <div>
                                    <strong>{{ Str::limit($admission->title, 50) }}</strong>
                                    @if($admission->is_featured)
                                    <span class="badge bg-warning text-dark ms-1">Featured</span>
                                    @endif
                                </div>
                                <small class="text-muted">{{ $admission->slug }}</small>
                            </td>
                            <td>{{ $admission->university->name ?? 'N/A' }}</td>
                            <td>{{ $admission->course->name ?? 'N/A' }}</td>
                            <td>
                                @if($admission->last_date)
                                    @php
                                        $lastDate = is_string($admission->last_date) ? \Carbon\Carbon::parse($admission->last_date) : $admission->last_date;
                                    @endphp
                                    <span class="{{ $lastDate->isPast() ? 'text-danger' : 'text-success' }}">
                                        {{ $lastDate->format('d M Y') }}
                                    </span>
                                    @if(!$lastDate->isPast())
                                    <br><small class="text-muted">({{ method_exists($admission, 'daysLeft') ? $admission->daysLeft() : $lastDate->diffInDays(now()) }} days left)</small>
                                    @endif
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>
                                @if($admission->is_active)
                                <span class="badge bg-success">Active</span>
                                @else
                                <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td>{{ $admission->views }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admissions.show', $admission->slug) }}" 
                                       class="btn btn-outline-primary" target="_blank" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.admissions.edit', $admission->id) }}" 
                                       class="btn btn-outline-info" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.admissions.toggle-status', $admission->id) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-{{ $admission->is_active ? 'warning' : 'success' }}" 
                                                title="{{ $admission->is_active ? 'Deactivate' : 'Activate' }}">
                                            <i class="fas fa-{{ $admission->is_active ? 'times' : 'check' }}"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.admissions.toggle-featured', $admission->id) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-{{ $admission->is_featured ? 'secondary' : 'warning' }}" 
                                                title="{{ $admission->is_featured ? 'Unfeature' : 'Feature' }}">
                                            <i class="fas fa-star"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.admissions.destroy', $admission->id) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" 
                                                onclick="return confirm('Are you sure?')" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <i class="fas fa-graduation-cap fa-2x text-muted mb-3"></i>
                                <p class="text-muted">No admissions found.</p>
                                <a href="{{ route('admin.admissions.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-1"></i> Create First Admission
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</form>

<!-- Pagination -->
@if($admissions->hasPages())
<div class="d-flex justify-content-center">
    {{ $admissions->links() }}
</div>
@endif
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Bulk actions
    const selectAll = document.getElementById('select-all');
    const rowCheckboxes = document.querySelectorAll('.row-checkbox');
    const bulkActionForm = document.getElementById('bulk-action-form');
    const applyBulkAction = document.getElementById('apply-bulk-action');
    const bulkAction = document.getElementById('bulk-action');

    // Select all functionality
    selectAll.addEventListener('change', function() {
        rowCheckboxes.forEach(checkbox => {
            checkbox.checked = selectAll.checked;
        });
    });

    // Apply bulk action
    applyBulkAction.addEventListener('click', function() {
        const selectedAction = bulkAction.value;
        const selectedItems = document.querySelectorAll('.row-checkbox:checked');
        
        if (!selectedAction) {
            alert('Please select an action');
            return;
        }
        
        if (selectedItems.length === 0) {
            alert('Please select at least one item');
            return;
        }
        
        if (selectedAction === 'delete' && !confirm('Are you sure you want to delete selected admissions?')) {
            return;
        }
        
        bulkActionForm.submit();
    });
});
</script>
@endpush