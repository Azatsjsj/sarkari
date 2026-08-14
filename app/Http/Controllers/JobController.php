<?php
// app/Http/Controllers/JobController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Category;
use Carbon\Carbon;

class JobController extends Controller
{
    /**
     * Display a listing of active jobs.
     */
    public function index(Request $request)
    {
        $query = Job::with('category')
            ->where('is_active', true)
            ->where('last_date', '>=', now());

        // Search filter
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('short_description', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%")
                  ->orWhere('qualification', 'LIKE', "%{$search}%")
                  ->orWhere('job_location', 'LIKE', "%{$search}%")
                  ->orWhereHas('category', function($categoryQuery) use ($search) {
                      $categoryQuery->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }

        // Category filter
        if ($request->has('category') && !empty($request->category)) {
            $query->where('category_id', $request->category);
        }

        // Sort filter
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'latest':
                    $query->latest();
                    break;
                case 'oldest':
                    $query->oldest();
                    break;
                case 'expiring_first':
                    $query->orderBy('last_date', 'asc');
                    break;
                case 'most_viewed':
                    $query->orderBy('views', 'desc');
                    break;
                default:
                    $query->latest();
            }
        } else {
            $query->latest();
        }

        $jobs = $query->paginate(15)->withQueryString();

        // Get categories with job counts for filter
        $categories = Category::withCount(['jobs' => function($query) {
            $query->where('is_active', true)->where('last_date', '>=', now());
        }])->where('is_active', true)->get();

        // Statistics
        $totalJobs = Job::where('is_active', true)->where('last_date', '>=', now())->count();
        $activeJobs = Job::where('is_active', true)->where('last_date', '>=', now())->count();
        $featuredJobs = Job::where('is_active', true)->where('is_featured', true)->where('last_date', '>=', now())->count();
        $expiringSoon = Job::where('is_active', true)
            ->where('last_date', '>=', now())
            ->where('last_date', '<=', now()->addDays(7))
            ->count();

        // Featured jobs for the special section
        $featuredJobsList = Job::with('category')
            ->where('is_active', true)
            ->where('is_featured', true)
            ->where('last_date', '>=', now())
            ->latest()
            ->take(4)
            ->get();

        // Upcoming jobs
        $upcomingJobs = Job::with('category')
            ->where('is_active', true)
            ->where('start_date', '>', now())
            ->orderBy('start_date', 'asc')
            ->take(5)
            ->get();

        // Trending jobs (most viewed in last 30 days)
        $trendingJobs = Job::with('category')
            ->where('is_active', true)
            ->where('last_date', '>=', now())
            ->orderBy('views', 'desc')
            ->take(5)
            ->get();

        return view('jobs.index', compact(
            'jobs', 
            'categories', 
            'totalJobs', 
            'activeJobs', 
            'featuredJobs', 
            'expiringSoon',
            'featuredJobsList',
            'upcomingJobs',
            'trendingJobs'
        ));
    }

