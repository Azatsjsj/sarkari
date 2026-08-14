<!-- resources/views/admin/jobs/show.blade.php -->
@extends('admin.layout')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Job Details</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.jobs.index') }}" class="btn btn-secondary btn-sm me-2">
            <i class="fas fa-arrow-left"></i> Back to Jobs
        </a>
        <a href="{{ route('admin.jobs.edit', $job->id) }}" class="btn btn-warning btn-sm me-2">
            <i class="fas fa-edit"></i> Edit Job
        </a>
        <a href="{{ route('job.show', $job->slug) }}" target="_blank" class="btn btn-info btn-sm">
            <i class="fas fa-external-link-alt"></i> View on Site
        </a>
    </div>
</div>

<!-- Job Details Card -->
<div class="row">
    <div class="col-lg-8">
        <!-- Basic Information -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle"></i> Basic Information
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="40%">Job Title:</th>
                                <td>
                                    <strong>{{ $job->title }}</strong>
                                    @if($job->is_featured)
                                    <span class="badge bg-warning text-dark ms-2">
                                        <i class="fas fa-star"></i> Featured
                                    </span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Category:</th>
                                <td>
                                    <span class="badge bg-info">{{ $job->category->name }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th>Status:</th>
                                <td>
                                    <span class="badge {{ $job->is_active ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $job->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Total Posts:</th>
                                <td>{{ $job->total_post ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Application Fee:</th>
                                <td>{{ $job->application_fee ?? 'N/A' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="40%">Start Date:</th>
                                <td>
                                    @php
                                        $startDate = $job->start_date;
                                        if (is_string($startDate)) {
                                            $startDate = \Carbon\Carbon::parse($startDate);
                                        }
                                    @endphp
                                    {{ $startDate->format('d M Y') }}
                                </td>
                            </tr>
                            <tr>
                                <th>Last Date:</th>
                                <td>
                                    @php
                                        $lastDate = $job->last_date;
                                        if (is_string($lastDate)) {
                                            $lastDate = \Carbon\Carbon::parse($lastDate);
                                        }
                                        $isExpired = $lastDate->lt(now());
                                    @endphp
                                    <span class="{{ $isExpired ? 'text-danger' : 'text-success' }}">
                                        {{ $lastDate->format('d M Y') }}
                                        @if($isExpired)
                                        <span class="badge bg-danger ms-1">Expired</span>
                                        @endif
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Exam Date:</th>
                                <td>
                                    @if($job->exam_date)
                                        @php
                                            $examDate = $job->exam_date;
                                            if (is_string($examDate)) {
                                                $examDate = \Carbon\Carbon::parse($examDate);
                                            }
                                        @endphp
                                        {{ $examDate->format('d M Y') }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Admit Card Date:</th>
                                <td>
                                    @if($job->admit_card_date)
                                        @php
                                            $admitCardDate = $job->admit_card_date;
                                            if (is_string($admitCardDate)) {
                                                $admitCardDate = \Carbon\Carbon::parse($admitCardDate);
                                            }
                                        @endphp
                                        {{ $admitCardDate->format('d M Y') }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Result Date:</th>
                                <td>
                                    @if($job->result_date)
                                        @php
                                            $resultDate = $job->result_date;
                                            if (is_string($resultDate)) {
                                                $resultDate = \Carbon\Carbon::parse($resultDate);
                                            }
                                        @endphp
                                        {{ $resultDate->format('d M Y') }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Description -->
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">
                    <i class="fas fa-file-alt"></i> Description
                </h5>
            </div>
            <div class="card-body">
                <h6>Short Description:</h6>
                <p class="text-muted mb-4">{{ $job->short_description }}</p>

                <h6>Full Description:</h6>
                <div class="bg-light p-3 rounded">
                    {!! nl2br(e($job->description)) !!}
                </div>
            </div>
        </div>

        <!-- Eligibility Criteria -->
        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">
                    <i class="fas fa-graduation-cap"></i> Eligibility Criteria
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="40%">Qualification:</th>
                                <td>{{ $job->qualification ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Age Limit:</th>
                                <td>{{ $job->age_limit ?? 'N/A' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="40%">Job Location:</th>
                                <td>{{ $job->job_location ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Total Views:</th>
                                <td>
                                    <span class="badge bg-secondary">
                                        <i class="fas fa-eye"></i> {{ $job->views }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Quick Actions -->
        <div class="card mb-4">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0">
                    <i class="fas fa-bolt"></i> Quick Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.jobs.edit', $job->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit Job
                    </a>
                    
                    <form action="{{ route('admin.jobs.updateStatus', $job->id) }}" method="POST" class="d-grid">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn {{ $job->is_active ? 'btn-secondary' : 'btn-success' }}">
                            <i class="fas {{ $job->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                            {{ $job->is_active ? 'Deactivate' : 'Activate' }} Job
                        </button>
                    </form>

                    <a href="{{ $job->application_link }}" target="_blank" class="btn btn-primary">
                        <i class="fas fa-external-link-alt"></i> Application Link
                    </a>

                    <a href="{{ $job->official_website }}" target="_blank" class="btn btn-info">
                        <i class="fas fa-globe"></i> Official Website
                    </a>

                    @if($job->notification_pdf)
                    <a href="{{ Storage::url($job->notification_pdf) }}" target="_blank" class="btn btn-success">
                        <i class="fas fa-file-pdf"></i> View Notification PDF
                    </a>
                    <a href="{{ Storage::url($job->notification_pdf) }}" download class="btn btn-outline-success">
                        <i class="fas fa-download"></i> Download PDF
                    </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Job Statistics -->
        <div class="card mb-4">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">
                    <i class="fas fa-chart-bar"></i> Job Statistics
                </h5>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <div class="row">
                        <div class="col-6">
                            <div class="border-end">
                                <h3 class="text-primary">{{ $job->views }}</h3>
                                <small class="text-muted">Total Views</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h3 class="text-success">{{ $job->results->count() }}</h3>
                            <small class="text-muted">Results</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Important Dates -->
        <div class="card mb-4">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0">
                    <i class="fas fa-calendar-alt"></i> Important Dates
                </h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item {{ \Carbon\Carbon::parse($job->start_date)->lt(now()) ? 'completed' : 'upcoming' }}">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <strong>Start Date</strong>
                            <br>
                            <small>
                                @php
                                    $startDate = $job->start_date;
                                    if (is_string($startDate)) {
                                        $startDate = \Carbon\Carbon::parse($startDate);
                                    }
                                @endphp
                                {{ $startDate->format('d M Y') }}
                            </small>
                        </div>
                    </div>
                    <div class="timeline-item {{ \Carbon\Carbon::parse($job->last_date)->lt(now()) ? 'completed' : 'upcoming' }}">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <strong>Last Date</strong>
                            <br>
                            <small>
                                @php
                                    $lastDate = $job->last_date;
                                    if (is_string($lastDate)) {
                                        $lastDate = \Carbon\Carbon::parse($lastDate);
                                    }
                                @endphp
                                {{ $lastDate->format('d M Y') }}
                            </small>
                        </div>
                    </div>
                    @if($job->exam_date)
                    <div class="timeline-item {{ \Carbon\Carbon::parse($job->exam_date)->lt(now()) ? 'completed' : 'upcoming' }}">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <strong>Exam Date</strong>
                            <br>
                            <small>
                                @php
                                    $examDate = $job->exam_date;
                                    if (is_string($examDate)) {
                                        $examDate = \Carbon\Carbon::parse($examDate);
                                    }
                                @endphp
                                {{ $examDate->format('d M Y') }}
                            </small>
                        </div>
                    </div>
                    @endif
                    @if($job->admit_card_date)
                    <div class="timeline-item {{ \Carbon\Carbon::parse($job->admit_card_date)->lt(now()) ? 'completed' : 'upcoming' }}">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <strong>Admit Card</strong>
                            <br>
                            <small>
                                @php
                                    $admitCardDate = $job->admit_card_date;
                                    if (is_string($admitCardDate)) {
                                        $admitCardDate = \Carbon\Carbon::parse($admitCardDate);
                                    }
                                @endphp
                                {{ $admitCardDate->format('d M Y') }}
                            </small>
                        </div>
                    </div>
                    @endif
                    @if($job->result_date)
                    <div class="timeline-item {{ \Carbon\Carbon::parse($job->result_date)->lt(now()) ? 'completed' : 'upcoming' }}">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <strong>Result Date</strong>
                            <br>
                            <small>
                                @php
                                    $resultDate = $job->result_date;
                                    if (is_string($resultDate)) {
                                        $resultDate = \Carbon\Carbon::parse($resultDate);
                                    }
                                @endphp
                                {{ $resultDate->format('d M Y') }}
                            </small>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Meta Information -->
        <div class="card">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-database"></i> Meta Information
                </h5>
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless">
                    <tr>
                        <th width="40%">Created:</th>
                        <td>
                            @php
                                $createdAt = $job->created_at;
                                if (is_string($createdAt)) {
                                    $createdAt = \Carbon\Carbon::parse($createdAt);
                                }
                            @endphp
                            {{ $createdAt->format('M d, Y h:i A') }}
                        </td>
                    </tr>
                    <tr>
                        <th>Last Updated:</th>
                        <td>
                            @php
                                $updatedAt = $job->updated_at;
                                if (is_string($updatedAt)) {
                                    $updatedAt = \Carbon\Carbon::parse($updatedAt);
                                }
                            @endphp
                            {{ $updatedAt->format('M d, Y h:i A') }}
                        </td>
                    </tr>
                    <tr>
                        <th>Slug:</th>
                        <td><code>{{ $job->slug }}</code></td>
                    </tr>
                    <tr>
                        <th>Job ID:</th>
                        <td><code>#{{ $job->id }}</code></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Related Results -->
@if($job->results && $job->results->count() > 0)
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">
                    <i class="fas fa-chart-bar"></i> Related Results ({{ $job->results->count() }})
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Result Title</th>
                                <th>Result Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($job->results as $result)
                            <tr>
                                <td>{{ $result->title }}</td>
                                <td>
                                    @php
                                        $resultDate = $result->result_date;
                                        if (is_string($resultDate)) {
                                            $resultDate = \Carbon\Carbon::parse($resultDate);
                                        }
                                    @endphp
                                    {{ $resultDate->format('d M Y') }}
                                </td>
                                <td>
                                    <span class="badge {{ $result->is_active ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $result->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.results.edit', $result->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('results.show', $result->slug) }}" target="_blank" class="btn btn-sm btn-info">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Danger Zone -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card border-danger">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0">
                    <i class="fas fa-exclamation-triangle"></i> Danger Zone
                </h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-danger">Delete This Job</h6>
                        <p class="text-muted mb-0">
                            Once you delete a job, there is no going back. Please be certain.
                            @if($job->results && $job->results->count() > 0)
                            <br><small class="text-warning">This job has {{ $job->results->count() }} associated results that will also be deleted.</small>
                            @endif
                        </p>
                    </div>
                    <div>
                        <form action="{{ route('admin.jobs.destroy', $job->id) }}" method="POST" 
                              onsubmit="return confirm('Are you sure you want to delete this job? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Delete Job
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.timeline {
    position: relative;
    padding-left: 20px;
}

.timeline-item {
    position: relative;
    margin-bottom: 15px;
}

.timeline-marker {
    position: absolute;
    left: -20px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: #6c757d;
}

.timeline-item.completed .timeline-marker {
    background: #28a745;
}

.timeline-item.upcoming .timeline-marker {
    background: #ffc107;
}

.timeline-content {
    padding-left: 10px;
}

.table-borderless th {
    font-weight: 600;
    color: #495057;
}

.btn-group-vertical .btn {
    margin-bottom: 5px;
    text-align: left;
}

.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border: 1px solid rgba(0, 0, 0, 0.125);
}
</style>
@endpush
