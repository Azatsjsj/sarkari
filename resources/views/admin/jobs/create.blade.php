<!-- resources/views/admin/jobs/create.blade.php -->
@extends('admin.layout')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Add New Job</h1>
    <a href="{{ route('admin.jobs.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to Jobs
    </a>
</div>

@if ($errors->any())
<div class="alert alert-danger">
    <h5><i class="fas fa-exclamation-triangle"></i> Please fix the following errors:</h5>
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-plus-circle"></i> Create New Job
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.jobs.store') }}" method="POST" enctype="multipart/form-data" id="jobForm">
                    @csrf
                    
                    <!-- Basic Information -->
                    <div class="mb-4">
                        <h6 class="border-bottom pb-2 mb-3">
                            <i class="fas fa-info-circle text-primary"></i> Basic Information
                        </h6>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Job Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                           id="title" name="title" value="{{ old('title') }}" 
                                           placeholder="Enter job title" required>
                                    <div class="form-text">A clear and descriptive job title</div>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
                                    <select class="form-select @error('category_id') is-invalid @enderror" 
                                            id="category_id" name="category_id" required>
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="short_description" class="form-label">Short Description <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('short_description') is-invalid @enderror" 
                                      id="short_description" name="short_description" rows="3" 
                                      maxlength="500" placeholder="Brief description of the job" required>{{ old('short_description') }}</textarea>
                            <div class="form-text">
                                <span id="charCount">0</span>/500 characters
                            </div>
                            @error('short_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Full Description <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="6" 
                                      placeholder="Detailed job description including responsibilities, requirements, etc." required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Important Dates -->
                    <div class="mb-4">
                        <h6 class="border-bottom pb-2 mb-3">
                            <i class="fas fa-calendar-alt text-success"></i> Important Dates
                        </h6>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('start_date') is-invalid @enderror" 
                                           id="start_date" name="start_date" value="{{ old('start_date', date('Y-m-d')) }}" 
                                           required>
                                    <div class="form-text">Application start date</div>
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="last_date" class="form-label">Last Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('last_date') is-invalid @enderror" 
                                           id="last_date" name="last_date" value="{{ old('last_date') }}" required>
                                    <div class="form-text">Application end date</div>
                                    @error('last_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="fee_last_date" class="form-label">Fee Payment Last Date</label>
                                    <input type="date" class="form-control @error('fee_last_date') is-invalid @enderror" 
                                           id="fee_last_date" name="fee_last_date" value="{{ old('fee_last_date') }}">
                                    <div class="form-text">Last date for fee payment (if different)</div>
                                    @error('fee_last_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="correction_date" class="form-label">Correction Date</label>
                                    <input type="date" class="form-control @error('correction_date') is-invalid @enderror" 
                                           id="correction_date" name="correction_date" value="{{ old('correction_date') }}">
                                    <div class="form-text">Application correction window date</div>
                                    @error('correction_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="exam_date" class="form-label">Exam Date</label>
                                    <input type="date" class="form-control @error('exam_date') is-invalid @enderror" 
                                           id="exam_date" name="exam_date" value="{{ old('exam_date') }}">
                                    <div class="form-text">Tentative exam date</div>
                                    @error('exam_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="admit_card_date" class="form-label">Admit Card Date</label>
                                    <input type="date" class="form-control @error('admit_card_date') is-invalid @enderror" 
                                           id="admit_card_date" name="admit_card_date" value="{{ old('admit_card_date') }}">
                                    <div class="form-text">Admit card release date</div>
                                    @error('admit_card_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="result_date" class="form-label">Result Date</label>
                                    <input type="date" class="form-control @error('result_date') is-invalid @enderror" 
                                           id="result_date" name="result_date" value="{{ old('result_date') }}">
                                    <div class="form-text">Expected result date</div>
                                    @error('result_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="age_calculation_date" class="form-label">Age As On Date</label>
                                    <input type="date" class="form-control @error('age_calculation_date') is-invalid @enderror" 
                                           id="age_calculation_date" name="age_calculation_date" value="{{ old('age_calculation_date') }}">
                                    <div class="form-text">Date for age calculation (as on)</div>
                                    @error('age_calculation_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Fee Structure -->
                    <div class="mb-4">
                        <h6 class="border-bottom pb-2 mb-3">
                            <i class="fas fa-rupee-sign text-warning"></i> Fee Structure
                        </h6>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="fee_general" class="form-label">Fee - General / OBC / EWS</label>
                                    <input type="text" class="form-control @error('fee_general') is-invalid @enderror" 
                                           id="fee_general" name="fee_general" value="{{ old('fee_general', '₹ 100/-') }}" 
                                           placeholder="₹ 100/-">
                                    <div class="form-text">Application fee for General/OBC/EWS</div>
                                    @error('fee_general')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="fee_sc_st_female" class="form-label">Fee - SC / ST / Female / PH</label>
                                    <input type="text" class="form-control @error('fee_sc_st_female') is-invalid @enderror" 
                                           id="fee_sc_st_female" name="fee_sc_st_female" value="{{ old('fee_sc_st_female', '₹ 0/- (Exempted)') }}" 
                                           placeholder="₹ 0/- (Exempted)">
                                    <div class="form-text">Application fee for reserved categories</div>
                                    @error('fee_sc_st_female')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="fee_other" class="form-label">Fee - Other Categories</label>
                                    <input type="text" class="form-control @error('fee_other') is-invalid @enderror" 
                                           id="fee_other" name="fee_other" value="{{ old('fee_other') }}" 
                                           placeholder="As per notification">
                                    <div class="form-text">Fee for any other categories</div>
                                    @error('fee_other')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="payment_mode" class="form-label">Payment Mode</label>
                            <input type="text" class="form-control @error('payment_mode') is-invalid @enderror" 
                                   id="payment_mode" name="payment_mode" value="{{ old('payment_mode', 'Debit Card, Credit Card, Net Banking') }}" 
                                   placeholder="Debit Card, Credit Card, Net Banking">
                            <div class="form-text">Available payment methods</div>
                            @error('payment_mode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Age Limit Details -->
                    <div class="mb-4">
                        <h6 class="border-bottom pb-2 mb-3">
                            <i class="fas fa-user-clock text-info"></i> Age Limit Details
                        </h6>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="min_age" class="form-label">Minimum Age</label>
                                    <input type="text" class="form-control @error('min_age') is-invalid @enderror" 
                                           id="min_age" name="min_age" value="{{ old('min_age', '18 Years') }}" 
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
                                           id="max_age" name="max_age" value="{{ old('max_age', '40 Years') }}" 
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
                                           id="age_relaxation" name="age_relaxation" value="{{ old('age_relaxation', 'As per government rules') }}" 
                                           placeholder="As per government rules">
                                    @error('age_relaxation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Job Specifications -->
                    <div class="mb-4">
                        <h6 class="border-bottom pb-2 mb-3">
                            <i class="fas fa-briefcase text-primary"></i> Job Specifications
                        </h6>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="total_post" class="form-label">Total Posts</label>
                                    <input type="text" class="form-control @error('total_post') is-invalid @enderror" 
                                           id="total_post" name="total_post" value="{{ old('total_post') }}" 
                                           placeholder="e.g., 3003 Posts">
                                    <div class="form-text">Number of vacancies</div>
                                    @error('total_post')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="job_location" class="form-label">Job Location</label>
                                    <input type="text" class="form-control @error('job_location') is-invalid @enderror" 
                                           id="job_location" name="job_location" value="{{ old('job_location', 'All India') }}" 
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
                                           id="qualification" name="qualification" value="{{ old('qualification') }}" 
                                           placeholder="e.g., Graduate, 10+2, Diploma">
                                    <div class="form-text">Required educational qualification</div>
                                    @error('qualification')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="additional_qualification" class="form-label">Additional Qualification</label>
                            <textarea class="form-control @error('additional_qualification') is-invalid @enderror" 
                                      id="additional_qualification" name="additional_qualification" rows="2" 
                                      placeholder="Any additional qualifications required">{{ old('additional_qualification') }}</textarea>
                            @error('additional_qualification')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="experience_required" class="form-label">Experience Required</label>
                            <textarea class="form-control @error('experience_required') is-invalid @enderror" 
                                      id="experience_required" name="experience_required" rows="2" 
                                      placeholder="Experience requirements if any">{{ old('experience_required') }}</textarea>
                            @error('experience_required')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Vacancy Details Table -->
                    <div class="mb-4">
                        <h6 class="border-bottom pb-2 mb-3">
                            <i class="fas fa-table text-info"></i> Vacancy & Eligibility Details Table
                        </h6>
                        
                        <div class="mb-3">
                            <label for="vacancy_details" class="form-label">Vacancy Details HTML</label>
                            <textarea class="form-control @error('vacancy_details') is-invalid @enderror" 
                                      id="vacancy_details" name="vacancy_details" rows="10" 
                                      placeholder='<table><tr><td>Post Name</td><td>Total Posts</td><td>Eligibility</td></tr><tr><td>Post Name</td><td>100</td><td>Graduate</td></tr></table>' 
                                      style="font-family: monospace;">{{ old('vacancy_details') }}</textarea>
                            <div class="form-text">
                                <i class="fas fa-info-circle"></i> 
                                Enter HTML table markup for vacancy distribution, category-wise details, and eligibility criteria.
                                Suggested format: &lt;table border="1" cellpadding="10" cellspacing="0"&gt;...&lt;/table&gt;
                            </div>
                            @error('vacancy_details')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Selection Process -->
                    <div class="mb-4">
                        <h6 class="border-bottom pb-2 mb-3">
                            <i class="fas fa-check-circle text-success"></i> Selection Process
                        </h6>
                        
                        <div class="mb-3">
                            <label for="selection_process" class="form-label">Selection Process</label>
                            <textarea class="form-control @error('selection_process') is-invalid @enderror" 
                                      id="selection_process" name="selection_process" rows="4" 
                                      placeholder="e.g., CBT, Descriptive, Skill Test">{{ old('selection_process') }}</textarea>
                            <div class="form-text">Describe the selection stages</div>
                            @error('selection_process')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- How to Apply -->
                    <div class="mb-4">
                        <h6 class="border-bottom pb-2 mb-3">
                            <i class="fas fa-edit text-primary"></i> How to Apply
                        </h6>
                        
                        <div class="mb-3">
                            <label for="how_to_apply" class="form-label">How to Apply Instructions</label>
                            <textarea class="form-control @error('how_to_apply') is-invalid @enderror" 
                                      id="how_to_apply" name="how_to_apply" rows="4" 
                                      placeholder="Step by step application instructions">{{ old('how_to_apply') }}</textarea>
                            @error('how_to_apply')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Application Links -->
                    <div class="mb-4">
                        <h6 class="border-bottom pb-2 mb-3">
                            <i class="fas fa-link text-primary"></i> Application Links
                        </h6>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="application_link" class="form-label">Apply Online Link <span class="text-danger">*</span></label>
                                    <input type="url" class="form-control @error('application_link') is-invalid @enderror" 
                                           id="application_link" name="application_link" value="{{ old('application_link') }}" 
                                           placeholder="https://example.com/apply" required>
                                    <div class="form-text">Direct link to apply online</div>
                                    @error('application_link')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="registration_link" class="form-label">Registration Link (Optional)</label>
                                    <input type="url" class="form-control @error('registration_link') is-invalid @enderror" 
                                           id="registration_link" name="registration_link" value="{{ old('registration_link') }}" 
                                           placeholder="https://example.com/register">
                                    <div class="form-text">Separate registration link if different</div>
                                    @error('registration_link')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="login_link" class="form-label">Login Link</label>
                                    <input type="url" class="form-control @error('login_link') is-invalid @enderror" 
                                           id="login_link" name="login_link" value="{{ old('login_link') }}" 
                                           placeholder="https://example.com/login">
                                    <div class="form-text">Login link for existing users</div>
                                    @error('login_link')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="admit_card_link" class="form-label">Admit Card Link</label>
                                    <input type="url" class="form-control @error('admit_card_link') is-invalid @enderror" 
                                           id="admit_card_link" name="admit_card_link" value="{{ old('admit_card_link') }}" 
                                           placeholder="https://example.com/admit-card">
                                    <div class="form-text">Link to download admit card</div>
                                    @error('admit_card_link')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="result_link" class="form-label">Result Link</label>
                                    <input type="url" class="form-control @error('result_link') is-invalid @enderror" 
                                           id="result_link" name="result_link" value="{{ old('result_link') }}" 
                                           placeholder="https://example.com/result">
                                    <div class="form-text">Link to check results</div>
                                    @error('result_link')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="answer_key_link" class="form-label">Answer Key Link</label>
                                    <input type="url" class="form-control @error('answer_key_link') is-invalid @enderror" 
                                           id="answer_key_link" name="answer_key_link" value="{{ old('answer_key_link') }}" 
                                           placeholder="https://example.com/answer-key">
                                    <div class="form-text">Link to download answer key</div>
                                    @error('answer_key_link')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="official_website" class="form-label">Official Website <span class="text-danger">*</span></label>
                                    <input type="url" class="form-control @error('official_website') is-invalid @enderror" 
                                           id="official_website" name="official_website" value="{{ old('official_website') }}" 
                                           placeholder="https://example.com" required>
                                    <div class="form-text">Organization's official website</div>
                                    @error('official_website')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="syllabus_link" class="form-label">Syllabus Link</label>
                                    <input type="url" class="form-control @error('syllabus_link') is-invalid @enderror" 
                                           id="syllabus_link" name="syllabus_link" value="{{ old('syllabus_link') }}" 
                                           placeholder="https://example.com/syllabus">
                                    <div class="form-text">Link to download syllabus</div>
                                    @error('syllabus_link')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- File Uploads -->
                    <div class="mb-4">
                        <h6 class="border-bottom pb-2 mb-3">
                            <i class="fas fa-file-pdf text-danger"></i> PDF Uploads
                        </h6>
                        
                        <div class="mb-3">
                            <label for="notification_pdf" class="form-label">Notification PDF</label>
                            <input type="file" class="form-control @error('notification_pdf') is-invalid @enderror" 
                                   id="notification_pdf" name="notification_pdf" accept=".pdf">
                            <div class="form-text">Detailed notification PDF file (Max: 10MB)</div>
                            @error('notification_pdf')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="short_notification_pdf" class="form-label">Short Notification PDF</label>
                            <input type="file" class="form-control @error('short_notification_pdf') is-invalid @enderror" 
                                   id="short_notification_pdf" name="short_notification_pdf" accept=".pdf">
                            <div class="form-text">Short notification PDF (Max: 10MB)</div>
                            @error('short_notification_pdf')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="syllabus_pdf" class="form-label">Syllabus PDF</label>
                            <input type="file" class="form-control @error('syllabus_pdf') is-invalid @enderror" 
                                   id="syllabus_pdf" name="syllabus_pdf" accept=".pdf">
                            <div class="form-text">Syllabus PDF file (Max: 10MB)</div>
                            @error('syllabus_pdf')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Status Settings -->
                    <div class="mb-4">
                        <h6 class="border-bottom pb-2 mb-3">
                            <i class="fas fa-sliders-h text-secondary"></i> Status Settings
                        </h6>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" 
                                               {{ old('is_active', true) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold" for="is_active">
                                            <i class="fas fa-toggle-on text-success"></i> Active Job
                                        </label>
                                    </div>
                                    <div class="form-text">Inactive jobs won't be visible on the website</div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1"
                                               {{ old('is_featured') ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold" for="is_featured">
                                            <i class="fas fa-star text-warning"></i> Featured Job
                                        </label>
                                    </div>
                                    <div class="form-text">Featured jobs appear in special sections</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end border-top pt-3">
                        <button type="reset" class="btn btn-outline-secondary me-md-2">
                            <i class="fas fa-undo"></i> Reset Form
                        </button>
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <i class="fas fa-save"></i> Create Job
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Sidebar Help -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">
                    <i class="fas fa-question-circle"></i> Quick Tips
                </h5>
            </div>
            <div class="card-body">
                <div class="alert alert-light">
                    <h6><i class="fas fa-lightbulb text-warning"></i> Best Practices:</h6>
                    <ul class="small mb-0">
                        <li>Use clear and descriptive job titles</li>
                        <li>Provide accurate application dates</li>
                        <li>Include all required qualifications</li>
                        <li>Upload the official notification PDF</li>
                        <li>Double-check all URLs before submitting</li>
                    </ul>
                </div>
                
                <div class="alert alert-warning">
                    <h6><i class="fas fa-exclamation-triangle"></i> Important:</h6>
                    <ul class="small mb-0">
                        <li>Fields marked with <span class="text-danger">*</span> are required</li>
                        <li>Last date must be after start date</li>
                        <li>PDF file size should be under 10MB</li>
                        <li>Verify all links before publishing</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Form Progress -->
        <div class="card mt-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">
                    <i class="fas fa-tasks"></i> Form Progress
                </h5>
            </div>
            <div class="card-body">
                <div class="progress mb-3" style="height: 10px;">
                    <div class="progress-bar" id="formProgress" role="progressbar" style="width: 0%"></div>
                </div>
                <small class="text-muted" id="progressText">Fill the form to see progress</small>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.form-section {
    margin-bottom: 2rem;
}

.section-header {
    border-left: 4px solid #0d6efd;
    padding-left: 1rem;
    margin-bottom: 1.5rem;
}

.card-header {
    border-bottom: 1px solid rgba(0, 0, 0, 0.125);
}

.form-text {
    font-size: 0.875rem;
}

.progress {
    background-color: #e9ecef;
}

.form-check-input:checked {
    background-color: #198754;
    border-color: #198754;
}

#is_featured.form-check-input:checked {
    background-color: #ffc107;
    border-color: #ffc107;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('jobForm');
    const progressBar = document.getElementById('formProgress');
    const progressText = document.getElementById('progressText');
    const charCount = document.getElementById('charCount');
    const shortDescription = document.getElementById('short_description');
    const submitBtn = document.getElementById('submitBtn');

    // Character count for short description
    if (shortDescription && charCount) {
        shortDescription.addEventListener('input', function() {
            charCount.textContent = this.value.length;
            if (this.value.length > 500) {
                charCount.classList.add('text-danger');
            } else {
                charCount.classList.remove('text-danger');
            }
        });
        charCount.textContent = shortDescription.value.length;
    }

    // Date validation
    const startDate = document.getElementById('start_date');
    const lastDate = document.getElementById('last_date');
    const feeLastDate = document.getElementById('fee_last_date');
    const examDate = document.getElementById('exam_date');
    const admitCardDate = document.getElementById('admit_card_date');
    const resultDate = document.getElementById('result_date');

    function validateDates() {
        const start = startDate && startDate.value ? new Date(startDate.value) : null;
        const last = lastDate && lastDate.value ? new Date(lastDate.value) : null;
        const feeLast = feeLastDate && feeLastDate.value ? new Date(feeLastDate.value) : null;
        const exam = examDate && examDate.value ? new Date(examDate.value) : null;
        const admitCard = admitCardDate && admitCardDate.value ? new Date(admitCardDate.value) : null;
        const result = resultDate && resultDate.value ? new Date(resultDate.value) : null;

        let isValid = true;

        // Check last date after start date
        if (last && start && last < start) {
            if (lastDate) lastDate.setCustomValidity('Last date must be after start date');
            isValid = false;
        } else if (lastDate) {
            lastDate.setCustomValidity('');
        }

        // Check fee last date
        if (feeLast && start && feeLast < start) {
            if (feeLastDate) feeLastDate.setCustomValidity('Fee last date must be after start date');
            isValid = false;
        } else if (feeLastDate) {
            feeLastDate.setCustomValidity('');
        }

        // Check exam date
        if (exam && start && exam < start) {
            if (examDate) examDate.setCustomValidity('Exam date must be after start date');
            isValid = false;
        } else if (examDate) {
            examDate.setCustomValidity('');
        }

        // Check admit card date
        if (admitCard && start && admitCard < start) {
            if (admitCardDate) admitCardDate.setCustomValidity('Admit card date must be after start date');
            isValid = false;
        } else if (admitCardDate) {
            admitCardDate.setCustomValidity('');
        }

        // Check result date after exam date
        if (result && exam && result < exam) {
            if (resultDate) resultDate.setCustomValidity('Result date must be after exam date');
            isValid = false;
        } else if (resultDate) {
            resultDate.setCustomValidity('');
        }

        return isValid;
    }

    // Add event listeners for date validation
    [startDate, lastDate, feeLastDate, examDate, admitCardDate, resultDate].forEach(input => {
        if (input) {
            input.addEventListener('change', validateDates);
        }
    });

    // Form progress calculation
    function calculateProgress() {
        const requiredFields = form.querySelectorAll('[required]');
        let filledCount = 0;
        
        requiredFields.forEach(field => {
            if (field.type === 'checkbox') {
                if (field.checked) filledCount++;
            } else if (field.value && field.value.trim() !== '') {
                filledCount++;
            }
        });
        
        const progress = requiredFields.length > 0 ? (filledCount / requiredFields.length) * 100 : 0;
        
        if (progressBar) progressBar.style.width = progress + '%';
        if (progressText) progressText.textContent = `Progress: ${Math.round(progress)}% complete`;
        
        if (progress === 100 && progressBar) {
            progressBar.classList.remove('bg-warning');
            progressBar.classList.add('bg-success');
        } else if (progressBar) {
            progressBar.classList.remove('bg-success');
            progressBar.classList.add('bg-warning');
        }
    }

    // Calculate progress on input
    if (form) {
        form.addEventListener('input', calculateProgress);
        calculateProgress();
    }

    // Form submission handling
    if (form && submitBtn) {
        form.addEventListener('submit', function(e) {
            if (!validateDates()) {
                e.preventDefault();
                alert('Please fix the date validation errors before submitting.');
                return;
            }

            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creating Job...';
        });
    }

    // Reset form progress on reset
    if (form && submitBtn) {
        form.addEventListener('reset', function() {
            setTimeout(calculateProgress, 100);
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-save"></i> Create Job';
        });
    }
});
</script>
@endpush