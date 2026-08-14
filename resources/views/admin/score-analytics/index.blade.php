@extends('admin.layout')

@section('title', 'Score & Rank Analytics - Admin Panel')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-chart-line text-primary me-2"></i> Score &amp; Rank Analytics
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <span class="badge bg-primary fs-6 px-3 py-2">Total Calculations: {{ number_format($stats['total_submissions']) }}</span>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4 g-3">
    <div class="col-md-3">
        <div class="card bg-primary text-white shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 text-uppercase mb-1">Total Submissions</h6>
                        <h3 class="mb-0 fw-bold">{{ number_format($stats['total_submissions']) }}</h3>
                    </div>
                    <i class="fas fa-calculator fa-2x text-white-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 text-uppercase mb-1">Average Net Score</h6>
                        <h3 class="mb-0 fw-bold">{{ number_format($stats['avg_net_score'], 2) }}</h3>
                    </div>
                    <i class="fas fa-chart-bar fa-2x text-white-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-dark shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-dark-50 text-uppercase mb-1">Max Recorded Score</h6>
                        <h3 class="mb-0 fw-bold">{{ number_format($stats['max_score'], 2) }}</h3>
                    </div>
                    <i class="fas fa-trophy fa-2x text-dark-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 text-uppercase mb-1">Top State</h6>
                        <h3 class="mb-0 fw-bold">{{ $stats['top_states']->first()->state ?? 'N/A' }}</h3>
                    </div>
                    <i class="fas fa-map-marker-alt fa-2x text-white-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card mb-4 shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.score-analytics.index') }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Search Answer Key URL or IP..." 
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <select name="category" class="form-select">
                    <option value="">All Categories</option>
                    <option value="UR" {{ request('category') == 'UR' ? 'selected' : '' }}>UR / General</option>
                    <option value="OBC" {{ request('category') == 'OBC' ? 'selected' : '' }}>OBC</option>
                    <option value="EWS" {{ request('category') == 'EWS' ? 'selected' : '' }}>EWS</option>
                    <option value="SC" {{ request('category') == 'SC' ? 'selected' : '' }}>SC</option>
                    <option value="ST" {{ request('category') == 'ST' ? 'selected' : '' }}>ST</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="state" class="form-select">
                    <option value="">All States</option>
                    <option value="Uttar Pradesh" {{ request('state') == 'Uttar Pradesh' ? 'selected' : '' }}>Uttar Pradesh</option>
                    <option value="Delhi" {{ request('state') == 'Delhi' ? 'selected' : '' }}>Delhi</option>
                    <option value="Bihar" {{ request('state') == 'Bihar' ? 'selected' : '' }}>Bihar</option>
                    <option value="Rajasthan" {{ request('state') == 'Rajasthan' ? 'selected' : '' }}>Rajasthan</option>
                    <option value="Madhya Pradesh" {{ request('state') == 'Madhya Pradesh' ? 'selected' : '' }}>Madhya Pradesh</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-filter me-1"></i> Filter
                </button>
                <a href="{{ route('admin.score-analytics.index') }}" class="btn btn-secondary">
                    <i class="fas fa-redo me-1"></i> Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Calculation Entries Table -->
<form id="bulk-action-form" method="POST" action="{{ route('admin.score-analytics.bulk-action') }}">
    @csrf
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0 fw-bold"><i class="fas fa-list me-2 text-primary"></i> Submissions List</h5>
            <div>
                <button type="submit" name="action" value="delete" class="btn btn-outline-danger btn-sm" 
                        onclick="return confirm('Are you sure you want to delete selected calculation entries?')">
                    <i class="fas fa-trash me-1"></i> Delete Selected
                </button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 40px;">
                            <input type="checkbox" id="select-all" class="form-check-input">
                        </th>
                        <th>ID</th>
                        <th>Answer Key URL</th>
                        <th>Category</th>
                        <th>Gender / State</th>
                        <th>Raw Score</th>
                        <th>Norm. Score</th>
                        <th>Pred. Rank</th>
                        <th>Date &amp; Time</th>
                        <th style="width: 100px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($calculations as $calc)
                    <tr>
                        <td>
                            <input type="checkbox" name="ids[]" value="{{ $calc->id }}" class="form-check-input item-checkbox">
                        </td>
                        <td>#{{ $calc->id }}</td>
                        <td>
                            <a href="{{ $calc->answer_key_url }}" target="_blank" class="text-truncate d-inline-block text-primary fw-bold" style="max-width: 250px;">
                                {{ $calc->answer_key_url }}
                            </a>
                        </td>
                        <td>
                            <span class="badge bg-info text-dark">{{ $calc->category }}</span>
                        </td>
                        <td>
                            <small class="d-block fw-bold">{{ $calc->gender }}</small>
                            <small class="text-muted">{{ $calc->state }}</small>
                        </td>
                        <td>
                            <strong class="text-primary">{{ number_format($calc->net_score, 2) }}</strong>
                            <small class="d-block text-muted">+{{ $calc->positive_marks }} / -{{ $calc->negative_marks }}</small>
                        </td>
                        <td>
                            <strong class="text-purple" style="color: #7c3aed;">{{ number_format($calc->normalized_score, 2) }}</strong>
                        </td>
                        <td>
                            <span class="badge bg-success">Rank #{{ $calc->overall_rank }}</span>
                            <small class="d-block text-muted">Cat: #{{ $calc->category_rank }}</small>
                        </td>
                        <td>
                            <small>{{ $calc->created_at->format('d M Y, h:i A') }}</small>
                        </td>
                        <td>
                            <a href="{{ route('admin.score-analytics.show', $calc->id) }}" class="btn btn-sm btn-outline-info me-1" title="View Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <form action="{{ route('admin.score-analytics.destroy', $calc->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete entry?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center py-4 text-muted">
                            No rank &amp; score calculation entries found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($calculations->hasPages())
        <div class="card-footer bg-white">
            {{ $calculations->withQueryString()->links() }}
        </div>
        @endif
    </div>
</form>

<script>
document.getElementById('select-all')?.addEventListener('change', function() {
    document.querySelectorAll('.item-checkbox').forEach(cb => cb.checked = this.checked);
});
</script>
@endsection