    /**
     * Display the specified job details.
     */
    public function show($slug)
    {
        $job = Job::where('slug', $slug)->firstOrFail();

        // Check if job is active and not expired
        if (!$job->is_active || ($job->last_date && Carbon::parse($job->last_date)->lt(now()))) {
            abort(404, 'Job not found or expired.');
        }

        // Increment views
        $job->increment('views');

        // Get related jobs (same category)
        $relatedJobs = Job::with('category')
            ->where('category_id', $job->category_id)
            ->where('id', '!=', $job->id)
            ->where('is_active', true)
            ->where('last_date', '>=', now())
            ->latest()
            ->take(5)
            ->get();

        // Get popular jobs for sidebar
        $popularJobs = Job::with('category')
            ->where('is_active', true)
            ->where('id', '!=', $job->id)
            ->where('last_date', '>=', now())
            ->orderBy('views', 'desc')
            ->take(5)
            ->get();

        // Prepare dates for display
        $startDate = $job->start_date ? Carbon::parse($job->start_date) : null;
        $lastDate = $job->last_date ? Carbon::parse($job->last_date) : null;
        $feeLastDate = $job->fee_last_date ? Carbon::parse($job->fee_last_date) : null;
        $correctionDate = $job->correction_date ? Carbon::parse($job->correction_date) : null;
        $examDate = $job->exam_date ? Carbon::parse($job->exam_date) : null;
        $admitCardDate = $job->admit_card_date ? Carbon::parse($job->admit_card_date) : null;
        $resultDate = $job->result_date ? Carbon::parse($job->result_date) : null;
        $ageCalcDate = $job->age_calculation_date ? Carbon::parse($job->age_calculation_date) : null;

        // Check if job is expired
        $isExpired = $lastDate ? $lastDate->lt(now()) : false;
        
        // Check if job is upcoming
        $isUpcoming = $startDate ? $startDate->gt(now()) : false;
        
        // Calculate days remaining
        $daysRemaining = $lastDate ? now()->diffInDays($lastDate, false) : null;

        return view('jobs.show', compact(
            'job', 
            'relatedJobs', 
            'popularJobs',
            'startDate',
            'lastDate',
            'feeLastDate',
            'correctionDate',
            'examDate',
            'admitCardDate',
            'resultDate',
            'ageCalcDate',
            'isExpired',
            'isUpcoming',
            'daysRemaining'
        ));
    }

    /**
     * Search jobs based on query.
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        $category = $request->get('category');
        $location = $request->get('location');
        
        $jobsQuery = Job::with('category')
            ->where('is_active', true)
            ->where('last_date', '>=', now());

        if (!empty($query)) {
            $jobsQuery->where(function($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%")
                  ->orWhere('qualification', 'LIKE', "%{$query}%")
                  ->orWhere('short_description', 'LIKE', "%{$query}%")
                  ->orWhere('job_location', 'LIKE', "%{$query}%")
                  ->orWhereHas('category', function($categoryQuery) use ($query) {
                      $categoryQuery->where('name', 'LIKE', "%{$query}%");
                  });
            });
        }

        if (!empty($category)) {
            $jobsQuery->where('category_id', $category);
        }

        if (!empty($location)) {
            $jobsQuery->where('job_location', 'LIKE', "%{$location}%");
        }

        $jobs = $jobsQuery->latest()->paginate(15)->withQueryString();

        // Get categories for sidebar
        $categories = Category::withCount(['jobs' => function($query) {
            $query->where('is_active', true)->where('last_date', '>=', now());
        }])->where('is_active', true)->get();

        // Get locations for filter
        $locations = Job::where('is_active', true)
            ->where('last_date', '>=', now())
            ->whereNotNull('job_location')
            ->select('job_location')
            ->distinct()
            ->pluck('job_location');

        return view('jobs.search', compact('jobs', 'query', 'categories', 'locations', 'category', 'location'));
    }

    /**
     * Display jobs by category.
     */
    public function category(Category $category)
    {
        $jobs = Job::with('category')
            ->where('category_id', $category->id)
            ->where('is_active', true)
            ->where('last_date', '>=', now())
            ->latest()
            ->paginate(15);

        // Get categories for sidebar
        $categories = Category::withCount(['jobs' => function($query) {
            $query->where('is_active', true)->where('last_date', '>=', now());
        }])->where('is_active', true)->get();

        $totalJobs = $jobs->total();
        $categoryName = $category->name;

        return view('jobs.category', compact('jobs', 'categories', 'totalJobs', 'categoryName', 'category'));
    }

    /**
     * Display expired jobs.
     */
    public function expired()
    {
        $jobs = Job::with('category')
            ->where('is_active', true)
            ->where('last_date', '<', now())
            ->orderBy('last_date', 'desc')
            ->paginate(15);

        $totalExpired = $jobs->total();

        // Get categories for sidebar
        $categories = Category::withCount(['jobs' => function($query) {
            $query->where('is_active', true)->where('last_date', '>=', now());
        }])->where('is_active', true)->get();

        return view('jobs.expired', compact('jobs', 'categories', 'totalExpired'));
    }

