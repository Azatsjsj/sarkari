@extends('layouts.app')

@section('title', 'Create Blog Article - Sarkari Result 2026')
@section('meta_description', 'Create and publish SEO-optimized blog articles about government jobs, Sarkari Result updates, and career guidance for 2026.')
@section('meta_keywords', 'create blog, sarkari result blog, government jobs article, seo blog, publish article')
@section('meta_robots', 'noindex, follow') {{-- Admin pages should not be indexed --}}

@push('styles')
<style>
    .seo-preview-card {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
        border: 1px solid #e9ecef;
    }
    
    .seo-preview-card .preview-title {
        color: #1a0dab;
        font-size: 18px;
        text-decoration: none;
        cursor: pointer;
    }
    
    .seo-preview-card .preview-title:hover {
        text-decoration: underline;
    }
    
    .seo-preview-card .preview-url {
        color: #006621;
        font-size: 14px;
        margin: 2px 0;
    }
    
    .seo-preview-card .preview-description {
        color: #545454;
        font-size: 13px;
        line-height: 1.4;
    }
    
    .meta-tag-input {
        font-family: 'Courier New', monospace;
        font-size: 13px;
    }
    
    .character-counter {
        font-size: 12px;
        color: #6c757d;
        margin-top: 4px;
    }
    
    .character-counter .text-danger {
        color: #dc3545 !important;
    }
    
    .slug-preview {
        background: #e9ecef;
        padding: 8px 12px;
        border-radius: 4px;
        font-size: 14px;
        color: #495057;
        word-break: break-all;
    }
    
    .auto-generate-btn {
        cursor: pointer;
        color: #007bff;
        font-size: 12px;
    }
    
    .auto-generate-btn:hover {
        text-decoration: underline;
    }
    
    @media (max-width: 768px) {
        .seo-preview-card {
            margin-top: 20px;
        }
    }
