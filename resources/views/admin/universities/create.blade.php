@extends('admin.layout')

@section('title', 'Add New University')
@section('content')
<div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-plus-circle me-2"></i>Add University</h1>
    <a href="{{ route('admin.universities.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Back</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.universities.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">University Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="state" class="form-label">State</label>
                    <input type="text" class="form-control" id="state" name="state">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="city" class="form-label">City</label>
                    <input type="text" class="form-control" id="city" name="city">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="type" class="form-label">Type</label>
                    <select class="form-select" id="type" name="type">
                        <option value="public">Public</option>
                        <option value="private">Private</option>
                        <option value="deemed">Deemed</option>
                        <option value="central">Central</option>
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <label for="official_website" class="form-label">Official Website</label>
                <input type="url" class="form-control" id="official_website" name="official_website" placeholder="https://example.edu">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="4"></textarea>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Save University</button>
        </form>
    </div>
</div>
@endsection
