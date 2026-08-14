@extends('layouts.app')

@section('title', $blog->title . ' - Sarkari Result 2026')
@section('meta_description', $blog->meta_description)
@section('meta_keywords', $blog->meta_keywords)
@section('meta_robots', $blog->status === 'published' ? 'index, follow' : 'noindex, follow')
@section('canonical', route('blog.show', $blog->slug))

@section('og_title', $blog->title)
@section('og_description', $blog->meta_description)
@section('og_image', asset('storage/' . $blog->featured_image))
@section('og_type', 'article')
@section('og_url', route('blog.show', $blog->slug))

@section('twitter_title', $blog->title)
@section('twitter_description', $blog->meta_description)
@section('twitter_image', asset('storage/' . $blog->featured_image))

@push('styles')
<style>
    .article-content h1 {
        font-size: 2.2rem;
        margin: 2rem 0 1rem;
        color: #1a1a1a;
    }
    
    .article-content h2 {
        font-size: 1.8rem;
        margin: 1.5rem 0 1rem;
        color: #2c3e50;
    }
    
    .article-content h3 {
        font-size: 1.4rem;
        margin: 1.2rem 0 0.8rem;
        color: #34495e;
    }
    
    .article-content p {
        margin-bottom: 1.2rem;
        line-height: 1.8;
        font-size: 1.1rem;
    }
    
    .article-content ul, .article-content ol {
        margin-bottom: 1.2rem;
        padding-left: 2rem;
    }
    
    .article-content li {
        margin-bottom: 0.5rem;
        line-height: 1.6;
    }
    
    .article-content img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 1.5rem 0;
    }
    
    .article-content blockquote {
        border-left: 4px solid #007bff;
        padding: 1rem 1.5rem;
        margin: 1.5rem 0;
        background: #f8f9fa;
        border-radius: 4px;
    }
    
    .article-content blockquote p {
        margin-bottom: 0;
        font-style: italic;
        color: #495057;
    }
    
    .social-share-btn {
        transition: transform 0.2s ease;
    }
    
    .social-share-btn:hover {
        transform: translateY(-3px);
    }
</style>
@endpush

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <!-- Breadcrumb -->
            <nav aria-label="Breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('blog.index') }}">Blog</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($blog->title, 30) }}</li>
                </ol>
            </nav>

            <!-- Article Header -->
            <div class="mb-4">
                @if($blog->is_breaking)
                <span class="badge bg-danger mb-2">
                    <i class="fas fa-bolt me-1"></i>Breaking News
                </span>
                @endif
                
                @if($blog->is_featured)
                <span class="badge bg-warning text-dark mb-2">
                    <i class="fas fa-star me-1"></i>Featured
                </span>
                @endif
                
                <h1 class="display-5 fw-bold mb-3">{{ $blog->title }}</h1>
                
                <div class="d-flex flex-wrap align-items-center gap-3 text-muted small">
                    <span>
                        <i class="fas fa-user me-1"></i>
                        {{ $blog->author?->name ?? 'Sarkari Result' }}
                    </span>
                    <span>
                        <i class="fas fa-calendar me-1"></i>
                        {{ $blog->published_at->format('d M Y') }}
                    </span>
                    <span>
                        <i class="fas fa-clock me-1"></i>
                        {{ $blog->reading_time }}
                    </span>
                    <span>
                        <i class="fas fa-eye me-1"></i>
                        {{ number_format($blog->views) }} views
                    </span>
                    @if($blog->category)
                    <span>
                        <i class="fas fa-folder me-1"></i>
                        <a href="{{ route('blog.category', $blog->category->slug) }}" class="text-decoration-none">
                            {{ $blog->category->name }}
                        </a>
                    </span>
                    @endif
                </div>
            </div>

            <!-- Featured Image -->
            @if($blog->featured_image)
            <div class="mb-4">
                <img src="{{ asset('storage/' . $blog->featured_image) }}" 
                     alt="{{ $blog->title }}" 
                     class="img-fluid rounded shadow-sm"
                     loading="lazy"
                     width="1200"
                     height="630">
                @if($blog->image_caption)
                <p class="text-muted small mt-2 text-center">{{ $blog->image_caption }}</p>
                @endif
            </div>
            @endif

            <!-- Article Content -->
            <div class="article-content mb-5">
                {!! $blog->content !!}
            </div>

            <!-- Tags -->
            @if($blog->tags)
            <div class="mb-4">
                <h6 class="fw-bold">Tags</h6>
                @foreach(explode(',', $blog->tags) as $tag)
                    <a href="{{ route('blog.tag', trim($tag)) }}" class="badge bg-secondary text-decoration-none me-1">
                        #{{ trim($tag) }}
                    </a>
                @endforeach
            </div>
            @endif

            <!-- Social Share -->
            <div class="card bg-light mb-4">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Share this article</h6>
                    <div class="d-flex gap-2">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blog.show', $blog->slug)) }}" 
                           target="_blank" 
                           class="btn btn-primary social-share-btn"
                           aria-label="Share on Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('blog.show', $blog->slug)) }}&text={{ urlencode($blog->title) }}" 
                           target="_blank" 
                           class="btn btn-info social-share-btn"
                           aria-label="Share on Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(route('blog.show', $blog->slug)) }}" 
                           target="_blank" 
                           class="btn btn-secondary social-share-btn"
                           aria-label="Share on LinkedIn">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($blog->title . ' - ' . route('blog.show', $blog->slug)) }}" 
                           target="_blank" 
                           class="btn btn-success social-share-btn"
                           aria-label="Share on WhatsApp">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <button onclick="copyLink()" class="btn btn-dark social-share-btn">
                            <i class="fas fa-link"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Related Articles -->
            @if($relatedArticles->count() > 0)
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Related Articles</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach($relatedArticles->take(3) as $related)
                        <div class="col-md-4">
                            <div class="card h-100">
                                @if($related->featured_image)
                                <img src="{{ asset('storage/' . $related->featured_image) }}" 
                                     class="card-img-top" 
                                     alt="{{ $related->title }}"
                                     loading="lazy"
                                     style="height: 150px; object-fit: cover;">
                                @endif
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <a href="{{ route('blog.show', $related->slug) }}" class="text-decoration-none">
                                            {{ Str::limit($related->title, 40) }}
                                        </a>
                                    </h6>
                                    <small class="text-muted">{{ $related->published_at->format('d M Y') }}</small>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Schema Markup -->
@if($blog->enable_schema)
<script type="application/ld+json">
{!! json_encode($blog->getArticleSchema(), JSON_UNESCAPED_SLASHES) !!}
</script>
@endif

@if($blog->enable_breadcrumb)
<script type="application/ld+json">
{!! json_encode($blog->getBreadcrumbSchema(), JSON_UNESCAPED_SLASHES) !!}
</script>
@endif

@push('scripts')
<script>
function copyLink() {
    const url = '{{ route('blog.show', $blog->slug) }}';
    navigator.clipboard.writeText(url).then(() => {
        alert('Link copied to clipboard!');
    });
}

// Track article view
document.addEventListener('DOMContentLoaded', function() {
    fetch('{{ route('blog.view', $blog->slug) }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    });
});
</script>
@endpush
@endsection