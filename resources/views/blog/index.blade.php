@extends('layouts.app')

@section('title', isset($category) ? $category->name . ' - Blog' : (isset($tag) ? '#' . $tag . ' - Blog' : 'Blog - Sarkari Result 2026'))
@section('meta_description', 'Latest articles, exam tips, and government job updates from Sarkari Result.')

@section('content')
<div class="container py-4">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Blog</li>
            @if(isset($category))
            <li class="breadcrumb-item active">{{ $category->name }}</li>
            @endif
            @if(isset($tag))
            <li class="breadcrumb-item active">#{{ $tag }}</li>
            @endif
        </ol>
    </nav>

    <div class="row">
        <div class="col-lg-8">
            <h1 class="h3 mb-4">
                @if(isset($category))
                    {{ $category->name }} Articles
                @elseif(isset($tag))
                    Articles tagged #{{ $tag }}
                @else
                    Latest Blog Articles
                @endif
            </h1>

            @forelse($blogs as $blog)
            <article class="card mb-3 shadow-sm">
                <div class="row g-0">
                    @if($blog->featured_image)
                    <div class="col-md-4">
                        <img src="{{ asset('storage/' . $blog->featured_image) }}" class="img-fluid rounded-start h-100" alt="{{ $blog->title }}" style="object-fit: cover; min-height: 160px;">
                    </div>
                    @endif
                    <div class="{{ $blog->featured_image ? 'col-md-8' : 'col-12' }}">
                        <div class="card-body">
                            <h2 class="h5 card-title">
                                <a href="{{ route('blog.show', $blog->slug) }}" class="text-decoration-none">{{ $blog->title }}</a>
                            </h2>
                            <p class="card-text text-muted small mb-2">
                                {{ $blog->published_at?->format('d M Y') }} · {{ $blog->reading_time }}
                                @if($blog->category) · {{ $blog->category->name }} @endif
                            </p>
                            <p class="card-text">{{ Str::limit(strip_tags($blog->content), 160) }}</p>
                            <a href="{{ route('blog.show', $blog->slug) }}" class="btn btn-sm btn-primary">Read More</a>
                        </div>
                    </div>
                </div>
            </article>
            @empty
            <div class="alert alert-info">No articles found.</div>
            @endforelse

            {{ $blogs->links() }}
        </div>

        <div class="col-lg-4">
            @if(isset($featuredBlogs) && $featuredBlogs->count())
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">Featured Articles</div>
                <ul class="list-group list-group-flush">
                    @foreach($featuredBlogs as $featured)
                    <li class="list-group-item">
                        <a href="{{ route('blog.show', $featured->slug) }}" class="text-decoration-none">{{ Str::limit($featured->title, 60) }}</a>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
