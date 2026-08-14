<!-- resources/views/admin/dashboard.blade.php -->
@extends('admin.layout')

@section('title', 'Admin Dashboard')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="refreshDashboard(event)">
                <i class="fas fa-sync-alt"></i> Refresh
            </button>
            <button type="button" class="btn btn-sm btn-outline-secondary" id="daterange">
                <i class="fas fa-calendar"></i> 
                <span id="dateRangeText">Last 30 Days</span>
            </button>
        </div>
        <button type="button" class="btn btn-sm btn-primary" onclick="exportDashboardData()">
            <i class="fas fa-download me-1"></i>Export
        </button>
    </div>
</div>

<!-- Quick Stats -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card bg-primary text-white shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h2 class="card-title mb-1">{{ $totalJobs ?? 0 }}</h2>
                        <p class="card-text mb-0">Total Jobs</p>
                        <small class="opacity-75">
                            <i class="fas fa-arrow-up me-1"></i>
                            <span id="jobsGrowth">{{ $jobsGrowth ?? 0 }}% growth</span>
                        </small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-briefcase fa-2x opacity-75"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('admin.jobs.index') }}" class="btn btn-sm btn-light text-primary">
                        <i class="fas fa-eye me-1"></i>View All
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card bg-success text-white shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h2 class="card-title mb-1">{{ $totalCategories ?? 0 }}</h2>
                        <p class="card-text mb-0">Categories</p>
                        <small class="opacity-75">
                            <i class="fas fa-check me-1"></i>
                            {{ $activeCategories ?? 0 }} active
                        </small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-list fa-2x opacity-75"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-light text-success">
                        <i class="fas fa-eye me-1"></i>Manage
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card bg-warning text-dark shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h2 class="card-title mb-1">{{ $totalResults ?? 0 }}</h2>
                        <p class="card-text mb-0">Results</p>
                        <small class="opacity-75">
                            <i class="fas fa-clock me-1"></i>
                            {{ $upcomingResults ?? 0 }} upcoming
                        </small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-chart-bar fa-2x opacity-75"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('admin.results.index') }}" class="btn btn-sm btn-dark text-warning">
                        <i class="fas fa-eye me-1"></i>View All
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card bg-info text-white shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h2 class="card-title mb-1">{{ $totalUsers ?? 0 }}</h2>
                        <p class="card-text mb-0">Users</p>
                        <small class="opacity-75">
                            <i class="fas fa-user-plus me-1"></i>
                            {{ $newUsers ?? 0 }} new
                        </small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-users fa-2x opacity-75"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="#" class="btn btn-sm btn-light text-info">
                        <i class="fas fa-chart-line me-1"></i>Analytics
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Additional Stats -->
<div class="row mb-4">
    <div class="col-xl-2 col-md-4 col-6 mb-3">
        <div class="card bg-light border h-100">
            <div class="card-body text-center py-3">
                <i class="fas fa-star text-warning fa-2x mb-2"></i>
                <h5 class="mb-1">{{ $featuredJobs ?? 0 }}</h5>
                <small class="text-muted">Featured Jobs</small>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-6 mb-3">
        <div class="card bg-light border h-100">
            <div class="card-body text-center py-3">
                <i class="fas fa-clock text-danger fa-2x mb-2"></i>
                <h5 class="mb-1">{{ $expiredJobs ?? 0 }}</h5>
                <small class="text-muted">Expired Jobs</small>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-6 mb-3">
        <div class="card bg-light border h-100">
            <div class="card-body text-center py-3">
                <i class="fas fa-toggle-on text-success fa-2x mb-2"></i>
                <h5 class="mb-1" data-stat="activeJobs">{{ $activeJobs ?? 0 }}</h5>
                <small class="text-muted">Active Jobs</small>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-6 mb-3">
        <div class="card bg-light border h-100">
            <div class="card-body text-center py-3">
                <i class="fas fa-file-pdf text-primary fa-2x mb-2"></i>
                <h5 class="mb-1">{{ $totalDownloads ?? 0 }}</h5>
                <small class="text-muted">Total Downloads</small>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-6 mb-3">
        <div class="card bg-light border h-100">
            <div class="card-body text-center py-3">
                <i class="fas fa-eye text-info fa-2x mb-2"></i>
                <h5 class="mb-1">{{ $totalViews ?? 0 }}</h5>
                <small class="text-muted">Total Views</small>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-6 mb-3">
        <div class="card bg-light border h-100">
            <div class="card-body text-center py-3">
                <i class="fas fa-calendar-check text-success fa-2x mb-2"></i>
                <h5 class="mb-1">{{ $todayJobs ?? 0 }}</h5>
                <small class="text-muted">Today's Jobs</small>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row mt-4">
    <div class="col-lg-8 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-chart-line me-2"></i>Activity Overview
                </h5>
                <div class="btn-group btn-group-sm">
                    <button type="button" class="btn btn-light btn-period active" data-period="week">Week</button>
                    <button type="button" class="btn btn-light btn-period" data-period="month">Month</button>
                    <button type="button" class="btn btn-light btn-period" data-period="year">Year</button>
                </div>
            </div>
            <div class="card-body">
                <canvas id="activityChart" style="height: 300px; width: 100%;"></canvas>
                <div id="activityChartPlaceholder" class="text-center py-5" style="display: none;">
                    <i class="fas fa-chart-bar fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Loading chart data...</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">
                    <i class="fas fa-chart-pie me-2"></i>Content Distribution
                </h5>
            </div>
            <div class="card-body">
                <canvas id="contentPieChart" style="height: 300px; width: 100%;"></canvas>
                <div id="contentPieChartPlaceholder" class="text-center py-5" style="display: none;">
                    <i class="fas fa-chart-pie fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Loading chart data...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <!-- Recent Jobs -->
    <div class="col-xl-6 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-briefcase me-2"></i>Recent Jobs
                </h5>
                <a href="{{ route('admin.jobs.index') }}" class="btn btn-sm btn-light">
                    View All <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse(($recentJobs ?? []) as $job)
                    <div class="list-group-item">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">
                                    <a href="{{ route('admin.jobs.edit', $job->id) }}" class="text-decoration-none">
                                        {{ Str::limit($job->title ?? 'Untitled', 50) }}
                                    </a>
                                </h6>
                                <div class="d-flex flex-wrap gap-2 mt-2">
                                    <small class="text-muted">
                                        <i class="fas fa-building me-1"></i>{{ $job->category->name ?? 'Uncategorized' }}
                                    </small>
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>
                                        {{ isset($job->last_date) ? (is_string($job->last_date) ? \Carbon\Carbon::parse($job->last_date)->format('d M Y') : $job->last_date->format('d M Y')) : 'N/A' }}
                                    </small>
                                    <small class="text-muted">
                                        <i class="fas fa-eye me-1"></i>{{ $job->views ?? 0 }}
                                    </small>
                                </div>
                            </div>
                            <div class="ms-3 text-end">
                                <span class="badge {{ ($job->is_active ?? false) ? 'bg-success' : 'bg-secondary' }}">
                                    {{ ($job->is_active ?? false) ? 'Active' : 'Inactive' }}
                                </span>
                                @if($job->is_featured ?? false)
                                <span class="badge bg-warning text-dark mt-1 d-block">Featured</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4">
                        <i class="fas fa-briefcase fa-2x text-muted mb-3"></i>
                        <p class="text-muted mb-0">No recent jobs</p>
                        <a href="{{ route('admin.jobs.create') }}" class="btn btn-sm btn-primary mt-2">
                            <i class="fas fa-plus me-1"></i>Add New Job
                        </a>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Results -->
    <div class="col-xl-6 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-chart-bar me-2"></i>Recent Results
                </h5>
                <a href="{{ route('admin.results.index') }}" class="btn btn-sm btn-light">
                    View All <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse(($recentResults ?? []) as $result)
                    <div class="list-group-item">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">
                                    <a href="{{ route('admin.results.edit', $result->id) }}" class="text-decoration-none">
                                        {{ Str::limit($result->title ?? 'Untitled', 50) }}
                                    </a>
                                </h6>
                                <div class="d-flex flex-wrap gap-2 mt-2">
                                    <small class="text-muted">
                                        <i class="fas fa-briefcase me-1"></i>
                                        {{ Str::limit($result->job->title ?? 'N/A', 30) }}
                                    </small>
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>
                                        @php
                                            try {
                                                $resultDate = $result->result_date ?? null;
                                                if ($resultDate) {
                                                    $dateObj = is_string($resultDate) ? \Carbon\Carbon::parse($resultDate) : $resultDate;
                                                    echo $dateObj->format('d M Y');
                                                } else {
                                                    echo 'Date not set';
                                                }
                                            } catch (\Exception $e) {
                                                echo 'Invalid Date';
                                            }
                                        @endphp
                                    </small>
                                    @if(($result->download_count ?? 0) > 0)
                                    <small class="text-muted">
                                        <i class="fas fa-download me-1"></i>{{ $result->download_count }}
                                    </small>
                                    @endif
                                </div>
                            </div>
                            <div class="ms-3 text-end">
                                <span class="badge {{ ($result->is_active ?? false) ? 'bg-success' : 'bg-secondary' }}">
                                    {{ ($result->is_active ?? false) ? 'Active' : 'Inactive' }}
                                </span>
                                @php
                                    $resultDate = safe_carbon($result->result_date ?? null);
                                    if (is_future_date($resultDate)) {
                                        echo '<span class="badge bg-warning text-dark mt-1 d-block">Upcoming</span>';
                                    }
                                @endphp
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4">
                        <i class="fas fa-chart-bar fa-2x text-muted mb-3"></i>
                        <p class="text-muted mb-0">No recent results</p>
                        <a href="{{ route('admin.results.create') }}" class="btn btn-sm btn-success mt-2">
                            <i class="fas fa-plus me-1"></i>Add New Result
                        </a>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions and System Status -->
<div class="row mt-4">
    <div class="col-lg-6 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">
                    <i class="fas fa-bolt me-2"></i>Quick Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <a href="{{ route('admin.jobs.create') }}" class="btn btn-primary w-100 text-start">
                            <i class="fas fa-plus me-2"></i>Add New Job
                        </a>
                    </div>
                    <div class="col-sm-6">
                        <a href="{{ route('admin.results.create') }}" class="btn btn-success w-100 text-start">
                            <i class="fas fa-plus me-2"></i>Add New Result
                        </a>
                    </div>
                    <div class="col-sm-6">
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-warning w-100 text-start">
                            <i class="fas fa-plus me-2"></i>Add Category
                        </a>
                    </div>
                    <div class="col-sm-6">
                        <a href="{{ route('admin.admit-cards.create') }}" class="btn btn-info w-100 text-start">
                            <i class="fas fa-plus me-2"></i>Add Admit Card
                        </a>
                    </div>
                    <div class="col-sm-6">
                        <a href="{{ route('admin.jobs.index', ['status' => 'active']) }}" class="btn btn-outline-primary w-100 text-start">
                            <i class="fas fa-eye me-2"></i>View Active Jobs
                        </a>
                    </div>
                    <div class="col-sm-6">
                        <a href="{{ route('admin.results.index', ['filter' => 'upcoming']) }}" class="btn btn-outline-success w-100 text-start">
                            <i class="fas fa-clock me-2"></i>Upcoming Results
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">
                    <i class="fas fa-server me-2"></i>System Status
                </h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <span>System Version</span>
                        <span class="badge bg-primary">v2.0.0</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Last Backup</span>
                        <span class="badge bg-success">{{ now()->subDays(1)->format('M j, H:i') }}</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Storage Usage</span>
                        <span class="badge bg-info">{{ $storageUsage ?? '0%' }}</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Active Sessions</span>
                        <span class="badge bg-warning text-dark">{{ $activeSessions ?? 1 }}</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Server Time</span>
                        <span class="badge bg-secondary" id="serverTime">{{ now()->format('H:i:s') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header bg-gradient-primary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-history me-2"></i>Recent Activity
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>Item</th>
                                <th>User</th>
                                <th>Time</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(($recentActivities ?? []) as $activity)
                            <tr>
                                <td>
                                    @if(($activity['type'] ?? '') === 'created')
                                        <i class="fas fa-plus text-success me-2"></i>Created
                                    @elseif(($activity['type'] ?? '') === 'updated')
                                        <i class="fas fa-edit text-warning me-2"></i>Updated
                                    @elseif(($activity['type'] ?? '') === 'deleted')
                                        <i class="fas fa-trash text-danger me-2"></i>Deleted
                                    @else
                                        <i class="fas fa-info-circle text-info me-2"></i>{{ ucfirst($activity['type'] ?? 'Action') }}
                                    @endif
                                 </td>
                                 <td>{{ $activity['item'] ?? 'N/A' }}</td>
                                 <td>{{ $activity['user'] ?? 'System' }}</td>
                                 <td>{{ $activity['time'] ?? 'N/A' }}</td>
                                 <td><span class="badge bg-success">Success</span></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <i class="fas fa-history fa-2x text-muted mb-3"></i>
                                    <p class="text-muted mb-0">No recent activity</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
}

.card {
    border: none;
    box-shadow: 0 0.125rem 0.5rem rgba(0, 0, 0, 0.1);
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-2px);
}