</style>
@endpush

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h2 mb-0">
                        <i class="fas fa-pencil-alt me-2 text-primary"></i>Create Blog Article
                    </h1>
                    <p class="text-muted mt-1">Publish SEO-optimized articles for Sarkari Result 2026</p>
                </div>
                <a href="{{ route('admin.blog.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Articles
                </a>
            </div>

            <!-- Main Form -->
            <form action="{{ route('admin.blog.store') }}" method="POST" enctype="multipart/form-data" id="blogForm">
                @csrf
                
                <div class="row">
                    <!-- Left Column - Main Content -->
                    <div class="col-lg-8">
                        <!-- Article Title -->
                        <div class="card shadow-sm mb-4">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="title" class="form-label fw-bold">
                                        <i class="fas fa-heading me-2 text-primary"></i>Article Title
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control form-control-lg @error('title') is-invalid @enderror" 
                                           id="title" 
                                           name="title" 
                                           placeholder="Enter compelling article title (e.g., How to Crack SSC CGL 2026 in 3 Months)"
                                           value="{{ old('title') }}"
                                           required
                                           maxlength="200">
                                    <div class="d-flex justify-content-between mt-1">
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle me-1"></i>Keep it under 60 characters for best SEO
                                        </small>
                                        <span class="character-counter" id="titleCounter">
                                            <span id="titleCount">0</span>/200
                                        </span>
                                    </div>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Slug -->
                                <div class="mb-3">
                                    <label for="slug" class="form-label fw-bold">
                                        <i class="fas fa-link me-2 text-primary"></i>URL Slug
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">{{ url('/blog') }}/</span>
                                        <input type="text" 
                                               class="form-control @error('slug') is-invalid @enderror" 
                                               id="slug" 
                                               name="slug" 
                                               placeholder="e.g., how-to-crack-ssc-cgl-2026"
                                               value="{{ old('slug') }}"
                                               required>
                                    </div>
                                    <div class="d-flex justify-content-between mt-1">
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle me-1"></i>Auto-generated from title
                                        </small>
                                        <span class="auto-generate-btn" onclick="generateSlug()">
                                            <i class="fas fa-magic me-1"></i>Auto Generate
                                        </span>
                                    </div>
                                    @error('slug')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Category & Tags -->
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="category_id" class="form-label fw-bold">
                                            <i class="fas fa-folder me-2 text-primary"></i>Category
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select @error('category_id') is-invalid @enderror" 
                                                id="category_id" 
                                                name="category_id" 
                                                required>
                                            <option value="">Select Category</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" 
                                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="tags" class="form-label fw-bold">
                                            <i class="fas fa-tags me-2 text-primary"></i>Tags
                                        </label>
                                        <input type="text" 
                                               class="form-control @error('tags') is-invalid @enderror" 
                                               id="tags" 
                                               name="tags" 
                                               placeholder="e.g., SSC, CGL, Government Job, Sarkari Result"
                                               value="{{ old('tags') }}">
                                        <small class="text-muted">Separate tags with commas</small>
                                        @error('tags')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Article Content -->
                        <div class="card shadow-sm mb-4">
                            <div class="card-body">
                                <label for="content" class="form-label fw-bold">
                                    <i class="fas fa-file-alt me-2 text-primary"></i>Article Content
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="mb-2">
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Minimum 300 words recommended for better SEO
                                    </small>
                                    <span class="float-end" id="wordCounter">
                                        <span id="wordCount">0</span> words
                                    </span>
                                </div>
                                <textarea class="form-control @error('content') is-invalid @enderror" 
                                          id="content" 
                                          name="content" 
                                          rows="20" 
                                          placeholder="Write your detailed article here... Use ## for headings, **bold** text, and - for lists"
                                          required>{{ old('content') }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Featured Image -->
                        <div class="card shadow-sm mb-4">
                            <div class="card-body">
                                <label for="featured_image" class="form-label fw-bold">
                                    <i class="fas fa-image me-2 text-primary"></i>Featured Image
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="file" 
                                       class="form-control @error('featured_image') is-invalid @enderror" 
                                       id="featured_image" 
                                       name="featured_image" 
                                       accept="image/jpeg,image/png,image/webp"
                                       required>
                                <div class="mt-2">
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Recommended: 1200x630px (JPG, PNG, or WebP, max 2MB)
                                    </small>
                                </div>
                                <div id="imagePreview" class="mt-3"></div>
                                @error('featured_image')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Additional Images -->
                        <div class="card shadow-sm mb-4">
                            <div class="card-body">
                                <label for="additional_images" class="form-label fw-bold">
                                    <i class="fas fa-images me-2 text-primary"></i>Additional Images
                                </label>
                                <input type="file" 
                                       class="form-control @error('additional_images.*') is-invalid @enderror" 
                                       id="additional_images" 
                                       name="additional_images[]" 
                                       multiple
                                       accept="image/jpeg,image/png,image/webp">
                                <small class="text-muted">Select multiple images for the article gallery</small>
                                @error('additional_images.*')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - SEO Settings -->
                    <div class="col-lg-4">
                        <!-- SEO Meta Tags -->
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-search me-2"></i>SEO Settings
                                </h5>
                            </div>
                            <div class="card-body">
                                <!-- Meta Description -->
                                <div class="mb-3">
                                    <label for="meta_description" class="form-label fw-bold">
                                        Meta Description
                                        <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control meta-tag-input @error('meta_description') is-invalid @enderror" 
                                              id="meta_description" 
                                              name="meta_description" 
                                              rows="3" 
                                              placeholder="Write a compelling description (150-160 characters) for search results"
                                              maxlength="160">{{ old('meta_description') }}</textarea>
                                    <div class="character-counter">
                                        <span id="metaDescCount">0</span>/160 characters
                                    </div>
                                    @error('meta_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Meta Keywords -->
                                <div class="mb-3">
                                    <label for="meta_keywords" class="form-label fw-bold">
                                        Meta Keywords
                                    </label>
                                    <input type="text" 
                                           class="form-control meta-tag-input @error('meta_keywords') is-invalid @enderror" 
                                           id="meta_keywords" 
                                           name="meta_keywords" 
                                           placeholder="sarkari result, government jobs, exam preparation"
                                           value="{{ old('meta_keywords') }}">
                                    <small class="text-muted">Separate keywords with commas</small>
                                    @error('meta_keywords')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Focus Keyphrase -->
                                <div class="mb-3">
                                    <label for="focus_keyphrase" class="form-label fw-bold text-success">
                                        <i class="fas fa-bullseye me-1"></i>Focus Keyphrase
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('focus_keyphrase') is-invalid @enderror" 
                                           id="focus_keyphrase" 
                                           name="focus_keyphrase" 
                                           placeholder="e.g., sarkari result 2026"
                                           value="{{ old('focus_keyphrase') }}"
                                           required>
                                    <small class="text-muted">Main keyword you want to rank for</small>
                                    @error('focus_keyphrase')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- SEO Score -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-chart-line me-2 text-primary"></i>SEO Score
                                    </label>
                                    <div id="seoScore">
                                        <div class="progress" style="height: 25px;">
                                            <div class="progress-bar bg-warning" 
                                                 role="progressbar" 
                                                 style="width: 0%" 
                                                 aria-valuenow="0" 
                                                 aria-valuemin="0" 
                                                 aria-valuemax="100">
                                                0%
                                            </div>
                                        </div>
                                        <small class="text-muted mt-1 d-block">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Auto-calculated based on SEO best practices
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Google Preview -->
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-dark text-white">
                                <h5 class="mb-0">
                                    <i class="fab fa-google me-2"></i>Google Search Preview
                                </h5>
                            </div>
                            <div class="card-body seo-preview-card">
                                <div id="googlePreview">
                                    <div class="preview-title" id="previewTitle">
                                        {{ old('title') ?: 'Sarkari Result 2026 - Article Title' }}
                                    </div>
                                    <div class="preview-url" id="previewUrl">
                                        {{ url('/blog') }}/{{ old('slug') ?: 'article-slug' }}
                                    </div>
                                    <div class="preview-description" id="previewDescription">
                                        {{ old('meta_description') ?: 'Meta description will appear here. Optimize for 150-160 characters.' }}
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i>
                                        This is how your article will appear in Google search results
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- Schema Markup Preview -->
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-code me-2"></i>Schema Markup
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="enable_schema" name="enable_schema" checked>
                                    <label class="form-check-label" for="enable_schema">
                                        Enable Article Schema
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="enable_breadcrumb" name="enable_breadcrumb" checked>
                                    <label class="form-check-label" for="enable_breadcrumb">
                                        Enable Breadcrumb Schema
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="enable_faq" name="enable_faq">
                                    <label class="form-check-label" for="enable_faq">
                                        Enable FAQ Schema
                                    </label>
                                </div>
                                <small class="text-muted mt-2 d-block">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Structured data improves search result appearance
                                </small>
                            </div>
                        </div>

                        <!-- Publication Settings -->
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-clock me-2"></i>Publication Settings
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="status" class="form-label fw-bold">Status</label>
                                    <select class="form-select @error('status') is-invalid @enderror" 
                                            id="status" 
                                            name="status">
                                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Publish Now</option>
                                        <option value="scheduled" {{ old('status') == 'scheduled' ? 'selected' : '' }}>Schedule</option>
                                    </select>
                                </div>

                                <div class="mb-3" id="scheduleDateTime" style="display: none;">
                                    <label for="published_at" class="form-label fw-bold">Publish Date & Time</label>
                                    <input type="datetime-local" 
                                           class="form-control @error('published_at') is-invalid @enderror" 
                                           id="published_at" 
                                           name="published_at" 
                                           value="{{ old('published_at') }}">
                                    @error('published_at')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_featured">
                                        <i class="fas fa-star text-warning me-1"></i>Feature this article
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_breaking" name="is_breaking" value="1" {{ old('is_breaking') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_breaking">
                                        <i class="fas fa-bolt text-danger me-1"></i>Mark as Breaking News
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Actions -->
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <button type="submit" class="btn btn-primary btn-lg w-100 mb-2" id="submitBtn">
                                    <i class="fas fa-save me-2"></i>Save Article
                                </button>
                                <button type="button" class="btn btn-outline-success w-100" onclick="previewArticle()">
                                    <i class="fas fa-eye me-2"></i>Preview Article
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Article Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="previewContent">
                <!-- Preview content will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Character counters
    const titleInput = document.getElementById('title');
    const metaDescInput = document.getElementById('meta_description');
    const contentInput = document.getElementById('content');
    
    // Title counter
    titleInput.addEventListener('input', function() {
        const count = this.value.length;
        document.getElementById('titleCount').textContent = count;
        updatePreview();
        generateSlug();
    });
    
    // Meta description counter
    metaDescInput.addEventListener('input', function() {
        const count = this.value.length;
        document.getElementById('metaDescCount').textContent = count;
        if (count > 160) {
            this.style.borderColor = '#dc3545';
        } else {
            this.style.borderColor = '';
        }
        updatePreview();
    });
    
    // Content word counter
    contentInput.addEventListener('input', function() {
        const text = this.value.trim();
        const words = text ? text.split(/\s+/).length : 0;
        document.getElementById('wordCount').textContent = words;
        updateSEOScore();
    });
    
    // Slug generation
    document.getElementById('slug').addEventListener('input', updatePreview);
    
    // Status change
    document.getElementById('status').addEventListener('change', function() {
        const scheduleDiv = document.getElementById('scheduleDateTime');
        if (this.value === 'scheduled') {
            scheduleDiv.style.display = 'block';
        } else {
            scheduleDiv.style.display = 'none';
        }
    });
    
    // Image preview
    document.getElementById('featured_image').addEventListener('change', function(e) {
        const preview = document.getElementById('imagePreview');
        preview.innerHTML = '';
        
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(event) {
                preview.innerHTML = `
                    <div class="mt-2">
                        <img src="${event.target.result}" alt="Preview" class="img-fluid rounded" style="max-height: 200px;">
                        <p class="small text-muted mt-1">Selected: ${e.target.files[0].name}</p>
                    </div>
                `;
            };
            reader.readAsDataURL(this.files[0]);
        }
    });
});

