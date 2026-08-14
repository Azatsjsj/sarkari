<!-- resources/views/admin/admit-cards/create.blade.php -->
@extends('admin.layout')

@section('title', 'Create New Admit Card')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-ticket-alt me-2"></i>Create New Admit Card
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.admit-cards.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back to Admit Cards
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <strong>Please fix the following errors:</strong>
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.admit-cards.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <!-- Basic Information -->
                <div class="col-md-8">
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-info-circle me-2"></i>Basic Information
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="title" class="form-label">Admit Card Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                       id="title" name="title" value="{{ old('title') }}" 
                                       placeholder="Enter admit card title" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">A descriptive title for the admit card (e.g., "SSC CGL 2024 Admit Card Download")</div>
                            </div>

                            <div class="mb-3">
                                <label for="job_id" class="form-label">Associated Job <span class="text-danger">*</span></label>
                                <select class="form-select @error('job_id') is-invalid @enderror" 
                                        id="job_id" name="job_id" required>
                                    <option value="">Select Job</option>
                                    @foreach($jobs as $job)
                                        <option value="{{ $job->id }}" 
                                            {{ old('job_id') == $job->id ? 'selected' : '' }}>
                                            {{ $job->title }} ({{ $job->category->name ?? 'N/A' }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('job_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Select the job for which this admit card is issued.</div>
                            </div>

                            <div class="mb-3">
                                <label for="short_description" class="form-label">Short Description</label>
                                <textarea class="form-control @error('short_description') is-invalid @enderror" 
                                          id="short_description" name="short_description" 
                                          rows="3" placeholder="Brief description (max 500 characters)"
                                          maxlength="500">{{ old('short_description') }}</textarea>
                                @error('short_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">This will be shown in admit card listings.</div>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Full Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" name="description" 
                                          rows="6" placeholder="Detailed description about the admit card">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Provide complete details about the admit card, exam instructions, etc.</div>
                            </div>
                        </div>
                    </div>

                    <!-- Important Dates & Venue -->
                    <div class="card mb-4">
                        <div class="card-header bg-success text-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-calendar-alt me-2"></i>Important Dates & Venue
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="admit_card_date" class="form-label">Admit Card Date <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control @error('admit_card_date') is-invalid @enderror" 
                                               id="admit_card_date" name="admit_card_date" 
                                               value="{{ old('admit_card_date') }}" required>
                                        @error('admit_card_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">Date when admit card will be available for download.</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="exam_date" class="form-label">Exam Date</label>
                                        <input type="date" class="form-control @error('exam_date') is-invalid @enderror" 
                                               id="exam_date" name="exam_date" 
                                               value="{{ old('exam_date') }}">
                                        @error('exam_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">Date of the examination (if applicable).</div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="exam_venue" class="form-label">Exam Venue/Instructions</label>
                                <input type="text" class="form-control @error('exam_venue') is-invalid @enderror" 
                                       id="exam_venue" name="exam_venue" 
                                       value="{{ old('exam_venue') }}" 
                                       placeholder="Enter exam venue or center details">
                                @error('exam_venue')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Exam center name, address, or venue instructions.</div>
                            </div>
                        </div>
                    </div>

                    <!-- Instructions & Requirements -->
                    <div class="card mb-4">
                        <div class="card-header bg-info text-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-clipboard-list me-2"></i>Instructions & Requirements
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="instructions" class="form-label">Important Instructions</label>
                                <textarea class="form-control @error('instructions') is-invalid @enderror" 
                                          id="instructions" name="instructions" 
                                          rows="4" placeholder="Important instructions for candidates">{{ old('instructions') }}</textarea>
                                @error('instructions')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Important instructions, guidelines, and rules for the examination.</div>
                            </div>

                            <div class="mb-3">
                                <label for="required_documents" class="form-label">Required Documents</label>
                                <textarea class="form-control @error('required_documents') is-invalid @enderror" 
                                          id="required_documents" name="required_documents" 
                                          rows="3" placeholder="List of required documents to carry">{{ old('required_documents') }}</textarea>
                                @error('required_documents')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Documents candidates need to carry (e.g., ID proof, photograph, etc.).</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-md-4">
                    <!-- Status & Settings -->
                    <div class="card mb-4">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-cog me-2"></i>Status & Settings
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" 
                                           id="is_active" name="is_active" value="1" 
                                           {{ old('is_active', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">Active Admit Card</label>
                                </div>
                                <div class="form-text">If inactive, admit card won't be visible on the website.</div>
                            </div>
                        </div>
                    </div>

                    <!-- Links & Files -->
                    <div class="card mb-4">
                        <div class="card-header bg-secondary text-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-link me-2"></i>Links & Files
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="official_website" class="form-label">Official Website <span class="text-danger">*</span></label>
                                <input type="url" class="form-control @error('official_website') is-invalid @enderror" 
                                       id="official_website" name="official_website" 
                                       value="{{ old('official_website') }}" 
                                       placeholder="https://example.com" required>
                                @error('official_website')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Official website where admit card can be downloaded.</div>
                            </div>

                            <div class="mb-3">
                                <label for="download_link" class="form-label">Download Link <span class="text-danger">*</span></label>
                                <input type="url" class="form-control @error('download_link') is-invalid @enderror" 
                                       id="download_link" name="download_link" 
                                       value="{{ old('download_link') }}" 
                                       placeholder="https://example.com/download" required>
                                @error('download_link')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Direct link to download the admit card.</div>
                            </div>

                            <div class="mb-3">
                                <label for="admit_card_file" class="form-label">Admit Card File (PDF)</label>
                                <input type="file" class="form-control @error('admit_card_file') is-invalid @enderror" 
                                       id="admit_card_file" name="admit_card_file" 
                                       accept=".pdf,.doc,.docx">
                                @error('admit_card_file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    Upload admit card file (PDF, DOC, DOCX). Max: 5MB.
                                    <br>Supported formats: PDF, DOC, DOCX
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SEO Settings -->
                    <div class="card mb-4">
                        <div class="card-header bg-dark text-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-search me-2"></i>SEO Settings
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="meta_title" class="form-label">Meta Title</label>
                                <input type="text" class="form-control @error('meta_title') is-invalid @enderror" 
                                       id="meta_title" name="meta_title" 
                                       value="{{ old('meta_title') }}" 
                                       placeholder="Meta title for SEO" maxlength="60">
                                @error('meta_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Recommended: 50-60 characters</div>
                            </div>

                            <div class="mb-3">
                                <label for="meta_description" class="form-label">Meta Description</label>
                                <textarea class="form-control @error('meta_description') is-invalid @enderror" 
                                          id="meta_description" name="meta_description" 
                                          rows="3" placeholder="Meta description for SEO" 
                                          maxlength="160">{{ old('meta_description') }}</textarea>
                                @error('meta_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Recommended: 150-160 characters</div>
                            </div>

                            <div class="mb-3">
                                <label for="meta_keywords" class="form-label">Meta Keywords</label>
                                <input type="text" class="form-control @error('meta_keywords') is-invalid @enderror" 
                                       id="meta_keywords" name="meta_keywords" 
                                       value="{{ old('meta_keywords') }}" 
                                       placeholder="keyword1, keyword2, keyword3">
                                @error('meta_keywords')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Separate keywords with commas</div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Tips -->
                    <div class="card">
                        <div class="card-header bg-light">
                            <h6 class="card-title mb-0">
                                <i class="fas fa-lightbulb me-2"></i>Quick Tips
                            </h6>
                        </div>
                        <div class="card-body">
                            <small class="text-muted">
                                <ul class="list-unstyled mb-0">
                                    <li><i class="fas fa-check text-success me-2"></i>Provide accurate dates</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Include clear instructions</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Verify all links before saving</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Upload relevant files</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Optimize for SEO</li>
                                </ul>
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('admin.admit-cards.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times me-2"></i>Cancel
                                </a>
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Create Admit Card
                                    </button>
                                    <button type="button" class="btn btn-outline-primary" onclick="previewAdmitCard()">
                                        <i class="fas fa-eye me-2"></i>Preview
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="previewModalLabel">
                    <i class="fas fa-eye me-2"></i>Admit Card Preview
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <h4 id="preview-title" class="text-warning mb-3"></h4>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Admit Card Date:</strong> <span id="preview-admit-card-date" class="text-muted"></span>
                            </div>
                            <div class="col-md-6">
                                <strong>Exam Date:</strong> <span id="preview-exam-date" class="text-muted">N/A</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <strong>Short Description:</strong>
                            <p id="preview-short-description" class="text-muted mb-0"></p>
                        </div>
                        <div class="mb-3">
                            <strong>Official Website:</strong>
                            <p id="preview-website" class="mb-0"></p>
                        </div>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            This is a basic preview. The actual page will include more details and styling.
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.card {
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.card-header {
    border-bottom: 1px solid rgba(0, 0, 0, 0.125);
}

.form-check-input:checked {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.btn {
    border-radius: 0.375rem;
    font-weight: 500;
}

/* Character counter */
.char-counter {
    font-size: 0.875em;
    margin-top: 0.25rem;
}

/* Required field indicator */
.text-danger {
    color: #dc3545 !important;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .card-body .row {
        margin-bottom: 1rem;
    }
    
    .btn-group {
        width: 100%;
        margin-top: 1rem;
    }
    
    .btn-group .btn {
        flex: 1;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Character counters
    initializeCharacterCounters();
    
    // Date validation
    initializeDateValidation();
    
    // Auto-generate meta description from short description
    initializeMetaDescriptionGenerator();
});

// Initialize character counters
function initializeCharacterCounters() {
    const fields = [
        { id: 'short_description', max: 500 },
        { id: 'meta_title', max: 60 },
        { id: 'meta_description', max: 160 }
    ];

    fields.forEach(field => {
        const input = document.getElementById(field.id);
        if (input) {
            const counter = document.createElement('div');
            counter.className = 'char-counter text-muted';
            counter.textContent = `0/${field.max} characters`;
            input.parentNode.appendChild(counter);

            input.addEventListener('input', function() {
                const length = this.value.length;
                counter.textContent = `${length}/${field.max} characters`;
                counter.className = `char-counter ${length > field.max ? 'text-danger' : 'text-muted'}`;
            });

            // Trigger initial count
            input.dispatchEvent(new Event('input'));
        }
    });
}

// Initialize date validation
function initializeDateValidation() {
    const admitCardDate = document.getElementById('admit_card_date');
    const examDate = document.getElementById('exam_date');

    function validateDates() {
        if (admitCardDate.value && examDate.value) {
            const admitCard = new Date(admitCardDate.value);
            const exam = new Date(examDate.value);

            if (exam <= admitCard) {
                examDate.setCustomValidity('Exam date must be after admit card date');
            } else {
                examDate.setCustomValidity('');
            }
        }
    }

    admitCardDate?.addEventListener('change', validateDates);
    examDate?.addEventListener('change', validateDates);
}

// Auto-generate meta description
function initializeMetaDescriptionGenerator() {
    const shortDesc = document.getElementById('short_description');
    const metaDesc = document.getElementById('meta_description');

    if (shortDesc && metaDesc) {
        shortDesc.addEventListener('blur', function() {
            // Only auto-fill if meta description is empty
            if (!metaDesc.value.trim() && this.value.trim()) {
                metaDesc.value = this.value.substring(0, 160);
                metaDesc.dispatchEvent(new Event('input'));
            }
        });
    }
}

// Preview functionality
function previewAdmitCard() {
    // Basic validation
    const title = document.getElementById('title').value;
    const admitCardDate = document.getElementById('admit_card_date').value;
    const examDate = document.getElementById('exam_date').value;
    const shortDescription = document.getElementById('short_description').value;
    const officialWebsite = document.getElementById('official_website').value;

    if (!title || !admitCardDate) {
        alert('Please fill in required fields (Title and Admit Card Date) before previewing.');
        return;
    }

    // Update preview content
    document.getElementById('preview-title').textContent = title || 'No title';
    document.getElementById('preview-admit-card-date').textContent = 
        admitCardDate ? new Date(admitCardDate).toLocaleDateString() : 'Not set';
    document.getElementById('preview-exam-date').textContent = 
        examDate ? new Date(examDate).toLocaleDateString() : 'N/A';
    document.getElementById('preview-short-description').textContent = 
        shortDescription || 'No description provided';
    document.getElementById('preview-website').innerHTML = 
        officialWebsite ? `<a href="${officialWebsite}" target="_blank">${officialWebsite}</a>` : 'Not set';

    // Show modal
    const previewModal = new bootstrap.Modal(document.getElementById('previewModal'));
    previewModal.show();
}

// Auto-fill today's date for admit card date
document.addEventListener('DOMContentLoaded', function() {
    const admitCardDate = document.getElementById('admit_card_date');
    if (admitCardDate && !admitCardDate.value) {
        admitCardDate.value = new Date().toISOString().split('T')[0];
    }
});

// URL validation
document.addEventListener('DOMContentLoaded', function() {
    const urlFields = ['official_website', 'download_link'];
    
    urlFields.forEach(fieldId => {
        const field = document.getElementById(fieldId);
        if (field) {
            field.addEventListener('blur', function() {
                if (this.value && !isValidUrl(this.value)) {
                    this.setCustomValidity('Please enter a valid URL (starting with http:// or https://)');
                } else {
                    this.setCustomValidity('');
                }
            });
        }
    });
});

function isValidUrl(string) {
    try {
        new URL(string);
        return true;
    } catch (_) {
        return false;
    }
}

// File size validation
document.getElementById('admit_card_file')?.addEventListener('change', function(e) {
    const file = e.target.files[0];
    const maxSize = 5 * 1024 * 1024; // 5MB in bytes
    
    if (file && file.size > maxSize) {
        alert('File size must be less than 5MB.');
        this.value = '';
    }
});
</script>
@endpush