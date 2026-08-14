@extends('admin.layout')

@section('title', 'Edit Admission')
@section('content')
<div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-edit me-2"></i>Edit Admission</h1>
    <a href="{{ route('admin.admissions.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Back</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.admissions.update', $admission->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="title" class="form-label">Admission Title <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $admission->title) }}" required>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="university_id" class="form-label">University</label>
                    <select class="form-select" id="university_id" name="university_id">
                        <option value="">Select University</option>
                        @foreach($universities ?? [] as $uni)
                            <option value="{{ $uni->id }}" {{ $admission->university_id == $uni->id ? 'selected' : '' }}>{{ $uni->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="course_id" class="form-label">Course</label>
                    <select class="form-select" id="course_id" name="course_id">
                        <option value="">Select Course</option>
                        @foreach($courses ?? [] as $course)
                            <option value="{{ $course->id }}" {{ $admission->course_id == $course->id ? 'selected' : '' }}>{{ $course->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" value="{{ old('start_date', $admission->start_date ? \Carbon\Carbon::parse($admission->start_date)->format('Y-m-d') : '') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="last_date" class="form-label">Last Date</label>
                    <input type="date" class="form-control" id="last_date" name="last_date" value="{{ old('last_date', $admission->last_date ? \Carbon\Carbon::parse($admission->last_date)->format('Y-m-d') : '') }}">
                </div>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="5">{{ old('description', $admission->description) }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Update Admission</button>
        </form>
    </div>
</div>
@endsection
