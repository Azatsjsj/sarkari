{{-- resources/views/admin/documents/create.blade.php --}}
@extends('admin.layout')

@section('title', 'Upload Document - Admin Panel')

@section('content')
<div class="admin-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">
            <i class="fas fa-upload"></i> Upload New Document
        </h1>
        <a href="{{ route('admin.documents.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Documents
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.documents.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="title" class="form-label required">Document Title</label>
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" 
                                   value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="short_description" class="form-label">Short Description</label>
                            <textarea name="short_description" id="short_description" class="form-control" rows="2">{{ old('short_description') }}</textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Full Description</label>
                            <textarea name="description" id="description" class="form-control" rows="5">{{ old('description') }}</textarea>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="document_file" class="form-label required">Document File</label>
                            <input type="file" name="document_file" id="document_file" class="form-control @error('document_file') is-invalid @enderror" 
                                   accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" required>
                            <small class="text-muted">Max size: 10MB. Allowed: PDF, JPG, PNG, DOC, DOCX</small>
                            @error('document_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="document_number" class="form-label">Document Number</label>
                            <input type="text" name="document_number" id="document_number" class="form-control" 
                                   value="{{ old('document_number') }}" placeholder="e.g., UPSSSC/2024/001">
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="type" class="form-label required">Document Type</label>
                            <select name="type" id="type" class="form-select @error('type') is-invalid @enderror" required>
                                <option value="">Select Type</option>
                                <option value="notice" {{ old('type') == 'notice' ? 'selected' : '' }}>Notice</option>
                                <option value="certificate" {{ old('type') == 'certificate' ? 'selected' : '' }}>Certificate</option>
                                <option value="syllabus" {{ old('type') == 'syllabus' ? 'selected' : '' }}>Syllabus</option>
                                <option value="admit_card" {{ old('type') == 'admit_card' ? 'selected' : '' }}>Admit Card</option>
                                <option value="result" {{ old('type') == 'result' ? 'selected' : '' }}>Result</option>
                                <option value="answer_key" {{ old('type') == 'answer_key' ? 'selected' : '' }}>Answer Key</option>
                                <option value="other" {{ old('type') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <input type="text" name="category" id="category" class="form-control" 
                                   value="{{ old('category') }}" placeholder="e.g., Recruitment, Education, Result">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="department" class="form-label">Department</label>
                            <input type="text" name="department" id="department" class="form-control" 
                                   value="{{ old('department') }}" placeholder="e.g., UPSSSC, SSC, Railway">
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="issued_by" class="form-label">Issued By</label>
                            <input type="text" name="issued_by" id="issued_by" class="form-control" 
                                   value="{{ old('issued_by') }}">
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="language" class="form-label">Language</label>
                            <select name="language" id="language" class="form-select">
                                <option value="hindi" {{ old('language') == 'hindi' ? 'selected' : '' }}>Hindi</option>
                                <option value="english" {{ old('language') == 'english' ? 'selected' : '' }}>English</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="issue_date" class="form-label">Issue Date</label>
                            <input type="date" name="issue_date" id="issue_date" class="form-control" 
                                   value="{{ old('issue_date') }}">
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="valid_upto" class="form-label">Valid Upto</label>
                            <input type="date" name="valid_upto" id="valid_upto" class="form-control" 
                                   value="{{ old('valid_upto') }}">
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="sort_order" class="form-label">Sort Order</label>
                            <input type="number" name="sort_order" id="sort_order" class="form-control" 
                                   value="{{ old('sort_order', 0) }}">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3 form-check">
                            <input type="checkbox" name="is_featured" id="is_featured" class="form-check-input" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                            <label for="is_featured" class="form-check-label">Feature this document (show on homepage)</label>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3 form-check">
                            <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
                            <label for="is_active" class="form-check-label">Active (visible to public)</label>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Upload Document
                    </button>
                    <a href="{{ route('admin.documents.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection