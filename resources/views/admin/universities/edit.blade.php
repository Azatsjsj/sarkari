@extends('admin.layout')

@section('title', 'Edit University')
@section('content')
<div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-edit me-2"></i>Edit University</h1>
    <a href="{{ route('admin.universities.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Back</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.universities.update', $university->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">University Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $university->name) }}" required>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="state" class="form-label">State</label>
                    <input type="text" class="form-control" id="state" name="state" value="{{ old('state', $university->state) }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="city" class="form-label">City</label>
                    <input type="text" class="form-control" id="city" name="city" value="{{ old('city', $university->city) }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="type" class="form-label">Type</label>
                    <select class="form-select" id="type" name="type">
                        <option value="public" {{ $university->type === 'public' ? 'selected' : '' }}>Public</option>
                        <option value="private" {{ $university->type === 'private' ? 'selected' : '' }}>Private</option>
                        <option value="deemed" {{ $university->type === 'deemed' ? 'selected' : '' }}>Deemed</option>
                        <option value="central" {{ $university->type === 'central' ? 'selected' : '' }}>Central</option>
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <label for="official_website" class="form-label">Official Website</label>
                <input type="url" class="form-control" id="official_website" name="official_website" value="{{ old('official_website', $university->official_website) }}">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="4">{{ old('description', $university->description) }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Update University</button>
        </form>
    </div>
</div>
@endsection
