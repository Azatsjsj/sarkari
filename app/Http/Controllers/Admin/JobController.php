<?php
// app/Http/Controllers/Admin/JobController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class JobController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        try {
            $query = Job::with('category');

            // Search filter
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('title', 'LIKE', "%{$search}%")
                      ->orWhere('short_description', 'LIKE', "%{$search}%")
                      ->orWhere('description', 'LIKE', "%{$search}%")
                      ->orWhereHas('category', function($q) use ($search) {
                          $q->where('name', 'LIKE', "%{$search}%");
                      });
                });
            }

            // Category filter
            if ($request->has('category') && !empty($request->category)) {
                $query->where('category_id', $request->category);
            }

            // Status filter
            if ($request->has('status') && !empty($request->status)) {
                switch ($request->status) {
                    case 'active':
                        $query->where('is_active', true);
                        break;
                    case 'inactive':
                        $query->where('is_active', false);
                        break;
                    case 'featured':
                        $query->where('is_featured', true);
                        break;
                    case 'expired':
                        $query->where('last_date', '<', now());
                        break;
                }
            }

            // Sort options
            $sort = $request->get('sort', 'latest');
            switch ($sort) {
                case 'oldest':
                    $query->oldest();
                    break;
                case 'title_asc':
                    $query->orderBy('title', 'asc');
                    break;
                case 'title_desc':
                    $query->orderBy('title', 'desc');
                    break;
                case 'last_date':
                    $query->orderBy('last_date', 'asc');
                    break;
                default:
                    $query->latest();
            }

            $jobs = $query->paginate(20);

            // Get categories for filter dropdown
            $categories = Category::where('is_active', true)->get();

            // Statistics
            $stats = [
                'total' => Job::count(),
                'active' => Job::where('is_active', true)->count(),
                'featured' => Job::where('is_featured', true)->count(),
                'expired' => Job::where('last_date', '<', now())->count(),
            ];

            return view('admin.jobs.index', compact('jobs', 'categories', 'stats'));

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to load jobs: ' . $e->getMessage());
        }
    }

    public function create()
    {
        try {
            $categories = Category::where('is_active', true)->get();
            return view('admin.jobs.create', compact('categories'));
        } catch (\Exception $e) {
            return redirect()->route('admin.jobs.index')
                ->with('error', 'Failed to load create form: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $validationRules = [
                'title' => 'required|string|max:255|unique:jobs,title',
                'category_id' => 'required|exists:categories,id',
                'short_description' => 'required|string|max:500',
                'description' => 'nullable|string',
                'vacancy_details' => 'nullable|string',
                'start_date' => 'required|date',
                'last_date' => 'required|date|after:start_date',
                'fee_last_date' => 'nullable|date|after_or_equal:start_date',
                'correction_date' => 'nullable|date',
                'exam_date' => 'nullable|date',
                'admit_card_date' => 'nullable|date',
                'result_date' => 'nullable|date',
                'age_calculation_date' => 'nullable|date',
                'official_website' => 'required|url',
                'application_link' => 'required|url',
                'registration_link' => 'nullable|url',
                'login_link' => 'nullable|url',
                'admit_card_link' => 'nullable|url',
                'result_link' => 'nullable|url',
                'answer_key_link' => 'nullable|url',
                'syllabus_link' => 'nullable|url',
                'notification_pdf' => 'nullable|file|mimes:pdf|max:10240',
                'short_notification_pdf' => 'nullable|file|mimes:pdf|max:10240',
                'syllabus_pdf' => 'nullable|file|mimes:pdf|max:10240',
                'total_post' => 'nullable|string|max:100',
                'job_location' => 'nullable|string|max:255',
                'qualification' => 'nullable|string|max:500',
                'additional_qualification' => 'nullable|string',
                'experience_required' => 'nullable|string',
                'selection_process' => 'nullable|string',
                'how_to_apply' => 'nullable|string',
                'fee_general' => 'nullable|string|max:100',
                'fee_sc_st_female' => 'nullable|string|max:100',
                'fee_other' => 'nullable|string|max:100',
                'payment_mode' => 'nullable|string|max:255',
                'min_age' => 'nullable|string|max:50',
                'max_age' => 'nullable|string|max:50',
                'age_relaxation' => 'nullable|string|max:255',
                'application_fee' => 'nullable|numeric|min:0',
                'age_limit' => 'nullable|string|max:100',
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string|max:500',
                'meta_keywords' => 'nullable|string|max:500',
                'is_active' => 'boolean',
                'is_featured' => 'boolean',
            ];

            $validationMessages = [
                'title.unique' => 'A job with this title already exists.',
                'last_date.after' => 'Last date must be after start date.',
                'fee_last_date.after_or_equal' => 'Fee last date must be after or equal to start date.',
                'notification_pdf.max' => 'Notification PDF must not exceed 100MB.',
                'short_notification_pdf.max' => 'Short notification PDF must not exceed 100MB.',
                'syllabus_pdf.max' => 'Syllabus PDF must not exceed 100MB.',
            ];

            $request->validate($validationRules, $validationMessages);

            $jobData = [
                'title' => $request->title,
                'slug' => $this->generateUniqueSlug($request->title),
                'category_id' => $request->category_id,
                'short_description' => $request->short_description,
                'description' => $request->description,
                'vacancy_details' => $request->vacancy_details,
                'start_date' => $request->start_date,
                'last_date' => $request->last_date,
                'fee_last_date' => $request->fee_last_date,
                'correction_date' => $request->correction_date,
                'exam_date' => $request->exam_date,
                'admit_card_date' => $request->admit_card_date,
                'result_date' => $request->result_date,
                'age_calculation_date' => $request->age_calculation_date,
                'official_website' => $request->official_website,
                'application_link' => $request->application_link,
                'registration_link' => $request->registration_link,
                'login_link' => $request->login_link,
                'admit_card_link' => $request->admit_card_link,
                'result_link' => $request->result_link,
                'answer_key_link' => $request->answer_key_link,
                'syllabus_link' => $request->syllabus_link,
                'total_post' => $request->total_post,
                'job_location' => $request->job_location,
                'qualification' => $request->qualification,
                'additional_qualification' => $request->additional_qualification,
                'experience_required' => $request->experience_required,
                'selection_process' => $request->selection_process,
                'how_to_apply' => $request->how_to_apply,
                'fee_general' => $request->fee_general,
                'fee_sc_st_female' => $request->fee_sc_st_female,
                'fee_other' => $request->fee_other,
                'payment_mode' => $request->payment_mode,
                'min_age' => $request->min_age,
                'max_age' => $request->max_age,
                'age_relaxation' => $request->age_relaxation,
                'application_fee' => $request->application_fee,
                'age_limit' => $request->age_limit,
                'is_active' => $request->boolean('is_active'),
                'is_featured' => $request->boolean('is_featured'),
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
                'meta_keywords' => $request->meta_keywords,
            ];

            // Handle file uploads
            if ($request->hasFile('notification_pdf')) {
                $jobData['notification_pdf'] = $this->uploadFile($request->file('notification_pdf'), 'notifications', $request->title);
            }

            if ($request->hasFile('short_notification_pdf')) {
                $jobData['short_notification_pdf'] = $this->uploadFile($request->file('short_notification_pdf'), 'notifications', $request->title . '-short');
            }

            if ($request->hasFile('syllabus_pdf')) {
                $jobData['syllabus_pdf'] = $this->uploadFile($request->file('syllabus_pdf'), 'syllabus', $request->title);
            }

            $job = Job::create($jobData);
            \App\Models\Notification::sendJobNotification($job);

            DB::commit();

            return redirect()->route('admin.jobs.index')
                ->with('success', 'Job created successfully.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to create job: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show($id)
    {
        try {
            $job = Job::with(['category', 'results'])->findOrFail($id);
            
            // Add results count
            $job->results_count = $job->results->count();

            return view('admin.jobs.show', compact('job'));
        } catch (\Exception $e) {
            return redirect()->route('admin.jobs.index')
                ->with('error', 'Job not found: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $job = Job::findOrFail($id);
            $categories = Category::where('is_active', true)->get();
            
            return view('admin.jobs.edit', compact('job', 'categories'));
        } catch (\Exception $e) {
            return redirect()->route('admin.jobs.index')
                ->with('error', 'Job not found: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $job = Job::findOrFail($id);

            $validationRules = [
                'title' => 'required|string|max:255|unique:jobs,title,' . $job->id,
                'category_id' => 'required|exists:categories,id',
                'short_description' => 'required|string|max:500',
                'description' => 'nullable|string',
                'vacancy_details' => 'nullable|string',
                'start_date' => 'required|date',
                'last_date' => 'required|date|after:start_date',
                'fee_last_date' => 'nullable|date|after_or_equal:start_date',
                'correction_date' => 'nullable|date',
                'exam_date' => 'nullable|date',
                'admit_card_date' => 'nullable|date',
                'result_date' => 'nullable|date',
                'age_calculation_date' => 'nullable|date',
                'official_website' => 'required|url',
                'application_link' => 'required|url',
                'registration_link' => 'nullable|url',
                'login_link' => 'nullable|url',
                'admit_card_link' => 'nullable|url',
                'result_link' => 'nullable|url',
                'answer_key_link' => 'nullable|url',
                'syllabus_link' => 'nullable|url',
                'notification_pdf' => 'nullable|file|mimes:pdf|max:10240',
                'short_notification_pdf' => 'nullable|file|mimes:pdf|max:10240',
                'syllabus_pdf' => 'nullable|file|mimes:pdf|max:10240',
                'total_post' => 'nullable|string|max:100',
                'job_location' => 'nullable|string|max:255',
                'qualification' => 'nullable|string|max:500',
                'additional_qualification' => 'nullable|string',
                'experience_required' => 'nullable|string',
                'selection_process' => 'nullable|string',
                'how_to_apply' => 'nullable|string',
                'fee_general' => 'nullable|string|max:100',
                'fee_sc_st_female' => 'nullable|string|max:100',
                'fee_other' => 'nullable|string|max:100',
                'payment_mode' => 'nullable|string|max:255',
                'min_age' => 'nullable|string|max:50',
                'max_age' => 'nullable|string|max:50',
                'age_relaxation' => 'nullable|string|max:255',
                'application_fee' => 'nullable|numeric|min:0',
                'age_limit' => 'nullable|string|max:100',
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string|max:500',
                'meta_keywords' => 'nullable|string|max:500',
                'is_active' => 'boolean',
                'is_featured' => 'boolean',
                'remove_notification_pdf' => 'nullable|boolean',
                'remove_short_notification_pdf' => 'nullable|boolean',
                'remove_syllabus_pdf' => 'nullable|boolean',
            ];

            $validationMessages = [
                'title.unique' => 'A job with this title already exists.',
                'last_date.after' => 'Last date must be after start date.',
                'fee_last_date.after_or_equal' => 'Fee last date must be after or equal to start date.',
                'notification_pdf.max' => 'Notification PDF must not exceed 100MB.',
                'short_notification_pdf.max' => 'Short notification PDF must not exceed 100MB.',
                'syllabus_pdf.max' => 'Syllabus PDF must not exceed 100MB.',
            ];

            $request->validate($validationRules, $validationMessages);

            $updateData = [
                'title' => $request->title,
                'category_id' => $request->category_id,
                'short_description' => $request->short_description,
                'description' => $request->description,
                'vacancy_details' => $request->vacancy_details,
                'start_date' => $request->start_date,
                'last_date' => $request->last_date,
                'fee_last_date' => $request->fee_last_date,
                'correction_date' => $request->correction_date,
                'exam_date' => $request->exam_date,
                'admit_card_date' => $request->admit_card_date,
                'result_date' => $request->result_date,
                'age_calculation_date' => $request->age_calculation_date,
                'official_website' => $request->official_website,
                'application_link' => $request->application_link,
                'registration_link' => $request->registration_link,
                'login_link' => $request->login_link,
                'admit_card_link' => $request->admit_card_link,
                'result_link' => $request->result_link,
                'answer_key_link' => $request->answer_key_link,
                'syllabus_link' => $request->syllabus_link,
                'total_post' => $request->total_post,
                'job_location' => $request->job_location,
                'qualification' => $request->qualification,
                'additional_qualification' => $request->additional_qualification,
                'experience_required' => $request->experience_required,
                'selection_process' => $request->selection_process,
                'how_to_apply' => $request->how_to_apply,
                'fee_general' => $request->fee_general,
                'fee_sc_st_female' => $request->fee_sc_st_female,
                'fee_other' => $request->fee_other,
                'payment_mode' => $request->payment_mode,
                'min_age' => $request->min_age,
                'max_age' => $request->max_age,
                'age_relaxation' => $request->age_relaxation,
                'application_fee' => $request->application_fee,
                'age_limit' => $request->age_limit,
                'is_active' => $request->boolean('is_active'),
                'is_featured' => $request->boolean('is_featured'),
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
                'meta_keywords' => $request->meta_keywords,
            ];

            // Generate new slug if title changed
            if ($job->title != $request->title) {
                $updateData['slug'] = $this->generateUniqueSlug($request->title);
            }

            // Handle file uploads and deletions
            // Notification PDF
            if ($request->boolean('remove_notification_pdf') && $job->notification_pdf) {
                $this->deleteFile($job->notification_pdf);
                $updateData['notification_pdf'] = null;
            }

            if ($request->hasFile('notification_pdf')) {
                if ($job->notification_pdf) {
                    $this->deleteFile($job->notification_pdf);
                }
                $updateData['notification_pdf'] = $this->uploadFile($request->file('notification_pdf'), 'notifications', $request->title);
            }

            // Short Notification PDF
            if ($request->boolean('remove_short_notification_pdf') && $job->short_notification_pdf) {
                $this->deleteFile($job->short_notification_pdf);
                $updateData['short_notification_pdf'] = null;
            }

            if ($request->hasFile('short_notification_pdf')) {
                if ($job->short_notification_pdf) {
                    $this->deleteFile($job->short_notification_pdf);
                }
                $updateData['short_notification_pdf'] = $this->uploadFile($request->file('short_notification_pdf'), 'notifications', $request->title . '-short');
            }

            // Syllabus PDF
            if ($request->boolean('remove_syllabus_pdf') && $job->syllabus_pdf) {
                $this->deleteFile($job->syllabus_pdf);
                $updateData['syllabus_pdf'] = null;
            }

            if ($request->hasFile('syllabus_pdf')) {
                if ($job->syllabus_pdf) {
                    $this->deleteFile($job->syllabus_pdf);
                }
                $updateData['syllabus_pdf'] = $this->uploadFile($request->file('syllabus_pdf'), 'syllabus', $request->title);
            }

            $job->update($updateData);

            DB::commit();

            return redirect()->route('admin.jobs.index')
                ->with('success', 'Job updated successfully.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to update job: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $job = Job::findOrFail($id);

            // Delete associated files
            if ($job->notification_pdf) {
                $this->deleteFile($job->notification_pdf);
            }
            if ($job->short_notification_pdf) {
                $this->deleteFile($job->short_notification_pdf);
            }
            if ($job->syllabus_pdf) {
                $this->deleteFile($job->syllabus_pdf);
            }

            $job->delete();

            DB::commit();

            return redirect()->route('admin.jobs.index')
                ->with('success', 'Job deleted successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.jobs.index')
                ->with('error', 'Failed to delete job: ' . $e->getMessage());
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $request->validate([
                'status' => 'required|in:active,inactive,featured,unfeatured'
            ]);

            $job = Job::findOrFail($id);
            
            switch ($request->status) {
                case 'active':
                    $job->update(['is_active' => true]);
                    $message = 'Job activated successfully.';
                    break;
                case 'inactive':
                    $job->update(['is_active' => false]);
                    $message = 'Job deactivated successfully.';
                    break;
                case 'featured':
                    $job->update(['is_featured' => true]);
                    $message = 'Job featured successfully.';
                    break;
                case 'unfeatured':
                    $job->update(['is_featured' => false]);
                    $message = 'Job unfeatured successfully.';
                    break;
            }

            return redirect()->back()->with('success', $message);

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update job status: ' . $e->getMessage());
        }
    }

    public function bulkAction(Request $request)
    {
        try {
            $request->validate([
                'action' => 'required|in:activate,deactivate,delete,feature,unfeature',
                'ids' => 'required|array',
                'ids.*' => 'exists:jobs,id'
            ]);

            $action = $request->action;
            $ids = $request->ids;

            switch ($action) {
                case 'activate':
                    Job::whereIn('id', $ids)->update(['is_active' => true]);
                    $message = 'Selected jobs activated successfully.';
                    break;
                case 'deactivate':
                    Job::whereIn('id', $ids)->update(['is_active' => false]);
                    $message = 'Selected jobs deactivated successfully.';
                    break;
                case 'feature':
                    Job::whereIn('id', $ids)->update(['is_featured' => true]);
                    $message = 'Selected jobs featured successfully.';
                    break;
                case 'unfeature':
                    Job::whereIn('id', $ids)->update(['is_featured' => false]);
                    $message = 'Selected jobs unfeatured successfully.';
                    break;
                case 'delete':
                    $jobs = Job::whereIn('id', $ids)->get();
                    foreach ($jobs as $job) {
                        if ($job->notification_pdf) {
                            $this->deleteFile($job->notification_pdf);
                        }
                        if ($job->short_notification_pdf) {
                            $this->deleteFile($job->short_notification_pdf);
                        }
                        if ($job->syllabus_pdf) {
                            $this->deleteFile($job->syllabus_pdf);
                        }
                        $job->delete();
                    }
                    $message = 'Selected jobs deleted successfully.';
                    break;
            }

            return redirect()->back()->with('success', $message);

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to perform bulk action: ' . $e->getMessage());
        }
    }

    public function duplicate($id)
    {
        DB::beginTransaction();

        try {
            $originalJob = Job::findOrFail($id);
            
            $newJob = $originalJob->replicate();
            $newJob->title = $originalJob->title . ' (Copy)';
            $newJob->slug = $this->generateUniqueSlug($originalJob->title . ' copy');
            $newJob->is_active = false;
            $newJob->views = 0;
            $newJob->created_at = now();
            $newJob->updated_at = now();
            
            $newJob->save();

            DB::commit();

            return redirect()->route('admin.jobs.edit', $newJob->id)
                ->with('success', 'Job duplicated successfully. You can now edit the copy.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to duplicate job: ' . $e->getMessage());
        }
    }

    /**
     * Generate unique slug for job
     */
    private function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        while (Job::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }

    /**
     * Upload file to storage
     */
    private function uploadFile($file, $folder, $name)
    {
        $fileName = time() . '_' . Str::slug($name) . '.pdf';
        return $file->storeAs($folder, $fileName, 'public');
    }

    /**
     * Delete file from storage
     */
    private function deleteFile($filePath)
    {
        if ($filePath && Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }
    }
}