@extends('admin.layout')

@section('title', 'Answer Keys Management')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h1>
                    <i class="icon-book3 position-left"></i>
                    Answer Keys Management
                </h1>
            </div>

            <div class="heading-elements">
                <a href="{{ route('admin.answer-keys.create') }}" class="btn btn-primary btn-lg">
                    <i class="icon-plus-circle2 position-left"></i>
                    Add New Answer Key
                </a>
            </div>
        </div>
    </div>

    <div class="content">
        <!-- Statistics Cards -->
        <div class="row">
            <div class="col-lg-3 col-sm-6">
                <div class="card bg-teal-400">
                    <div class="card-body">
                        <div class="d-flex">
                            <h3 class="font-weight-semibold mb-0">{{ $stats['total'] }}</h3>
                            <div class="ml-auto">
                                <i class="icon-book3 icon-3x opacity-75"></i>
                            </div>
                        </div>
                        <div>Total Answer Keys</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card bg-blue-400">
                    <div class="card-body">
                        <div class="d-flex">
                            <h3 class="font-weight-semibold mb-0">{{ $stats['active'] }}</h3>
                            <div class="ml-auto">
                                <i class="icon-checkmark3 icon-3x opacity-75"></i>
                            </div>
                        </div>
                        <div>Active Answer Keys</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card bg-orange-400">
                    <div class="card-body">
                        <div class="d-flex">
                            <h3 class="font-weight-semibold mb-0">{{ $stats['upcoming'] }}</h3>
                            <div class="ml-auto">
                                <i class="icon-calendar3 icon-3x opacity-75"></i>
                            </div>
                        </div>
                        <div>Upcoming Answer Keys</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card bg-pink-400">
                    <div class="card-body">
                        <div class="d-flex">
                            <h3 class="font-weight-semibold mb-0">{{ $stats['recent'] }}</h3>
                            <div class="ml-auto">
                                <i class="icon-history icon-3x opacity-75"></i>
                            </div>
                        </div>
                        <div>Added Last 7 Days</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">Filters & Search</h5>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <form method="GET" action="{{ route('admin.answer-keys.index') }}">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Search:</label>
                                <input type="text" name="search" class="form-control" placeholder="Search by title, description, exam name..." value="{{ request('search') }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Job:</label>
                                <select name="job" class="form-control">
                                    <option value="">All Jobs</option>
                                    @foreach($jobs as $job)
                                        <option value="{{ $job->id }}" {{ request('job') == $job->id ? 'selected' : '' }}>
                                            {{ $job->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Status:</label>
                                <select name="status" class="form-control">
                                    <option value="">All Status</option>
                                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Date Filter:</label>
                                <select name="date" class="form-control">
                                    <option value="">All Dates</option>
                                    <option value="upcoming" {{ request('date') === 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                                    <option value="past" {{ request('date') === 'past' ? 'selected' : '' }}>Past</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Sort By:</label>
                                <select name="sort" class="form-control">
                                    <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Latest First</option>
                                    <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest First</option>
                                    <option value="title_asc" {{ request('sort') === 'title_asc' ? 'selected' : '' }}>Title A-Z</option>
                                    <option value="title_desc" {{ request('sort') === 'title_desc' ? 'selected' : '' }}>Title Z-A</option>
                                    <option value="date_asc" {{ request('sort') === 'date_asc' ? 'selected' : '' }}>Date Ascending</option>
                                    <option value="date_desc" {{ request('sort') === 'date_desc' ? 'selected' : '' }}>Date Descending</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-primary btn-block">Filter</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Answer Keys Table -->
        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">Answer Keys List</h5>
            </div>

            <div class="card-body">
                @if($answerKeys->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Job</th>
                                    <th>Exam Name</th>
                                    <th>Answer Key Date</th>
                                    <th>Subjects</th>
                                    <th>Status</th>
                                    <th>Downloads</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($answerKeys as $answerKey)
                                    <tr>
                                        <td>
                                            <div class="font-weight-semibold">{{ $answerKey->title }}</div>
                                            @if($answerKey->short_description)
                                                <small class="text-muted">{{ Str::limit($answerKey->short_description, 50) }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($answerKey->job)
                                                <span class="badge badge-info">{{ $answerKey->job->title }}</span>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>{{ $answerKey->exam_name ?? 'N/A' }}</td>
                                        <td>
                                            @php
                                                $answerKeyDate = safe_carbon($answerKey->answer_key_date);
                                            @endphp
                                            {{ $answerKeyDate ? $answerKeyDate->format('M d, Y') : 'N/A' }}
                                            @if(is_future_date($answerKeyDate))
                                                <span class="badge badge-warning ml-1">Upcoming</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($answerKey->subjects && count($answerKey->subjects) > 0)
                                                <span class="badge badge-light">{{ count($answerKey->subjects) }} subjects</span>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge {{ $answerKey->is_active ? 'badge-success' : 'badge-danger' }}">
                                                {{ $answerKey->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-secondary">{{ $answerKey->download_count ?? 0 }}</span>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('admin.answer-keys.show', $answerKey->id) }}" 
                                                   class="btn btn-sm btn-info" title="View">
                                                    <i class="icon-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.answer-keys.edit', $answerKey->id) }}" 
                                                   class="btn btn-sm btn-primary" title="Edit">
                                                    <i class="icon-pencil7"></i>
                                                </a>
                                                
                                                @if($answerKey->answer_key_file)
                                                    <a href="{{ route('admin.answer-keys.download', $answerKey->id) }}" 
                                                       class="btn btn-sm btn-success" title="Download File">
                                                        <i class="icon-download"></i>
                                                    </a>
                                                @endif
                                                
                                                <form method="POST" action="{{ route('admin.answer-keys.update-status', $answerKey->id) }}" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm {{ $answerKey->is_active ? 'btn-warning' : 'btn-success' }}" 
                                                            title="{{ $answerKey->is_active ? 'Deactivate' : 'Activate' }}">
                                                        <i class="icon-{{ $answerKey->is_active ? 'cross' : 'checkmark' }}"></i>
                                                    </button>
                                                </form>
                                                
                                                <form method="POST" action="{{ route('admin.answer-keys.destroy', $answerKey->id) }}" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" 
                                                            onclick="return confirm('Are you sure you want to delete this answer key?')"
                                                            title="Delete">
                                                        <i class="icon-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="text-muted">
                            Showing {{ $answerKeys->firstItem() }} to {{ $answerKeys->lastItem() }} of {{ $answerKeys->total() }} entries
                        </div>
                        <div>
                            {{ $answerKeys->links() }}
                        </div>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="icon-book3 icon-2x text-muted mb-3"></i>
                        <h4 class="text-muted">No answer keys found</h4>
                        <p class="text-muted">No answer keys match your search criteria.</p>
                        <a href="{{ route('admin.answer-keys.create') }}" class="btn btn-primary">
                            <i class="icon-plus-circle2 position-left"></i>
                            Add New Answer Key
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Auto submit form on filter change
        $('select[name="status"], select[name="job"], select[name="date"], select[name="sort"]').change(function() {
            $(this).closest('form').submit();
        });
    });
</script>
@endpush