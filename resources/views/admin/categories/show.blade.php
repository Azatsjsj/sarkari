@extends('admin.layout')

@section('title', 'Category Details')
@section('content')
<div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-folder me-2"></i>{{ $category->name }}</h1>
    <div>
        <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit me-1"></i>Edit</a>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Back</a>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-bordered">
            <tr><th>Name</th><td>{{ $category->name }}</td></tr>
            <tr><th>Slug</th><td>{{ $category->slug }}</td></tr>
            <tr><th>Description</th><td>{{ $category->description ?? 'N/A' }}</td></tr>
            <tr><th>Status</th><td><span class="badge bg-{{ $category->is_active ? 'success' : 'secondary' }}">{{ $category->is_active ? 'Active' : 'Inactive' }}</span></td></tr>
            <tr><th>Created At</th><td>{{ safe_date_format($category->created_at) }}</td></tr>
        </table>
    </div>
</div>
@endsection
