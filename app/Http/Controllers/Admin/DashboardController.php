<?php
// app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Category;
use App\Models\Result;
use App\Models\User;
use App\Models\AdmitCard;
use App\Models\AnswerKey;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        try {
            // Basic counts
            $totalJobs = Job::count();
            $totalCategories = Category::count();
            $totalResults = Result::count();
            $totalUsers = User::count();
            $totalAdmitCards = AdmitCard::count();
            $totalAnswerKeys = AnswerKey::count();

            // Active counts
            $activeJobs = Job::where('is_active', true)->count();
            $activeCategories = Category::where('is_active', true)->count();
            $activeResults = Result::where('is_active', true)->count();
            $activeAdmitCards = AdmitCard::where('is_active', true)->count();
            $activeAnswerKeys = AnswerKey::where('is_active', true)->count();

            // Featured and special counts
            $featuredJobs = Job::where('is_featured', true)->count();
            $expiredJobs = Job::where('last_date', '<', now())->count();
            $upcomingResults = Result::where('result_date', '>', now())->count();
            $upcomingAdmitCards = AdmitCard::where('admit_card_date', '>', now())->count();
            $upcomingAnswerKeys = AnswerKey::where('answer_key_date', '>', now())->count();

            // Recent activity counts
            $newUsers = User::where('created_at', '>=', now()->subDays(30))->count();
            $todayJobs = Job::whereDate('created_at', today())->count();
            $recentResultsCount = Result::where('created_at', '>=', now()->subDays(7))->count();
            $recentAdmitCardsCount = AdmitCard::where('created_at', '>=', now()->subDays(7))->count();

            // Download and view statistics
            $totalDownloads = Result::sum('download_count') + AdmitCard::sum('download_count') + AnswerKey::sum('download_count');
            $totalViews = Job::sum('views') + Result::sum('views') + AdmitCard::sum('views') + AnswerKey::sum('views');

            // Growth calculations (compared to previous month)
            $jobsGrowth = $this->calculateGrowth(Job::class);
            $resultsGrowth = $this->calculateGrowth(Result::class);
            $admitCardsGrowth = $this->calculateGrowth(AdmitCard::class);
            $usersGrowth = $this->calculateGrowth(User::class);

            // Recent data for tables
            $recentJobs = Job::with('category')
                ->latest()
                ->take(5)
                ->get();

            $recentResults = Result::with('job')
                ->latest()
                ->take(5)
                ->get();

            $recentAdmitCards = AdmitCard::with('job')
                ->latest()
                ->take(5)
                ->get();

            $recentAnswerKeys = AnswerKey::with('job')
               ->latest()
               ->take(5)
               ->get();

            // Recent activities
            $recentActivities = $this->getRecentActivity();

            // System statistics
            $storageUsage = $this->calculateStorageUsage();
            $activeSessions = $this->getActiveSessionsCount();

            // Compile all data
            $data = [
                // Basic totals
                'totalJobs' => $totalJobs,
                'totalCategories' => $totalCategories,
                'totalResults' => $totalResults,
                'totalUsers' => $totalUsers,
                'totalAdmitCards' => $totalAdmitCards,
                'totalAnswerKeys' => $totalAnswerKeys,

                // Active counts
                'activeJobs' => $activeJobs,
                'activeCategories' => $activeCategories,
                'activeResults' => $activeResults,
                'activeAdmitCards' => $activeAdmitCards,
                'activeAnswerKeys' => $activeAnswerKeys,

                // Special counts
                'featuredJobs' => $featuredJobs,
                'expiredJobs' => $expiredJobs,
                'upcomingResults' => $upcomingResults,
                'upcomingAdmitCards' => $upcomingAdmitCards,
                'upcomingAnswerKeys' => $upcomingAnswerKeys,

                // Recent activity
                'newUsers' => $newUsers,
                'todayJobs' => $todayJobs,
                'recentResultsCount' => $recentResultsCount,
                'recentAdmitCardsCount' => $recentAdmitCardsCount,

                // Download and views
                'totalDownloads' => $totalDownloads,
                'totalViews' => $totalViews,

                // Growth percentages
                'jobsGrowth' => $jobsGrowth,
                'resultsGrowth' => $resultsGrowth,
                'admitCardsGrowth' => $admitCardsGrowth,
                'usersGrowth' => $usersGrowth,

                // Recent data for display
                'recentJobs' => $recentJobs,
                'recentResults' => $recentResults,
                'recentAdmitCards' => $recentAdmitCards,
                'recentAnswerKeys' => $recentAnswerKeys,

                // Recent activities
                'recentActivities' => $recentActivities,

                // System info
                'storageUsage' => $storageUsage,
                'activeSessions' => $activeSessions,
            ];

            return view('admin.dashboard', $data);

        } catch (\Exception $e) {
            \Log::error('Dashboard Error: ' . $e->getMessage());
            
            // Fallback data in case of errors
            $fallbackData = [
                'totalJobs' => 0,
                'totalCategories' => 0,
                'totalResults' => 0,
                'totalUsers' => 0,
                'totalAdmitCards' => 0,
                'totalAnswerKeys' => 0,
                'activeJobs' => 0,
                'activeCategories' => 0,
                'activeResults' => 0,
                'activeAdmitCards' => 0,
                'activeAnswerKeys' => 0,
                'featuredJobs' => 0,
                'expiredJobs' => 0,
                'upcomingResults' => 0,
                'upcomingAdmitCards' => 0,
                'upcomingAnswerKeys' => 0,
                'newUsers' => 0,
                'todayJobs' => 0,
                'recentResultsCount' => 0,
                'recentAdmitCardsCount' => 0,
                'totalDownloads' => 0,
                'totalViews' => 0,
                'jobsGrowth' => 0,
                'resultsGrowth' => 0,
                'admitCardsGrowth' => 0,
                'usersGrowth' => 0,
                'recentJobs' => collect(),
                'recentResults' => collect(),
                'recentAdmitCards' => collect(),
                'recentAnswerKeys' => collect(),
                'recentActivities' => collect(),
                'storageUsage' => '0%',
                'activeSessions' => 1,
            ];

            return view('admin.dashboard', $fallbackData);
        }
    }

    /**
     * Calculate growth percentage compared to previous period
     */
    private function calculateGrowth($model, $period = 'month')
    {
        try {
            $currentPeriod = now()->startOfMonth();
            $previousPeriod = now()->subMonth()->startOfMonth();

            if ($period === 'week') {
                $currentPeriod = now()->startOfWeek();
                $previousPeriod = now()->subWeek()->startOfWeek();
            }

            $currentCount = $model::where('created_at', '>=', $currentPeriod)->count();
            $previousCount = $model::whereBetween('created_at', [
                $previousPeriod, 
                $currentPeriod->copy()->subDay()
            ])->count();

            if ($previousCount === 0) {
                return $currentCount > 0 ? 100 : 0;
            }

            return round((($currentCount - $previousCount) / $previousCount) * 100, 1);

        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * Calculate storage usage percentage
     */
    private function calculateStorageUsage()
    {
        try {
            $totalSize = 0;

            // Check if directories exist before scanning
            $directories = ['notifications', 'results', 'admit-cards', 'answer-keys'];
            
            foreach ($directories as $directory) {
                if (Storage::disk('public')->exists($directory)) {
                    $files = Storage::disk('public')->allFiles($directory);
                    foreach ($files as $file) {
                        try {
                            $totalSize += Storage::disk('public')->size($file);
                        } catch (\Exception $e) {
                            // Skip files that can't be accessed
                            continue;
                        }
                    }
                }
            }

            // Convert to MB and calculate percentage (assuming 1GB total storage)
            $totalSizeMB = round($totalSize / 1024 / 1024, 2);
            $totalStorageMB = 1024; // 1GB in MB
            $usagePercentage = round(($totalSizeMB / $totalStorageMB) * 100, 1);

            return $usagePercentage . '% (' . $totalSizeMB . ' MB)';

        } catch (\Exception $e) {
            return '0%';
        }
    }

    /**
     * Get active sessions count (simplified)
     */
    private function getActiveSessionsCount()
    {
        try {
            // This is a simplified version
            return rand(1, 10); // Placeholder
        } catch (\Exception $e) {
            return 1;
        }
    }

    /**
     * Get recent activity log
     */
    private function getRecentActivity()
    {
        try {
            $activities = collect();

            // Recent jobs
            $recentJobs = Job::with('category')
                ->latest()
                ->take(3)
                ->get();

            foreach ($recentJobs as $job) {
                $activities->push([
                    'type' => 'created',
                    'item' => 'Job: ' . Str::limit($job->title, 40),
                    'user' => 'Admin',
                    'time' => $job->created_at->diffForHumans(),
                    'status' => 'success'
                ]);
            }

            // Recent results
            $recentResults = Result::with('job')
                ->latest()
                ->take(2)
                ->get();

            foreach ($recentResults as $result) {
                $activities->push([
                    'type' => 'created',
                    'item' => 'Result: ' . Str::limit($result->title, 40),
                    'user' => 'Admin',
                    'time' => $result->created_at->diffForHumans(),
                    'status' => 'success'
                ]);
            }

            // Recent admit cards
            $recentAdmitCards = AdmitCard::with('job')
                ->latest()
                ->take(2)
                ->get();

            foreach ($recentAdmitCards as $admitCard) {
                $activities->push([
                    'type' => 'created',
                    'item' => 'Admit Card: ' . Str::limit($admitCard->title, 40),
                    'user' => 'Admin',
                    'time' => $admitCard->created_at->diffForHumans(),
                    'status' => 'success'
                ]);
            }

            // Recent answer keys
            $recentAnswerKeys = AnswerKey::with('job')
                ->latest()
                ->take(2)
                ->get();

            foreach ($recentAnswerKeys as $answerKey) {
                $activities->push([
                    'type' => 'created',
                    'item' => 'Answer Key: ' . Str::limit($answerKey->title, 40),
                    'user' => 'Admin',
                    'time' => $answerKey->created_at->diffForHumans(),
                    'status' => 'success'
                ]);
            }

            return $activities->sortByDesc(function($activity) {
                return $activity['time'];
            })->take(5);

        } catch (\Exception $e) {
            return collect();
        }
    }

    /**
     * Get dashboard chart data (API endpoint)
     */
    public function getChartData(Request $request)
    {
        try {
            $period = $request->query('period', 'month');
            $activity = [
                'labels' => [],
                'jobs' => [],
                'results' => []
            ];

            if ($period === 'week') {
                for ($i = 3; $i >= 0; $i--) {
                    $week = now()->subWeeks($i);
                    $label = 'Week ' . $week->weekOfYear;

                    $activity['labels'][] = $label;
                    $activity['jobs'][] = Job::whereBetween('created_at', [
                        $week->startOfWeek(), $week->endOfWeek()
                    ])->count();
                    $activity['results'][] = Result::whereBetween('created_at', [
                        $week->startOfWeek(), $week->endOfWeek()
                    ])->count();
                }
            } elseif ($period === 'year') {
                for ($i = 11; $i >= 0; $i--) {
                    $month = now()->subMonths($i);
                    $label = $month->format('M Y');

                    $activity['labels'][] = $label;
                    $activity['jobs'][] = Job::whereYear('created_at', $month->year)
                        ->whereMonth('created_at', $month->month)
                        ->count();
                    $activity['results'][] = Result::whereYear('created_at', $month->year)
                        ->whereMonth('created_at', $month->month)
                        ->count();
                }
            } else {
                for ($i = 5; $i >= 0; $i--) {
                    $month = now()->subMonths($i);
                    $label = $month->format('M Y');

                    $activity['labels'][] = $label;
                    $activity['jobs'][] = Job::whereYear('created_at', $month->year)
                        ->whereMonth('created_at', $month->month)
                        ->count();
                    $activity['results'][] = Result::whereYear('created_at', $month->year)
                        ->whereMonth('created_at', $month->month)
                        ->count();
                }
            }

            $distribution = [
                'labels' => ['Jobs', 'Results', 'Admit Cards', 'Answer Keys'],
                'values' => [
                    Job::count(),
                    Result::count(),
                    AdmitCard::count(),
                    AnswerKey::count()
                ]
            ];

            return response()->json([
                'success' => true,
                'activity' => $activity,
                'distribution' => $distribution
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'activity' => [
                    'labels' => [],
                    'jobs' => [],
                    'results' => []
                ],
                'distribution' => [
                    'labels' => [],
                    'values' => []
                ]
            ]);
        }
    }

    /**
     * Get quick stats for AJAX updates
     */
    public function getQuickStats()
    {
        try {
            $stats = [
                'totalJobs' => Job::count(),
                'activeJobs' => Job::where('is_active', true)->count(),
                'todayJobs' => Job::whereDate('created_at', today())->count(),
                'totalResults' => Result::count(),
                'totalUsers' => User::count(),
                'newUsers' => User::whereDate('created_at', today())->count(),
            ];

            return response()->json([
                'success' => true,
                'stats' => $stats,
                'updated_at' => now()->format('H:i:s')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load stats'
            ], 500);
        }
    }
}