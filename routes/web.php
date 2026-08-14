<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\AdmitCardController;
use App\Http\Controllers\AnswerKeyController;
use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UniversityController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\CategoryController as FrontendCategoryController;
use App\Http\Controllers\CourseController as FrontendCourseController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\JobController as AdminJobController;
use App\Http\Controllers\Admin\ResultController as AdminResultController;
use App\Http\Controllers\Admin\AdmitCardController as AdminAdmitCardController;
use App\Http\Controllers\Admin\AnswerKeyController as AdminAnswerKeyController;
use App\Http\Controllers\Admin\AdmissionController as AdminAdmissionController;
use App\Http\Controllers\Admin\UniversityController as AdminUniversityController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\ScoreAnalyticsController as AdminScoreAnalyticsController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\AdminDocumentController;
use App\Http\Controllers\Admin\AdminSitemapController;

use Illuminate\Support\Facades\Auth;

// ----------------------------
// Frontend Routes
// ----------------------------

Route::get('/', [HomeController::class, 'index'])->name('home');

// Jobs Routes
Route::get('/jobs', [JobController::class, 'index'])->name('jobs');
Route::get('/jobs/search', [JobController::class, 'search'])->name('jobs.search');
Route::get('/job/{slug}', [JobController::class, 'show'])->name('job.show');

// Category Routes
Route::get('/category/{slug}', [FrontendCategoryController::class, 'show'])->name('category');
Route::get('/categories/{slug}', [FrontendCategoryController::class, 'show'])->name('categories.show');

// Results Routes
Route::get('/results', [ResultController::class, 'index'])->name('results');
Route::get('/results-all', [ResultController::class, 'index'])->name('results.index');
Route::get('/results/search', [ResultController::class, 'search'])->name('results.search');
Route::get('/results/category/{slug}', [ResultController::class, 'byCategory'])->name('results.category');
Route::get('/results/{result}', [ResultController::class, 'show'])->name('results.show');

// Admit Cards Routes - FIXED naming consistency
Route::prefix('admit-cards')->name('admit-cards.')->group(function () {
    Route::get('/search', [AdmitCardController::class, 'search'])->name('search');
    Route::get('/job/{jobSlug}', [AdmitCardController::class, 'byJob'])->name('by-job');
    Route::post('/{id}/increment-download', [AdmitCardController::class, 'incrementDownload'])->name('increment-download');
    Route::post('/{id}/increment-view', [AdmitCardController::class, 'incrementView'])->name('increment-view');
});
Route::get('/admit-cards', [HomeController::class, 'admitCardsIndex'])->name('admit-cards');
Route::get('/admit-card/{slug}', [HomeController::class, 'showAdmitCard'])->name('admit-card.show');
Route::get('/admit card/{slug}', [HomeController::class, 'showAdmitCard']);
Route::get('/admit_card/{slug}', [HomeController::class, 'showAdmitCard']);
Route::get('/admit-cards/show/{slug}', [HomeController::class, 'showAdmitCard']);
Route::get('/admit-card/{slug}/download', [AdmitCardController::class, 'download'])->name('admit-card.download');

// Answer Key Routes
Route::prefix('answer-keys')->name('answer-keys.')->group(function () {
    Route::get('/search', [AnswerKeyController::class, 'search'])->name('search');
    Route::get('/job/{jobSlug}', [AnswerKeyController::class, 'byJob'])->name('by-job');
    Route::get('/{id}/download', [AnswerKeyController::class, 'download'])->name('download');
    Route::post('/track-download', [AnswerKeyController::class, 'trackDownload'])->name('track-download');
});
Route::get('/answer-keys', [HomeController::class, 'answerKeysIndex'])->name('answer-keys');
Route::get('/answer-key-calculator', [HomeController::class, 'answerKeyCalculator'])->name('answer-key-calculator');
Route::post('/answer-key-calculator/submit', [HomeController::class, 'saveAnswerKeyCalculation'])->name('answer-key-calculator.submit');
Route::get('/notifications', [HomeController::class, 'notifications'])->name('notifications.index');
Route::post('/notifications/mark-read', [HomeController::class, 'markNotificationsRead'])->name('notifications.mark-read');
Route::get('/answer-key/{slug}', [HomeController::class, 'showAnswerKey'])->name('answer-key.show');
Route::get('/answer key/{slug}', [HomeController::class, 'showAnswerKey']);
Route::get('/answer_key/{slug}', [HomeController::class, 'showAnswerKey']);
Route::get('/answer-keys/show/{slug}', [HomeController::class, 'showAnswerKey']);


