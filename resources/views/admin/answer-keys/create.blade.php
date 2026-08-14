@extends('admin.layout')

@section('title', 'Create Answer Key')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h1>
                    <i class="icon-plus-circle2 position-left"></i>
                    Create New Answer Key
                </h1>
            </div>

            <div class="heading-elements">
                <a href="{{ route('admin.answer-keys.index') }}" class="btn btn-default">
                    <i class="icon-arrow-left13 position-left"></i>
                    Back to List
                </a>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('admin.answer-keys.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="card">
                        <div class="card-header header-elements-inline">
                            <h5 class="card-title">Basic Information</h5>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title">Title *</label>
                                        <input type="text" name="title" id="title" class="form-control" 
                                               value="{{ old('title') }}" required maxlength="255">
                                        @error('title')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="job_id">Job *</label>
                                        <select name="job_id" id="job_id" class="form-control" required>
                                            <option value="">Select Job</option>
                                            @foreach($jobs as $job)
                                                <option value="{{ $job->id }}" {{ old('job_id') == $job->id ? 'selected' : '' }}>
                                                    {{ $job->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('job_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="short_description">Short Description</label>
                                <textarea name="short_description" id="short_description" class="form-control" 
                                          maxlength="500" rows="2">{{ old('short_description') }}</textarea>
                                <small class="text-muted">Maximum 500 characters</small>
                                @error('short_description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="description">Full Description</label>
                                <textarea name="description" id="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                                @error('description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header header-elements-inline">
                            <h5 class="card-title">Exam Details</h5>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="answer_key_date">Answer Key Date *</label>
                                        <input type="date" name="answer_key_date" id="answer_key_date" 
                                               class="form-control" value="{{ old('answer_key_date') }}" required>
                                        @error('answer_key_date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exam_name">Exam Name</label>
                                        <input type="text" name="exam_name" id="exam_name" class="form-control" 
                                               value="{{ old('exam_name') }}" maxlength="255">
                                        @error('exam_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exam_date">Exam Date</label>
                                        <input type="date" name="exam_date" id="exam_date" 
                                               class="form-control" value="{{ old('exam_date') }}">
                                        @error('exam_date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="total_questions">Total Questions</label>
                                        <input type="number" name="total_questions" id="total_questions" 
                                               class="form-control" value="{{ old('total_questions', 100) }}" min="1">
                                        @error('total_questions')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="total_marks">Total Marks</label>
                                        <input type="number" name="total_marks" id="total_marks" 
                                               class="form-control" value="{{ old('total_marks', 100) }}" min="1">
                                        @error('total_marks')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="correct_marks">Marks per Right (+)</label>
                                        <input type="number" step="0.01" name="correct_marks" id="correct_marks" 
                                               class="form-control" value="{{ old('correct_marks', 1.00) }}" min="0">
                                        @error('correct_marks')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="negative_marks">Negative Penalty (-)</label>
                                        <input type="number" step="0.01" name="negative_marks" id="negative_marks" 
                                               class="form-control" value="{{ old('negative_marks', 0.25) }}" min="0">
                                        @error('negative_marks')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header header-elements-inline">
                            <h5 class="card-title">Links & Files</h5>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="official_website">Official Website *</label>
                                        <input type="url" name="official_website" id="official_website" 
                                               class="form-control" value="{{ old('official_website') }}" required>
                                        @error('official_website')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="download_link">Download Link *</label>
                                        <input type="url" name="download_link" id="download_link" 
                                               class="form-control" value="{{ old('download_link') }}" required>
                                        @error('download_link')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="answer_key_url">Official Answer Key URL</label>
                                        <input type="url" name="answer_key_url" id="answer_key_url" 
                                               class="form-control" value="{{ old('answer_key_url') }}" placeholder="https://example.com/answer-key-login">
                                        <small class="text-muted">Direct link to candidates answer key login/portal</small>
                                        @error('answer_key_url')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="objection_link">Objection Submission Link</label>
                                        <input type="url" name="objection_link" id="objection_link" 
                                               class="form-control" value="{{ old('objection_link') }}" placeholder="https://example.com/raise-objection">
                                        <small class="text-muted">Direct link for submitting online answer key objections</small>
                                        @error('objection_link')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="answer_key_file">Answer Key File</label>
                                <input type="file" name="answer_key_file" id="answer_key_file" 
                                       class="form-control-file" accept=".pdf,.doc,.docx,.xls,.xlsx">
                                <small class="text-muted">Allowed formats: PDF, DOC, DOCX, XLS, XLSX. Max size: 5MB</small>
                                @error('answer_key_file')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header header-elements-inline">
                            <h5 class="card-title">Additional Information</h5>
                        </div>

                        <div class="card-body">
                            <div class="form-group">
                                <label for="instructions">Instructions</label>
                                <textarea name="instructions" id="instructions" class="form-control" rows="3">{{ old('instructions') }}</textarea>
                                @error('instructions')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="subjects">Subjects</label>
                                <div id="subjects-container">
                                    @if(old('subjects'))
                                        @foreach(old('subjects') as $subject)
                                            <div class="input-group mb-2">
                                                <input type="text" name="subjects[]" class="form-control" 
                                                       value="{{ $subject }}" maxlength="100">
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-danger remove-subject">Remove</button>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <button type="button" id="add-subject" class="btn btn-sm btn-secondary mt-2">
                                    <i class="icon-plus-circle2 position-left"></i>Add Subject
                                </button>
                                @error('subjects.*')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header header-elements-inline">
                            <h5 class="card-title">SEO Settings</h5>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="meta_title">Meta Title</label>
                                        <input type="text" name="meta_title" id="meta_title" class="form-control" 
                                               value="{{ old('meta_title') }}" maxlength="255">
                                        <small class="text-muted">Recommended: 50-60 characters</small>
                                        @error('meta_title')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="meta_keywords">Meta Keywords</label>
                                        <input type="text" name="meta_keywords" id="meta_keywords" class="form-control" 
                                               value="{{ old('meta_keywords') }}">
                                        <small class="text-muted">Separate keywords with commas</small>
                                        @error('meta_keywords')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="meta_description">Meta Description</label>
                                <textarea name="meta_description" id="meta_description" class="form-control" rows="3">{{ old('meta_description') }}</textarea>
                                <small class="text-muted">Recommended: 150-160 characters</small>
                                @error('meta_description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                        Active (Visible to users)
                                    </label>
                                </div>
                            </div>

                            <div class="text-right">
                                <a href="{{ route('admin.answer-keys.index') }}" class="btn btn-default">
                                    Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="icon-plus-circle2 position-left"></i>
                                    Create Answer Key
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Add subject field
        $('#add-subject').click(function() {
            const subjectField = `
                <div class="input-group mb-2">
                    <input type="text" name="subjects[]" class="form-control" placeholder="Enter subject name" maxlength="100">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-danger remove-subject">Remove</button>
                    </div>
                </div>
            `;
            $('#subjects-container').append(subjectField);
        });

        // Remove subject field
        $(document).on('click', '.remove-subject', function() {
            $(this).closest('.input-group').remove();
        });

        // Character counters
        $('#short_description').on('input', function() {
            const maxLength = 500;
            const currentLength = $(this).val().length;
            if (currentLength >= maxLength - 50) {
                $(this).next('small').text(`${maxLength - currentLength} characters remaining`);
            }
        });
    });
</script>
@endpush