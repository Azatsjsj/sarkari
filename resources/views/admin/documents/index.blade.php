{{-- resources/views/admin/documents/index.blade.php --}}
@extends('admin.layout')

@section('title', 'Manage Documents - Admin Panel')

@section('content')
<div class="admin-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">
            <i class="fas fa-file-alt"></i> Manage Documents
        </h1>
        <a href="{{ route('admin.documents.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Upload New Document
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Documents</h5>
                    <h2 class="mb-0">{{ $stats['total'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Notices</h5>
                    <h2 class="mb-0">{{ $stats['notices'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Certificates</h5>
                    <h2 class="mb-0">{{ $stats['certificates'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-dark">
                <div class="card-body">
                    <h5 class="card-title">Featured</h5>
                    <h2 class="mb-0">{{ $stats['featured'] }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="Search by title, number..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <select name="type" class="form-select">
                        <option value="">All Types</option>
                        <option value="notice" {{ request('type') == 'notice' ? 'selected' : '' }}>Notice</option>
                        <option value="certificate" {{ request('type') == 'certificate' ? 'selected' : '' }}>Certificate</option>
                        <option value="syllabus" {{ request('type') == 'syllabus' ? 'selected' : '' }}>Syllabus</option>
                        <option value="admit_card" {{ request('type') == 'admit_card' ? 'selected' : '' }}>Admit Card</option>
                        <option value="result" {{ request('type') == 'result' ? 'selected' : '' }}>Result</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> Filter
                    </button>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('admin.documents.export', request()->query()) }}" class="btn btn-success w-100">
                        <i class="fas fa-download"></i> Export CSV
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Documents Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th width="50">
                                <input type="checkbox" id="selectAll">
                            </th>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Document No.</th>
                            <th>Type</th>
                            <th>Department</th>
                            <th>Downloads</th>
                            <th>Status</th>
                            <th>Featured</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($documents as $document)
                        <tr>
                            <td>
                                <input type="checkbox" class="document-checkbox" value="{{ $document->id }}">
                            </td>
                            <td>{{ $document->id }}</td>
                            <td>
                                <a href="{{ route('admin.documents.show', $document) }}">
                                    {{ Str::limit($document->title, 50) }}
                                </a>
                            </td>
                            <td>{{ $document->document_number ?? 'N/A' }}</td>
                            <td>
                                <span class="badge bg-{{ $document->type == 'notice' ? 'primary' : ($document->type == 'certificate' ? 'success' : 'secondary') }}">
                                    {{ ucfirst(str_replace('_', ' ', $document->type)) }}
                                </span>
                            </td>
                            <td>{{ $document->department ?? 'N/A' }}</td>
                            <td>{{ number_format($document->download_count) }}</td>
                            <td>
                                <button class="btn btn-sm {{ $document->is_active ? 'btn-success' : 'btn-secondary' }} toggle-status" 
                                        data-id="{{ $document->id }}">
                                    {{ $document->is_active ? 'Active' : 'Inactive' }}
                                </button>
                            </td>
                            <td>
                                <button class="btn btn-sm {{ $document->is_featured ? 'btn-warning' : 'btn-outline-warning' }} toggle-featured" 
                                        data-id="{{ $document->id }}">
                                    <i class="fas {{ $document->is_featured ? 'fa-star' : 'fa-star-o' }}"></i>
                                </button>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.documents.edit', $document) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-sm btn-danger delete-document" data-id="{{ $document->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <a href="{{ route('documents.download', $document->slug) }}" class="btn btn-sm btn-success">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center">No documents found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Bulk Actions -->
            <div class="row mt-3">
                <div class="col-md-6">
                    <select id="bulkAction" class="form-select w-auto d-inline-block" style="width: auto;">
                        <option value="">Bulk Actions</option>
                        <option value="delete">Delete Selected</option>
                        <option value="activate">Activate Selected</option>
                        <option value="deactivate">Deactivate Selected</option>
                    </select>
                    <button id="applyBulkAction" class="btn btn-secondary">Apply</button>
                </div>
                <div class="col-md-6">
                    {{ $documents->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Select All
    $('#selectAll').change(function() {
        $('.document-checkbox').prop('checked', $(this).prop('checked'));
    });
    
    // Toggle Status
    $('.toggle-status').click(function() {
        var id = $(this).data('id');
        var btn = $(this);
        
        $.ajax({
            url: '/admin/documents/' + id + '/toggle-status',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.status == 'active') {
                    btn.removeClass('btn-secondary').addClass('btn-success').text('Active');
                } else {
                    btn.removeClass('btn-success').addClass('btn-secondary').text('Inactive');
                }
                toastr.success('Status updated successfully');
            }
        });
    });
    
    // Toggle Featured
    $('.toggle-featured').click(function() {
        var id = $(this).data('id');
        var btn = $(this);
        
        $.ajax({
            url: '/admin/documents/' + id + '/toggle-featured',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.featured) {
                    btn.removeClass('btn-outline-warning').addClass('btn-warning');
                    btn.html('<i class="fas fa-star"></i>');
                } else {
                    btn.removeClass('btn-warning').addClass('btn-outline-warning');
                    btn.html('<i class="fas fa-star-o"></i>');
                }
                toastr.success('Featured status updated');
            }
        });
    });
    
    // Delete Document
    $('.delete-document').click(function() {
        if (confirm('Are you sure you want to delete this document?')) {
            var id = $(this).data('id');
            var row = $(this).closest('tr');
            
            $.ajax({
                url: '/admin/documents/' + id,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function() {
                    row.remove();
                    toastr.success('Document deleted successfully');
                }
            });
        }
    });
    
    // Bulk Action
    $('#applyBulkAction').click(function() {
        var action = $('#bulkAction').val();
        var ids = [];
        
        $('.document-checkbox:checked').each(function() {
            ids.push($(this).val());
        });
        
        if (ids.length === 0) {
            alert('Please select at least one document');
            return;
        }
        
        if (action === '') {
            alert('Please select an action');
            return;
        }
        
        if (confirm('Are you sure you want to perform this action on ' + ids.length + ' document(s)?')) {
            $.ajax({
                url: '/admin/documents/bulk-delete',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    ids: ids,
                    action: action
                },
                success: function() {
                    location.reload();
                }
            });
        }
    });
});
</script>
@endpush
@endsection