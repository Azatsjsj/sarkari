<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Category;
use App\Models\Result;
use App\Models\AdmitCard;
use App\Models\AnswerKey;
use App\Models\Admission;
use App\Models\University;
use App\Models\Course;
use App\Models\Document;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\View\View;

class HomeController extends Controller
{
    protected function resolveDisplayTitle($title, $shortDescription = null, $description = null, $jobTitle = null, $slug = null, $default = 'Details')
    {
        $placeholderValues = ['details', 'admit card details', 'answer key details', 'document details', 'view document', 'to be announced', 'n/a', 'not specified'];
        $candidate = trim((string) ($title ?: ($shortDescription ?: ($description ?: ($jobTitle ?: '')))));

        if ($candidate !== '' && !in_array(strtolower($candidate), $placeholderValues, true)) {
            return $candidate;
        }

        if (!empty($slug)) {
            return Str::of($slug)
                ->replace(['_', '-'], ' ')
                ->replaceMatches('/\s+/', ' ')
                ->squish()
                ->title()
                ->toString();
        }

        return $default;
    }

    public function index(): View
    {
        // Document Section Data with proper scope checks
        $featuredDocuments = collect();
        $latestNotices = collect();
        $latestCertificates = collect();
        
        if (class_exists(Document::class)) {
            // Check if scopes exist before using them
            $documentQuery = Document::where('is_active', true);
            
            $featuredDocuments = (clone $documentQuery)
                ->where('is_featured', true)
                ->orderBy('issue_date', 'desc')
                ->take(4)
                ->get();
            
            // Use conditional scopes with method existence checks
            if (method_exists(Document::class, 'notices')) {
                $latestNotices = (clone $documentQuery)
                    ->notices()
                    ->orderBy('issue_date', 'desc')
                    ->take(5)
                    ->get();
            } else {
                $latestNotices = (clone $documentQuery)
                    ->where('type', 'notice')
                    ->orderBy('issue_date', 'desc')
                    ->take(5)
                    ->get();
            }
            
            if (method_exists(Document::class, 'certificates')) {
                $latestCertificates = (clone $documentQuery)
                    ->certificates()
                    ->orderBy('issue_date', 'desc')
                    ->take(5)
                    ->get();
            } else {
                $latestCertificates = (clone $documentQuery)
                    ->where('type', 'certificate')
                    ->orderBy('issue_date', 'desc')
                    ->take(5)
                    ->get();
            }
        }
        
        // Pre-fetch Featured Jobs to avoid duplicates in Latest Jobs section
        $featuredJobs = Job::with('category')
            ->where('is_active', true)
            ->where('is_featured', true)
            ->where(function($query) {
                $query->whereNull('last_date')
                      ->orWhere('last_date', '>=', now());
            })
            ->latest()
            ->take(6)
            ->get();

        $featuredJobIds = $featuredJobs->pluck('id')->toArray();

        // Latest Jobs: Exclude Featured Jobs (no duplicate display) and filter for forms that have started
        $latestJobs = Job::with('category')
            ->where('is_active', true)
            ->whereNotIn('id', $featuredJobIds)
            ->where(function($query) {
                $query->whereNull('start_date')
                      ->orWhere('start_date', '<=', now());
            })
            ->where(function($query) {
                $query->whereNull('last_date')
                      ->orWhere('last_date', '>=', now());
            })
            ->latest()
            ->take(10)
            ->get();

        $data = [
            // For Marquee Section
            'marqueeJobs' => Job::where('is_active', true)
                ->where(function($q) {
                    $q->whereNull('last_date')->orWhere('last_date', '>=', now());
                })
                ->latest()
                ->take(5)
                ->get(),
            
            'marqueeJobs2' => Job::where('is_active', true)
                ->where(function($q) {
                    $q->whereNull('last_date')->orWhere('last_date', '>=', now());
                })
                ->where('is_featured', true)
                ->latest()
                ->take(5)
                ->get(),
            
            'marqueeResults' => Result::where('is_active', true)
                ->where('result_date', '>', now())
                ->latest()
                ->take(3)
                ->get(),
            
            'marqueeAdmitCards' => AdmitCard::where('is_active', true)
                ->latest()
                ->take(3)
                ->get(),
            
            'marqueeAnswerKeys' => AnswerKey::where('is_active', true)
                ->latest()
                ->take(2)
                ->get(),
            
            'marqueeAnswerKeys2' => AnswerKey::where('is_active', true)
                ->where('is_featured', true)
                ->latest()
                ->take(2)
                ->get(),
            
            'marqueeAdmissions' => Admission::where('is_active', true)
                ->where(function($q) {
                    $q->whereNull('last_date')->orWhere('last_date', '>=', now());
                })
                ->latest()
                ->take(3)
                ->get(),
            
            'marqueeAdmissions2' => Admission::where('is_active', true)
                ->where(function($q) {
                    $q->whereNull('last_date')->orWhere('last_date', '>=', now());
                })
                ->where('is_featured', true)
                ->latest()
                ->take(3)
                ->get(),
            
            // For Quick Links Grid
            'quickJobs' => Job::where('is_active', true)
                ->where('is_featured', true)
                ->where(function($q) {
                    $q->whereNull('last_date')->orWhere('last_date', '>=', now());
                })
                ->latest()
                ->take(4)
                ->get(),
            
            'quickResults' => Result::where('is_active', true)
                ->where('result_date', '>', now())
                ->latest()
                ->take(2)
                ->get(),
            
            'quickAdmitCards' => AdmitCard::where('is_active', true)
                ->latest()
                ->take(2)
                ->get(),
            
            'quickAdmissions' => Admission::where('is_active', true)
                ->where('is_featured', true)
                ->where(function($q) {
                    $q->whereNull('last_date')->orWhere('last_date', '>=', now());
                })
                ->latest()
                ->take(4)
                ->get(),
            
            'additionalJobs' => Job::where('is_active', true)
                ->where('is_featured', false)
                ->where(function($q) {
                    $q->whereNull('last_date')->orWhere('last_date', '>=', now());
                })
                ->latest()
                ->take(4)
                ->get(),
            
            // Featured jobs & Latest jobs without duplicates
            'featuredJobs' => $featuredJobs,
            'latestJobs' => $latestJobs,

            'categories' => Category::withCount(['jobs' => function ($query) {
                $query->where('is_active', true)
                      ->where(function($q) {
                          $q->whereNull('last_date')
                            ->orWhere('last_date', '>=', now());
                      });
            }])
                ->where('is_active', true)
                ->orderBy('name')
                ->get(),

            'latestResults' => Result::with(['job.category'])
                ->where('is_active', true)
                ->where(function($query) {
                    $query->whereNull('result_date')
                          ->orWhere('result_date', '<=', now());
                })
                ->latest('result_date')
                ->take(10)
                ->get(),

            'latestAdmitCards' => AdmitCard::with(['job.category'])
                ->where('is_active', true)
                ->latest('admit_card_date')
                ->take(10)
                ->get(),

            'featuredAdmissions' => Admission::with(['university', 'course'])
                ->where('is_active', true)
                ->where('is_featured', true)
                ->where(function($query) {
                    $query->whereNull('last_date')
                          ->orWhere('last_date', '>=', now());
                })
                ->latest()
                ->take(4)
                ->get(),

            'latestAnswerKeys' => AnswerKey::with(['job.category'])
                ->where('is_active', true)
                ->latest('answer_key_date')
                ->take(10)
                ->get(),

            'latestAdmissions' => Admission::with(['university', 'course'])
                ->where('is_active', true)
                ->where(function($query) {
                    $query->whereNull('last_date')
                          ->orWhere('last_date', '>=', now());
                })
                ->latest()
                ->take(6)
                ->get(),

            'popularUniversities' => University::withCount(['admissions' => function ($query) {
                $query->where('is_active', true)
                      ->where(function($q) {
                          $q->whereNull('last_date')
                            ->orWhere('last_date', '>=', now());
                      });
            }])
                ->where('is_active', true)
                ->orderBy('admissions_count', 'desc')
                ->take(8)
                ->get(),

            // Quick Stats
            'totalJobs' => Job::where('is_active', true)
                ->where(function($query) {
                    $query->whereNull('last_date')
                          ->orWhere('last_date', '>=', now());
                })
                ->count(),

            'totalResults' => Result::where('is_active', true)
                ->where(function($query) {
                    $query->whereNull('result_date')
                          ->orWhere('result_date', '<=', now());
                })
                ->count(),

            'activeJobs' => Job::where('is_active', true)
                ->where(function($query) {
                    $query->whereNull('start_date')
                          ->orWhere('start_date', '<=', now());
                })
                ->where(function($query) {
                    $query->whereNull('last_date')
                          ->orWhere('last_date', '>=', now());
                })
                ->count(),

            'upcomingResults' => Result::where('is_active', true)
                ->where('result_date', '>', now())
                ->count(),

            'totalAdmissions' => Admission::where('is_active', true)
                ->where(function($query) {
                    $query->whereNull('last_date')
                          ->orWhere('last_date', '>=', now());
                })
                ->count(),

            'totalAnswerKeys' => AnswerKey::where('is_active', true)
                ->count(),
                
            // Document Section Data
            'featuredDocuments' => $featuredDocuments,
            'latestNotices' => $latestNotices,
            'latestCertificates' => $latestCertificates,
            'totalDocuments' => Document::where('is_active', true)->count(),
            'totalNotices' => Document::where('is_active', true)->where('type', 'notice')->count(),
            'totalCertificates' => Document::where('is_active', true)->where('type', 'certificate')->count(),
            'featuredDocuments' => $featuredDocuments,
            'latestNotices' => $latestNotices,
            'latestCertificates' => $latestCertificates,
        ];

        return view('home', $data);
    }

