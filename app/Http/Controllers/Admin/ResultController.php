<?php
// app/Http/Controllers/Admin/ResultController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Result;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ResultController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        try {
            $query = Result::with('job');

            // Search filter
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('title', 'LIKE', "%{$search}%")
                      ->orWhere('short_description', 'LIKE', "%{$search}%")
                      ->orWhere('description', 'LIKE', "%{$search}%")
                      ->orWhere('roll_number', 'LIKE', "%{$search}%")
                      ->orWhereHas('job', function($q) use ($search) {
                          $q->where('title', 'LIKE', "%{$search}%");
                      });
                });
            }

            // Job filter
            if ($request->has('job_id') && !empty($request->job_id)) {
                $query->where('job_id', $request->job_id);
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
                    case 'published':
                        $query->published();
                        break;
                    case 'upcoming':
                        $query->upcoming();
                        break;
                }
            }

            // Date filter
            if ($request->has('date_from') && !empty($request->date_from)) {
                $query->whereDate('result_date', '>=', $request->date_from);
            }
            
            if ($request->has('date_to') && !empty($request->date_to)) {
                $query->whereDate('result_date', '<=', $request->date_to);
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
                case 'result_date_asc':
                    $query->orderBy('result_date', 'asc');
                    break;
                case 'result_date_desc':
                    $query->orderBy('result_date', 'desc');
                    break;
                case 'most_viewed':
                    $query->orderBy('views', 'desc');
                    break;
                case 'most_downloaded':
                    $query->orderBy('download_count', 'desc');
                    break;
                default:
                    $query->latest();
            }

            $results = $query->paginate(20)->withQueryString();

            // Get jobs for filter dropdown
            $jobs = Job::where('is_active', true)->orderBy('title', 'asc')->get();

            // Statistics
            $stats = [
                'total' => Result::count(),
                'active' => Result::where('is_active', true)->count(),
                'inactive' => Result::where('is_active', false)->count(),
                'published' => Result::published()->count(),
                'upcoming' => Result::upcoming()->count(),
                'recent' => Result::where('created_at', '>=', Carbon::now()->subDays(7))->count(),
            ];

            return view('admin.results.index', compact('results', 'jobs', 'stats'));

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to load results: ' . $e->getMessage());
        }
    }

    public function create(Request $request)
    {
        try {
            $jobs = Job::where('is_active', true)->orderBy('title', 'asc')->get();
            
            // Pre-select job if job_id is provided
            $selectedJob = null;
            if ($request->has('job_id') && !empty($request->job_id)) {
                $selectedJob = Job::find($request->job_id);
            }
            
            return view('admin.results.create', compact('jobs', 'selectedJob'));
        } catch (\Exception $e) {
            return redirect()->route('admin.results.index')
                ->with('error', 'Failed to load create form: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'title' => 'required|string|max:255|unique:results,title',
                'job_id' => 'required|exists:jobs,id',
                'short_description' => 'nullable|string|max:500',
                'description' => 'nullable|string',
                'roll_number' => 'nullable|string|max:255',
                'result_date' => 'nullable|date',
                'declaration_date' => 'nullable|date',
                'result_link' => 'nullable|url',
                'result_pdf' => 'nullable|file|mimes:pdf|max:10240', // 10MB
                'is_active' => 'boolean',
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string|max:500',
                'meta_keywords' => 'nullable|string|max:500',
            ], [
                'title.unique' => 'A result with this title already exists.',
                'result_pdf.max' => 'The result PDF must not be greater than 10MB.',
                'result_pdf.mimes' => 'The result file must be a PDF.',
            ]);

            $resultData = [
                'title' => $request->title,
                'slug' => $this->generateUniqueSlug($request->title),
                'job_id' => $request->job_id,
                'short_description' => $request->short_description,
                'description' => $request->description,
                'roll_number' => $request->roll_number,
                'result_date' => $request->result_date ?? $request->declaration_date,
                'declaration_date' => $request->declaration_date ?? $request->result_date,
                'result_link' => $request->result_link,
                'is_active' => $request->boolean('is_active'),
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
                'meta_keywords' => $request->meta_keywords,
            ];

            // Handle file upload
            if ($request->hasFile('result_pdf')) {
                $filePath = $this->uploadResultFile($request->file('result_pdf'), $request->title);
                $resultData['result_pdf'] = $filePath;
            }

            // Also handle legacy result_file field if provided
            if ($request->hasFile('result_file')) {
                $filePath = $this->uploadResultFile($request->file('result_file'), $request->title);
                $resultData['result_pdf'] = $filePath;
                $resultData['result_file'] = $filePath;
            }

            $result = Result::create($resultData);
            \App\Models\Notification::sendResultNotification($result);

            DB::commit();

            // Redirect based on submit action
            if ($request->input('submit_action') === 'save_and_new') {
                return redirect()->route('admin.results.create')
                    ->with('success', 'Result created successfully. You can add another.');
            }

            return redirect()->route('admin.results.index')
                ->with('success', 'Result created successfully.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to create result: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show($id)
    {
        try {
            $result = Result::with(['job'])->findOrFail($id);
            
            // Increment view count
            $result->increment('views');
            
            return view('admin.results.show', compact('result'));
        } catch (\Exception $e) {
            return redirect()->route('admin.results.index')
                ->with('error', 'Result not found: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $result = Result::findOrFail($id);
            $jobs = Job::where('is_active', true)->orderBy('title', 'asc')->get();
            
            return view('admin.results.edit', compact('result', 'jobs'));
        } catch (\Exception $e) {
            return redirect()->route('admin.results.index')
                ->with('error', 'Result not found: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $result = Result::findOrFail($id);

            $request->validate([
                'title' => 'required|string|max:255|unique:results,title,' . $result->id,
                'job_id' => 'required|exists:jobs,id',
                'short_description' => 'nullable|string|max:500',
                'description' => 'nullable|string',
                'roll_number' => 'nullable|string|max:255',
                'result_date' => 'nullable|date',
                'declaration_date' => 'nullable|date',
                'result_link' => 'nullable|url',
                'result_pdf' => 'nullable|file|mimes:pdf|max:10240',
                'is_active' => 'boolean',
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string|max:500',
                'meta_keywords' => 'nullable|string|max:500',
                'remove_result_pdf' => 'nullable|boolean',
            ], [
                'title.unique' => 'A result with this title already exists.',
                'result_pdf.max' => 'The result PDF must not be greater than 10MB.',
                'result_pdf.mimes' => 'The result file must be a PDF.',
            ]);

            $updateData = [
                'title' => $request->title,
                'job_id' => $request->job_id,
                'short_description' => $request->short_description,
                'description' => $request->description,
                'roll_number' => $request->roll_number,
                'result_date' => $request->result_date ?? $request->declaration_date,
                'declaration_date' => $request->declaration_date ?? $request->result_date,
                'result_link' => $request->result_link,
                'is_active' => $request->boolean('is_active'),
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
                'meta_keywords' => $request->meta_keywords,
            ];

            // Generate new slug if title changed
            if ($result->title != $request->title) {
                $updateData['slug'] = $this->generateUniqueSlug($request->title);
            }

            // Handle file removal
            if ($request->boolean('remove_result_pdf') && $result->result_pdf) {
                $this->deleteResultFile($result->result_pdf);
                $updateData['result_pdf'] = null;
                $updateData['result_file'] = null;
            }

            // Handle file upload
            if ($request->hasFile('result_pdf')) {
                // Delete old file if exists
                if ($result->result_pdf) {
                    $this->deleteResultFile($result->result_pdf);
                }

                $filePath = $this->uploadResultFile($request->file('result_pdf'), $request->title);
                $updateData['result_pdf'] = $filePath;
                $updateData['result_file'] = $filePath;
            }

            // Also handle legacy result_file field
            if ($request->hasFile('result_file')) {
                if ($result->result_pdf) {
                    $this->deleteResultFile($result->result_pdf);
                }
                $filePath = $this->uploadResultFile($request->file('result_file'), $request->title);
                $updateData['result_pdf'] = $filePath;
                $updateData['result_file'] = $filePath;
            }

            $result->update($updateData);

            DB::commit();

            return redirect()->route('admin.results.index')
                ->with('success', 'Result updated successfully.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to update result: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $result = Result::findOrFail($id);

            // Delete associated file
            if ($result->result_pdf) {
                $this->deleteResultFile($result->result_pdf);
            }

            $result->delete();

            DB::commit();

            return redirect()->route('admin.results.index')
                ->with('success', 'Result deleted successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.results.index')
                ->with('error', 'Failed to delete result: ' . $e->getMessage());
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $request->validate([
                'status' => 'required|in:active,inactive'
            ]);

            $result = Result::findOrFail($id);
            
            $isActive = $request->status === 'active';
            $result->update(['is_active' => $isActive]);

            $statusText = $isActive ? 'activated' : 'deactivated';

            return redirect()->back()
                ->with('success', "Result {$statusText} successfully.");

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update result status: ' . $e->getMessage());
        }
    }

    public function bulkAction(Request $request)
    {
        try {
            $request->validate([
                'action' => 'required|in:activate,deactivate,delete',
                'ids' => 'required|array',
                'ids.*' => 'exists:results,id'
            ]);

            $action = $request->action;
            $ids = $request->ids;

            switch ($action) {
                case 'activate':
                    Result::whereIn('id', $ids)->update(['is_active' => true]);
                    $message = 'Selected results activated successfully.';
                    break;
                case 'deactivate':
                    Result::whereIn('id', $ids)->update(['is_active' => false]);
                    $message = 'Selected results deactivated successfully.';
                    break;
                case 'delete':
                    $results = Result::whereIn('id', $ids)->get();
                    foreach ($results as $result) {
                        if ($result->result_pdf) {
                            $this->deleteResultFile($result->result_pdf);
                        }
                        $result->delete();
                    }
                    $message = 'Selected results deleted successfully.';
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
            $originalResult = Result::findOrFail($id);
            
            $newResult = $originalResult->replicate();
            $newResult->title = $originalResult->title . ' (Copy)';
            $newResult->slug = $this->generateUniqueSlug($originalResult->title . ' copy');
            $newResult->is_active = false;
            $newResult->views = 0;
            $newResult->download_count = 0;
            $newResult->created_at = now();
            $newResult->updated_at = now();
            
            // Don't copy the file reference
            $newResult->result_pdf = null;
            $newResult->result_file = null;
            
            $newResult->save();

            DB::commit();

            return redirect()->route('admin.results.edit', $newResult->id)
                ->with('success', 'Result duplicated successfully. You can now edit the copy.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to duplicate result: ' . $e->getMessage());
        }
    }

    public function downloadFile($id)
    {
        try {
            $result = Result::findOrFail($id);
            
            $file = $result->result_pdf ?? $result->result_file;
            
            if (!$file || !Storage::disk('public')->exists($file)) {
                return redirect()->back()->with('error', 'File not found.');
            }

            // Increment download count
            $result->incrementDownloadCount();

            $fileName = Str::slug($result->title) . '.' . pathinfo($file, PATHINFO_EXTENSION);

            return Storage::disk('public')->download($file, $fileName);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to download file: ' . $e->getMessage());
        }
    }

    /**
     * Generate unique slug for result
     */
    private function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        while (Result::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }

    /**
     * Upload result file
     */
    private function uploadResultFile($file, $title)
    {
        $fileName = time() . '_' . Str::slug($title) . '.' . $file->getClientOriginalExtension();
        return $file->storeAs('results', $fileName, 'public');
    }

    /**
     * Delete result file
     */
    private function deleteResultFile($filePath)
    {
        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }
    }

    /**
     * Export results to CSV
     */
    public function export(Request $request)
    {
        try {
            $query = Result::with('job');

            // Apply filters
            if ($request->has('job_id') && !empty($request->job_id)) {
                $query->where('job_id', $request->job_id);
            }

            if ($request->has('status') && !empty($request->status)) {
                $query->where('is_active', $request->status === 'active');
            }

            $results = $query->get();

            $filename = 'results_export_' . date('Y-m-d_His') . '.csv';
            $handle = fopen('php://temp', 'w+');

            // Add headers
            fputcsv($handle, ['ID', 'Title', 'Job', 'Result Date', 'Link', 'Status', 'Views', 'Downloads', 'Created At']);

            // Add data
            foreach ($results as $result) {
                fputcsv($handle, [
                    $result->id,
                    $result->title,
                    $result->job->title ?? 'N/A',
                    $result->formatted_result_date,
                    $result->result_link,
                    $result->is_active ? 'Active' : 'Inactive',
                    $result->views,
                    $result->download_count,
                    $result->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            rewind($handle);
            $csvContent = stream_get_contents($handle);
            fclose($handle);

            return response($csvContent)
                ->header('Content-Type', 'text/csv')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to export results: ' . $e->getMessage());
        }
    }
}