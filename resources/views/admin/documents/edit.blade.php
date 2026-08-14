@extends('admin.layout')

@section('title', 'Edit Document')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Document</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.documents.index') }}" class="btn btn-default btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Documents
                        </a>
                    </div>
                </div>
                
                <form action="{{ route('admin.documents.update', $document->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <!-- Basic Information -->
                                <div class="form-group">
                                    <label for="title">Title <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('title') is-invalid @enderror" 
                                           id="title" 
                                           name="title" 
                                           value="{{ old('title', $document->title) }}" 
                                           required>
                                    @error('title')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="slug">Slug</label>
                                    <input type="text" 
                                           class="form-control @error('slug') is-invalid @enderror" 
                                           id="slug" 
                                           name="slug" 
                                           value="{{ old('slug', $document->slug) }}">
                                    <small class="form-text text-muted">Leave empty to auto-generate from title</small>
                                    @error('slug')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="document_number">Document Number</label>
                                            <input type="text" 
                                                   class="form-control @error('document_number') is-invalid @enderror" 
                                                   id="document_number" 
                                                   name="document_number" 
                                                   value="{{ old('document_number', $document->document_number) }}">
                                            @error('document_number')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="category">Category</label>
                                            <input type="text" 
                                                   class="form-control @error('category') is-invalid @enderror" 
                                                   id="category" 
                                                   name="category" 
                                                   value="{{ old('category', $document->category) }}">
                                            @error('category')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="short_description">Short Description</label>
                                    <textarea class="form-control @error('short_description') is-invalid @enderror" 
                                              id="short_description" 
                                              name="short_description" 
                                              rows="2">{{ old('short_description', $document->short_description) }}</textarea>
                                    @error('short_description')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" 
                                              name="description" 
                                              rows="5">{{ old('description', $document->description) }}</textarea>
                                    @error('description')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Document File -->
                                <div class="form-group">
                                    <label>Current File</label>
                                    @if($document->file_path)
                                        <div class="alert alert-info">
                                            <i class="fas {{ $document->getFileIcon() }}"></i>
                                            {{ $document->file_name ?? basename($document->file_path) }}
                                            ({{ $document->getFormattedFileSize() }})
                                            <br>
                                            <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank" class="btn btn-sm btn-info mt-2">
                                                <i class="fas fa-eye"></i> View Current File
                                            </a>
                                        </div>
                                    @else
                                        <div class="alert alert-warning">No file uploaded</div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="file">Replace File (Optional)</label>
                                    <input type="file" 
                                           class="form-control-file @error('file') is-invalid @enderror" 
                                           id="file" 
                                           name="file">
                                    <small class="form-text text-muted">Allowed formats: PDF, DOC, DOCX, JPG, PNG (Max: 10MB)</small>
                                    @error('file')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Additional Information -->
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="department">Department</label>
                                            <input type="text" 
                                                   class="form-control @error('department') is-invalid @enderror" 
                                                   id="department" 
                                                   name="department" 
                                                   value="{{ old('department', $document->department) }}">
                                            @error('department')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="issued_by">Issued By</label>
                                            <input type="text" 
                                                   class="form-control @error('issued_by') is-invalid @enderror" 
                                                   id="issued_by" 
                                                   name="issued_by" 
                                                   value="{{ old('issued_by', $document->issued_by) }}">
                                            @error('issued_by')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="language">Language</label>
                                            <select class="form-control @error('language') is-invalid @enderror" 
                                                    id="language" 
                                                    name="language">
                                                <option value="en" {{ old('language', $document->language) == 'en' ? 'selected' : '' }}>English</option>
                                                <option value="hi" {{ old('language', $document->language) == 'hi' ? 'selected' : '' }}>Hindi</option>
                                                <option value="mr" {{ old('language', $document->language) == 'mr' ? 'selected' : '' }}>Marathi</option>
                                            </select>
                                            @error('language')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="issue_date">Issue Date</label>
                                            <input type="date" 
                                                   class="form-control @error('issue_date') is-invalid @enderror" 
                                                   id="issue_date" 
                                                   name="issue_date" 
                                                   value="{{ old('issue_date', $document->issue_date ? $document->issue_date->format('Y-m-d') : '') }}">
                                            @error('issue_date')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="valid_upto">Valid Upto</label>
                                            <input type="date" 
                                                   class="form-control @error('valid_upto') is-invalid @enderror" 
                                                   id="valid_upto" 
                                                   name="valid_upto" 
                                                   value="{{ old('valid_upto', $document->valid_upto ? $document->valid_upto->format('Y-m-d') : '') }}">
                                            @error('valid_upto')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="sort_order">Sort Order</label>
                                    <input type="number" 
                                           class="form-control @error('sort_order') is-invalid @enderror" 
                                           id="sort_order" 
                                           name="sort_order" 
                                           value="{{ old('sort_order', $document->sort_order) }}">
                                    @error('sort_order')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <!-- Status & Settings -->
                                <div class="form-group">
                                    <label for="type">Document Type</label>
                                    <select class="form-control @error('type') is-invalid @enderror" 
                                            id="type" 
                                            name="type" 
                                            required>
                                        <option value="notice" {{ old('type', $document->type) == 'notice' ? 'selected' : '' }}>Notice</option>
                                        <option value="certificate" {{ old('type', $document->type) == 'certificate' ? 'selected' : '' }}>Certificate</option>
                                    </select>
                                    @error('type')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" 
                                               class="custom-control-input" 
                                               id="is_active" 
                                               name="is_active" 
                                               value="1" 
                                               {{ old('is_active', $document->is_active) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="is_active">Active</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" 
                                               class="custom-control-input" 
                                               id="is_featured" 
                                               name="is_featured" 
                                               value="1" 
                                               {{ old('is_featured', $document->is_featured) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="is_featured">Featured Document</label>
                                    </div>
                                </div>

                                <!-- Statistics -->
                                <div class="card card-info mt-3">
                                    <div class="card-header">
                                        <h4 class="card-title">Statistics</h4>
                                    </div>
                                    <div class="card-body">
                                        <p><strong>Download Count:</strong> {{ number_format($document->download_count ?? 0) }}</p>
                                        <p><strong>Views:</strong> {{ number_format($document->views ?? 0) }}</p>
                                        <p><strong>Created:</strong> {{ $document->created_at ? $document->created_at->format('d M Y, h:i A') : 'N/A' }}</p>
                                        <p><strong>Last Updated:</strong> {{ $document->updated_at ? $document->updated_at->format('d M Y, h:i A') : 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Document
                        </button>
                        <a href="{{ route('admin.documents.index') }}" class="btn btn-default">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto-generate slug from title
    const titleInput = document.getElementById('title');
    const slugInput = document.getElementById('slug');
    
    if (titleInput && slugInput) {
        titleInput.addEventListener('keyup', function() {
            if (slugInput.value === '' || slugInput.getAttribute('data-auto') === 'true') {
                let slug = this.value.toLowerCase()
                    .replace(/[^\w\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/--+/g, '-')
                    .trim();
                slugInput.value = slug;
                slugInput.setAttribute('data-auto', 'true');
            }
        });
        
        // Initialize slug auto-generate flag
        if (slugInput.value === '') {
            slugInput.setAttribute('data-auto', 'true');
        } else {
            slugInput.setAttribute('data-auto', 'false');
        }
    }
</script>
@endpush