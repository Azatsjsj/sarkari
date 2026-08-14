<!-- resources/views/admin/results/edit.blade.php -->
@extends('admin.layout')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Result</h1>
    <a href="{{ route('admin.results.index') }}" class="btn btn-secondary">Back to Results</a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.results.update', $result->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="title" class="form-label">Result Title *</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title', $result->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="job_id" class="form-label">Select Job *</label>
                        <select class="form-control @error('job_id') is-invalid @enderror" 
                                id="job_id" name="job_id" required>
                            <option value="">Select Job</option>
                            @foreach($jobs as $job)
                                <option value="{{ $job->id }}" 
                                    {{ old('job_id', $result->job_id) == $job->id ? 'selected' : '' }}>
                                    {{ $job->title }}
                                </option>
                            @endforeach
                        </select>
                        @error('job_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="result_date" class="form-label">Result Date *</label>
                        <input type="date" class="form-control @error('result_date') is-invalid @enderror" 
                               id="result_date" name="result_date" 
                               value="{{ old('result_date', $result->result_date->format('Y-m-d')) }}" required>
                        @error('result_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="result_link" class="form-label">Result Link *</label>
                        <input type="url" class="form-control @error('result_link') is-invalid @enderror" 
                               id="result_link" name="result_link" 
                               value="{{ old('result_link', $result->result_link) }}" 
                               placeholder="https://example.com/result" required>
                        @error('result_link')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="result_file" class="form-label">Result File (PDF/DOC)</label>
                <input type="file" class="form-control @error('result_file') is-invalid @enderror" 
                       id="result_file" name="result_file" accept=".pdf,.doc,.docx">
                <small class="form-text text-muted">
                    @if($result->result_file)
                        Current file: 
                        <a href="{{ Storage::url($result->result_file) }}" target="_blank">View File</a> |
                        <a href="{{ Storage::url($result->result_file) }}" download>Download</a>
                    @else
                        No file uploaded
                    @endif
                </small>
                @error('result_file')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" 
                          id="description" name="description" rows="4">{{ old('description', $result->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" 
                    {{ old('is_active', $result->is_active) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">Active</label>
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="{{ route('admin.results.index') }}" class="btn btn-secondary me-md-2">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Result</button>
            </div>
        </form>
    </div>
</div>
@endsection