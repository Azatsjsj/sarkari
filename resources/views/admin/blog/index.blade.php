@extends('admin.layout')

@section('content')
<div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Blog Articles</h1>
    <a href="{{ route('admin.blog.create') }}" class="btn btn-primary btn-sm">
        <i class="fas fa-plus"></i> New Article
    </a>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Title</th>
                <th>Status</th>
                <th>Featured</th>
                <th>Published</th>
                <th>Views</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($blogs as $blog)
            <tr>
                <td>{{ Str::limit($blog->title, 50) }}</td>
                <td><span class="badge bg-{{ $blog->status === 'published' ? 'success' : 'secondary' }}">{{ ucfirst($blog->status) }}</span></td>
                <td>{{ $blog->is_featured ? 'Yes' : 'No' }}</td>
                <td>{{ $blog->published_at?->format('d M Y') ?? '-' }}</td>
                <td>{{ $blog->views }}</td>
                <td>
                    <a href="{{ route('blog.show', $blog->slug) }}" class="btn btn-sm btn-outline-info" target="_blank">View</a>
                    <a href="{{ route('admin.blog.edit', $blog) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                    <form action="{{ route('admin.blog.destroy', $blog) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this article?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center">No articles yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

{{ $blogs->links() }}
@endsection
