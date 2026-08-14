<!-- resources/views/admin/jobs/edit.blade.php -->
@extends('admin.layout')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Job</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.jobs.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back to Jobs
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.jobs.update', $job->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <!-- LEFT COLUMN - MAIN CONTENT -->
                <div class="col-md-8">
                    
                    <!-- Basic Information -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-info-circle text-primary"></i> Basic Information
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="title" class="form-label">Job Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                       id="title" name="title" value="{{ old('title', $job->title) }}" 
                                       placeholder="Enter job title" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
                                <select class="form-select @error('category_id') is-invalid @enderror" 
                                        id="category_id" name="category_id" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" 
                                            {{ old('category_id', $job->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="short_description" class="form-label">Short Description <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('short_description') is-invalid @enderror" 
                                          id="short_description" name="short_description" 
                                          rows="3" placeholder="Brief description (max 500 characters)" 
                                          maxlength="500" required>{{ old('short_description', $job->short_description) }}</textarea>
                                @error('short_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">This will be shown in job listings.</div>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Full Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" name="description" 
                                          rows="8" placeholder="Detailed job description">{{ old('description', $job->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="vacancy_details" class="form-label">Vacancy & Eligibility Details Table</label>
                                <textarea class="form-control @error('vacancy_details') is-invalid @enderror" 
                                          id="vacancy_details" name="vacancy_details" 
                                          rows="10" placeholder='<table class="vacancy-table"><tr><th>Post Name</th><th>Total Posts</th><th>Eligibility</th><tr>...</table>' 
                                          style="font-family: monospace;">{{ old('vacancy_details', $job->vacancy_details) }}</textarea>
                                @error('vacancy_details')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    <i class="fas fa-info-circle"></i> 
                                    Enter HTML table markup for vacancy distribution, category-wise details, and eligibility criteria.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Important Dates -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-calendar-alt text-success"></i> Important Dates
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control @error('start_date') is-invalid @enderror" 
                                               id="start_date" name="start_date" 
                                               value="{{ old('start_date', $job->start_date ? $job->start_date->format('Y-m-d') : '') }}" required>
                                        @error('start_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="last_date" class="form-label">Last Date <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control @error('last_date') is-invalid @enderror" 
                                               id="last_date" name="last_date" 
                                               value="{{ old('last_date', $job->last_date ? $job->last_date->format('Y-m-d') : '') }}" required>
                                        @error('last_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="fee_last_date" class="form-label">Fee Payment Last Date</label>
                                        <input type="date" class="form-control @error('fee_last_date') is-invalid @enderror" 
                                               id="fee_last_date" name="fee_last_date" 
                                               value="{{ old('fee_last_date', $job->fee_last_date ? $job->fee_last_date->format('Y-m-d') : '') }}">
                                        @error('fee_last_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">Last date for fee payment (if different)</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="correction_date" class="form-label">Correction Date</label>
                                        <input type="date" class="form-control @error('correction_date') is-invalid @enderror" 
                                               id="correction_date" name="correction_date" 
                                               value="{{ old('correction_date', $job->correction_date ? $job->correction_date->format('Y-m-d') : '') }}">
                                        @error('correction_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">Application correction window date</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="exam_date" class="form-label">Exam Date</label>
                                        <input type="date" class="form-control @error('exam_date') is-invalid @enderror" 
                                               id="exam_date" name="exam_date" 
                                               value="{{ old('exam_date', $job->exam_date ? $job->exam_date->format('Y-m-d') : '') }}">
                                        @error('exam_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="admit_card_date" class="form-label">Admit Card Release Date</label>
                                        <input type="date" class="form-control @error('admit_card_date') is-invalid @enderror" 
                                               id="admit_card_date" name="admit_card_date" 
                                               value="{{ old('admit_card_date', $job->admit_card_date ? $job->admit_card_date->format('Y-m-d') : '') }}">
                                        @error('admit_card_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="result_date" class="form-label">Result Declaration Date</label>
                                        <input type="date" class="form-control @error('result_date') is-invalid @enderror" 
                                               id="result_date" name="result_date" 
                                               value="{{ old('result_date', $job->result_date ? $job->result_date->format('Y-m-d') : '') }}">
                                        @error('result_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="age_calculation_date" class="form-label">Age As On Date</label>
                                        <input type="date" class="form-control @error('age_calculation_date') is-invalid @enderror" 
                                               id="age_calculation_date" name="age_calculation_date" 
                                               value="{{ old('age_calculation_date', $job->age_calculation_date ? $job->age_calculation_date->format('Y-m-d') : '') }}">
                                        @error('age_calculation_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">Date for age calculation (as on)</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Fee Structure -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-rupee-sign text-warning"></i> Fee Structure
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="fee_general" class="form-label">Fee - General / OBC / EWS</label>
                                        <input type="text" class="form-control @error('fee_general') is-invalid @enderror" 
                                               id="fee_general" name="fee_general" 
                                               value="{{ old('fee_general', $job->fee_general) }}" 
                                               placeholder="₹ 100/-">
                                        @error('fee_general')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="fee_sc_st_female" class="form-label">Fee - SC / ST / Female / PH</label>
                                        <input type="text" class="form-control @error('fee_sc_st_female') is-invalid @enderror" 
                                               id="fee_sc_st_female" name="fee_sc_st_female" 
                                               value="{{ old('fee_sc_st_female', $job->fee_sc_st_female) }}" 
                                               placeholder="₹ 0/- (Exempted)">
                                        @error('fee_sc_st_female')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="fee_other" class="form-label">Fee - Other Categories</label>
                                        <input type="text" class="form-control @error('fee_other') is-invalid @enderror" 
                                               id="fee_other" name="fee_other" 
                                               value="{{ old('fee_other', $job->fee_other) }}" 
                                               placeholder="As per notification">
                                        @error('fee_other')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="payment_mode" class="form-label">Payment Mode</label>
                                <input type="text" class="form-control @error('payment_mode') is-invalid @enderror" 
                                       id="payment_mode" name="payment_mode" 
                                       value="{{ old('payment_mode', $job->payment_mode) }}" 
                                       placeholder="Debit Card, Credit Card, Net Banking">
                                @error('payment_mode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Age Limit Details -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-user-clock text-info"></i> Age Limit Details
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="min_age" class="form-label">Minimum Age</label>
                                        <input type="text" class="form-control @error('min_age') is-invalid @enderror" 
                                               id="min_age" name="min_age" 
                                               value="{{ old('min_age', $job->min_age) }}" 
                                               placeholder="18 Years">
                                        @error('min_age')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="max_age" class="form-label">Maximum Age</label>
                                        <input type="text" class="form-control @error('max_age') is-invalid @enderror" 
                                               id="max_age" name="max_age" 
                                               value="{{ old('max_age', $job->max_age) }}" 
                                               placeholder="40 Years">
                                        @error('max_age')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="age_relaxation" class="form-label">Age Relaxation</label>
                                        <input type="text" class="form-control @error('age_relaxation') is-invalid @enderror" 
                                               id="age_relaxation" name="age_relaxation" 
                                               value="{{ old('age_relaxation', $job->age_relaxation) }}" 
                                               placeholder="As per government rules">
                                        @error('age_relaxation')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Job Specifications -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-briefcase text-primary"></i> Job Specifications
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="total_post" class="form-label">Total Posts</label>
                                        <input type="text" class="form-control @error('total_post') is-invalid @enderror" 
                                               id="total_post" name="total_post" 
                                               value="{{ old('total_post', $job->total_post) }}" 
                                               placeholder="e.g., 3003 Posts">
                                        @error('total_post')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="job_location" class="form-label">Job Location</label>
                                        <input type="text" class="form-control @error('job_location') is-invalid @enderror" 
                                               id="job_location" name="job_location" 
                                               value="{{ old('job_location', $job->job_location) }}" 
                                               placeholder="All India">
                                        @error('job_location')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="qualification" class="form-label">Qualification</label>
                                        <input type="text" class="form-control @error('qualification') is-invalid @enderror" 
                                               id="qualification" name="qualification" 
                                               value="{{ old('qualification', $job->qualification) }}" 
                                               placeholder="e.g., Graduate, 10+2, Diploma">
                                        @error('qualification')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="additional_qualification" class="form-label">Additional Qualification</label>
                                <textarea class="form-control @error('additional_qualification') is-invalid @enderror" 
                                          id="additional_qualification" name="additional_qualification" 
                                          rows="2" placeholder="Any additional qualifications required">{{ old('additional_qualification', $job->additional_qualification) }}</textarea>
                                @error('additional_qualification')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="experience_required" class="form-label">Experience Required</label>
                                <textarea class="form-control @error('experience_required') is-invalid @enderror" 
                                          id="experience_required" name="experience_required" 
                                          rows="2" placeholder="Experience requirements if any">{{ old('experience_required', $job->experience_required) }}</textarea>
                                @error('experience_required')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Selection Process -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-check-circle text-success"></i> Selection Process
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="selection_process" class="form-label">Selection Process</label>
                                <textarea class="form-control @error('selection_process') is-invalid @enderror" 
                                          id="selection_process" name="selection_process" 
                                          rows="4" placeholder="e.g., CBT, Descriptive, Skill Test">{{ old('selection_process', $job->selection_process) }}</textarea>
                                @error('selection_process')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Describe the selection stages</div>
                            </div>
                        </div>
                    </div>

                    <!-- How to Apply -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-edit text-primary"></i> How to Apply
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="how_to_apply" class="form-label">How to Apply Instructions</label>
                                <textarea class="form-control @error('how_to_apply') is-invalid @enderror" 
                                          id="how_to_apply" name="how_to_apply" 
                                          rows="4" placeholder="Step by step application instructions">{{ old('how_to_apply', $job->how_to_apply) }}</textarea>
                                @error('how_to_apply')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                </div>

                <!-- RIGHT COLUMN - SIDEBAR -->
                <div class="col-md-4">
                    
                    <!-- Status & Settings -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-sliders-h text-secondary"></i> Status & Settings
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" 
                                           id="is_active" name="is_active" value="1" 
                                           {{ old('is_active', $job->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold" for="is_active">
                                        <i class="fas fa-toggle-on text-success"></i> Active Job
                                    </label>
                                </div>
                                <div class="form-text">Inactive jobs won't be visible on the website.</div>
                            </div>

                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" 
                                           id="is_featured" name="is_featured" value="1" 
                                           {{ old('is_featured', $job->is_featured) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold" for="is_featured">
                                        <i class="fas fa-star text-warning"></i> Featured Job
                                    </label>
                                </div>
                                <div class="form-text">Featured jobs appear in highlighted sections.</div>
                            </div>
                        </div>
                    </div>

                    <!-- Application Links -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-link text-primary"></i> Application Links
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="application_link" class="form-label">Apply Online Link <span class="text-danger">*</span></label>
                                <input type="url" class="form-control @error('application_link') is-invalid @enderror" 
                                       id="application_link" name="application_link" 
                                       value="{{ old('application_link', $job->application_link) }}" 
                                       placeholder="https://example.com/apply" required>
                                @error('application_link')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="registration_link" class="form-label">Registration Link</label>
                                <input type="url" class="form-control @error('registration_link') is-invalid @enderror" 
                                       id="registration_link" name="registration_link" 
                                       value="{{ old('registration_link', $job->registration_link) }}" 
                                       placeholder="https://example.com/register">
                                @error('registration_link')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="login_link" class="form-label">Login Link</label>
                                <input type="url" class="form-control @error('login_link') is-invalid @enderror" 
                                       id="login_link" name="login_link" 
                                       value="{{ old('login_link', $job->login_link) }}" 
                                       placeholder="https://example.com/login">
                                @error('login_link')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="official_website" class="form-label">Official Website <span class="text-danger">*</span></label>
                                <input type="url" class="form-control @error('official_website') is-invalid @enderror" 
                                       id="official_website" name="official_website" 
                                       value="{{ old('official_website', $job->official_website) }}" 
                                       placeholder="https://example.com" required>
                                @error('official_website')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Other Important Links -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-file-alt text-info"></i> Other Important Links
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="admit_card_link" class="form-label">Admit Card Link</label>
                                <input type="url" class="form-control @error('admit_card_link') is-invalid @enderror" 
                                       id="admit_card_link" name="admit_card_link" 
                                       value="{{ old('admit_card_link', $job->admit_card_link) }}" 
                                       placeholder="https://example.com/admit-card">
                                @error('admit_card_link')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="result_link" class="form-label">Result Link</label>
                                <input type="url" class="form-control @error('result_link') is-invalid @enderror" 
                                       id="result_link" name="result_link" 
                                       value="{{ old('result_link', $job->result_link) }}" 
                                       placeholder="https://example.com/result">
                                @error('result_link')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="answer_key_link" class="form-label">Answer Key Link</label>
                                <input type="url" class="form-control @error('answer_key_link') is-invalid @enderror" 
                                       id="answer_key_link" name="answer_key_link" 
                                       value="{{ old('answer_key_link', $job->answer_key_link) }}" 
                                       placeholder="https://example.com/answer-key">
                                @error('answer_key_link')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="syllabus_link" class="form-label">Syllabus Link</label>
                                <input type="url" class="form-control @error('syllabus_link') is-invalid @enderror" 
                                       id="syllabus_link" name="syllabus_link" 
                                       value="{{ old('syllabus_link', $job->syllabus_link) }}" 
                                       placeholder="https://example.com/syllabus">
                                @error('syllabus_link')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- PDF Uploads -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-file-pdf text-danger"></i> PDF Uploads
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="notification_pdf" class="form-label">Notification PDF</label>
                                <input type="file" class="form-control @error('notification_pdf') is-invalid @enderror" 
                                       id="notification_pdf" name="notification_pdf" accept=".pdf">
                                @error('notification_pdf')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if($job->notification_pdf)
                                    <div class="mt-2">
                                        <small class="text-muted">Current file:</small>
                                        <div class="d-flex align-items-center mt-1">
                                            <i class="fas fa-file-pdf text-danger me-2"></i>
                                            <a href="{{ Storage::url($job->notification_pdf) }}" target="_blank" class="text-decoration-none">
                                                View PDF
                                            </a>
                                            <div class="form-check ms-3">
                                                <input type="checkbox" class="form-check-input" id="remove_notification_pdf" name="remove_notification_pdf" value="1">
                                                <label class="form-check-label small" for="remove_notification_pdf">Remove</label>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="short_notification_pdf" class="form-label">Short Notification PDF</label>
                                <input type="file" class="form-control @error('short_notification_pdf') is-invalid @enderror" 
                                       id="short_notification_pdf" name="short_notification_pdf" accept=".pdf">
                                @error('short_notification_pdf')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if($job->short_notification_pdf)
                                    <div class="mt-2">
                                        <small class="text-muted">Current file:</small>
                                        <div class="d-flex align-items-center mt-1">
                                            <i class="fas fa-file-pdf text-danger me-2"></i>
                                            <a href="{{ Storage::url($job->short_notification_pdf) }}" target="_blank" class="text-decoration-none">
                                                View PDF
                                            </a>
                                            <div class="form-check ms-3">
                                                <input type="checkbox" class="form-check-input" id="remove_short_notification_pdf" name="remove_short_notification_pdf" value="1">
                                                <label class="form-check-label small" for="remove_short_notification_pdf">Remove</label>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="syllabus_pdf" class="form-label">Syllabus PDF</label>
                                <input type="file" class="form-control @error('syllabus_pdf') is-invalid @enderror" 
                                       id="syllabus_pdf" name="syllabus_pdf" accept=".pdf">
                                @error('syllabus_pdf')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if($job->syllabus_pdf)
                                    <div class="mt-2">
                                        <small class="text-muted">Current file:</small>
                                        <div class="d-flex align-items-center mt-1">
                                            <i class="fas fa-file-pdf text-danger me-2"></i>
                                            <a href="{{ Storage::url($job->syllabus_pdf) }}" target="_blank" class="text-decoration-none">
                                                View PDF
                                            </a>
                                            <div class="form-check ms-3">
                                                <input type="checkbox" class="form-check-input" id="remove_syllabus_pdf" name="remove_syllabus_pdf" value="1">
                                                <label class="form-check-label small" for="remove_syllabus_pdf">Remove</label>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
 <!-- SEO Settings -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">SEO Settings</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="meta_title" class="form-label">Meta Title</label>
                                <input type="text" class="form-control @error('meta_title') is-invalid @enderror" 
                                       id="meta_title" name="meta_title" 
                                       value="{{ old('meta_title', $job->meta_title) }}" 
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
                                          maxlength="160">{{ old('meta_description', $job->meta_description) }}</textarea>
                                @error('meta_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Recommended: 150-160 characters</div>
                            </div>

                            <div class="mb-3">
                                <label for="meta_keywords" class="form-label">Meta Keywords</label>
                                <input type="text" class="form-control @error('meta_keywords') is-invalid @enderror" 
                                       id="meta_keywords" name="meta_keywords" 
                                       value="{{ old('meta_keywords', $job->meta_keywords) }}" 
                                       placeholder="keyword1, keyword2, keyword3">
                                @error('meta_keywords')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Separate keywords with commas</div>
                            </div>
                        </div>
                    </div>

            <!-- Form Actions -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.jobs.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                                <div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Update Job
                                    </button>
                                    @if($job->slug)
                                        <a href="{{ route('job.show', $job->slug) }}" target="_blank" class="btn btn-outline-info">
                                            <i class="fas fa-eye"></i> Preview
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Date validation
    const startDate = document.getElementById('start_date');
    const lastDate = document.getElementById('last_date');
    const examDate = document.getElementById('exam_date');
    const feeLastDate = document.getElementById('fee_last_date');
    const resultDate = document.getElementById('result_date');

    function validateDates() {
        const start = startDate.value ? new Date(startDate.value) : null;
        const last = lastDate.value ? new Date(lastDate.value) : null;
        const exam = examDate.value ? new Date(examDate.value) : null;
        const feeLast = feeLastDate.value ? new Date(feeLastDate.value) : null;
        const result = resultDate.value ? new Date(resultDate.value) : null;

        // Check last date after start date
        if (last && start && last <= start) {
            lastDate.setCustomValidity('Last date must be after start date');
        } else if (lastDate) {
            lastDate.setCustomValidity('');
        }

        // Check fee last date
        if (feeLast && start && feeLast < start) {
            feeLastDate.setCustomValidity('Fee last date must be after start date');
        } else if (feeLastDate) {
            feeLastDate.setCustomValidity('');
        }

        // Check exam date
        if (exam && start && exam < start) {
            examDate.setCustomValidity('Exam date must be after start date');
        } else if (examDate) {
            examDate.setCustomValidity('');
        }

        // Check result date after exam date
        if (result && exam && result < exam) {
            resultDate.setCustomValidity('Result date must be after exam date');
        } else if (resultDate) {
            resultDate.setCustomValidity('');
        }
    }

    // Add event listeners for date validation
    [startDate, lastDate, feeLastDate, examDate, resultDate].forEach(input => {
        if (input) {
            input.addEventListener('change', validateDates);
            input.addEventListener('blur', validateDates);
        }
    });

    // Initial validation
    validateDates();

    // Maintain active tab after form submission
    const activeTab = localStorage.getItem('activeJobTab');
    if (activeTab) {
        const tabTrigger = document.querySelector(`#${activeTab}-tab`);
        if (tabTrigger) {
            const tab = new bootstrap.Tab(tabTrigger);
            tab.show();
        }
    }

    // Save active tab on click
    document.querySelectorAll('#jobTabs button').forEach(tab => {
        tab.addEventListener('shown.bs.tab', function(event) {
            localStorage.setItem('activeJobTab', event.target.id.replace('-tab', ''));
        });
    });
});
</script>

<style>
.char-counter {
    font-size: 0.875em;
}

.form-check-input:checked {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.card {
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}

.form-control:focus, .form-select:focus {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

textarea.form-control {
    font-family: monospace;
}

#vacancy_details {
    font-family: 'Courier New', monospace;
    font-size: 13px;
}

.table-responsive {
    overflow-x: auto;
}

.btn-group-sm > .btn {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
}

.nav-tabs .nav-link {
    color: #495057;
}

.nav-tabs .nav-link.active {
    color: #0d6efd;
    font-weight: 500;
}

.badge {
    margin-left: 5px;
}

.text-center .fa-3x {
    font-size: 3em;
}
</style>
@endpush