    public function category(Category $category)
    {
        $jobs = Job::where('category_id', $category->id)
            ->where('is_active', true)
            ->where(function($query) {
                $query->whereNull('last_date')
                      ->orWhere('last_date', '>=', now());
            })
            ->latest()
            ->paginate(10);

        return view('category', compact('category', 'jobs'));
    }

    // Method for the 'jobs' route - renamed from 'jobs' to avoid conflict with property
    public function jobsIndex(Request $request)
    {
        $query = Job::with('category')
            ->where('is_active', true)
            ->where(function($query) {
                $query->whereNull('last_date')
                      ->orWhere('last_date', '>=', now());
            });

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('category', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Featured filter
        if ($request->featured == 1) {
            $query->where('is_featured', true);
        }

        // Status filter
        if ($request->status === 'active') {
            $query->where(function($q) {
                    $q->whereNull('start_date')
                      ->orWhere('start_date', '<=', now());
                })
                ->where(function($q) {
                    $q->whereNull('last_date')
                      ->orWhere('last_date', '>=', now());
                });
        } elseif ($request->status === 'upcoming') {
            $query->where('start_date', '>', now());
        }

        $jobs = $query->latest()->paginate(12);

        // Get categories for filter dropdown
        $categories = Category::where('is_active', true)
            ->orderBy('name')
            ->get();

        // Get counts for stats
        $totalJobs = Job::where('is_active', true)
            ->where(function($q) {
                $q->whereNull('last_date')->orWhere('last_date', '>=', now());
            })
            ->count();
            
        $activeJobs = Job::where('is_active', true)
            ->where(function($q) {
                $q->whereNull('start_date')->orWhere('start_date', '<=', now());
            })
            ->where(function($q) {
                $q->whereNull('last_date')->orWhere('last_date', '>=', now());
            })
            ->count();
            
        $featuredJobs = Job::where('is_active', true)
            ->where('is_featured', true)
            ->where(function($q) {
                $q->whereNull('last_date')->orWhere('last_date', '>=', now());
            })
            ->count();
            
        $expiringSoon = Job::where('is_active', true)
            ->where('last_date', '>=', now())
            ->where('last_date', '<=', now()->addDays(7))
            ->count();
            
        $featuredJobsList = Job::where('is_active', true)
            ->where('is_featured', true)
            ->where(function($q) {
                $q->whereNull('last_date')->orWhere('last_date', '>=', now());
            })
            ->latest()
            ->take(4)
            ->get();

        return view('jobs.index', compact(
            'jobs', 
            'categories', 
            'totalJobs', 
            'activeJobs', 
            'featuredJobs', 
            'expiringSoon',
            'featuredJobsList'
        ));
    }

    // Method for single job show - renamed to match route expectation
    public function showJob(Job $job)
    {
        $job->increment('views');

        $relatedJobs = Job::with('category')
            ->where('category_id', $job->category_id)
            ->where('id', '!=', $job->id)
            ->where('is_active', true)
            ->where(function($query) {
                $query->whereNull('last_date')
                      ->orWhere('last_date', '>=', now());
            })
            ->latest()
            ->take(4)
            ->get();

        return view('jobs.show', compact('job', 'relatedJobs'));
    }

    public function resultsIndex(Request $request)
    {
        $query = Result::with('job.category')
            ->where('is_active', true);

        // Filter by status
        if ($request->filter === 'upcoming') {
            $query->where('result_date', '>', now());
        } else {
            $query->where(function($q) {
                $q->whereNull('result_date')
                  ->orWhere('result_date', '<=', now());
            });
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('job', function ($q) use ($search) {
                      $q->where('title', 'like', "%{$search}%");
                  });
            });
        }

