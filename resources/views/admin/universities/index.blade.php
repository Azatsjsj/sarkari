@extends('admin.layout')

@section('title', 'Manage Universities')
@section('content')
<div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-university me-2"></i>Universities</h1>
    <a href="{{ route('admin.universities.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus me-1"></i>Add University</a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>State</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($universities ?? [] as $uni)
                <tr>
                    <td>{{ $uni->id }}</td>
                    <td><strong>{{ $uni->name }}</strong></td>
                    <td>{{ $uni->state ?? 'N/A' }}</td>
                    <td><span class="badge bg-info">{{ ucfirst($uni->type ?? 'Public') }}</span></td>
                    <td>
                        <span class="badge bg-{{ $uni->is_active ? 'success' : 'secondary' }}">
                            {{ $uni->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="text-end">
                        <a href="{{ route('admin.universities.edit', $uni->id) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">No universities found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
