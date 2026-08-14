<?php
// app/Http/Controllers/ResultController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Result;
use App\Models\Job;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ResultController extends Controller
{
    public function index()
    {
        try {
            $results = Result::with(['job', 'job.category'])
                ->where('is_active', true)
                ->where(function($query) {
                    $query->whereDate('result_date', '<=', now())
                          ->orWhereNull('result_date');
                })
                ->latest()
                ->paginate(15);

            $recentResults = Result::with('job')
                ->where('is_active', true)
                ->where(function($query) {
                    $query->whereDate('result_date', '<=', now())
                          ->orWhereNull('result_date');
                })
                ->latest()
                ->take(5)
                ->get();
                
                // ✅ FIX: Add upcoming results
        $upcomingResults = Result::with('job')
        ->where('result_date', '>', now())
        ->where('is_active', true)
        ->orderBy('result_date', 'asc')
        ->limit(10)
        ->get();

            return view('results.index', compact('results', 'recentResults', 'upcomingResults'));

        } catch (\Exception $e) {
            Log::error('Error loading results index: ' . $e->getMessage());
            return redirect()->route('home')
                ->with('error', 'Unable to load results. Please try again.');
        }
    }

    public function show(Result $result)
    {
        try {
            // Check if result is active
            if (!$result->is_active) {
                abort(404, 'Result not found or is inactive.');
            }

            // Load relationships
            $result->load(['job', 'job.category']);

            $relatedResults = Result::with('job')
                ->where('job_id', $result->job_id)
                ->where('id', '!=', $result->id)
                ->where('is_active', true)
                ->latest()
                ->take(5)
                ->get();

            return view('results.show', compact('result', 'relatedResults'));

        } catch (\Exception $e) {
            Log::error('Error loading result show page: ' . $e->getMessage());
            abort(404, 'Result not found.');
        }
    }

    public function search(Request $request)
    {
        try {
            $query = $request->get('q');
            
            $results = Result::with(['job', 'job.category'])
                ->where('is_active', true)
                ->where(function($q) use ($query) {
                    $q->where('title', 'LIKE', "%{$query}%")
                      ->orWhere('description', 'LIKE', "%{$query}%")
                      ->orWhereHas('job', function($jobQuery) use ($query) {
                          $jobQuery->where('title', 'LIKE', "%{$query}%")
                                   ->orWhereHas('category', function($categoryQuery) use ($query) {
                                       $categoryQuery->where('name', 'LIKE', "%{$query}%");
                                   });
                      });
                })
                ->where(function($queryBuilder) {
                    $queryBuilder->whereDate('result_date', '<=', now())
                                ->orWhereNull('result_date');
                })
                ->latest()
                ->paginate(15);

            $recentResults = Result::with('job')
                ->where('is_active', true)
                ->where(function($queryBuilder) {
                    $queryBuilder->whereDate('result_date', '<=', now())
                                ->orWhereNull('result_date');
                })
                ->latest()
                ->take(5)
                ->get();

            return view('results.index', compact('results', 'recentResults', 'query'));

        } catch (\Exception $e) {
            Log::error('Error searching results: ' . $e->getMessage());
            return redirect()->route('results.index')
                ->with('error', 'Error performing search. Please try again.');
        }
    }
    
      /**
     * Download result file
     */
    public function downloadFile(Result $result)
    {
        // Authorize the download (optional)
        // $this->authorize('download', $result);
        
        try {
            // Validate file exists
            if (!$result->result_file) {
                return redirect()->back()->with('error', 'No file attached to this result.');
            }
            
            // Check if file exists in storage
            if (!Storage::disk('public')->exists($result->result_file)) {
                \Log::error('File not found: ' . $result->result_file);
                return redirect()->back()->with('error', 'The file could not be found.');
            }
            
            // Increment download count if you have that field
            // $result->increment('download_count');
            
            // Prepare filename
            $originalName = pathinfo($result->result_file, PATHINFO_FILENAME);
            $extension = pathinfo($result->result_file, PATHINFO_EXTENSION);
            $filename = $result->slug . '_result.' . $extension;
            
            // Return download response
            return Storage::disk('public')->download($result->result_file, $filename, [
                'Content-Type' => 'application/pdf',
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Download error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while downloading the file.');
        }
    }

    /**
     * Get results by category
     */
    public function byCategory($categorySlug)
    {
        try {
            $results = Result::with(['job', 'job.category'])
                ->whereHas('job.category', function($query) use ($categorySlug) {
                    $query->where('slug', $categorySlug);
                })
                ->where('is_active', true)
                ->where(function($query) {
                    $query->whereDate('result_date', '<=', now())
                          ->orWhereNull('result_date');
                })
                ->latest()
                ->paginate(15);

            $recentResults = Result::with('job')
                ->where('is_active', true)
                ->where(function($query) {
                    $query->whereDate('result_date', '<=', now())
                          ->orWhereNull('result_date');
                })
                ->latest()
                ->take(5)
                ->get();

            $category = \App\Models\Category::where('slug', $categorySlug)->firstOrFail();

            return view('results.category', compact('results', 'recentResults', 'category'));

        } catch (\Exception $e) {
            Log::error('Error loading results by category: ' . $e->getMessage());
            return redirect()->route('results.index')
                ->with('error', 'Category not found.');
        }
    }

    /**
     * Get latest results (API endpoint if needed)
     */
    public function latestResults()
    {
        try {
            $results = Result::with(['job', 'job.category'])
                ->where('is_active', true)
                ->where(function($query) {
                    $query->whereDate('result_date', '<=', now())
                          ->orWhereNull('result_date');
                })
                ->latest()
                ->take(10)
                ->get();

            return response()->json([
                'success' => true,
                'data' => $results,
                'count' => $results->count()
            ]);

        } catch (\Exception $e) {
            Log::error('Error fetching latest results: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Unable to fetch results.'
            ], 500);
        }
    }
}