.list-group-item {
    border: none;
    border-bottom: 1px solid #e9ecef;
    transition: background-color 0.2s ease;
}

.list-group-item:hover {
    background-color: #f8f9fa;
}

.badge {
    font-weight: 500;
}

.btn {
    border-radius: 0.375rem;
    font-weight: 500;
}

/* Animation for loading */
@keyframes pulse {
    0% { opacity: 1; }
    50% { opacity: 0.5; }
    100% { opacity: 1; }
}

.loading {
    animation: pulse 1.5s infinite;
    pointer-events: none;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .card-body .row.g-3 .col-sm-6 {
        margin-bottom: 10px;
    }
    
    .d-flex.flex-wrap.gap-2 {
        flex-direction: column;
        gap: 5px !important;
    }
    
    .d-flex.flex-wrap.gap-2 small {
        display: block;
    }
    
    .btn-group .btn {
        font-size: 0.7rem;
        padding: 0.25rem 0.5rem;
    }
}

/* Dark mode adjustments */
[data-bs-theme="dark"] .card.bg-light {
    background: #373b44 !important;
    color: #e9ecef;
}

[data-bs-theme="dark"] .list-group-item:hover {
    background-color: #2d3036;
}

/* Disabled button state */
.btn:disabled {
    opacity: 0.65;
    cursor: not-allowed;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// Global chart variables
let activityChart = null;
let contentPieChart = null;

// Toast notification function
function showToast(message, type = 'info') {
    // Check if Bootstrap toast is available
    if (typeof bootstrap !== 'undefined' && bootstrap.Toast) {
        const toastHtml = `
            <div class="toast align-items-center text-bg-${type} border-0 position-fixed" style="z-index: 9999; top: 20px; right: 20px;">
                <div class="d-flex">
                    <div class="toast-body">${message}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        `;
        document.body.insertAdjacentHTML('beforeend', toastHtml);
        const toastElement = document.querySelector('.toast:last-child');
        const bsToast = new bootstrap.Toast(toastElement, { autohide: true, delay: 3000 });
        bsToast.show();
        toastElement.addEventListener('hidden.bs.toast', () => toastElement.remove());
    } else {
        // Fallback alert
        alert(message);
    }
}

// Update server time every second
function updateServerTime() {
    const now = new Date();
    const timeElement = document.getElementById('serverTime');
    if (timeElement) {
        timeElement.textContent = now.toLocaleTimeString('en-US', { hour12: false });
    }
}

setInterval(updateServerTime, 1000);

// Refresh dashboard
function refreshDashboard(event) {
    const btn = event?.target ? event.target.closest('button') : document.querySelector('[onclick="refreshDashboard(event)"]');
    if (!btn) return;
    
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Refreshing...';
    btn.disabled = true;
    
    // Reload the page to refresh all data
    setTimeout(() => {
        window.location.reload();
    }, 500);
    
    // Reset button after timeout in case reload fails
    setTimeout(() => {
        if (btn) {
            btn.innerHTML = originalText;
            btn.disabled = false;
        }
    }, 3000);
}

// Export dashboard data
function exportDashboardData() {
    showToast('Preparing export...', 'info');
    // Create a simple CSV export of visible stats
    const stats = {
        'Total Jobs': document.querySelector('.bg-primary .card-title')?.innerText || '0',
        'Total Categories': document.querySelector('.bg-success .card-title')?.innerText || '0',
        'Total Results': document.querySelector('.bg-warning .card-title')?.innerText || '0',
        'Total Users': document.querySelector('.bg-info .card-title')?.innerText || '0',
        'Active Jobs': document.querySelector('[data-stat="activeJobs"]')?.innerText || document.querySelector('.col-xl-2:nth-child(3) h5')?.innerText || '0',
        'Export Date': new Date().toLocaleString()
    };
    
    let csvContent = "Statistic,Value\n";
    Object.entries(stats).forEach(([key, value]) => {
        csvContent += `"${key}","${value}"\n`;
    });
    
    const blob = new Blob([csvContent], { type: 'text/csv' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `dashboard_export_${new Date().toISOString().slice(0,19)}.csv`;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
    
    showToast('Export completed successfully!', 'success');
}

// Initialize charts
async function initializeCharts() {
    try {
        // Fetch chart data from server
        const response = await fetch('{{ route("admin.dashboard.chart-data") }}');
        const data = await response.json();
        
        if (data.success) {
            renderActivityChart(data.activity || getDefaultActivityData());
            renderPieChart(data.distribution || getDefaultDistributionData());
        } else {
            renderActivityChart(getDefaultActivityData());
            renderPieChart(getDefaultDistributionData());
        }
    } catch (error) {
        console.error('Error loading chart data:', error);
        renderActivityChart(getDefaultActivityData());
        renderPieChart(getDefaultDistributionData());
    }
}

function getDefaultActivityData() {
    return {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        jobs: [12, 19, 15, 17, 14, 10, 8],
        results: [8, 12, 10, 14, 11, 7, 5]
    };
}

function getDefaultDistributionData() {
    return {
        labels: ['Jobs', 'Results', 'Admit Cards', 'Other'],
        values: [45, 30, 15, 10]
    };
}

function renderActivityChart(data) {
    const ctx = document.getElementById('activityChart');
    if (!ctx) return;
    
    // Hide placeholder, show canvas
    const placeholder = document.getElementById('activityChartPlaceholder');
    if (placeholder) placeholder.style.display = 'none';
    ctx.style.display = 'block';
    
    if (activityChart) {
        activityChart.destroy();
    }
    
    activityChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: data.labels,
            datasets: [
                {
                    label: 'Jobs Posted',
                    data: data.jobs,
                    borderColor: '#007bff',
                    backgroundColor: 'rgba(0, 123, 255, 0.1)',
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Results Published',
                    data: data.results,
                    borderColor: '#28a745',
                    backgroundColor: 'rgba(40, 167, 69, 0.1)',
                    tension: 0.4,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    mode: 'index',
                    intersect: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Count'
                    }
                }
            }
        }
    });
}

