<?php
// app/Http/Controllers/AnswerKeyController.php

namespace App\Http\Controllers;

use App\Models\AnswerKey;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AnswerKeyController extends Controller
{
    public function index(Request $request)
    {
        $query = AnswerKey::with('job.category')
            ->where('is_active', true);

        // Search filter
        if ($request->has('q') && !empty($request->q)) {
            $search = $request->q;
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('short_description', 'LIKE', "%{$search}%")
                  ->orWhere('exam_name', 'LIKE', "%{$search}%")
                  ->orWhereHas('job', function($q) use ($search) {
                      $q->where('title', 'LIKE', "%{$search}%");
                  });
            });
        }

        // Date filter
        if ($request->has('filter') && !empty($request->filter)) {
            if ($request->filter === 'upcoming') {
                $query->where('answer_key_date', '>', now());
            } elseif ($request->filter === 'recent') {
                $query->where('answer_key_date', '>=', now()->subDays(30));
            }
        }

        $answerKeys = $query->latest()->paginate(15);

        $recentAnswerKeys = AnswerKey::with('job')
            ->where('is_active', true)
            ->latest()
            ->take(5)
            ->get();

        return view('answer-keys.index', compact('answerKeys', 'recentAnswerKeys'));
    }

    // In your AnswerKeyController.php
public function show($slug)
{
    $answerKey = AnswerKey::where('slug', $slug)->firstOrFail();
    $relatedAnswerKeys = AnswerKey::where('id', '!=', $answerKey->id)
        ->where('is_active', true)
        ->limit(5)
        ->get();
    
    return view('answer-keys.show', compact('answerKey', 'relatedAnswerKeys'));
}

    public function search(Request $request)
    {
        return $this->index($request);
    }

    public function byJob($jobSlug)
    {
        $answerKeys = AnswerKey::with('job.category')
            ->whereHas('job', function($query) use ($jobSlug) {
                $query->where('slug', $jobSlug);
            })
            ->where('is_active', true)
            ->latest()
            ->paginate(15);

        $job = Job::where('slug', $jobSlug)->firstOrFail();

        return view('answer-keys.by-job', compact('answerKeys', 'job'));
    }

    public function download($slug)
    {
        try {
            $answerKey = AnswerKey::where('slug', $slug)
                ->where('is_active', true)
                ->firstOrFail();

            $file = $answerKey->download_path;

            if ($file && filter_var($file, FILTER_VALIDATE_URL)) {
                return redirect()->away($file);
            }

            if ($file && Storage::disk('public')->exists($file)) {
                $answerKey->incrementDownloadCount();

                return Storage::disk('public')->download(
                    $file,
                    Str::slug($answerKey->title) . '.' . pathinfo($file, PATHINFO_EXTENSION)
                );
            }

            if ($answerKey->download_link) {
                return redirect()->away($answerKey->download_link);
            }

            return redirect()->back()->with('error', 'Answer key file not found.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to download answer key: ' . $e->getMessage());
        }
    }
}