    /**
     * Display upcoming jobs.
     */
    public function upcoming()
    {
        $jobs = Job::with('category')
            ->where('is_active', true)
            ->where('start_date', '>', now())
            ->orderBy('start_date', 'asc')
            ->paginate(15);

        $totalUpcoming = $jobs->total();

        // Get categories for sidebar
        $categories = Category::withCount(['jobs' => function($query) {
            $query->where('is_active', true)->where('last_date', '>=', now());
        }])->where('is_active', true)->get();

        return view('jobs.upcoming', compact('jobs', 'categories', 'totalUpcoming'));
    }

    /**
     * Display featured jobs.
     */
    public function featured()
    {
        $jobs = Job::with('category')
            ->where('is_active', true)
            ->where('is_featured', true)
            ->where('last_date', '>=', now())
            ->latest()
            ->paginate(15);

        $totalFeatured = $jobs->total();

        // Get categories for sidebar
        $categories = Category::withCount(['jobs' => function($query) {
            $query->where('is_active', true)->where('last_date', '>=', now());
        }])->where('is_active', true)->get();

        return view('jobs.featured', compact('jobs', 'categories', 'totalFeatured'));
    }

    /**
     * Display jobs by location.
     */
    public function location($location)
    {
        $jobs = Job::with('category')
            ->where('is_active', true)
            ->where('last_date', '>=', now())
            ->where('job_location', 'LIKE', "%{$location}%")
            ->latest()
            ->paginate(15);

        $totalJobs = $jobs->total();

        // Get categories for sidebar
        $categories = Category::withCount(['jobs' => function($query) {
            $query->where('is_active', true)->where('last_date', '>=', now());
        }])->where('is_active', true)->get();

        return view('jobs.location', compact('jobs', 'categories', 'totalJobs', 'location'));
    }

    /**
     * API endpoint for live job search (AJAX).
     */
    public function apiSearch(Request $request)
    {
        $query = $request->get('q');
        
        $jobs = Job::with('category')
            ->where('is_active', true)
            ->where('last_date', '>=', now())
            ->where(function($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                  ->orWhere('qualification', 'LIKE', "%{$query}%");
            })
            ->select('id', 'title', 'slug', 'short_description', 'last_date', 'category_id')
            ->limit(10)
            ->get();

        return response()->json([
            'success' => true,
            'jobs' => $jobs
        ]);
    }

    /**
     * API endpoint for job statistics.
     */
    public function apiStats()
    {
        $stats = [
            'total_jobs' => Job::where('is_active', true)->where('last_date', '>=', now())->count(),
            'featured_jobs' => Job::where('is_active', true)->where('is_featured', true)->where('last_date', '>=', now())->count(),
            'expiring_soon' => Job::where('is_active', true)
                ->where('last_date', '>=', now())
                ->where('last_date', '<=', now()->addDays(7))
                ->count(),
            'categories_count' => Category::where('is_active', true)->count(),
            'latest_jobs' => Job::where('is_active', true)
                ->where('last_date', '>=', now())
                ->latest()
                ->take(5)
                ->get(['id', 'title', 'slug', 'created_at'])
        ];

        return response()->json($stats);
    }

    /**
     * Download notification PDF.
     */
    public function downloadNotification(Job $job)
    {
        if (!$job->notification_pdf || !file_exists(storage_path('app/public/' . $job->notification_pdf))) {
            abort(404, 'Notification PDF not found.');
        }

        return response()->download(storage_path('app/public/' . $job->notification_pdf), $job->slug . '-notification.pdf');
    }

    /**
     * Download syllabus PDF.
     */
    public function downloadSyllabus(Job $job)
    {
        if (!$job->syllabus_pdf || !file_exists(storage_path('app/public/' . $job->syllabus_pdf))) {
            abort(404, 'Syllabus PDF not found.');
        }

        return response()->download(storage_path('app/public/' . $job->syllabus_pdf), $job->slug . '-syllabus.pdf');
    }

    /**
     * Redirect to application link with tracking.
     */
    public function redirectToApplication(Job $job)
    {
        if (!$job->application_link) {
            abort(404, 'Application link not available.');
        }

        // Track application click (optional)
        // You can add analytics tracking here
        
        return redirect()->away($job->application_link);
    }
}