// Generate slug from title
function generateSlug() {
    const title = document.getElementById('title').value;
    const slugInput = document.getElementById('slug');
    
    if (title && !slugInput.value) {
        const slug = title
            .toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-');
        slugInput.value = slug;
        updatePreview();
    }
}

// Update Google preview
function updatePreview() {
    const title = document.getElementById('title').value || 'Sarkari Result 2026 - Article Title';
    const slug = document.getElementById('slug').value || 'article-slug';
    const description = document.getElementById('meta_description').value || 
                       'Meta description will appear here. Optimize for 150-160 characters.';
    
    document.getElementById('previewTitle').textContent = title.substring(0, 60);
    document.getElementById('previewUrl').textContent = `${window.location.origin}/blog/${slug}`;
    document.getElementById('previewDescription').textContent = description.substring(0, 160);
}

// Update SEO score
function updateSEOScore() {
    let score = 0;
    const title = document.getElementById('title').value;
    const content = document.getElementById('content').value;
    const metaDesc = document.getElementById('meta_description').value;
    const focusKeyphrase = document.getElementById('focus_keyphrase').value;
    
    // Title check (20 points)
    if (title.length >= 30 && title.length <= 60) {
        score += 20;
    } else if (title.length > 0) {
        score += 10;
    }
    
    // Content length (30 points)
    const words = content.trim().split(/\s+/).length;
    if (words >= 1000) {
        score += 30;
    } else if (words >= 500) {
        score += 20;
    } else if (words >= 300) {
        score += 10;
    }
    
    // Meta description (25 points)
    if (metaDesc.length >= 150 && metaDesc.length <= 160) {
        score += 25;
    } else if (metaDesc.length >= 120) {
        score += 15;
    } else if (metaDesc.length > 0) {
        score += 5;
    }
    
    // Focus keyphrase (15 points)
    if (focusKeyphrase && content.toLowerCase().includes(focusKeyphrase.toLowerCase())) {
        score += 15;
    }
    
    // Image (10 points)
    if (document.getElementById('featured_image').files.length > 0) {
        score += 10;
    }
    
    // Update progress bar
    const progressBar = document.querySelector('#seoScore .progress-bar');
    progressBar.style.width = score + '%';
    progressBar.textContent = score + '%';
    
    // Color coding
    if (score >= 80) {
        progressBar.className = 'progress-bar bg-success';
    } else if (score >= 50) {
        progressBar.className = 'progress-bar bg-warning';
    } else {
        progressBar.className = 'progress-bar bg-danger';
    }
}

