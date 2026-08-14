@extends('admin.layout')

@section('title', 'Edit Course')
@section('content')
<div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-edit me-2"></i>Edit Course</h1>
    <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Back</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.courses.update', $course->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Course Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $course->name) }}" required>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="code" class="form-label">Course Code</label>
                    <input type="text" class="form-control" id="code" name="code" value="{{ old('code', $course->code) }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="level" class="form-label">Level</label>
                    <select class="form-select" id="level" name="level">
                        <option value="undergraduate" {{ $course->level === 'undergraduate' ? 'selected' : '' }}>Undergraduate</option>
                        <option value="postgraduate" {{ $course->level === 'postgraduate' ? 'selected' : '' }}>Postgraduate</option>
                        <option value="diploma" {{ $course->level === 'diploma' ? 'selected' : '' }}>Diploma</option>
                        <option value="phd" {{ $course->level === 'phd' ? 'selected' : '' }}>PhD</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="duration" class="form-label">Duration</label>
                    <input type="text" class="form-control" id="duration" name="duration" value="{{ old('duration', $course->duration) }}">
                </div>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="4">{{ old('description', $course->description) }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Update Course</button>
        </form>
    </div>
</div>
@endsection
