<?php

namespace App\Http\Controllers;

use App\Models\University;
use App\Models\Admission;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UniversityController extends Controller
{
    /**
     * Display a listing of universities
     */
    public function index(Request $request): View
    {
        $query = University::where('is_active', true)
            ->withCount(['admissions' => function ($query) {
                $query->where('is_active', true)
                    ->where(function($q) {
                        $q->whereNull('last_date')
                          ->orWhere('last_date', '>=', now());
                    });
            }]);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('short_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Filter by state
        if ($request->filled('state')) {
            $query->where('state', $request->state);
        }

        // Filter by type (Government/Private)
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $universities = $query->orderBy('name')
            ->paginate(20);

        // Get unique states for filter
        $states = University::where('is_active', true)
            ->whereNotNull('state')
            ->distinct()
            ->pluck('state')
            ->sort()
            ->values();

        // Get counts
        $totalUniversities = University::where('is_active', true)->count();
        $featuredUniversities = University::where('is_active', true)
            ->where('is_featured', true)
            ->count();
        $governmentUniversities = University::where('is_active', true)
            ->where('type', 'government')
            ->count();
        $privateUniversities = University::where('is_active', true)
            ->where('type', 'private')
            ->count();

        return view('universities.index', compact(
            'universities',
            'states',
            'totalUniversities',
            'featuredUniversities',
            'governmentUniversities',
            'privateUniversities'
        ));
    }

    /**
     * Display featured universities
     */
    public function featured(): View
    {
        $universities = University::where('is_active', true)
            ->where('is_featured', true)
            ->withCount(['admissions' => function ($query) {
                $query->where('is_active', true)
                    ->where(function($q) {
                        $q->whereNull('last_date')
                          ->orWhere('last_date', '>=', now());
                    });
            }])
            ->orderBy('name')
            ->paginate(20);

        return view('universities.featured', compact('universities'));
    }

    /**
     * Display the specified university
     */
    public function show(University $university): View
    {
        // Check if university is active
        if (!$university->is_active) {
            abort(404);
        }

        // Increment view count
        $university->increment('views');

        // Get admissions for this university
        $admissions = Admission::with(['course', 'university'])
            ->where('university_id', $university->id)
            ->where('is_active', true)
            ->where(function($q) {
                $q->whereNull('last_date')
                  ->orWhere('last_date', '>=', now());
            })
            ->latest()
            ->paginate(10);

        // Get featured admissions
        $featuredAdmissions = Admission::with(['course', 'university'])
            ->where('university_id', $university->id)
            ->where('is_active', true)
            ->where('is_featured', true)
            ->where(function($q) {
                $q->whereNull('last_date')
                  ->orWhere('last_date', '>=', now());
            })
            ->latest()
            ->take(4)
            ->get();

        // Get courses offered by this university
        $courses = Course::whereHas('admissions', function($q) use ($university) {
            $q->where('university_id', $university->id)
              ->where('is_active', true);
        })
        ->where('is_active', true)
        ->distinct()
        ->get();

        // Get related universities (same state or type)
        $relatedUniversities = University::where('is_active', true)
            ->where('id', '!=', $university->id)
            ->where(function($q) use ($university) {
                $q->where('state', $university->state)
                  ->orWhere('type', $university->type);
            })
            ->withCount(['admissions' => function ($query) {
                $query->where('is_active', true);
            }])
            ->latest()
            ->take(5)
            ->get();

        return view('universities.show', compact(
            'university',
            'admissions',
            'featuredAdmissions',
            'courses',
            'relatedUniversities'
        ));
    }

    /**
     * Display universities by state
     */
    public function byState($state): View
    {
        $universities = University::where('is_active', true)
            ->where('state', $state)
            ->withCount(['admissions' => function ($query) {
                $query->where('is_active', true);
            }])
            ->orderBy('name')
            ->paginate(20);

        $stateName = $state;

        return view('universities.by-state', compact('universities', 'stateName'));
    }

    /**
     * Display universities by type
     */
    public function byType($type): View
    {
        $validTypes = ['government', 'private', 'deemed', 'central', 'state'];
        
        if (!in_array($type, $validTypes)) {
            abort(404);
        }

        $universities = University::where('is_active', true)
            ->where('type', $type)
            ->withCount(['admissions' => function ($query) {
                $query->where('is_active', true);
            }])
            ->orderBy('name')
            ->paginate(20);

        $typeName = ucfirst($type);

        return view('universities.by-type', compact('universities', 'typeName', 'type'));
    }

    /**
     * Search universities via AJAX
     */
    public function search(Request $request)
    {
        $search = $request->get('q');
        
        $universities = University::where('is_active', true)
            ->where('name', 'like', "%{$search}%")
            ->orWhere('short_name', 'like', "%{$search}%")
            ->limit(10)
            ->get(['id', 'name', 'short_name', 'logo']);

        return response()->json($universities);
    }

    /**
     * Get popular universities
     */
    public function popular(): View
    {
        $universities = University::where('is_active', true)
            ->withCount(['admissions' => function ($query) {
                $query->where('is_active', true);
            }])
            ->orderBy('views', 'desc')
            ->orderBy('admissions_count', 'desc')
            ->paginate(20);

        return view('universities.popular', compact('universities'));
    }
}