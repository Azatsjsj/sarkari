<?php
// app/Http/Controllers/Admin/AnswerKeyController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AnswerKey;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class AnswerKeyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        try {
            $query = AnswerKey::with('job');

            // Search filter
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('title', 'LIKE', "%{$search}%")
                      ->orWhere('short_description', 'LIKE', "%{$search}%")
                      ->orWhere('exam_name', 'LIKE', "%{$search}%")
                      ->orWhereHas('job', function($q) use ($search) {
                          $q->where('title', 'LIKE', "%{$search}%");
                      });
                });
            }

            // Job filter
            if ($request->has('job') && !empty($request->job)) {
                $query->where('job_id', $request->job);
            }

            // Status filter
            if ($request->has('status') && !empty($request->status)) {
                $query->where('is_active', $request->status === 'active');
            }

            // Date filter
            if ($request->has('date') && !empty($request->date)) {
                if ($request->date === 'upcoming') {
                    $query->where('answer_key_date', '>', now());
                } elseif ($request->date === 'past') {
                    $query->where('answer_key_date', '<', now());
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
                case 'date_asc':
                    $query->orderBy('answer_key_date', 'asc');
                    break;
                case 'date_desc':
                    $query->orderBy('answer_key_date', 'desc');
                    break;
                default:
                    $query->latest();
            }

            $answerKeys = $query->paginate(20);

            // Get jobs for filter dropdown
            $jobs = Job::where('is_active', true)->get();

            // Statistics
            $stats = [
                'total' => AnswerKey::count(),
                'active' => AnswerKey::where('is_active', true)->count(),
                'upcoming' => AnswerKey::where('answer_key_date', '>', now())->count(),
                'recent' => AnswerKey::where('created_at', '>=', now()->subDays(7))->count(),
            ];

            return view('admin.answer-keys.index', compact('answerKeys', 'jobs', 'stats'));

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to load answer keys: ' . $e->getMessage());
        }
    }

    public function create()
    {
        try {
            $jobs = Job::where('is_active', true)->latest()->get();
            return view('admin.answer-keys.create', compact('jobs'));
        } catch (\Exception $e) {
            return redirect()->route('admin.answer-keys.index')
                ->with('error', 'Failed to load create form: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'title' => 'required|string|max:255|unique:answer_keys,title',
                'job_id' => 'required|exists:jobs,id',
                'short_description' => 'nullable|string|max:500',
                'description' => 'nullable|string',
                'answer_key_date' => 'required|date',
                'exam_name' => 'nullable|string|max:255',
                'exam_date' => 'nullable|date',
                'official_website' => 'required|url',
                'download_link' => 'required|url',
                'answer_key_url' => 'nullable|url',
                'objection_link' => 'nullable|url',
                'answer_key_file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:101200',
                'instructions' => 'nullable|string',
                'subjects' => 'nullable|array',
                'subjects.*' => 'string|max:100',
                'total_questions' => 'nullable|integer|min:1',
                'total_marks' => 'nullable|integer|min:1',
                'correct_marks' => 'nullable|numeric|min:0',
                'negative_marks' => 'nullable|numeric|min:0',
            ], [
                'title.unique' => 'An answer key with this title already exists.',
                'answer_key_file.max' => 'The answer key file must not be greater than 5MB.',
                'total_questions.min' => 'Total questions must be at least 1.',
                'total_marks.min' => 'Total marks must be at least 1.',
            ]);
            

            $answerKeyData = [
                'title' => $request->title,
                'slug' => $this->generateUniqueSlug($request->title),
                'job_id' => $request->job_id,
                'short_description' => $request->short_description,
                'description' => $request->description,
                'answer_key_date' => $request->answer_key_date,
                'exam_name' => $request->exam_name,
                'exam_date' => $request->exam_date,
                'official_website' => $request->official_website,
                'download_link' => $request->download_link,
                'answer_key_url' => $request->answer_key_url ?: $request->download_link,
                'objection_link' => $request->objection_link,
                'instructions' => $request->instructions,
                'subjects' => $request->subjects,
                'total_questions' => $request->total_questions,
                'total_marks' => $request->total_marks,
                'correct_marks' => $request->filled('correct_marks') ? $request->correct_marks : 1.00,
                'negative_marks' => $request->filled('negative_marks') ? $request->negative_marks : 0.25,
                'is_active' => $request->boolean('is_active'),
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
                'meta_keywords' => $request->meta_keywords,
            ];

            // Handle file upload
            if ($request->hasFile('answer_key_file')) {
                $filePath = $this->uploadAnswerKeyFile($request->file('answer_key_file'), $request->title);
                $answerKeyData['answer_key_file'] = $filePath;
            }

            $answerKey = AnswerKey::create($answerKeyData);
            \App\Models\Notification::sendAnswerKeyNotification($answerKey);

            DB::commit();

            return redirect()->route('admin.answer-keys.index')
                ->with('success', 'Answer key created successfully.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to create answer key: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show($id)
    {
        try {
            $answerKey = AnswerKey::with(['job'])->findOrFail($id);
            return view('admin.answer-keys.show', compact('answerKey'));
        } catch (\Exception $e) {
            return redirect()->route('admin.answer-keys.index')
                ->with('error', 'Answer key not found: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $answerKey = AnswerKey::findOrFail($id);
            $jobs = Job::where('is_active', true)->latest()->get();
            
            return view('admin.answer-keys.edit', compact('answerKey', 'jobs'));
        } catch (\Exception $e) {
            return redirect()->route('admin.answer-keys.index')
                ->with('error', 'Answer key not found: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $answerKey = AnswerKey::findOrFail($id);

            $request->validate([
                'title' => 'required|string|max:255|unique:answer_keys,title,' . $answerKey->id,
                'job_id' => 'required|exists:jobs,id',
                'short_description' => 'nullable|string|max:500',
                'description' => 'nullable|string',
                'answer_key_date' => 'required|date',
                'exam_name' => 'nullable|string|max:255',
                'exam_date' => 'nullable|date',
                'official_website' => 'required|url',
                'download_link' => 'required|url',
                'answer_key_url' => 'nullable|url',
                'objection_link' => 'nullable|url',
                'answer_key_file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:5120',
                'instructions' => 'nullable|string',
                'subjects' => 'nullable|array',
                'subjects.*' => 'string|max:100',
                'total_questions' => 'nullable|integer|min:1',
                'total_marks' => 'nullable|integer|min:1',
                'correct_marks' => 'nullable|numeric|min:0',
                'negative_marks' => 'nullable|numeric|min:0',
            ], [
                'title.unique' => 'An answer key with this title already exists.',
                'answer_key_file.max' => 'The answer key file must not be greater than 5MB.',
                'total_questions.min' => 'Total questions must be at least 1.',
                'total_marks.min' => 'Total marks must be at least 1.',
            ]);

            $updateData = [
                'title' => $request->title,
                'job_id' => $request->job_id,
                'short_description' => $request->short_description,
                'description' => $request->description,
                'answer_key_date' => $request->answer_key_date,
                'exam_name' => $request->exam_name,
                'exam_date' => $request->exam_date,
                'official_website' => $request->official_website,
                'download_link' => $request->download_link,
                'answer_key_url' => $request->answer_key_url ?: $request->download_link,
                'objection_link' => $request->objection_link,
                'instructions' => $request->instructions,
                'subjects' => $request->subjects,
                'total_questions' => $request->total_questions,
                'total_marks' => $request->total_marks,
                'correct_marks' => $request->filled('correct_marks') ? $request->correct_marks : 1.00,
                'negative_marks' => $request->filled('negative_marks') ? $request->negative_marks : 0.25,
                'is_active' => $request->boolean('is_active'),
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
                'meta_keywords' => $request->meta_keywords,
            ];

            // Generate new slug if title changed
            if ($answerKey->title != $request->title) {
                $updateData['slug'] = $this->generateUniqueSlug($request->title);
            }

            // Handle file upload
            if ($request->hasFile('answer_key_file')) {
                // Delete old file if exists
                if ($answerKey->answer_key_file) {
                    $this->deleteAnswerKeyFile($answerKey->answer_key_file);
                }

                $filePath = $this->uploadAnswerKeyFile($request->file('answer_key_file'), $request->title);
                $updateData['answer_key_file'] = $filePath;
            }

            $answerKey->update($updateData);

            DB::commit();

            return redirect()->route('admin.answer-keys.index')
                ->with('success', 'Answer key updated successfully.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to update answer key: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $answerKey = AnswerKey::findOrFail($id);

            // Delete associated file
            if ($answerKey->answer_key_file) {
                $this->deleteAnswerKeyFile($answerKey->answer_key_file);
            }

            $answerKey->delete();

            DB::commit();

            return redirect()->route('admin.answer-keys.index')
                ->with('success', 'Answer key deleted successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.answer-keys.index')
                ->with('error', 'Failed to delete answer key: ' . $e->getMessage());
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $answerKey = AnswerKey::findOrFail($id);
            
            $answerKey->update([
                'is_active' => !$answerKey->is_active
            ]);

            $status = $answerKey->is_active ? 'activated' : 'deactivated';

            return redirect()->back()
                ->with('success', "Answer key {$status} successfully.");

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update answer key status: ' . $e->getMessage());
        }
    }

    public function downloadFile($id)
    {
        try {
            $answerKey = AnswerKey::findOrFail($id);
            
            if (!$answerKey->answer_key_file || !Storage::disk('public')->exists($answerKey->answer_key_file)) {
                return redirect()->back()->with('error', 'File not found.');
            }

            // Increment download count
            $answerKey->incrementDownloadCount();

            return Storage::disk('public')->download($answerKey->answer_key_file, 
                Str::slug($answerKey->title) . '.' . pathinfo($answerKey->answer_key_file, PATHINFO_EXTENSION));

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to download file: ' . $e->getMessage());
        }
    }

    /**
     * Generate unique slug for answer key
     */
    private function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        while (AnswerKey::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }

    /**
     * Upload answer key file
     */
    private function uploadAnswerKeyFile($file, $title)
    {
        $fileName = time() . '_' . Str::slug($title) . '.' . $file->getClientOriginalExtension();
        return $file->storeAs('answer-keys', $fileName, 'public');
    }

    /**
     * Delete answer key file
     */
    private function deleteAnswerKeyFile($filePath)
    {
        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }
    }
}