// Preview article
function previewArticle() {
    const title = document.getElementById('title').value || 'Untitled Article';
    const content = document.getElementById('content').value || 'No content available.';
    const categories = document.getElementById('category_id');
    const categoryName = categories.options[categories.selectedIndex]?.text || 'Uncategorized';
    
    const previewContent = document.getElementById('previewContent');
    previewContent.innerHTML = `
        <div class="container">
            <h1 class="h2 mb-3">${title}</h1>
            <div class="text-muted mb-3">
                <i class="fas fa-folder me-1"></i>${categoryName}
                <span class="mx-2">|</span>
                <i class="fas fa-calendar me-1"></i>${new Date().toLocaleDateString('en-US', { 
                    year: 'numeric', 
                    month: 'long', 
                    day: 'numeric' 
                })}
            </div>
            <div class="content-preview">
                ${content.replace(/\n/g, '<br>')}
            </div>
        </div>
    `;
    
    new bootstrap.Modal(document.getElementById('previewModal')).show();
}

// Markdown to HTML (basic)
function markdownToHTML(text) {
    // Headers
    text = text.replace(/^### (.*$)/gm, '<h3>$1</h3>');
    text = text.replace(/^## (.*$)/gm, '<h2>$1</h2>');
    text = text.replace(/^# (.*$)/gm, '<h1>$1</h1>');
    
    // Bold
    text = text.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
    
    // Lists
    text = text.replace(/^- (.*$)/gm, '<li>$1</li>');
    text = text.replace(/(<li>.*<\/li>)/s, '<ul>$1</ul>');
    
    // Paragraphs
    text = text.replace(/\n\n/g, '</p><p>');
    text = '<p>' + text + '</p>';
    
    return text;
}

// Form validation before submit
document.getElementById('blogForm').addEventListener('submit', function(e) {
    const title = document.getElementById('title').value;
    const content = document.getElementById('content').value;
    const metaDesc = document.getElementById('meta_description').value;
    const focusKeyphrase = document.getElementById('focus_keyphrase').value;
    const image = document.getElementById('featured_image').files.length;
    
    let errors = [];
    
    if (!title) {
        errors.push('Title is required');
    }
    
    if (!content || content.trim().split(/\s+/).length < 300) {
        errors.push('Content must be at least 300 words');
    }
    
    if (!metaDesc || metaDesc.length < 120) {
        errors.push('Meta description should be at least 120 characters');
    }
    
    if (!focusKeyphrase) {
        errors.push('Focus keyphrase is required');
    }
    
    if (!image) {
        errors.push('Featured image is required');
    }
    
    if (errors.length > 0) {
        e.preventDefault();
        alert('Please fix the following issues:\n\n• ' + errors.join('\n• '));
        return false;
    }
    
    // Show loading state
    const btn = document.getElementById('submitBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Saving...';
});
</script>
@endpush
@endsection