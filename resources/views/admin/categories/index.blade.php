<!-- resources/views/admin/categories/index.blade.php -->
@extends('admin.layout')

@section('content')

@php
    // Detect whether $categories is a paginator
    $isPaginated = $categories instanceof \Illuminate\Contracts\Pagination\Paginator
                || $categories instanceof \Illuminate\Pagination\LengthAwarePaginator
                || method_exists($categories, 'currentPage');
@endphp

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Categories Management</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <a href="{{ route('admin.categories.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus"></i> Add New Category
            </a>
            <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#importModal">
                <i class="fas fa-upload"></i> Import
            </button>
            <a href="{{ route('admin.categories.export') }}" class="btn btn-sm btn-outline-success">
                <i class="fas fa-download"></i> Export
            </a>
        </div>
    </div>
</div>

<!-- Flash Messages -->
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

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <strong>Please fix the following errors:</strong>
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Quick Stats -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card bg-primary text-white shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h3 class="card-title">{{ $stats['total'] ?? 0 }}</h3>
                        <p class="card-text">Total Categories</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-layer-group fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card bg-success text-white shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h3 class="card-title">{{ $stats['active'] ?? 0 }}</h3>
                        <p class="card-text">Active Categories</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-check-circle fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card bg-warning text-dark shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h3 class="card-title">{{ $stats['with_jobs'] ?? 0 }}</h3>
                        <p class="card-text">Categories with Jobs</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-briefcase fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card bg-info text-white shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h3 class="card-title">{{ $stats['total_jobs'] ?? 0 }}</h3>
                        <p class="card-text">Total Jobs</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-file-alt fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filters and Search -->
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form action="{{ route('admin.categories.index') }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <label for="search" class="form-label">Search Categories</label>
                <input type="text" name="search" class="form-control" 
                       placeholder="Search by name or description..." 
                       value="{{ request('search') }}"
                       id="search">
            </div>
            <div class="col-md-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" class="form-select" id="status">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="sort" class="form-label">Sort By</label>
                <select name="sort" class="form-select" id="sort">
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest First</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                    <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name A-Z</option>
                    <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name Z-A</option>
                    <option value="jobs_asc" {{ request('sort') == 'jobs_asc' ? 'selected' : '' }}>Jobs (Low to High)</option>
                    <option value="jobs_desc" {{ request('sort') == 'jobs_desc' ? 'selected' : '' }}>Jobs (High to Low)</option>
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <div class="d-grid gap-2 w-100">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter"></i> Apply
                    </button>
                    @if(request()->hasAny(['search', 'status', 'sort']))
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i> Clear
                    </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Categories Table -->
