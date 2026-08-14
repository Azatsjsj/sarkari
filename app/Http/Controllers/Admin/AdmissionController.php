<?php
// app/Http/Controllers/Admin/AdmissionController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admission;
use App\Models\University;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdmissionController extends Controller
{
    public function index(Request $request)
    {
        $query = Admission::with(['university', 'course'])->latest();

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%")
                  ->orWhereHas('university', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('course', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by status
        if ($request->has('status')) {
            switch ($request->status) {
                case 'active':
                    $query->where('is_active', true)->where('last_date', '>=', now());
                    break;
                case 'expired':
                    $query->where('last_date', '<', now());
                    break;
                case 'featured':
                    $query->where('is_featured', true);
                    break;
                case 'inactive':
                    $query->where('is_active', false);
                    break;
            }
        }

        $admissions = $query->paginate(20);

        return view('admin.admissions.index', compact('admissions'));
    }

    public function create()
    {
        $universities = University::active()->get();
        $courses = Course::active()->get();
        
        return view('admin.admissions.create', compact('universities', 'courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:admissions,slug',
            'short_description' => 'nullable|string|max:500',
            'description' => 'required|string',
            'university_id' => 'required|exists:universities,id',
            'course_id' => 'required|exists:courses,id',
            'start_date' => 'required|date',
            'last_date' => 'required|date|after:start_date',
            'exam_date' => 'nullable|date|after:start_date',
            'application_fee' => 'nullable|numeric|min:0',
            'total_seats' => 'nullable|integer|min:0',
            'eligibility' => 'nullable|string',
            'application_process' => 'nullable|string',
            'official_website' => 'nullable|url',
            'brochure_url' => 'nullable|url',
            'apply_url' => 'nullable|url',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Handle important dates
        if ($request->has('important_dates')) {
            $importantDates = [];
            foreach ($request->important_dates as $date) {
                if (!empty($date['event']) && !empty($date['date'])) {
                    $importantDates[] = [
                        'event' => $date['event'],
                        'date' => $date['date']
                    ];
                }
            }
            $validated['important_dates'] = !empty($importantDates) ? $importantDates : null;
        }

        // Handle contact info
        if ($request->has('contact_info')) {
            $contactInfo = [];
            foreach ($request->contact_info as $key => $value) {
                if (!empty($value)) {
                    $contactInfo[$key] = $value;
                }
            }
            $validated['contact_info'] = !empty($contactInfo) ? $contactInfo : null;
        }

        $admission = Admission::create($validated);
        \App\Models\Notification::sendAdmissionNotification($admission);

        return redirect()->route('admin.admissions.index')
            ->with('success', 'Admission created successfully!');
    }

    public function edit(Admission $admission)
    {
        $universities = University::active()->get();
        $courses = Course::active()->get();
        
        return view('admin.admissions.edit', compact('admission', 'universities', 'courses'));
    }

    public function update(Request $request, Admission $admission)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('admissions')->ignore($admission->id)
            ],
            'short_description' => 'nullable|string|max:500',
            'description' => 'required|string',
            'university_id' => 'required|exists:universities,id',
            'course_id' => 'required|exists:courses,id',
            'start_date' => 'required|date',
            'last_date' => 'required|date|after:start_date',
            'exam_date' => 'nullable|date|after:start_date',
            'application_fee' => 'nullable|numeric|min:0',
            'total_seats' => 'nullable|integer|min:0',
            'eligibility' => 'nullable|string',
            'application_process' => 'nullable|string',
            'official_website' => 'nullable|url',
            'brochure_url' => 'nullable|url',
            'apply_url' => 'nullable|url',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Handle important dates
        if ($request->has('important_dates')) {
            $importantDates = [];
            foreach ($request->important_dates as $date) {
                if (!empty($date['event']) && !empty($date['date'])) {
                    $importantDates[] = [
                        'event' => $date['event'],
                        'date' => $date['date']
                    ];
                }
            }
            $validated['important_dates'] = !empty($importantDates) ? $importantDates : null;
        }

        // Handle contact info
        if ($request->has('contact_info')) {
            $contactInfo = [];
            foreach ($request->contact_info as $key => $value) {
                if (!empty($value)) {
                    $contactInfo[$key] = $value;
                }
            }
            $validated['contact_info'] = !empty($contactInfo) ? $contactInfo : null;
        }

        $admission->update($validated);

        return redirect()->route('admin.admissions.index')
            ->with('success', 'Admission updated successfully!');
    }

    public function destroy(Admission $admission)
    {
        $admission->delete();

        return redirect()->route('admin.admissions.index')
            ->with('success', 'Admission deleted successfully!');
    }

    public function toggleStatus(Admission $admission)
    {
        $admission->update(['is_active' => !$admission->is_active]);

        $status = $admission->is_active ? 'activated' : 'deactivated';

        return back()->with('success', "Admission {$status} successfully!");
    }

    public function toggleFeatured(Admission $admission)
    {
        $admission->update(['is_featured' => !$admission->is_featured]);

        $status = $admission->is_featured ? 'featured' : 'unfeatured';

        return back()->with('success', "Admission {$status} successfully!");
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,activate,deactivate,feature,unfeature',
            'ids' => 'required|array',
            'ids.*' => 'exists:admissions,id'
        ]);

        $action = $request->action;
        $ids = $request->ids;

        switch ($action) {
            case 'delete':
                Admission::whereIn('id', $ids)->delete();
                $message = 'Admissions deleted successfully!';
                break;
            case 'activate':
                Admission::whereIn('id', $ids)->update(['is_active' => true]);
                $message = 'Admissions activated successfully!';
                break;
            case 'deactivate':
                Admission::whereIn('id', $ids)->update(['is_active' => false]);
                $message = 'Admissions deactivated successfully!';
                break;
            case 'feature':
                Admission::whereIn('id', $ids)->update(['is_featured' => true]);
                $message = 'Admissions featured successfully!';
                break;
            case 'unfeature':
                Admission::whereIn('id', $ids)->update(['is_featured' => false]);
                $message = 'Admissions unfeatured successfully!';
                break;
        }

        return back()->with('success', $message);
    }
}