@extends('admin.layout')

@section('title', 'User Profile #' . $user->id . ' - Admin Panel')

@section('content')
<div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-id-card text-info me-2"></i>User Profile: {{ $user->name }}</h1>
    <div>
        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary me-2"><i class="fas fa-edit me-1"></i>Edit Profile</a>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i>Back to List</a>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card shadow-sm text-center p-4">
            <div class="mb-3">
                @if($user->avatar)
                    <img src="{{ $user->avatar }}" alt="Avatar" class="rounded-circle shadow-sm" style="width: 100px; height: 100px; object-fit: cover;">
                @else
                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center fw-bold fs-3 shadow-sm" style="width: 100px; height: 100px;">
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    </div>
                @endif
            </div>
            <h4 class="fw-bold mb-1">{{ $user->name }}</h4>
            <p class="text-muted mb-2">{{ $user->email }}</p>
            <div class="mb-3">
                @if($user->role === 'admin')
                    <span class="badge bg-danger fs-6 px-3 py-1">Admin</span>
                @elseif($user->role === 'editor')
                    <span class="badge bg-warning text-dark fs-6 px-3 py-1">Editor</span>
                @else
                    <span class="badge bg-secondary fs-6 px-3 py-1">User</span>
                @endif
                
                @if($user->is_active)
                    <span class="badge bg-success fs-6 px-3 py-1 ms-1">Active</span>
                @else
                    <span class="badge bg-secondary fs-6 px-3 py-1 ms-1">Inactive</span>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white fw-bold">Account Details</div>
            <div class="card-body">
                <table class="table table-bordered align-middle mb-0">
                    <tr>
                        <th style="width: 200px;">User ID</th>
                        <td>#{{ $user->id }}</td>
                    </tr>
                    <tr>
                        <th>Full Name</th>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <th>Email Address</th>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <th>Phone Number</th>
                        <td>{{ $user->phone ?: 'Not provided' }}</td>
                    </tr>
                    <tr>
                        <th>Role</th>
                        <td>{{ ucfirst($user->role) }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>{{ $user->is_active ? 'Active Account' : 'Deactivated' }}</td>
                    </tr>
                    <tr>
                        <th>Registration Date</th>
                        <td>{{ $user->created_at ? $user->created_at->format('d M Y, h:i A') : 'N/A' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