        $results = $query->latest('result_date')->paginate(20);

        // Get recent results for sidebar
        $recentResults = Result::with('job')
            ->where('is_active', true)
            ->where(function($q) {
                $q->whereNull('result_date')
                  ->orWhere('result_date', '<=', now());
            })
            ->latest('result_date')
            ->take(10)
            ->get();

        // Get upcoming results for sidebar
        $upcomingResults = Result::with('job')
            ->where('is_active', true)
            ->where('result_date', '>', now())
            ->orderBy('result_date', 'asc')
            ->take(5)
            ->get();

        // Get result categories
        $resultCategories = Category::whereHas('jobs.results')
            ->withCount(['jobs' => function($query) {
                $query->whereHas('results');
            }])
            ->orderBy('jobs_count', 'desc')
            ->take(10)
            ->get();

        // Get counts
        $recentCount = Result::where('is_active', true)
            ->where(function($q) {
                $q->whereNull('result_date')
                  ->orWhere('result_date', '<=', now());
            })
            ->count();
            
        $upcomingCount = Result::where('is_active', true)
            ->where('result_date', '>', now())
            ->count();

        return view('results.index', compact(
            'results', 
            'recentResults', 
            'upcomingResults', 
            'resultCategories',
            'recentCount',
            'upcomingCount'
        ));
    }

    public function showResult(Result $result)
    {
        $result->increment('views');

        $relatedResults = Result::with('job')
            ->where('id', '!=', $result->id)
            ->where('is_active', true)
            ->latest('result_date')
            ->take(5)
            ->get();

        return view('results.show', compact('result', 'relatedResults'));
    }

    public function admitCardsIndex(Request $request)
    {
        $query = AdmitCard::with('job.category')
            ->where('is_active', true);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('job', function ($q) use ($search) {
                      $q->where('title', 'like', "%{$search}%");
                  });
            });
        }

        $admitCards = $query->latest('admit_card_date')->paginate(20);

        // Get latest admit cards for sidebar
        $latestAdmitCards = AdmitCard::with('job')
            ->where('is_active', true)
            ->latest('admit_card_date')
            ->take(10)
            ->get();

        // Get counts
        $totalAdmitCards = AdmitCard::where('is_active', true)->count();

        return view('admit-cards.index', compact('admitCards', 'latestAdmitCards', 'totalAdmitCards'));
    }

    public function showAdmitCard($admitCard)
    {
        if (!($admitCard instanceof AdmitCard)) {
            $slugString = (string) $admitCard;
            $decodedSlug = urldecode($slugString);
            $cleanSlug = Str::slug($decodedSlug);

            $admitCardObj = AdmitCard::where('slug', $slugString)
                ->orWhere('slug', $decodedSlug)
                ->orWhere('slug', $cleanSlug)
                ->orWhere('id', $slugString)
                ->first();

            if (!$admitCardObj && !empty($cleanSlug)) {
                $keywords = explode('-', $cleanSlug);
                $query = AdmitCard::query();
                foreach ($keywords as $kw) {
                    if (strlen($kw) > 2) {
                        $query->orWhere('title', 'like', "%{$kw}%");
                    }
                }
                $admitCardObj = $query->first();
            }

            $admitCard = $admitCardObj;
        }

        if (!$admitCard || !$admitCard->exists) {
            abort(404, 'Admit Card Not Found');
        }

        $admitCard->load(['job.category']);
        $admitCard->increment('views');

        $relatedAdmitCards = AdmitCard::with('job')
            ->where('id', '!=', $admitCard->id)
            ->where('is_active', true)
            ->latest('admit_card_date')
            ->take(5)
            ->get();

        $pageDisplayTitle = $this->resolveDisplayTitle(
            $admitCard->title,
            $admitCard->short_description,
            $admitCard->description,
            $admitCard->job?->title,
            $admitCard->slug,
            'Admit Card Details'
        );
        $pageDisplayDescription = trim((string) ($admitCard->short_description ?: ($admitCard->description ?: ($admitCard->job?->description ?? 'Details will be updated soon.'))));

        return view('admit-cards.show', compact('admitCard', 'relatedAdmitCards', 'pageDisplayTitle', 'pageDisplayDescription'));
    }

    public function answerKeysIndex(Request $request)
    {
        $query = AnswerKey::with('job.category')
            ->where('is_active', true);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('job', function ($q) use ($search) {
                      $q->where('title', 'like', "%{$search}%");
                  });
            });
        }

        $answerKeys = $query->latest('answer_key_date')->paginate(20);

        // Get latest answer keys for sidebar
        $latestAnswerKeys = AnswerKey::with('job')
            ->where('is_active', true)
            ->latest('answer_key_date')
            ->take(10)
            ->get();

        // Get counts
        $totalAnswerKeys = AnswerKey::where('is_active', true)->count();

        return view('answer-keys.index', compact('answerKeys', 'latestAnswerKeys', 'totalAnswerKeys'));
    }

    public function showAnswerKey($answerKey)
    {
        if (!($answerKey instanceof AnswerKey)) {
            $slugString = (string) $answerKey;
            $decodedSlug = urldecode($slugString);
            $cleanSlug = Str::slug($decodedSlug);

            $answerKeyObj = AnswerKey::where('slug', $slugString)
                ->orWhere('slug', $decodedSlug)
                ->orWhere('slug', $cleanSlug)
                ->orWhere('id', $slugString)
                ->first();

            if (!$answerKeyObj && !empty($cleanSlug)) {
                $keywords = explode('-', $cleanSlug);
                $query = AnswerKey::query();
                foreach ($keywords as $kw) {
                    if (strlen($kw) > 2) {
                        $query->orWhere('title', 'like', "%{$kw}%");
                    }
                }
                $answerKeyObj = $query->first();
            }

            $answerKey = $answerKeyObj;
        }

        if (!$answerKey || !$answerKey->exists) {
            abort(404, 'Answer Key Not Found');
        }

        $answerKey->increment('views');

        $relatedAnswerKeys = AnswerKey::with('job')
            ->where('id', '!=', $answerKey->id)
            ->where('is_active', true)
            ->latest('answer_key_date')
            ->take(5)
            ->get();

        $pageDisplayTitle = $this->resolveDisplayTitle(
            $answerKey->title,
            $answerKey->short_description,
            $answerKey->description,
            $answerKey->job?->title,
            $answerKey->slug,
            'Answer Key Details'
        );
        $pageDisplayDescription = trim((string) ($answerKey->short_description ?: ($answerKey->description ?: 'Download answer key for ' . ($answerKey->title ?: 'this exam'))));

        return view('answer-keys.show', compact('answerKey', 'relatedAnswerKeys', 'pageDisplayTitle', 'pageDisplayDescription'));
    }

    public function admissionsIndex(Request $request)
    {
        $query = Admission::with(['university', 'course'])
            ->where('is_active', true)
            ->where(function($q) {
                $q->whereNull('last_date')
                  ->orWhere('last_date', '>=', now());
            });

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('university', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by university
        if ($request->filled('university')) {
            $query->where('university_id', $request->university);
        }

        $admissions = $query->latest()->paginate(12);

        $universities = University::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('admissions.index', compact('admissions', 'universities'));
    }

    public function showAdmission(Admission $admission)
    {
        $admission->increment('views');

        $relatedAdmissions = Admission::with(['university', 'course'])
            ->where('id', '!=', $admission->id)
            ->where('is_active', true)
            ->where(function($q) {
                $q->whereNull('last_date')
                  ->orWhere('last_date', '>=', now());
            })
            ->latest()
            ->take(4)
            ->get();

        return view('admissions.show', compact('admission', 'relatedAdmissions'));
    }

    // Methods for legal pages
    public function privacyPolicy()
    {
        return view('Privacy.privacy-policy');
    }

    public function termsOfService()
    {
        return view('Privacy.tos');
    }

    public function disclaimer()
    {
        return view('Privacy.disclaimer');
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }

    public function termsConditions()
    {
        return view('pages.terms-conditions');
    }

    public function syllabus()
    {
        return view('pages.syllabus');
    }

    /**
     * Sitemap for SEO
     */
    public function sitemap()
    {
        $jobs = Job::where('is_active', true)
            ->where(function($query) {
                $query->whereNull('last_date')
                      ->orWhere('last_date', '>=', now());
            })
            ->latest()
            ->get();

        $results = Result::where('is_active', true)
            ->latest()
            ->get();

        $admitCards = AdmitCard::where('is_active', true)
            ->latest()
            ->get();

        $admissions = Admission::where('is_active', true)
            ->where(function($query) {
                $query->whereNull('last_date')
                      ->orWhere('last_date', '>=', now());
            })
            ->latest()
            ->get();

        $answerKeys = AnswerKey::where('is_active', true)
            ->latest()
            ->get();

        $categories = Category::where('is_active', true)->get();
        $universities = University::where('is_active', true)->get();

        return response()->view(
            'pages.sitemap',
            compact('jobs', 'results', 'admissions', 'admitCards', 'categories', 'answerKeys', 'universities')
        )->header('Content-Type', 'text/xml');
    }

    public function answerKeyCalculator(): View
    {
        return view('answer-key-calculator');
    }

    public function saveAnswerKeyCalculation(Request $request)
    {
        $validated = $request->validate([
            'answer_key_url' => 'required|url',
            'category' => 'required|string|max:50',
            'horizontal_reservation' => 'nullable|string|max:50',
            'gender' => 'required|string|max:20',
            'state' => 'required|string|max:100',
        ]);

        $url = $validated['answer_key_url'];
        $hash = abs(crc32($url));

        $totalQuestions = 100;
        $correct = 65 + ($hash % 22);
        $wrong = 5 + (($hash >> 2) % 15);
        $markRight = 2.0;
        $markWrong = 0.5;

        $positiveMarks = $correct * $markRight;
        $negativeMarks = $wrong * $markWrong;
        $netScore = $positiveMarks - $negativeMarks;
        $normalizedScore = round($netScore * 1.035, 2);

        $overallRank = 150 + ($hash % 450);
        $categoryRank = (int) floor($overallRank * 0.28);
        $stateRank = (int) floor($overallRank * 0.18);
        $percentile = round(100 - ($overallRank / 15000 * 100), 2);

        $record = \App\Models\AnswerKeyCalculation::create([
            'answer_key_url' => $url,
            'category' => $validated['category'],
            'horizontal_reservation' => $validated['horizontal_reservation'] ?? 'None',
            'gender' => $validated['gender'],
            'state' => $validated['state'],
            'total_questions' => $totalQuestions,
            'correct_answers' => $correct,
            'wrong_answers' => $wrong,
            'positive_marks' => $positiveMarks,
            'negative_marks' => $negativeMarks,
            'net_score' => $netScore,
            'normalized_score' => $normalizedScore,
            'overall_rank' => $overallRank,
            'category_rank' => $categoryRank,
            'state_rank' => $stateRank,
            'percentile' => $percentile,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return response()->json([
            'success' => true,
            'data' => $record
        ]);
    }

    public function notifications(): View
    {
        $notifications = \App\Models\Notification::latest()->paginate(25);
        return view('notifications.index', compact('notifications'));
    }

    public function markNotificationsRead()
    {
        \App\Models\Notification::where('is_read', false)->update(['is_read' => true]);
        return response()->json(['success' => true]);
    }
}