<!-- resources/views/admin/admit-cards/edit.blade.php -->
@extends('admin.layout')

@section('title', 'Edit Admit Card - Admin Panel')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-ticket-alt text-primary"></i> Edit Admit Card
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.admit-cards.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to List
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.admit-cards.update', $admitCard->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-8">
                    <!-- Basic Information -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Basic Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="title" class="form-label">Admit Card Title *</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                       id="title" name="title" value="{{ old('title', $admitCard->title) }}" required
                                       placeholder="e.g., SSC CGL Tier-I Admit Card 2024">
                                @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="slug" class="form-label">Slug</label>
                                <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                                       id="slug" name="slug" value="{{ old('slug', $admitCard->slug) }}"
                                       placeholder="ssc-cgl-tier-i-admit-card-2024">
                                <div class="form-text">Leave empty to auto-generate from title</div>
                                @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="exam_name" class="form-label">Exam Name *</label>
                                        <input type="text" class="form-control @error('exam_name') is-invalid @enderror" 
                                               id="exam_name" name="exam_name" value="{{ old('exam_name', $admitCard->exam_name) }}" required
                                               placeholder="e.g., SSC CGL Tier-I">
                                        @error('exam_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="job_id" class="form-label">Related Job (Optional)</label>
                                        <select class="form-select @error('job_id') is-invalid @enderror" 
                                                id="job_id" name="job_id">
                                            <option value="">Select Related Job</option>
                                            @foreach($jobs as $job)
                                            <option value="{{ $job->id }}" {{ old('job_id', $admitCard->job_id) == $job->id ? 'selected' : '' }}>
                                                {{ $job->title }} ({{ $job->last_date->format('d M Y') }})
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('job_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="exam_date" class="form-label">Exam Date *</label>
                                        <input type="date" class="form-control @error('exam_date') is-invalid @enderror" 
                                               id="exam_date" name="exam_date" value="{{ old('exam_date', $admitCard->exam_date->format('Y-m-d')) }}" required>
                                        @error('exam_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="admit_card_date" class="form-label">Admit Card Date *</label>
                                        <input type="date" class="form-control @error('admit_card_date') is-invalid @enderror" 
                                               id="admit_card_date" name="admit_card_date" value="{{ old('admit_card_date', $admitCard->admit_card_date->format('Y-m-d')) }}" required>
                                        @error('admit_card_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="release_date" class="form-label">Release Date</label>
                                        <input type="date" class="form-control @error('release_date') is-invalid @enderror" 
                                               id="release_date" name="release_date" value="{{ old('release_date', $admitCard->release_date ? $admitCard->release_date->format('Y-m-d') : '') }}">
                                        @error('release_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="short_description" class="form-label">Short Description</label>
                                <textarea class="form-control @error('short_description') is-invalid @enderror" 
                                          id="short_description" name="short_description" rows="3"
                                          placeholder="Brief description about this admit card...">{{ old('short_description', $admitCard->short_description) }}</textarea>
                                <div class="form-text" id="short-desc-counter">0/500 characters</div>
                                @error('short_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Detailed Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" name="description" rows="8"
                                          placeholder="Detailed information about the admit card, download process, etc...">{{ old('description', $admitCard->description) }}</textarea>
                                @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="instructions" class="form-label">Instructions</label>
                                <textarea class="form-control @error('instructions') is-invalid @enderror" 
                                          id="instructions" name="instructions" rows="5"
                                          placeholder="Important instructions for candidates...">{{ old('instructions', $admitCard->instructions) }}</textarea>
                                @error('instructions')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- File & Download Options -->
                    <div class="card mb-4">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">File & Download Options</h5>
                        </div>
                        <div class="card-body">
                            <!-- Current File -->
                            @if($admitCard->admit_card_file)
                            <div class="mb-3">
                                <label class="form-label">Current File</label>
                                <div class="alert alert-info d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="{{ $admitCard->file_icon }} me-2"></i>
                                        {{ basename($admitCard->admit_card_file) }}
                                        @if($admitCard->file_size)
                                        <span class="badge bg-secondary ms-2">{{ $admitCard->file_size }}</span>
                                        @endif
                                    </div>
                                    <div>
                                        <a href="{{ Storage::url($admitCard->admit_card_file) }}" 
                                           class="btn btn-sm btn-success me-2" target="_blank" download>
                                            <i class="fas fa-download me-1"></i>Download
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeCurrentFile()">
                                            <i class="fas fa-times me-1"></i>Remove
                                        </button>
                                    </div>
                                </div>
                                <input type="hidden" name="current_file" value="{{ $admitCard->admit_card_file }}">
                            </div>
                            @endif

                            <div class="mb-3">
                                <label for="admit_card_file" class="form-label">
                                    {{ $admitCard->admit_card_file ? 'Replace Admit Card File' : 'Upload Admit Card File' }}
                                </label>
                                <input type="file" class="form-control @error('admit_card_file') is-invalid @enderror" 
                                       id="admit_card_file" name="admit_card_file"
                                       accept=".pdf,.doc,.docx,.xls,.xlsx,.zip,.rar">
                                <div class="form-text">
                                    Supported formats: PDF, Word, Excel, ZIP, RAR. Max size: 10MB
                                </div>
                                @error('admit_card_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="download_link" class="form-label">Or Provide Download Link</label>
                                <input type="url" class="form-control @error('download_link') is-invalid @enderror" 
                                       id="download_link" name="download_link" value="{{ old('download_link', $admitCard->download_link) }}"
                                       placeholder="https://example.com/admit-card.pdf">
                                <div class="form-text">Provide a direct download link if you don't want to upload a file</div>
                                @error('download_link')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="official_website" class="form-label">Official Website</label>
                                <input type="url" class="form-control @error('official_website') is-invalid @enderror" 
                                       id="official_website" name="official_website" value="{{ old('official_website', $admitCard->official_website) }}"
                                       placeholder="https://ssc.nic.in">
                                @error('official_website')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Note:</strong> Either upload a file or provide a download link. If both are provided, the uploaded file will be given priority.
                            </div>
                        </div>
                    </div>

                    <!-- Important Dates -->
                    <div class="card mb-4">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="mb-0">Important Dates</h5>
                        </div>
                        <div class="card-body">
                            <div id="important-dates-container">
                                @php
                                    $importantDates = old('important_dates', $admitCard->important_dates ?? []);
                                    if (empty($importantDates)) {
                                        $importantDates = [['event' => '', 'date' => '']];
                                    }
                                @endphp
                                
                                @foreach($importantDates as $index => $date)
                                <div class="row important-date-row mb-3">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" 
                                               name="important_dates[{{ $index }}][event]" 
                                               value="{{ $date['event'] ?? '' }}"
                                               placeholder="Event name (e.g., Application Start, Last Date to Download)">
                                    </div>
                                    <div class="col-md-5">
                                        <input type="date" class="form-control" 
                                               name="important_dates[{{ $index }}][date]" 
                                               value="{{ $date['date'] ?? '' }}">
                                    </div>
                                    <div class="col-md-1">
                                        @if($index === 0)
                                        <button type="button" class="btn btn-success btn-sm" onclick="addDateField()">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                        @else
                                        <button type="button" class="btn btn-danger btn-sm" onclick="removeDateField(this)">
                                            <i class="fas fa-times"></i>
                                        </button>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <!-- Settings -->
                    <div class="card mb-4">
                        <div class="card-header bg-secondary text-white">
                            <h5 class="mb-0">Settings</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" 
                                           {{ old('is_active', $admitCard->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">Active</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1"
                                           {{ old('is_featured', $admitCard->is_featured) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_featured">Featured</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SEO Settings -->
                    <div class="card mb-4">
                        <div class="card-header bg-dark text-white">
                            <h5 class="mb-0">SEO Settings</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="meta_title" class="form-label">Meta Title</label>
                                <input type="text" class="form-control @error('meta_title') is-invalid @enderror" 
                                       id="meta_title" name="meta_title" value="{{ old('meta_title', $admitCard->meta_title) }}"
                                       placeholder="Meta title for SEO">
                                <div class="form-text" id="meta-title-counter">0/255 characters</div>
                                @error('meta_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="meta_description" class="form-label">Meta Description</label>
                                <textarea class="form-control @error('meta_description') is-invalid @enderror" 
                                          id="meta_description" name="meta_description" rows="3"
                                          placeholder="Meta description for SEO">{{ old('meta_description', $admitCard->meta_description) }}</textarea>
                                <div class="form-text" id="meta-desc-counter">0/500 characters</div>
                                @error('meta_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Preview Card -->
                    <div class="card mb-4">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">Preview</h5>
                        </div>
                        <div class="card-body">
                            <div class="text-center">
                                <i class="fas fa-ticket-alt fa-3x text-primary mb-3"></i>
                                <h6 id="preview-title">{{ Str::limit($admitCard->title, 30) }}</h6>
                                <small class="text-muted" id="preview-exam">{{ $admitCard->exam_name }}</small>
                                <div class="mt-2">
                                    <span class="badge bg-{{ $admitCard->is_active ? 'success' : 'danger' }}" id="preview-status">
                                        {{ $admitCard->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                    <span class="badge bg-warning text-dark {{ $admitCard->is_featured ? '' : 'd-none' }}" id="preview-featured">
                                        Featured
                                    </span>
                                </div>
                                <div class="mt-3">
                                    <small class="text-muted d-block">
                                        <i class="fas fa-calendar me-1"></i>
                                        Exam: {{ $admitCard->exam_date->format('d M Y') }}
                                    </small>
                                    <small class="text-muted d-block">
                                        <i class="fas fa-ticket-alt me-1"></i>
                                        Admit Card: {{ $admitCard->admit_card_date->format('d M Y') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Statistics -->
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">Statistics</h5>
                        </div>
                        <div class="card-body">
                            <div class="text-center">
                                <div class="mb-3">
                                    <i class="fas fa-eye fa-2x text-primary mb-2"></i>
                                    <h4>{{ $admitCard->views }}</h4>
                                    <small class="text-muted">Total Views</small>
                                </div>
                                <div class="mb-2">
                                    <small class="text-muted">
                                        <strong>Created:</strong> {{ $admitCard->created_at->format('d M Y') }}
                                    </small>
                                </div>
                                <div>
                                    <small class="text-muted">
                                        <strong>Updated:</strong> {{ $admitCard->updated_at->format('d M Y') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-save me-2"></i> Update Admit Card
                </button>
                <a href="{{ route('admin.admit-cards.index') }}" class="btn btn-secondary btn-lg">
                    <i class="fas fa-times me-2"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
.form-check-input:checked {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.card-header {
    font-weight: 600;
}

.alert-info {
    border-left: 4px solid #0dcaf0;
}

.important-date-row {
    align-items: center;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-generate slug from title
    const titleField = document.getElementById('title');
    const slugField = document.getElementById('slug');
    
    titleField.addEventListener('input', function() {
        if (!slugField.value || slugField.value === '{{ $admitCard->slug }}') {
            slugField.value = this.value
                .toLowerCase()
                .replace(/[^a-z0-9 -]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');
        }
        updatePreview();
    });

    // Update preview in real-time
    function updatePreview() {
        const title = titleField.value || '{{ $admitCard->title }}';
        const examName = document.getElementById('exam_name').value || '{{ $admitCard->exam_name }}';
        const examDate = document.getElementById('exam_date').value;
        const admitCardDate = document.getElementById('admit_card_date').value;
        const isActive = document.getElementById('is_active').checked;
        const isFeatured = document.getElementById('is_featured').checked;

        document.getElementById('preview-title').textContent = title.length > 30 ? 
            title.substring(0, 30) + '...' : title;
        document.getElementById('preview-exam').textContent = examName;
        document.getElementById('preview-status').textContent = isActive ? 'Active' : 'Inactive';
        document.getElementById('preview-status').className = `badge bg-${isActive ? 'success' : 'danger'}`;
        
        const featuredBadge = document.getElementById('preview-featured');
        if (isFeatured) {
            featuredBadge.classList.remove('d-none');
        } else {
            featuredBadge.classList.add('d-none');
        }

        // Update dates in preview
        const examDateElement = document.querySelector('#preview-exam').nextElementSibling;
        const admitCardDateElement = examDateElement.nextElementSibling;

        if (examDate) {
            const formattedExamDate = new Date(examDate).toLocaleDateString('en-GB', {
                day: 'numeric', month: 'short', year: 'numeric'
            });
            examDateElement.innerHTML = `<i class="fas fa-calendar me-1"></i>Exam: ${formattedExamDate}`;
        }

        if (admitCardDate) {
            const formattedAdmitCardDate = new Date(admitCardDate).toLocaleDateString('en-GB', {
                day: 'numeric', month: 'short', year: 'numeric'
            });
            admitCardDateElement.innerHTML = `<i class="fas fa-ticket-alt me-1"></i>Admit Card: ${formattedAdmitCardDate}`;
        }
    }

    // Add event listeners for preview updates
    document.getElementById('exam_name').addEventListener('input', updatePreview);
    document.getElementById('exam_date').addEventListener('change', updatePreview);
    document.getElementById('admit_card_date').addEventListener('change', updatePreview);
    document.getElementById('is_active').addEventListener('change', updatePreview);
    document.getElementById('is_featured').addEventListener('change', updatePreview);

    // Initial preview update
    updatePreview();

    // File input preview
    const fileInput = document.getElementById('admit_card_file');
    fileInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const fileSize = (file.size / (1024 * 1024)).toFixed(2);
            alert(`Selected file: ${file.name}\nSize: ${fileSize} MB`);
        }
    });

    // Character counters
    function setupCharacterCounter(textareaId, counterId, maxLength) {
        const textarea = document.getElementById(textareaId);
        const counter = document.getElementById(counterId);
        
        if (!textarea || !counter) return;

        textarea.addEventListener('input', function() {
            const length = this.value.length;
            counter.textContent = `${length}/${maxLength} characters`;
            counter.className = `form-text ${length > maxLength ? 'text-danger' : 'text-muted'}`;
        });

        // Initial count
        const initialLength = textarea.value.length;
        counter.textContent = `${initialLength}/${maxLength} characters`;
        if (initialLength > maxLength) {
            counter.className = 'form-text text-danger';
        }
    }

    // Setup character counters
    setupCharacterCounter('short_description', 'short-desc-counter', 500);
    setupCharacterCounter('meta_description', 'meta-desc-counter', 500);
    setupCharacterCounter('meta_title', 'meta-title-counter', 255);

    // Important dates functionality
    window.addDateField = function() {
        const container = document.getElementById('important-dates-container');
        const index = container.children.length;
        
        const newRow = document.createElement('div');
        newRow.className = 'row important-date-row mb-3';
        newRow.innerHTML = `
            <div class="col-md-6">
                <input type="text" class="form-control" 
                       name="important_dates[${index}][event]" 
                       placeholder="Event name">
            </div>
            <div class="col-md-5">
                <input type="date" class="form-control" 
                       name="important_dates[${index}][date]">
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-danger btn-sm" onclick="removeDateField(this)">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
        
        container.appendChild(newRow);
    };

    window.removeDateField = function(button) {
        const row = button.closest('.important-date-row');
        row.remove();
        
        // Reindex remaining rows
        const container = document.getElementById('important-dates-container');
        const rows = container.getElementsByClassName('important-date-row');
        
        Array.from(rows).forEach((row, index) => {
            const eventInput = row.querySelector('input[name^="important_dates"]');
            const dateInput = row.querySelector('input[type="date"]');
            
            eventInput.name = `important_dates[${index}][event]`;
            dateInput.name = `important_dates[${index}][date]`;
        });
    };

    // Remove current file
    window.removeCurrentFile = function() {
        if (confirm('Are you sure you want to remove the current file?')) {
            // Add a hidden field to indicate file removal
            const form = document.querySelector('form');
            const removeFileInput = document.createElement('input');
            removeFileInput.type = 'hidden';
            removeFileInput.name = 'remove_file';
            removeFileInput.value = '1';
            form.appendChild(removeFileInput);
            
            // Hide the current file section
            document.querySelector('.alert.alert-info').style.display = 'none';
        }
    };
});
</script>
@endpush