<div class="card shadow-sm">
    <div class="card-header bg-dark text-white">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h5 class="mb-0">
                    <i class="fas fa-list me-2"></i> All Categories
                    @if(request()->hasAny(['search', 'status']))
                    <small class="text-warning">(Filtered Results)</small>
                    @endif
                </h5>
            </div>
            <div class="col-md-6 text-end">
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-outline-light" onclick="selectAllRows()">
                        <i class="fas fa-check-square"></i> Select All
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-light" onclick="clearSelection()">
                        <i class="fas fa-times-circle"></i> Clear
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="50" class="text-center">
                            <input type="checkbox" id="select-all" onchange="toggleSelectAll(this)">
                        </th>
                        <th width="60" class="text-center">#</th>
                        <th>Category Name</th>
                        <th>Slug</th>
                        <th>Description</th>
                        <th class="text-center">Jobs Count</th>
                        <th class="text-center">Status</th>
                        <th width="180" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr>
                        <td class="text-center">
                            <input type="checkbox" class="row-selector" value="{{ $category->id }}" 
                                   onchange="updateBulkActions()">
                        </td>
                        <td class="text-center">
                            <strong>
                                {{ $loop->iteration + ($isPaginated ? ($categories->currentPage() - 1) * $categories->perPage() : 0) }}
                            </strong>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="category-icon me-3">
                                    <i class="fas fa-folder text-primary fa-lg"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">{{ $category->name }}</h6>
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>
                                        {{ $category->created_at->format('M d, Y') }}
                                        @if($category->updated_at->gt($category->created_at))
                                        <br><i class="fas fa-edit me-1"></i>
                                        Updated: {{ $category->updated_at->format('M d, Y') }}
                                        @endif
                                    </small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <code class="text-muted bg-light p-1 rounded">{{ $category->slug }}</code>
                        </td>
                        <td>
                            @if($category->description)
                                <span class="text-truncate d-inline-block" style="max-width: 200px;" 
                                      data-bs-toggle="tooltip" title="{{ $category->description }}">
                                    {{ Str::limit($category->description, 50) }}
                                </span>
                            @else
                                <span class="text-muted">No description</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <span class="badge bg-primary rounded-pill fs-6 px-3 py-2">
                                {{ $category->jobs_count ?? 0 }}
                            </span>
                            @if($category->jobs_count > 0)
                            <br>
                            <small class="text-muted">
                                <a href="{{ route('admin.jobs.index', ['category' => $category->id]) }}" 
                                   class="text-decoration-none">
                                    View Jobs
                                </a>
                            </small>
                            @endif
                        </td>
                        <td class="text-center">
                            <span class="badge {{ $category->is_active ? 'bg-success' : 'bg-secondary' }}">
                                <i class="fas {{ $category->is_active ? 'fa-check' : 'fa-times' }} me-1"></i>
                                {{ $category->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('category', $category->slug) }}" 
                                   target="_blank" 
                                   class="btn btn-outline-info" 
                                   title="View on Site"
                                   data-bs-toggle="tooltip">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                                
                                <a href="{{ route('admin.categories.edit', $category->id) }}" 
                                   class="btn btn-outline-warning" 
                                   title="Edit"
                                   data-bs-toggle="tooltip">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                <button type="button" 
                                        class="btn {{ $category->is_active ? 'btn-outline-secondary' : 'btn-outline-success' }}"
                                        onclick="toggleCategoryStatus({{ $category->id }})"
                                        title="{{ $category->is_active ? 'Deactivate' : 'Activate' }}"
                                        data-bs-toggle="tooltip">
                                    <i class="fas {{ $category->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                                </button>
                                
                                <button type="button" 
                                        class="btn btn-outline-danger" 
                                        onclick="confirmDelete({{ $category->id }}, '{{ addslashes($category->name) }}')"
                                        title="Delete"
                                        data-bs-toggle="tooltip"
                                        {{ $category->jobs_count > 0 ? 'disabled' : '' }}>
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            
                            @if($category->jobs_count > 0)
                            <small class="text-danger d-block mt-1">
                                <i class="fas fa-exclamation-triangle me-1"></i>Has {{ $category->jobs_count }} jobs
                            </small>
                            @endif
                            
                            <!-- Status Toggle Form -->
                            <form id="toggle-form-{{ $category->id }}" 
                                  action="{{ route('admin.categories.updateStatus', $category->id) }}" 
                                  method="POST" 
                                  class="d-none">
                                @csrf
                                @method('PATCH')
                            </form>
                            
                            <!-- Delete Form -->
                            <form id="delete-form-{{ $category->id }}" 
                                  action="{{ route('admin.categories.destroy', $category->id) }}" 
                                  method="POST" 
                                  class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <div class="text-muted">
                                <i class="fas fa-inbox fa-3x mb-3"></i>
                                <h5>No Categories Found</h5>
                                <p class="mb-3">
                                    @if(request()->hasAny(['search', 'status']))
                                    No categories match your search criteria. Try different filters.
                                    @else
                                    Get started by creating your first category.
                                    @endif
                                </p>
                                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Add New Category
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bulk Actions and Pagination -->
    @if($categories->count() > 0)
    <div class="card-footer">
        <div class="row align-items-center">
            <div class="col-md-6">
                <!-- Bulk Actions -->
                <div class="bulk-actions d-none" id="bulkActions">
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="bulkAction('activate')">
                            <i class="fas fa-toggle-on"></i> Activate
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="bulkAction('deactivate')">
                            <i class="fas fa-toggle-off"></i> Deactivate
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="bulkAction('delete')">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </div>
                    <span class="ms-2 text-muted" id="selectedCount">0 categories selected</span>
                </div>
            </div>
            <div class="col-md-6">
                <!-- Pagination -->
                @if($isPaginated && $categories->hasPages())
                <nav class="d-flex justify-content-end">
                    <div class="d-flex align-items-center">
                        <span class="text-muted me-3">
                            Showing {{ $categories->firstItem() }} to {{ $categories->lastItem() }} of {{ $categories->total() }} entries
                        </span>
                        {{ $categories->appends(request()->query())->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </nav>
                @elseif(!$isPaginated)
                <div class="text-end text-muted">
                    Showing all {{ $categories->count() }} categories
                </div>
                @endif
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">
                    <i class="fas fa-upload me-2"></i>Import Categories
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.categories.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="importFile" class="form-label">Select CSV File</label>
                        <input type="file" class="form-control" id="importFile" name="file" accept=".csv" required>
                        <div class="form-text">
                            Download the <a href="{{ asset('templates/categories-template.csv') }}">template file</a> for reference.
                            File should contain: name, description, is_active columns.
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Import Categories</button>
                </div>
            </form>
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

// Toggle category status
function toggleCategoryStatus(categoryId) {
    if (confirm('Are you sure you want to change the status of this category?')) {
        document.getElementById('toggle-form-' + categoryId).submit();
    }
}

// Confirm delete with category name
function confirmDelete(categoryId, categoryName) {
    const categoryElement = document.querySelector(`[onclick="confirmDelete(${categoryId}, '${categoryName}')"]`);
    if (categoryElement && categoryElement.disabled) {
        alert('This category cannot be deleted because it has associated jobs. Please remove all jobs first.');
        return;
    }

    if (confirm(`Are you sure you want to delete the category "${categoryName}"? This action cannot be undone.`)) {
        document.getElementById('delete-form-' + categoryId).submit();
    }
}

// Bulk selection functionality
function toggleSelectAll(checkbox) {
    const selectors = document.querySelectorAll('.row-selector');
    selectors.forEach(selector => {
        selector.checked = checkbox.checked;
    });
    updateBulkActions();
}

function selectAllRows() {
    document.getElementById('select-all').checked = true;
    toggleSelectAll(document.getElementById('select-all'));
}

function clearSelection() {
    document.getElementById('select-all').checked = false;
    toggleSelectAll(document.getElementById('select-all'));
}

function updateBulkActions() {
    const selected = document.querySelectorAll('.row-selector:checked');
    const bulkActions = document.getElementById('bulkActions');
    const selectedCount = document.getElementById('selectedCount');
    
    if (selected.length > 0) {
        bulkActions.classList.remove('d-none');
        selectedCount.textContent = `${selected.length} categor${selected.length === 1 ? 'y' : 'ies'} selected`;
    } else {
        bulkActions.classList.add('d-none');
    }
    
    // Update select all checkbox
    const total = document.querySelectorAll('.row-selector').length;
    document.getElementById('select-all').checked = selected.length === total && total > 0;
    document.getElementById('select-all').indeterminate = selected.length > 0 && selected.length < total;
}

function bulkAction(action) {
    const selected = Array.from(document.querySelectorAll('.row-selector:checked'))
        .map(checkbox => checkbox.value);
    
    if (selected.length === 0) {
        alert('Please select at least one category.');
        return;
    }

    let message = '';
    let formAction = '';
    
    switch (action) {
        case 'activate':
            message = `Are you sure you want to activate ${selected.length} categor${selected.length === 1 ? 'y' : 'ies'}?`;
            formAction = "{{ route('admin.categories.bulk-activate') }}";
            break;
        case 'deactivate':
            message = `Are you sure you want to deactivate ${selected.length} categor${selected.length === 1 ? 'y' : 'ies'}?`;
            formAction = "{{ route('admin.categories.bulk-deactivate') }}";
            break;
        case 'delete':
            message = `Are you sure you want to delete ${selected.length} categor${selected.length === 1 ? 'y' : 'ies'}? This action cannot be undone.`;
            formAction = "{{ route('admin.categories.bulk-delete') }}";
            break;
    }

    if (confirm(message)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = formAction;
        
        const csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = '{{ csrf_token() }}';
        form.appendChild(csrf);

        if (action === 'delete') {
            const method = document.createElement('input');
            method.type = 'hidden';
            method.name = '_method';
            method.value = 'DELETE';
            form.appendChild(method);
        }

        selected.forEach(id => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'ids[]';
            input.value = id;
            form.appendChild(input);
        });

        document.body.appendChild(form);
        form.submit();
    }
}

// Quick search functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search');
    if (searchInput) {
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                if (this.value.length >= 2 || this.value.length === 0) {
                    this.form.submit();
                }
            }, 500);
        });
    }
});

