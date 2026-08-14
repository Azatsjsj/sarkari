<?php
// app/Http/Controllers/AdmissionController.php

namespace App\Http\Controllers;

use App\Models\Admission;
use App\Models\University;
use App\Models\Course;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdmissionController extends Controller
{
    public function index(Request $request)
    {
        $query = Admission::with(['university', 'course'])
            ->active()
            ->upcoming()
            ->latest();

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('university', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('course', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by university
        if ($request->has('university') && $request->university) {
            $query->where('university_id', $request->university);
        }

        // Filter by course
        if ($request->has('course') && $request->course) {
            $query->where('course_id', $request->course);
        }

        // Filter by featured
        if ($request->has('featured') && $request->featured) {
            $query->featured();
        }

        // Apply sorting
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'deadline':
                    $query->orderBy('last_date', 'asc');
                    break;
                case 'popular':
                    $query->orderBy('views', 'desc');
                    break;
                case 'featured':
                    $query->featured()->orderBy('created_at', 'desc');
                    break;
                case 'latest':
                default:
                    $query->latest();
                    break;
            }
        }

        $admissions = $query->paginate(12);

        // Get statistics for the view
        $totalAdmissions = Admission::active()->count();
        $activeAdmissions = Admission::active()->upcoming()->count();
        $featuredAdmissions = Admission::active()->upcoming()->featured()->count();
        
        $universities = University::active()->get();
        $courses = Course::active()->get();

        return view('admissions.index', compact(
            'admissions', 
            'universities', 
            'courses',
            'totalAdmissions',
            'activeAdmissions',
            'featuredAdmissions'
        ));
    }

    public function show(Admission $admission)
    {
        // Check if admission is active
        if (!$admission->is_active) {
            abort(404);
        }

        // Increment view count
        $admission->increment('views');

        // Get related admissions
        $relatedAdmissions = Admission::with(['university', 'course'])
            ->where('id', '!=', $admission->id)
            ->where(function($query) use ($admission) {
                $query->where('university_id', $admission->university_id)
                      ->orWhere('course_id', $admission->course_id);
            })
            ->active()
            ->upcoming()
            ->latest()
            ->take(4)
            ->get();

        return view('admissions.show', compact('admission', 'relatedAdmissions'));
    }

    public function university(University $university)
    {
        $admissions = Admission::with('course')
            ->where('university_id', $university->id)
            ->active()
            ->upcoming()
            ->latest()
            ->paginate(12);

        // Get statistics for university page
        $totalAdmissions = Admission::active()->count();
        $activeAdmissions = Admission::active()->upcoming()->count();
        $featuredAdmissions = Admission::active()->upcoming()->featured()->count();

        return view('admissions.university', compact(
            'university', 
            'admissions',
            'totalAdmissions',
            'activeAdmissions',
            'featuredAdmissions'
        ));
    }

    public function course(Course $course)
    {
        $admissions = Admission::with('university')
            ->where('course_id', $course->id)
            ->active()
            ->upcoming()
            ->latest()
            ->paginate(12);

        // Get statistics for course page
        $totalAdmissions = Admission::active()->count();
        $activeAdmissions = Admission::active()->upcoming()->count();
        $featuredAdmissions = Admission::active()->upcoming()->featured()->count();

        return view('admissions.course', compact(
            'course', 
            'admissions',
            'totalAdmissions',
            'activeAdmissions',
            'featuredAdmissions'
        ));
    }

    public function featured(Request $request)
    {
        $query = Admission::with(['university', 'course'])
            ->featured()
            ->active()
            ->upcoming()
            ->latest();

        // Apply filters for featured page
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

        $admissions = $query->paginate(12);

        // Get statistics for featured page
        $totalAdmissions = Admission::active()->count();
        $activeAdmissions = Admission::active()->upcoming()->count();
        $featuredAdmissions = Admission::active()->upcoming()->featured()->count();
        
        $universities = University::active()->get();
        $courses = Course::active()->get();

        return view('admissions.featured', compact(
            'admissions',
            'universities',
            'courses',
            'totalAdmissions',
            'activeAdmissions',
            'featuredAdmissions'
        ));
    }

    public function expired(Request $request)
    {
        $query = Admission::with(['university', 'course'])
            ->active()
            ->where('last_date', '<', now())
            ->latest();

        // Apply filters for expired page
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

        $admissions = $query->paginate(12);

        // Get statistics for expired page
        $totalAdmissions = Admission::active()->count();
        $activeAdmissions = Admission::active()->upcoming()->count();
        $featuredAdmissions = Admission::active()->upcoming()->featured()->count();
        
        $universities = University::active()->get();
        $courses = Course::active()->get();

        return view('admissions.expired', compact(
            'admissions',
            'universities',
            'courses',
            'totalAdmissions',
            'activeAdmissions',
            'featuredAdmissions'
        ));
    }

    /**
     * Get admissions ending soon (within 7 days)
     */
    public function endingSoon(Request $request)
    {
        $query = Admission::with(['university', 'course'])
            ->active()
            ->upcoming()
            ->where('last_date', '<=', now()->addDays(7))
            ->orderBy('last_date', 'asc');

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhereHas('university', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $admissions = $query->paginate(12);

        // Get statistics
        $totalAdmissions = Admission::active()->count();
        $activeAdmissions = Admission::active()->upcoming()->count();
        $featuredAdmissions = Admission::active()->upcoming()->featured()->count();
        
        $universities = University::active()->get();
        $courses = Course::active()->get();

        return view('admissions.ending-soon', compact(
            'admissions',
            'universities',
            'courses',
            'totalAdmissions',
            'activeAdmissions',
            'featuredAdmissions'
        ));
    }
}