function renderPieChart(data) {
    const ctx = document.getElementById('contentPieChart');
    if (!ctx) return;
    
    // Hide placeholder, show canvas
    const placeholder = document.getElementById('contentPieChartPlaceholder');
    if (placeholder) placeholder.style.display = 'none';
    ctx.style.display = 'block';
    
    if (contentPieChart) {
        contentPieChart.destroy();
    }
    
    contentPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: data.labels,
            datasets: [{
                data: data.values,
                backgroundColor: ['#007bff', '#28a745', '#ffc107', '#6c757d'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.parsed || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((value / total) * 100).toFixed(1);
                            return `${label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
}

function updateCharts(period) {
    showToast(`Loading ${period} data...`, 'info');
    fetch(`{{ url("admin/dashboard/chart-data") }}?period=${period}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (activityChart) {
                    activityChart.data.labels = data.activity.labels;
                    activityChart.data.datasets[0].data = data.activity.jobs;
                    activityChart.data.datasets[1].data = data.activity.results;
                    activityChart.update();
                }
                if (contentPieChart && data.distribution) {
                    contentPieChart.data.labels = data.distribution.labels;
                    contentPieChart.data.datasets[0].data = data.distribution.values;
                    contentPieChart.update();
                }
                showToast('Chart data updated!', 'success');
            }
        })
        .catch(error => {
            console.error('Error updating charts:', error);
            showToast('Error updating chart data', 'danger');
        });
}

// Date range picker functionality
document.addEventListener('DOMContentLoaded', function() {
    // Initialize charts
    initializeCharts();
    
    // Chart period buttons
    document.querySelectorAll('.btn-period').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.btn-period').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            const period = this.getAttribute('data-period');
            updateCharts(period);
        });
    });
    
    // Date range picker
    const dateRangeBtn = document.getElementById('daterange');
    if (dateRangeBtn) {
        dateRangeBtn.addEventListener('click', function() {
            showToast('Date range picker would open here', 'info');
        });
    }
    
    // Add loading states to quick action buttons
    document.querySelectorAll('.card .btn[href]').forEach(btn => {
        if (btn.getAttribute('href') && !btn.getAttribute('href').startsWith('#')) {
            btn.addEventListener('click', function(e) {
                // Don't add loading if it's a form submission or has target blank
                if (!this.getAttribute('target')) {
                    this.classList.add('loading');
                }
            });
        }
    });
});
</script>
@endpush