// Auto-submit sort and filter changes
document.getElementById('status')?.addEventListener('change', function() {
    this.form.submit();
});

document.getElementById('sort')?.addEventListener('change', function() {
    this.form.submit();
});
</script>

<style>
.category-icon {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8f9fa;
    border-radius: 8px;
    border: 1px solid #e9ecef;
}

.table tbody tr:hover {
    background-color: rgba(0, 123, 255, 0.04) !important;
}

.badge {
    font-size: 0.75em;
    font-weight: 500;
}

.btn-group .btn {
    border-radius: 0.375rem;
    margin: 0 1px;
}

.card {
    border: none;
    box-shadow: 0 0.125rem 0.5rem rgba(0, 0, 0, 0.1);
}

.card-header {
    border-bottom: 1px solid rgba(0, 0, 0, 0.125);
}

.table-responsive {
    min-height: 400px;
}

.bulk-actions {
    transition: all 0.3s ease;
}

/* Row selection styling */
.row-selector:checked {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .card-header .row {
        flex-direction: column;
        gap: 10px;
    }
    
    .card-header .text-end {
        text-align: left !important;
    }
    
    .btn-group {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
    }
    
    .btn-group .btn {
        margin: 2px;
        font-size: 0.8rem;
    }
    
    .table-responsive {
        font-size: 0.875rem;
    }
    
    .category-icon {
        width: 30px;
        height: 30px;
    }
    
    .category-icon .fa-lg {
        font-size: 1rem;
    }
}

/* Animation for new categories */
@keyframes highlight {
    0% { background-color: rgba(40, 167, 69, 0.2); }
    100% { background-color: transparent; }
}

.highlight-new {
    animation: highlight 2s ease-in-out;
}
</style>
@endpush