
<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <?php
        $metaDescription = trim($__env->yieldContent('meta_description', $__env->yieldContent('description', 'Latest Sarkari Result updates, government jobs, admit cards, results and answer keys. Find all upcoming and ongoing recruitment notifications.')));
        $metaKeywords = trim($__env->yieldContent('meta_keywords', 'sarkari result, government jobs, latest jobs, admit card, results, recruitment'));
        $metaRobots = trim($__env->yieldContent('meta_robots', 'index, follow, max-snippet:-1, max-image-preview:large'));
        $canonicalUrl = trim($__env->yieldContent('canonical', url()->current()));
    ?>
    <meta name="description" content="<?php echo e($metaDescription); ?>">
    <meta name="keywords" content="<?php echo e($metaKeywords); ?>">
    <meta name="author" content="Sarkari Result">
    <meta name="robots" content="<?php echo e($metaRobots); ?>">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link rel="canonical" href="<?php echo e($canonicalUrl); ?>" />

    <!-- Robots & Crawling -->
    <meta name="googlebot" content="<?php echo e($__env->yieldContent('meta_googlebot', $metaRobots)); ?>">
    <meta name="bingbot" content="<?php echo e($__env->yieldContent('meta_bingbot', $metaRobots)); ?>">

    <!-- Geo & Regional Targeting -->
    <meta name="geo.region" content="IN" />
    <meta name="geo.placename" content="India" />
    <meta name="geo.position" content="20.5937;78.9629" />
    <meta name="ICBM" content="20.5937, 78.9629" />
    <meta name="language" content="<?php echo $__env->yieldContent('meta_language', 'en'); ?>">
    <meta name="country" content="India">

    <!-- Author & Publisher -->
    <meta name="publisher" content="Sarkari Result Mobi">
    <meta name="copyright" content="Sarkari Result <?php echo e(date('Y')); ?>">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="<?php echo $__env->yieldContent('title', 'Sarkari Result - Latest Government Jobs and Results'); ?>">
    <meta property="og:description" content="<?php echo $__env->yieldContent('meta_description', 'Latest Sarkari Result updates, government jobs, admit cards, results and answer keys.'); ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo e(url()->current()); ?>">
    <meta property="og:image" content="<?php echo e(asset('images/og-image.jpg')); ?>">
    <meta property="og:site_name" content="Sarkari Result">
    <meta property="og:locale" content="en_IN">

    <meta name="p:domain_verify" content="8d18a2bd95d93e8dd971e9651b775deb"/>

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo $__env->yieldContent('title', 'Sarkari Result - Latest Government Jobs and Results'); ?>">
    <meta name="twitter:description" content="<?php echo $__env->yieldContent('meta_description', 'Latest Sarkari Result updates, government jobs, admit cards, results and answer keys.'); ?>">
    <meta name="twitter:image" content="<?php echo e(asset('images/og-image.jpg')); ?>">

    <!-- Theme Color for Mobile Browsers -->
    <meta name="theme-color" content="#dc3545">
    <meta name="color-scheme" content="light">

    <title><?php echo $__env->yieldContent('title', 'Sarkari Result - Latest Government Jobs and Results'); ?></title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo e(asset('images/favicon-96x96.png')); ?>" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="<?php echo e(asset('images/favicon.svg')); ?>" />
    <link rel="shortcut icon" href="<?php echo e(asset('images/favicon.ico')); ?>" />
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo e(asset('images/apple-touch-icon.png')); ?>" />
    <link rel="manifest" href="<?php echo e(asset('images/site.webmanifest')); ?>" />

    <!-- Preconnect for Critical Third-Party Domains -->
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    </noscript>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Google AdSense -->
    <meta name="google-site-verification" content="4bSR8xyCVu86jE3jpVq_WTRoRXObxfJIOerEMqKNiBI" />

    <!-- Dynamic Schema -->
    <?php echo $__env->make('partials.schema', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- Critical CSS -->
    <style>
        /* ----- Skip to main ----- */
        .skip-to-main {
            position: absolute;
            top: -40px;
            left: 0;
            background: #3b82f6;
            color: white;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 0 0 8px 0;
            z-index: 10001;
            font-weight: 500;
        }
        .skip-to-main:focus { top: 0; }

        /* ----- Reset & Base ----- */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #eef2f6 100%);
            color: #1e293b;
            line-height: 1.5;
            scroll-behavior: smooth;
            font-size: 16px;
            font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }

        /* ----- Navbar ----- */
        .navbar {
            background: rgba(15, 23, 42, 0.95) !important;
            backdrop-filter: blur(6px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            padding: 0.875rem 0;
            transition: all 0.3s ease;
        }
        .navbar.scrolled {
            padding: 0.5rem 0;
            background: rgba(15, 23, 42, 0.98) !important;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }

        /* ----- Modern Logo ----- */
        .modern-logo {
            display: flex;
            align-items: baseline;
            gap: 2px;
            font-weight: 800;
            font-size: 1.75rem;
            letter-spacing: -0.02em;
        }
        .modern-logo .sarkari {
            background: linear-gradient(135deg, #f97316, #ef4444);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        .modern-logo .result {
            background: linear-gradient(135deg, #10b981, #059669);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        .modern-logo .mobi {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            font-size: 1.25rem;
        }

        /* ----- Nav Links ----- */
        .navbar-nav .nav-link {
            font-weight: 500;
            font-size: 0.95rem;
            padding: 0.5rem 1rem;
            border-radius: 12px;
            color: #cbd5e1 !important;
            transition: all 0.3s ease;
        }
        .navbar-nav .nav-link:hover { color: white !important; background: rgba(255, 255, 255, 0.08); }
        .navbar-nav .nav-link.active {
            color: white !important;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        /* ----- Search Form ----- */
        .search-form .input-group {
            background: rgba(255, 255, 255, 0.08);
            border-radius: 48px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }
        .search-form .input-group:focus-within {
            background: rgba(255, 255, 255, 0.12);
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }
        .search-form .form-control {
            background: transparent;
            border: none;
            color: white;
            padding: 0.6rem 1.2rem;
        }
        .search-form .form-control::placeholder { color: #94a3b8; }
        .search-form .btn {
            background: transparent;
            color: #94a3b8;
            border-radius: 48px;
            padding: 0.6rem 1.2rem;
            transition: all 0.3s ease;
        }
        .search-form .btn:hover { color: white; }

        /* ----- Dropdown ----- */
        .dropdown-menu {
            background: #1e293b;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 0.5rem;
            backdrop-filter: blur(10px);
            max-height: 400px;
            overflow-y: auto;
        }
        .dropdown-item {
            border-radius: 12px;
            padding: 0.6rem 1rem;
            color: #e2e8f0;
            transition: all 0.2s ease;
        }
        .dropdown-item:hover { background: rgba(59, 130, 246, 0.2); color: white; }

        /* ----- Notification Badge ----- */
        .notification-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 18px;
            height: 18px;
            background: #ef4444;
            color: white;
            font-size: 0.65rem;
            font-weight: 600;
            border-radius: 9px;
            margin-left: 6px;
            padding: 0 4px;
        }

        /* ----- Footer ----- */
        .modern-footer {
            background: #0f172a;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            position: relative;
            overflow: hidden;
        }
        .modern-footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, #3b82f6, #8b5cf6, #ec4899, transparent);
        }
        .footer-heading {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1.25rem;
            background: linear-gradient(135deg, #fff, #94a3b8);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        .modern-footer a {
            color: #94a3b8;
            text-decoration: none;
            transition: all 0.2s ease;
            font-size: 0.9rem;
        }
        .modern-footer a:hover { color: white; transform: translateX(4px); }

        /* ----- Social Icons ----- */
        .social-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            transition: all 0.3s ease;
        }
        .social-icon:hover { background: #3b82f6; transform: translateY(-3px); }

        /* ----- Back to Top ----- */
        .back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 48px;
            height: 48px;
            border-radius: 24px;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            border: none;
            color: white;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.4);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .back-to-top.show { opacity: 1; visibility: visible; }
        .back-to-top:hover { transform: translateY(-3px); box-shadow: 0 12px 25px rgba(59, 130, 246, 0.5); }

        /* ----- Loading Spinner ----- */
        .loading-spinner {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.75);
            z-index: 9999;
            align-items: center;
            justify-content: center;
        }
        .loading-spinner.show { display: flex; }
        .spinner {
            width: 50px;
            height: 50px;
            border: 4px solid rgba(255,255,255,0.2);
            border-top-color: #dc3545;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* ----- Modern Disclaimer ----- */
        .modern-disclaimer {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            border-left: 4px solid #f59e0b;
            border-radius: 16px;
            padding: 1rem 1.5rem;
            margin: 2rem auto;
            font-size: 0.85rem;
            color: #78350f;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        /* ----- Responsive ----- */
        @media (max-width: 991.98px) {
            .navbar-nav .nav-link { padding: 0.6rem 1rem; }
            .search-form { margin: 1rem 0; }
        }

        @media (max-width: 768px) {
            body { font-size: 15px; }
            p, .text-muted, small { font-size: 0.85rem; line-height: 1.5; }
            .modern-disclaimer { padding: 0.75rem 1rem; margin: 1rem auto; font-size: 0.75rem; }
            .modern-logo { font-size: 1.4rem; }
            .modern-logo .mobi { font-size: 1rem; }
        }

        @media (max-width: 576px) {
            .container { padding-left: 12px; padding-right: 12px; }
            .back-to-top { bottom: 20px; right: 20px; width: 40px; height: 40px; }
        }
    </style>

    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <!-- Loading Spinner -->
    <div class="loading-spinner" id="loadingSpinner" role="status" aria-live="polite">
        <div class="spinner"></div>
        <span class="visually-hidden">Loading...</span>
    </div>

    <!-- Skip to Main Content -->
    <a href="#main-content" class="skip-to-main">Skip to main content</a>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top shadow-lg" aria-label="Main navigation">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand" href="<?php echo e(route('home')); ?>" aria-label="Sarkari Result Home">
                <div class="modern-logo">
                    <span class="sarkari">Sarkari</span>
                    <span class="result">Result</span>
                    <span class="mobi">.mobi</span>
                </div>
            </a>

            <!-- Mobile Toggle -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation menu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar Content -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('home') ? 'active' : ''); ?>"
                           href="<?php echo e(route('home')); ?>"
                           aria-current="<?php echo e(request()->routeIs('home') ? 'page' : 'false'); ?>">
                            <i class="fas fa-home me-1" aria-hidden="true"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('jobs*') ? 'active' : ''); ?>"
                           href="<?php echo e(route('jobs')); ?>">
                            <i class="fas fa-briefcase me-1" aria-hidden="true"></i> Latest Jobs
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('results*') ? 'active' : ''); ?>"
                           href="<?php echo e(route('results')); ?>">
                            <i class="fas fa-chart-bar me-1" aria-hidden="true"></i> Results
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('admit-cards*') ? 'active' : ''); ?>"
                           href="<?php echo e(route('admit-cards')); ?>">
                            <i class="fas fa-ticket-alt me-1" aria-hidden="true"></i> Admit Cards
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('answer-keys*') && !request()->routeIs('answer-key-calculator') ? 'active' : ''); ?>"
                           href="<?php echo e(route('answer-keys')); ?>">
                            <i class="fas fa-key me-1" aria-hidden="true"></i> Answer Keys
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('answer-key-calculator') ? 'active' : ''); ?>"
                           href="<?php echo e(route('answer-key-calculator')); ?>">
                            <i class="fas fa-calculator me-1" aria-hidden="true"></i> Rank Calculator
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('documents*') ? 'active' : ''); ?>"
                           href="<?php echo e(route('documents.index')); ?>">
                            <i class="fas fa-file-alt me-1" aria-hidden="true"></i> Notices
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?php echo e(request()->routeIs('category*') ? 'active' : ''); ?>"
                           href="#" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside"
                           aria-expanded="false">
                            <i class="fas fa-list me-1" aria-hidden="true"></i> Categories
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg" aria-label="Job categories">
                            <?php
                                $categories = collect();
                                if (class_exists(\App\Models\Category::class)) {
                                    try {
                                        $categories = \App\Models\Category::where('is_active', true)
                                            ->withCount('jobs')
                                            ->orderBy('name')
                                            ->take(15)
                                            ->get();
                                    } catch (\Throwable $e) {
                                        $categories = collect();
                                    }
                                }
                            ?>
                            <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <li>
                                    <a class="dropdown-item py-2" href="<?php echo e(route('categories.show', $category->slug)); ?>">
                                        <i class="fas fa-folder me-2 text-primary" aria-hidden="true"></i>
                                        <?php echo e($category->name); ?>

                                        <?php if($category->jobs_count > 0): ?>
                                            <span class="badge bg-primary rounded-pill ms-2"><?php echo e(number_format($category->jobs_count)); ?></span>
                                        <?php endif; ?>
                                    </a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <li><a class="dropdown-item text-muted disabled" href="#"><i class="fas fa-info-circle me-2" aria-hidden="true"></i>No categories available</a></li>
                            <?php endif; ?>
                            <?php if($categories && $categories->count() > 0): ?>
                                <li><hr class="dropdown-divider my-1"></li>
                                <li>
                                    <a class="dropdown-item text-primary fw-semibold py-2" href="<?php echo e(route('jobs')); ?>">
                                        <i class="fas fa-eye me-2" aria-hidden="true"></i> View All Categories
                                        <i class="fas fa-arrow-right ms-2 small" aria-hidden="true"></i>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                </ul>

                <!-- Search Form -->
                <form action="<?php echo e(route('jobs')); ?>" method="GET" class="search-form me-3 my-2 my-lg-0" role="search" aria-label="Site search">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control"
                               placeholder="Search jobs, results..."
                               value="<?php echo e(request('search')); ?>"
                               aria-label="Search jobs and results"
                               autocomplete="off">
                        <button class="btn" type="submit" aria-label="Submit search">
                            <i class="fas fa-search" aria-hidden="true"></i>
                        </button>
                    </div>
                </form>

                <!-- Notification Bell & Dropdown -->
                <ul class="navbar-nav me-2">
                    <li class="nav-item dropdown">
                        <?php
                            $recentNotifs = collect();
                            $unreadNotifCount = 0;
                            if (class_exists(\App\Models\Notification::class)) {
                                try {
                                    $recentNotifs = \App\Models\Notification::latest()->take(5)->get();
                                    $unreadNotifCount = \App\Models\Notification::where('is_read', false)->count();
                                } catch (\Throwable $e) {}
                            }
                        ?>
                        <a class="nav-link position-relative" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" title="Notifications">
                            <i class="fas fa-bell fa-lg"></i>
                            <?php if($unreadNotifCount > 0): ?>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 10px; transform: translate(-50%, 20%) !important;">
                                <?php echo e($unreadNotifCount > 9 ? '9+' : $unreadNotifCount); ?>

                            </span>
                            <?php endif; ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg py-0" style="width: 320px; max-width: 90vw;">
                            <li class="dropdown-header bg-light d-flex justify-content-between align-items-center py-2 px-3 border-bottom">
                                <strong>Notifications</strong>
                                <a href="<?php echo e(route('notifications.index')); ?>" class="text-primary small">View All</a>
                            </li>
                            <div style="max-height: 300px; overflow-y: auto;">
                                <?php $__empty_1 = true; $__currentLoopData = $recentNotifs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <li>
                                    <a class="dropdown-item py-2 px-3 text-wrap border-bottom <?php echo e(!$n->is_read ? 'bg-light font-weight-bold' : ''); ?>" href="<?php echo e($n->link ?: '#'); ?>">
                                        <div class="d-flex align-items-start">
                                            <i class="fas <?php echo e($n->icon ?: 'fa-bell text-primary'); ?> me-2 mt-1"></i>
                                            <div>
                                                <div class="small fw-bold text-dark mb-0"><?php echo e(Str::limit($n->title, 45)); ?></div>
                                                <small class="text-muted" style="font-size: 11px;"><?php echo e($n->created_at->diffForHumans()); ?></small>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <li class="p-3 text-center text-muted small">No recent notifications</li>
                                <?php endif; ?>
                            </div>
                            <li class="dropdown-footer text-center bg-light py-2 border-top">
                                <a href="<?php echo e(route('notifications.index')); ?>" class="text-dark small font-weight-bold">See All Live Updates &rarr;</a>
                            </li>
                        </ul>
                    </li>
                </ul>

                <!-- Admin/Auth Links -->
                <ul class="navbar-nav">
                    <?php if(auth()->guard()->check()): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center gap-1"
                               href="#" role="button" data-bs-toggle="dropdown"
                               data-bs-auto-close="outside" aria-expanded="false" aria-label="Admin menu">
                                <i class="fas fa-user-shield" aria-hidden="true"></i>
                                <span class="d-none d-lg-inline">Admin</span>
                                <span class="notification-badge" aria-label="3 notifications">3</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-lg">
                                <li><a class="dropdown-item py-2" href="<?php echo e(route('admin.dashboard')); ?>"><i class="fas fa-tachometer-alt me-2 text-primary" aria-hidden="true"></i>Dashboard</a></li>
                                <li><a class="dropdown-item py-2" href="<?php echo e(route('admin.jobs.index')); ?>"><i class="fas fa-briefcase me-2 text-success" aria-hidden="true"></i>Manage Jobs</a></li>
                                <li><a class="dropdown-item py-2" href="<?php echo e(route('admin.results.index')); ?>"><i class="fas fa-chart-bar me-2 text-info" aria-hidden="true"></i>Manage Results</a></li>
                                <li><a class="dropdown-item py-2" href="<?php echo e(route('admin.admit-cards.index')); ?>"><i class="fas fa-ticket-alt me-2 text-warning" aria-hidden="true"></i>Manage Admit Cards</a></li>
                                <li><hr class="dropdown-divider my-1"></li>
                                <li>
                                    <form method="POST" action="<?php echo e(route('logout')); ?>" id="logout-form">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="dropdown-item text-danger py-2">
                                            <i class="fas fa-sign-out-alt me-2" aria-hidden="true"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a href="<?php echo e(route('login')); ?>" class="btn btn-outline-light btn-sm">
                                <i class="fas fa-sign-in-alt me-1" aria-hidden="true"></i> Login
                            </a>
                        </li>
                        <li class="nav-item ms-2">
                            <a href="<?php echo e(route('register')); ?>" class="btn btn-primary btn-sm">
                                <i class="fas fa-user-plus me-1" aria-hidden="true"></i> Register
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main id="main-content" tabindex="-1">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- Disclaimer Notice -->
    <div class="container">
        <div class="modern-disclaimer">
            <div class="d-flex gap-3 align-items-start">
                <i class="fas fa-shield-alt fs-4 mt-1" aria-hidden="true"></i>
                <div>
                    <strong>Disclaimer:</strong> SarkariResult.mobi is not affiliated with any Government Organization. This is a private website that provides information about government jobs, results, and admit cards for informational purposes only. All the information provided on this website is collected from various official sources. We recommend visitors to verify all details from the official government websites before taking any action.
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="modern-footer py-5 mt-5" role="contentinfo">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-4 col-md-6">
                    <div class="mb-4">
                        <div class="modern-logo mb-3">
                            <span class="sarkari">Sarkari</span>
                            <span class="result">Result</span>
                            <span class="mobi">.mobi</span>
                        </div>
                        <p class="text-secondary mb-4" style="line-height: 1.6;">
                            Your trusted partner for government job notifications, exam results, admit cards,
                            and all Sarkari Result updates in one place.
                        </p>
                    </div>
                    <div class="d-flex gap-3" aria-label="Social media links">
                        <a href="https://www.facebook.com/sarkariresultmobi" class="social-icon" aria-label="Facebook" rel="noopener noreferrer" target="_blank"><i class="fab fa-facebook-f" aria-hidden="true"></i></a>
                        <a href="https://twitter.com/sarkariresultmobi" class="social-icon" aria-label="Twitter" rel="noopener noreferrer" target="_blank"><i class="fab fa-twitter" aria-hidden="true"></i></a>
                        <a href="https://t.me/sarkariresultofficial" class="social-icon" aria-label="Telegram" rel="noopener noreferrer" target="_blank"><i class="fab fa-telegram" aria-hidden="true"></i></a>
                        <a href="https://www.youtube.com/@sarkariresultmobi" class="social-icon" aria-label="YouTube" rel="noopener noreferrer" target="_blank"><i class="fab fa-youtube" aria-hidden="true"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6">
                    <h5 class="footer-heading">Quick Links</h5>
                    <ul class="list-unstyled d-flex flex-column gap-2">
                        <li><a href="<?php echo e(route('home')); ?>"><i class="fas fa-chevron-right me-2" aria-hidden="true"></i>Home</a></li>
                        <li><a href="<?php echo e(route('jobs')); ?>"><i class="fas fa-chevron-right me-2" aria-hidden="true"></i>Latest Sarkari Jobs</a></li>
                        <li><a href="<?php echo e(route('results')); ?>"><i class="fas fa-chevron-right me-2" aria-hidden="true"></i>Check All Results</a></li>
                        <li><a href="<?php echo e(route('admit-cards')); ?>"><i class="fas fa-chevron-right me-2" aria-hidden="true"></i>Download Admit Card</a></li>
                        <li><a href="<?php echo e(route('answer-keys')); ?>"><i class="fas fa-chevron-right me-2" aria-hidden="true"></i>Answer Keys</a></li>
                        <li><a href="<?php echo e(route('documents.index')); ?>"><i class="fas fa-chevron-right me-2" aria-hidden="true"></i>Notices</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h5 class="footer-heading">Popular Categories</h5>
                    <ul class="list-unstyled d-flex flex-column gap-2">
                        <?php if(isset($categories) && $categories->count() > 0): ?>
                            <?php $__currentLoopData = $categories->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li>
                                    <a href="<?php echo e(route('categories.show', $category->slug)); ?>">
                                        <i class="fas fa-chevron-right me-2" aria-hidden="true"></i><?php echo e($category->name); ?>

                                    </a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <li><span class="text-secondary">No categories available</span></li>
                        <?php endif; ?>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h5 class="footer-heading">Get in Touch</h5>
                    <ul class="list-unstyled d-flex flex-column gap-3">
                        <li>
                            <div class="d-flex align-items-center gap-3">
                                <i class="fas fa-envelope text-primary" aria-hidden="true"></i>
                                <a href="mailto:info@sarkariresult.mobi" class="text-secondary">info@sarkariresult.mobi</a>
                            </div>
                        </li>
                        <li>
                            <div class="d-flex align-items-center gap-3">
                                <i class="fas fa-phone text-primary" aria-hidden="true"></i>
                                <a href="tel:+918889322227" class="text-secondary">+91-8889322227</a>
                            </div>
                        </li>
                        <li>
                            <div class="d-flex align-items-center gap-3">
                                <i class="fas fa-map-marker-alt text-primary" aria-hidden="true"></i>
                                <span class="text-secondary">New Delhi, India</span>
                            </div>
                        </li>
                        <li>
                            <div class="d-flex align-items-center gap-3">
                                <i class="fas fa-clock text-primary" aria-hidden="true"></i>
                                <span class="text-secondary">Mon - Fri: 9:00 - 18:00</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <hr class="my-4">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0 text-secondary small">
                        &copy; <?php echo e(date('Y')); ?> SarkariResult.mobi. All rights reserved.
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="d-flex gap-4 justify-content-md-end">
                        <a href="<?php echo e(route('privacy-policy')); ?>" class="text-secondary small">Privacy Policy</a>
                        <a href="<?php echo e(route('terms-of-service')); ?>" class="text-secondary small">Terms of Service</a>
                        <a href="<?php echo e(route('disclaimer')); ?>" class="text-secondary small">Disclaimer</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button class="back-to-top" id="backToTop" aria-label="Back to top" title="Scroll back to top">
        <i class="fas fa-chevron-up" aria-hidden="true"></i>
    </button>

    <!-- Defer non-critical scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>
    
    <!-- FIX: Check if app.js exists before loading -->
    <?php if(file_exists(public_path('js/app.js'))): ?>
        <script src="<?php echo e(asset('js/app.js')); ?>" defer></script>
    <?php endif; ?>

    <!-- Scripts for Back to Top, Navbar scroll -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ---- Back to Top ----
            const backBtn = document.getElementById('backToTop');
            window.addEventListener('scroll', function() {
                if (window.scrollY > 400) {
                    backBtn.classList.add('show');
                } else {
                    backBtn.classList.remove('show');
                }
            });
            backBtn.addEventListener('click', function() {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });

            // ---- Navbar scroll effect ----
            const navbar = document.querySelector('.navbar');
            window.addEventListener('scroll', function() {
                if (window.scrollY > 30) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            });
        });
    </script>

    <?php echo $__env->yieldPushContent('jsonld'); ?>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH E:\SARKARIMOBI\sarkariresult.mobi\resources\views/layouts/app.blade.php ENDPATH**/ ?>