// Public routes
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
Route::post('/blog/{slug}/view', [BlogController::class, 'trackView'])->name('blog.view');
Route::get('/blog/category/{slug}', [BlogController::class, 'category'])->name('blog.category');
Route::get('/blog/tag/{tag}', [BlogController::class, 'tag'])->name('blog.tag');

// Admission Routes - FIXED naming consistency
Route::prefix('admissions')->name('admissions.')->group(function () {
    Route::get('/featured', [AdmissionController::class, 'featured'])->name('featured');
    Route::get('/expired', [AdmissionController::class, 'expired'])->name('expired');
});
Route::get('/admissions', [HomeController::class, 'admissionsIndex'])->name('admissions');
Route::get('/admissions/{slug}', [HomeController::class, 'showAdmission'])->name('admissions.show'); // FIXED: Changed from 'admission.show' to 'admissions.show'

// University and Course Routes
Route::get('/universities', [UniversityController::class, 'index'])->name('universities.index');
Route::get('/universities/featured', [UniversityController::class, 'featured'])->name('universities.featured');
Route::get('/universities/type/public', [UniversityController::class, 'byType'])->name('universities.public');
Route::get('/universities/type/private', [UniversityController::class, 'byType'])->name('universities.private');
Route::get('/university/{slug}', [AdmissionController::class, 'university'])->name('university.show');
Route::get('/universities/detail/{slug}', [AdmissionController::class, 'university'])->name('universities.show');
Route::get('/courses', [FrontendCourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{slug}', [FrontendCourseController::class, 'show'])->name('courses.show');

// Privacy and legal pages
Route::get('/privacy-policy', [PageController::class, 'privacyPolicy'])->name('privacy-policy'); // FIXED: Consistent naming
Route::get('/terms-of-service', [PageController::class, 'termsOfService'])->name('terms-of-service'); // FIXED: Consistent naming
Route::get('/disclaimer', [PageController::class, 'disclaimer'])->name('disclaimer');
Route::get('/about', [PageController::class, 'about'])->name('about'); // Added about page
Route::get('/contact', [PageController::class, 'contact'])->name('contact'); // Added contact page

// Frontend Document Routes
Route::prefix('documents')->name('documents.')->group(function () {
    Route::get('/', [DocumentController::class, 'index'])->name('index');
    Route::get('/notices', [DocumentController::class, 'notices'])->name('notices');
    Route::get('/certificates', [DocumentController::class, 'certificates'])->name('certificates');
    Route::get('/verify', [DocumentController::class, 'verifyForm'])->name('verify-form');
    Route::post('/verify', [DocumentController::class, 'verifyCertificate'])->name('verify');
    Route::get('/{document}', [DocumentController::class, 'show'])->name('show');
    Route::get('/{document}/download', [DocumentController::class, 'download'])->name('download');
});

// ----------------------------
// Sitemap Routes
// ----------------------------
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap.index');
Route::get('/sitemap/pages.xml', [SitemapController::class, 'pages'])->name('sitemap.pages');
Route::get('/sitemap/jobs.xml', [SitemapController::class, 'jobs'])->name('sitemap.jobs');
Route::get('/sitemap/results.xml', [SitemapController::class, 'results'])->name('sitemap.results');
Route::get('/sitemap/admit-cards.xml', [SitemapController::class, 'admitCards'])->name('sitemap.admit-cards');
Route::get('/sitemap/answer-keys.xml', [SitemapController::class, 'answerKeys'])->name('sitemap.answer-keys');
Route::get('/sitemap/documents.xml', [SitemapController::class, 'documents'])->name('sitemap.documents');
Route::get('/sitemap/categories.xml', [SitemapController::class, 'categories'])->name('sitemap.categories');


// ----------------------------
// Admin Routes
// ----------------------------
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/quick-stats', [DashboardController::class, 'getQuickStats'])->name('dashboard.quick-stats');
    Route::get('/dashboard/stats', [DashboardController::class, 'getQuickStats'])->name('dashboard.stats');
    Route::get('/dashboard/chart-data', [DashboardController::class, 'getChartData'])->name('dashboard.chart-data');

    // Categories
    Route::resource('categories', CategoryController::class);
    Route::patch('categories/{category}/status', [CategoryController::class, 'updateStatus'])->name('categories.updateStatus');

    // Bulk Actions
    Route::post('categories/bulk-activate', [CategoryController::class, 'bulkActivate'])->name('categories.bulk-activate');
    Route::post('categories/bulk-deactivate', [CategoryController::class, 'bulkDeactivate'])->name('categories.bulk-deactivate');
    Route::delete('categories/bulk-delete', [CategoryController::class, 'bulkDelete'])->name('categories.bulk-delete');

    // Import/Export
    Route::post('categories/import', [CategoryController::class, 'import'])->name('categories.import');
    Route::get('categories/export', [CategoryController::class, 'export'])->name('categories.export');

    // Jobs
    Route::resource('jobs', AdminJobController::class);
    Route::patch('jobs/{job}/status', [AdminJobController::class, 'updateStatus'])->name('jobs.updateStatus');

    // Results
    Route::resource('results', AdminResultController::class);
    Route::patch('results/{result}/status', [AdminResultController::class, 'updateStatus'])->name('results.updateStatus');

    // Admit Cards
    Route::resource('admit-cards', AdminAdmitCardController::class);
    Route::patch('admit-cards/{admitCard}/status', [AdminAdmitCardController::class, 'updateStatus'])->name('admit-cards.updateStatus');
    Route::get('admit-cards/{admitCard}/download', [AdminAdmitCardController::class, 'downloadFile'])->name('admit-cards.download');

    // Answer Keys
    Route::resource('answer-keys', AdminAnswerKeyController::class);
    Route::patch('answer-keys/{answerKey}/status', [AdminAnswerKeyController::class, 'updateStatus'])->name('answer-keys.update-status');
    Route::get('answer-keys/{answerKey}/download', [AdminAnswerKeyController::class, 'downloadFile'])->name('answer-keys.download');

    // Admissions
    Route::get('/admissions', [AdminAdmissionController::class, 'index'])->name('admissions.index');
    Route::get('/admissions/create', [AdminAdmissionController::class, 'create'])->name('admissions.create');
    Route::post('/admissions', [AdminAdmissionController::class, 'store'])->name('admissions.store');
    Route::get('/admissions/{admission}/edit', [AdminAdmissionController::class, 'edit'])->name('admissions.edit');
    Route::put('/admissions/{admission}', [AdminAdmissionController::class, 'update'])->name('admissions.update');
    Route::delete('/admissions/{admission}', [AdminAdmissionController::class, 'destroy'])->name('admissions.destroy');
    Route::post('/admissions/{admission}/toggle-status', [AdminAdmissionController::class, 'toggleStatus'])->name('admissions.toggle-status');
    Route::post('/admissions/{admission}/toggle-featured', [AdminAdmissionController::class, 'toggleFeatured'])->name('admissions.toggle-featured');
    Route::post('/admissions/bulk-action', [AdminAdmissionController::class, 'bulkAction'])->name('admissions.bulk-action');

    // Universities Management
    Route::get('/universities', [AdminUniversityController::class, 'index'])->name('universities.index');
    Route::get('/universities/create', [AdminUniversityController::class, 'create'])->name('universities.create');
    Route::post('/universities', [AdminUniversityController::class, 'store'])->name('universities.store');
    Route::get('/universities/{university}/edit', [AdminUniversityController::class, 'edit'])->name('universities.edit');
    Route::put('/universities/{university}', [AdminUniversityController::class, 'update'])->name('universities.update');
    Route::delete('/universities/{university}', [AdminUniversityController::class, 'destroy'])->name('universities.destroy');
    Route::post('/universities/{university}/toggle-status', [AdminUniversityController::class, 'toggleStatus'])->name('universities.toggle-status');

    // Courses Management
    Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/create', [CourseController::class, 'create'])->name('courses.create');
    Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');
    Route::get('/courses/{course}/edit', [CourseController::class, 'edit'])->name('courses.edit');
    Route::put('/courses/{course}', [CourseController::class, 'update'])->name('courses.update');
    Route::delete('/courses/{course}', [CourseController::class, 'destroy'])->name('courses.destroy');
    Route::post('/courses/{course}/toggle-status', [CourseController::class, 'toggleStatus'])->name('courses.toggle-status');
    
    // Documents Management
    Route::resource('documents', AdminDocumentController::class);
    Route::post('/documents/{document}/toggle-status', [AdminDocumentController::class, 'toggleStatus'])->name('documents.toggle-status');
    Route::post('/documents/{document}/toggle-featured', [AdminDocumentController::class, 'toggleFeatured'])->name('documents.toggle-featured');
    Route::post('/documents/bulk-delete', [AdminDocumentController::class, 'bulkDelete'])->name('documents.bulk-delete');
    Route::get('/documents/export/csv', [AdminDocumentController::class, 'export'])->name('documents.export');
    
    Route::post('/generate-all', [SitemapController::class, 'generateAll'])
        ->name('generate-all')
        ->middleware('auth');
    Route::get('/sitemap', [AdminSitemapController::class, 'index'])->name('sitemap.index');
    Route::get('/sitemap/generate', [AdminSitemapController::class, 'generate'])->name('sitemap.generate');
    Route::get('/sitemap/generate/{type}', [AdminSitemapController::class, 'generateSpecific'])->name('sitemap.generate-specific');
    Route::get('/sitemap/clear-cache', [AdminSitemapController::class, 'clearCache'])->name('sitemap.clear-cache');
    Route::get('/sitemap/stats', [AdminSitemapController::class, 'stats'])->name('sitemap.stats');
        
    Route::resource('blog', AdminBlogController::class);
    Route::post('/blog/{id}/toggle-status', [AdminBlogController::class, 'toggleStatus'])->name('blog.toggle-status');
    Route::post('/blog/{id}/toggle-featured', [AdminBlogController::class, 'toggleFeatured'])->name('blog.toggle-featured');

    // Score & Rank Analytics
    Route::get('/score-analytics', [AdminScoreAnalyticsController::class, 'index'])->name('score-analytics.index');
    Route::get('/score-analytics/{id}', [AdminScoreAnalyticsController::class, 'show'])->name('score-analytics.show');
    Route::delete('/score-analytics/{id}', [AdminScoreAnalyticsController::class, 'destroy'])->name('score-analytics.destroy');
    Route::post('/score-analytics/bulk-action', [AdminScoreAnalyticsController::class, 'bulkAction'])->name('score-analytics.bulk-action');

    // User Management
    Route::resource('users', AdminUserController::class);
    Route::post('/users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::post('/users/bulk-action', [AdminUserController::class, 'bulkAction'])->name('users.bulk-action');
});

// Storage Route - FIXED: Use correct parameter binding
Route::get('/storage/{path}', function ($path) {
    $fullPath = storage_path('app/public/' . $path);
    
    if (!file_exists($fullPath)) {
        abort(404);
    }
    
    return response()->file($fullPath);
})->where('path', '.*');

Route::get('/robots.txt', function () {
    $baseUrl = rtrim(config('app.url', 'https://sarkariresult.mobi'), '/');
    $content = "User-agent: *\n"
        . "Allow: /\n"
        . "Disallow: /admin/\n"
        . "Disallow: /login\n"
        . "Disallow: /register\n"
        . "Disallow: /password/\n"
        . "Disallow: /api/\n"
        . "Disallow: /storage/\n"
        . "Disallow: /vendor/\n"
        . "Disallow: /debugbar/\n"
        . "Disallow: /_debugbar/\n"
        . "Sitemap: {$baseUrl}/sitemap.xml\n";

    return response($content, 200)
        ->header('Content-Type', 'text/plain; charset=utf-8');
})->name('robots.txt');

// Email verification resend route
Route::post('/email/verification-notification', function (Illuminate\Http\Request $request) {
    $request->user()?->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.resend');

// Fallback Route - Must be LAST
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});

// Auth Routes
Auth::routes();
