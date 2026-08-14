<?php
// app/Http/Controllers/Admin/AdmitCardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdmitCard;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class AdmitCardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        try {
            $query = AdmitCard::with('job');

            // Search filter
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('title', 'LIKE', "%{$search}%")
                      ->orWhere('short_description', 'LIKE', "%{$search}%")
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
                    $query->where('admit_card_date', '>', now());
                } elseif ($request->date === 'past') {
                    $query->where('admit_card_date', '<', now());
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
                    $query->orderBy('admit_card_date', 'asc');
                    break;
                case 'date_desc':
                    $query->orderBy('admit_card_date', 'desc');
                    break;
                default:
                    $query->latest();
            }

            $admitCards = $query->paginate(20);

            // Get jobs for filter dropdown
            $jobs = Job::where('is_active', true)->get();

            // Statistics
            $stats = [
                'total' => AdmitCard::count(),
                'active' => AdmitCard::where('is_active', true)->count(),
                'upcoming' => AdmitCard::where('admit_card_date', '>', now())->count(),
                'recent' => AdmitCard::where('created_at', '>=', now()->subDays(7))->count(),
            ];

            return view('admin.admit-cards.index', compact('admitCards', 'jobs', 'stats'));

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to load admit cards: ' . $e->getMessage());
        }
    }

    public function create()
    {
        try {
            $jobs = Job::where('is_active', true)->latest()->get();
            return view('admin.admit-cards.create', compact('jobs'));
        } catch (\Exception $e) {
            return redirect()->route('admin.admit-cards.index')
                ->with('error', 'Failed to load create form: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'title' => 'required|string|max:255|unique:admit_cards,title',
                'job_id' => 'required|exists:jobs,id',
                'short_description' => 'nullable|string|max:500',
                'description' => 'nullable|string',
                'admit_card_date' => 'required|date',
                'exam_date' => 'nullable|date|after:admit_card_date',
                'exam_venue' => 'nullable|string|max:255',
                'official_website' => 'required|url',
                'download_link' => 'required|url',
                'admit_card_file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
                'instructions' => 'nullable|string',
                'required_documents' => 'nullable|string',
            ], [
                'title.unique' => 'An admit card with this title already exists.',
                'exam_date.after' => 'Exam date must be after admit card date.',
                'admit_card_file.max' => 'The admit card file must not be greater than 5MB.',
            ]);

            $admitCardData = [
                'title' => $request->title,
                'slug' => $this->generateUniqueSlug($request->title),
                'job_id' => $request->job_id,
                'short_description' => $request->short_description,
                'description' => $request->description,
                'admit_card_date' => $request->admit_card_date,
                'exam_date' => $request->exam_date,
                'exam_venue' => $request->exam_venue,
                'official_website' => $request->official_website,
                'download_link' => $request->download_link,
                'instructions' => $request->instructions,
                'required_documents' => $request->required_documents,
                'is_active' => $request->has('is_active') ? $request->boolean('is_active') : true,
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
                'meta_keywords' => $request->meta_keywords,
            ];

            // Handle file upload
            if ($request->hasFile('admit_card_file')) {
                $filePath = $this->uploadAdmitCardFile($request->file('admit_card_file'), $request->title);
                $admitCardData['admit_card_file'] = $filePath;
            }

            $admitCard = AdmitCard::create($admitCardData);
            \App\Models\Notification::sendAdmitCardNotification($admitCard);

            DB::commit();

            return redirect()->route('admin.admit-cards.index')
                ->with('success', 'Admit card created successfully.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to create admit card: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show($id)
    {
        try {
            $admitCard = AdmitCard::with(['job'])->findOrFail($id);
            return view('admin.admit-cards.show', compact('admitCard'));
        } catch (\Exception $e) {
            return redirect()->route('admin.admit-cards.index')
                ->with('error', 'Admit card not found: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $admitCard = AdmitCard::findOrFail($id);
            $jobs = Job::where('is_active', true)->latest()->get();
            
            return view('admin.admit-cards.edit', compact('admitCard', 'jobs'));
        } catch (\Exception $e) {
            return redirect()->route('admin.admit-cards.index')
                ->with('error', 'Admit card not found: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $admitCard = AdmitCard::findOrFail($id);

            $request->validate([
                'title' => 'required|string|max:255|unique:admit_cards,title,' . $admitCard->id,
                'job_id' => 'required|exists:jobs,id',
                'short_description' => 'nullable|string|max:500',
                'description' => 'nullable|string',
                'admit_card_date' => 'required|date',
                'exam_date' => 'nullable|date|after:admit_card_date',
                'exam_venue' => 'nullable|string|max:255',
                'official_website' => 'required|url',
                'download_link' => 'required|url',
                'admit_card_file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
                'instructions' => 'nullable|string',
                'required_documents' => 'nullable|string',
            ], [
                'title.unique' => 'An admit card with this title already exists.',
                'exam_date.after' => 'Exam date must be after admit card date.',
                'admit_card_file.max' => 'The admit card file must not be greater than 5MB.',
            ]);

            $updateData = [
                'title' => $request->title,
                'job_id' => $request->job_id,
                'short_description' => $request->short_description,
                'description' => $request->description,
                'admit_card_date' => $request->admit_card_date,
                'exam_date' => $request->exam_date,
                'exam_venue' => $request->exam_venue,
                'official_website' => $request->official_website,
                'download_link' => $request->download_link,
                'instructions' => $request->instructions,
                'required_documents' => $request->required_documents,
                'is_active' => $request->boolean('is_active'),
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
                'meta_keywords' => $request->meta_keywords,
            ];

            // Generate new slug if title changed
            if ($admitCard->title != $request->title) {
                $updateData['slug'] = $this->generateUniqueSlug($request->title);
            }

            // Handle file upload
            if ($request->hasFile('admit_card_file')) {
                // Delete old file if exists
                if ($admitCard->admit_card_file) {
                    $this->deleteAdmitCardFile($admitCard->admit_card_file);
                }

                $filePath = $this->uploadAdmitCardFile($request->file('admit_card_file'), $request->title);
                $updateData['admit_card_file'] = $filePath;
            }

            $admitCard->update($updateData);

            DB::commit();

            return redirect()->route('admin.admit-cards.index')
                ->with('success', 'Admit card updated successfully.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to update admit card: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $admitCard = AdmitCard::findOrFail($id);

            // Delete associated file
            if ($admitCard->admit_card_file) {
                $this->deleteAdmitCardFile($admitCard->admit_card_file);
            }

            $admitCard->delete();

            DB::commit();

            return redirect()->route('admin.admit-cards.index')
                ->with('success', 'Admit card deleted successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.admit-cards.index')
                ->with('error', 'Failed to delete admit card: ' . $e->getMessage());
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $admitCard = AdmitCard::findOrFail($id);
            
            $admitCard->update([
                'is_active' => !$admitCard->is_active
            ]);

            $status = $admitCard->is_active ? 'activated' : 'deactivated';

            return redirect()->back()
                ->with('success', "Admit card {$status} successfully.");

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update admit card status: ' . $e->getMessage());
        }
    }

    public function downloadFile($id)
    {
        try {
            $admitCard = AdmitCard::findOrFail($id);
            
            if (!$admitCard->admit_card_file || !Storage::disk('public')->exists($admitCard->admit_card_file)) {
                return redirect()->back()->with('error', 'File not found.');
            }

            // Increment download count
            $admitCard->incrementDownloadCount();

            return Storage::disk('public')->download($admitCard->admit_card_file, 
                Str::slug($admitCard->title) . '.' . pathinfo($admitCard->admit_card_file, PATHINFO_EXTENSION));

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to download file: ' . $e->getMessage());
        }
    }

    /**
     * Generate unique slug for admit card
     */
    private function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        while (AdmitCard::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }

    /**
     * Upload admit card file
     */
    private function uploadAdmitCardFile($file, $title)
    {
        $fileName = time() . '_' . Str::slug($title) . '.' . $file->getClientOriginalExtension();
        return $file->storeAs('admit-cards', $fileName, 'public');
    }

    /**
     * Delete admit card file
     */
    private function deleteAdmitCardFile($filePath)
    {
        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }
    }
}