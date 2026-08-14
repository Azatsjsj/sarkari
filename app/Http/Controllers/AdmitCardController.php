<?php
// app/Http/Controllers/AdmitCardController.php

namespace App\Http\Controllers;

use App\Models\AdmitCard;
use App\Models\Job;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdmitCardController extends Controller
{
    /**
     * Display a listing of admit cards.
     */
    public function index(Request $request)
    {
        $query = AdmitCard::with(['job.category'])
            ->where('is_active', true);

        // Search filter
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('short_description', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%")
                  ->orWhereHas('job', function($q) use ($search) {
                      $q->where('title', 'LIKE', "%{$search}%");
                  });
            });
        }

        // Date filter
        if ($request->filled('filter')) {
            if ($request->filter === 'upcoming') {
                $query->where('admit_card_date', '>', Carbon::now());
            } elseif ($request->filter === 'recent') {
                $query->where('admit_card_date', '>=', Carbon::now()->subDays(30));
            } elseif ($request->filter === 'available') {
                $query->where('admit_card_date', '<=', Carbon::now())
                      ->whereNotNull('admit_card_date');
            }
        }

        // Sorting
        $sort = $request->get('sort', 'latest');
        if ($sort === 'latest') {
            $query->latest();
        } elseif ($sort === 'oldest') {
            $query->oldest();
        } elseif ($sort === 'exam_date_asc') {
            $query->orderBy('exam_date', 'asc');
        } elseif ($sort === 'exam_date_desc') {
            $query->orderBy('exam_date', 'desc');
        } else {
            $query->latest();
        }

        $admitCards = $query->paginate(15)->withQueryString();

        $recentAdmitCards = AdmitCard::with('job')
            ->where('is_active', true)
            ->latest()
            ->take(5)
            ->get();

        // Get upcoming admit cards count for badge
        $upcomingCount = AdmitCard::where('is_active', true)
            ->where('admit_card_date', '>', Carbon::now())
            ->count();

        return view('admit-cards.index', compact('admitCards', 'recentAdmitCards', 'upcomingCount'));
    }

    /**
     * Display the specified admit card.
     */
    public function show($slug)
    {
        $admitCard = AdmitCard::with(['job.category'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Increment views - FIXED: Check if method exists
        if (method_exists($admitCard, 'incrementViews')) {
            $admitCard->incrementViews();
        } else {
            // Fallback increment
            $admitCard->increment('views');
        }

        // Get related admit cards - FIXED: Handle null job_id
        $relatedAdmitCards = collect();
        if ($admitCard->job_id) {
            $relatedAdmitCards = AdmitCard::with('job')
                ->where('id', '!=', $admitCard->id)
                ->where('is_active', true)
                ->where('job_id', $admitCard->job_id)
                ->latest()
                ->take(4)
                ->get();
        }

        // If no related by job, get by category or latest
        if ($relatedAdmitCards->isEmpty() && $admitCard->job && $admitCard->job->category_id) {
            $relatedAdmitCards = AdmitCard::with('job')
                ->where('id', '!=', $admitCard->id)
                ->where('is_active', true)
                ->whereHas('job', function($query) use ($admitCard) {
                    $query->where('category_id', $admitCard->job->category_id);
                })
                ->latest()
                ->take(4)
                ->get();
        }

        // Final fallback - get latest admit cards
        if ($relatedAdmitCards->isEmpty()) {
            $relatedAdmitCards = AdmitCard::with('job')
                ->where('id', '!=', $admitCard->id)
                ->where('is_active', true)
                ->latest()
                ->take(4)
                ->get();
        }

        return view('admit-cards.show', compact('admitCard', 'relatedAdmitCards'));
    }

    /**
     * Search admit cards (alias for index).
     */
    public function search(Request $request)
    {
        return $this->index($request);
    }

    /**
     * Display admit cards by job slug.
     */
    public function byJob($jobSlug)
    {
        $job = Job::where('slug', $jobSlug)
            ->with('category')
            ->firstOrFail();

        $admitCards = AdmitCard::with(['job.category'])
            ->whereHas('job', function($query) use ($jobSlug) {
                $query->where('slug', $jobSlug);
            })
            ->where('is_active', true)
            ->latest()
            ->paginate(15);

        return view('admit-cards.by-job', compact('admitCards', 'job'));
    }

    /**
     * Download admit card file.
     */
    public function download($slug)
    {
        $admitCard = AdmitCard::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $file = $admitCard->download_path;

        if ($file && filter_var($file, FILTER_VALIDATE_URL)) {
            return redirect()->away($file);
        }

        if ($file && \Storage::disk('public')->exists($file)) {
            if (method_exists($admitCard, 'incrementDownloads')) {
                $admitCard->incrementDownloads();
            } else {
                $admitCard->increment('download_count');
            }

            return response()->download(
                \Storage::disk('public')->path($file),
                $admitCard->slug . '.pdf',
                ['Content-Type' => 'application/pdf']
            );
        }

        if ($admitCard->download_link) {
            return redirect()->away($admitCard->download_link);
        }

        abort(404, 'Admit card file not found.');
    }

    /**
     * API endpoint to increment view count (AJAX).
     */
    public function incrementView(Request $request, $id)
    {
        $admitCard = AdmitCard::findOrFail($id);
        
        if (method_exists($admitCard, 'incrementViews')) {
            $admitCard->incrementViews();
        } else {
            $admitCard->increment('views');
        }
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true]);
        }
        
        return redirect()->back();
    }

    /**
     * Get upcoming admit cards (API/JSON response).
     */
    public function upcoming(Request $request)
    {
        $upcoming = AdmitCard::with('job')
            ->where('is_active', true)
            ->where('admit_card_date', '>', Carbon::now())
            ->orderBy('admit_card_date', 'asc')
            ->take($request->get('limit', 10))
            ->get();

        if ($request->wantsJson()) {
            return response()->json($upcoming);
        }

        return view('admit-cards.upcoming', compact('upcoming'));
    }

    /**
     * Get recent admit cards (API/JSON response).
     */
    public function recent(Request $request)
    {
        $recent = AdmitCard::with('job')
            ->where('is_active', true)
            ->latest()
            ->take($request->get('limit', 10))
            ->get();

        if ($request->wantsJson()) {
            return response()->json($recent);
        }

        return view('admit-cards.recent', compact('recent'));
    }
}