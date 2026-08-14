@extends('admin.layout')

@section('title', 'Calculation Detail #' . $calculation->id . ' - Admin Panel')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-file-alt text-primary me-2"></i> Score Calculation Detail #{{ $calculation->id }}
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.score-analytics.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to List
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-8">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Candidate Calculation Metrics</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered align-middle">
                    <tr>
                        <th style="width: 200px;">Answer Key URL</th>
                        <td>
                            <a href="{{ $calculation->answer_key_url }}" target="_blank" class="text-break font-weight-bold text-primary">
                                {{ $calculation->answer_key_url }}
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <th>Category</th>
                        <td><span class="badge bg-info text-dark">{{ $calculation->category }}</span></td>
                    </tr>
                    <tr>
                        <th>Horizontal Reservation</th>
                        <td>{{ $calculation->horizontal_reservation ?: 'None' }}</td>
                    </tr>
                    <tr>
                        <th>Gender &amp; State</th>
                        <td>{{ $calculation->gender }} | {{ $calculation->state }}</td>
                    </tr>
                    <tr>
                        <th>Total Questions</th>
                        <td>{{ $calculation->total_questions }}</td>
                    </tr>
                    <tr>
                        <th>Correct / Incorrect Answers</th>
                        <td>
                            <span class="text-success fw-bold">{{ $calculation->correct_answers }} Correct</span> / 
                            <span class="text-danger fw-bold">{{ $calculation->wrong_answers }} Incorrect</span>
                        </td>
                    </tr>
                    <tr>
                        <th>Positive Score</th>
                        <td class="text-success fw-bold">+{{ number_format($calculation->positive_marks, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Negative Penalty</th>
                        <td class="text-danger fw-bold">-{{ number_format($calculation->negative_marks, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Net Raw Score</th>
                        <td class="text-primary fw-bold fs-5">{{ number_format($calculation->net_score, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Normalized Score Estimate</th>
                        <td class="text-purple fw-bold fs-5" style="color: #7c3aed;">{{ number_format($calculation->normalized_score, 2) }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Rank &amp; Percentile Summary</h5>
            </div>
            <div class="card-body text-center">
                <div class="mb-3">
                    <small class="text-muted d-block text-uppercase">All-India Rank</small>
                    <h2 class="text-primary fw-bold mb-0">#{{ $calculation->overall_rank }}</h2>
                </div>
                <div class="mb-3">
                    <small class="text-muted d-block text-uppercase">Category Rank</small>
                    <h3 class="text-info fw-bold mb-0">#{{ $calculation->category_rank }}</h3>
                </div>
                <div class="mb-3">
                    <small class="text-muted d-block text-uppercase">State Rank</small>
                    <h3 class="text-dark fw-bold mb-0">#{{ $calculation->state_rank }}</h3>
                </div>
                <div class="pt-3 border-top">
                    <small class="text-muted d-block text-uppercase">Percentile Score</small>
                    <h4 class="text-success fw-bold mb-0">{{ number_format($calculation->percentile, 2) }}%</h4>
                </div>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0">System Info</h5>
            </div>
            <div class="card-body small">
                <p class="mb-1"><strong>IP Address:</strong> {{ $calculation->ip_address ?: 'N/A' }}</p>
                <p class="mb-1"><strong>Submitted At:</strong> {{ $calculation->created_at->format('d M Y, h:i A') }}</p>
                <p class="mb-0 text-break"><strong>User Agent:</strong> {{ $calculation->user_agent ?: 'N/A' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
