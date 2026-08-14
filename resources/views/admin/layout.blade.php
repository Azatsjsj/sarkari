<!-- resources/views/admin/layout.blade.php -->
<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - {{ config('app.name', 'Laravel') }}</title>
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    
    <!-- Custom Admin CSS -->
    <style>
        :root {
            --sidebar-width: 280px;
            --sidebar-collapsed-width: 80px;
            --header-height: 70px;
            --primary-color: #4361ee;
            --secondary-color: #6c757d;
            --success-color: #28a745;
            --danger-color: #dc3545;
            --warning-color: #ffc107;
            --info-color: #17a2b8;
            --dark-color: #343a40;
            --light-color: #f8f9fa;
            --sidebar-bg: #2c3e50;
            --sidebar-color: #ecf0f1;
            --header-bg: #ffffff;
            --content-bg: #f8f9fa;
            --border-color: #e9ecef;
        }

        [data-bs-theme="dark"] {
            --sidebar-bg: #1a1d23;
            --sidebar-color: #b4b9c0;
            --header-bg: #2d3036;
            --content-bg: #25282e;
            --border-color: #3a3e45;
            --dark-color: #f8f9fa;
            --light-color: #343a40;
        }

        /* Layout Styles */
        .admin-layout {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--content-bg);
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            color: var(--sidebar-color);
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        .sidebar-header {
            padding: 1.5rem 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: inherit;
        }

        .brand-logo {
            width: 40px;
            height: 40px;
            background: var(--primary-color);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
        }

        .brand-logo i {
            color: white;
            font-size: 1.2rem;
        }

        .brand-text {
            line-height: 1.2;
        }

        .brand-title {
            font-weight: 700;
            font-size: 1.2rem;
            display: block;
        }

        .brand-subtitle {
            font-size: 0.75rem;
            opacity: 0.8;
        }

        .sidebar-toggle {
            background: none;
            border: none;
            color: inherit;
            font-size: 1.2rem;
            cursor: pointer;
            padding: 4px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .sidebar-toggle:hover {
            background: rgba(255,255,255,0.1);
        }

        /* Sidebar User */
        .sidebar-user {
            padding: 1.5rem 1rem;
            display: flex;
            align-items: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            overflow: hidden;
            margin-right: 12px;
            border: 3px solid rgba(255,255,255,0.2);
            background: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .user-info {
            line-height: 1.3;
        }

        .user-name {
            font-weight: 600;
            display: block;
            font-size: 0.9rem;
        }

        .user-role {
            font-size: 0.75rem;
            opacity: 0.8;
            text-transform: capitalize;
        }

        /* Sidebar Navigation */
        .sidebar-content {
            height: calc(100vh - 140px);
            overflow-y: auto;
        }

        .sidebar-nav {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .nav-category {
            padding: 1rem 1rem 0.5rem;
            font-size: 0.75rem;
            text-transform: uppercase;
            font-weight: 600;
            opacity: 0.6;
            letter-spacing: 0.5px;
        }

        .nav-item {
            position: relative;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: inherit;
            text-decoration: none;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }

        .nav-link:hover {
            background: rgba(255,255,255,0.1);
            border-left-color: var(--primary-color);
        }

        .nav-link.active {
            background: rgba(255,255,255,0.15);
            border-left-color: var(--primary-color);
            color: white;
        }

        .nav-icon {
            width: 20px;
            margin-right: 12px;
            text-align: center;
            font-size: 1.1rem;
        }

        .nav-text {
            flex: 1;
            font-weight: 500;
            transition: opacity 0.3s;
        }

        .sidebar.collapsed .nav-text {
            opacity: 0;
            pointer-events: none;
        }

        .nav-badge {
            font-size: 0.7rem;
            padding: 0.25em 0.5em;
        }

        /* Sidebar Footer */
        .sidebar-footer {
            padding: 1rem;
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            transition: margin-left 0.3s ease;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .sidebar.collapsed + .main-content {
            margin-left: var(--sidebar-collapsed-width);
        }

        /* Top Header */
        .top-header {
            height: var(--header-height);
            background: var(--header-bg);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.5rem;
            position: sticky;
            top: 0;
            z-index: 999;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .header-left {
            display: flex;
            align-items: center;
        }

        .header-toggle {
            background: none;
            border: none;
            font-size: 1.2rem;
            color: var(--secondary-color);
            margin-right: 1rem;
            cursor: pointer;
            padding: 8px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .header-toggle:hover {
            background: var(--border-color);
        }

        .breadcrumb {
            font-size: 0.9rem;
            color: var(--secondary-color);
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        /* Search Box */
        .search-box {
            position: relative;
            width: 300px;
        }

        .search-box .form-control {
            padding-left: 2.5rem;
            border-radius: 20px;
            border: 1px solid var(--border-color);
            background: var(--header-bg);
            color: var(--dark-color);
        }

        .search-btn {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--secondary-color);
        }

        /* Header Items */
        .header-item {
            position: relative;
        }

        .header-icon {
            background: none;
            border: none;
            font-size: 1.2rem;
            color: var(--secondary-color);
            padding: 8px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s;
            position: relative;
        }

        .header-icon:hover {
            background: var(--border-color);
            color: var(--primary-color);
        }

        .notification-badge {
            position: absolute;
            top: -2px;
            right: -2px;
            background: var(--danger-color);
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* User Dropdown */
        .user-dropdown {
            background: none;
            border: none;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 6px 12px;
            border-radius: 20px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .user-dropdown:hover {
            background: var(--border-color);
        }

        .user-avatar-sm {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            overflow: hidden;
            background: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 0.8rem;
        }

        .user-avatar-sm img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .user-name-sm {
            font-weight: 500;
            color: var(--dark-color);
        }

        [data-bs-theme="dark"] .user-name-sm {
            color: var(--sidebar-color);
        }

        /* Dropdown Menus */
        .dropdown-menu {
            border: none;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            border-radius: 8px;
            padding: 0.5rem;
        }

        .dropdown-header {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .dropdown-body {
            max-height: 300px;
            overflow-y: auto;
        }

        .dropdown-item {
            padding: 0.75rem 1rem;
            border-radius: 6px;
            margin-bottom: 2px;
            display: flex;
            align-items: center;
        }

        .dropdown-item i {
            width: 20px;
            margin-right: 8px;
        }

        .dropdown-item:hover {
            background: var(--border-color);
        }

        /* Content Wrapper */
        .content-wrapper {
            flex: 1;
            padding: 1.5rem;
        }

        /* Page Header */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .page-title {
            font-weight: 700;
            color: var(--dark-color);
            margin: 0;
        }

        [data-bs-theme="dark"] .page-title {
            color: white;
        }

        .page-actions {
            display: flex;
            gap: 0.5rem;
        }

        /* Alerts */
        .alert {
            border: none;
            border-radius: 8px;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
        }

        [data-bs-theme="dark"] .alert-success {
            background: #1e4620;
            color: #75b798;
        }

        [data-bs-theme="dark"] .alert-danger {
            background: #4a1c24;
            color: #e8a5b2;
        }

        /* Page Content */
        .page-content {
            background: var(--header-bg);
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 1.5rem;
        }

        /* Footer */
        .main-footer {
            background: var(--header-bg);
            border-top: 1px solid var(--border-color);
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: var(--secondary-color);
            font-size: 0.9rem;
        }

        /* Loading Spinner */
        .loading-spinner {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            display: none;
        }

        .loading-spinner.show {
            display: flex;
        }

        /* Notification Items */
        .notification-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            color: white;
        }

        .notification-content p {
            margin: 0;
            font-size: 0.9rem;
        }

        .notification-content small {
            font-size: 0.8rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.mobile-open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0 !important;
            }

            .search-box {
                width: 200px;
            }

            .header-right {
                gap: 0.5rem;
            }

            .user-name-sm {
                display: none;
            }
        }

        @media (max-width: 576px) {
            .content-wrapper {
                padding: 1rem;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .search-box {
                display: none;
            }
            
            .main-footer {
                flex-direction: column;
                gap: 0.5rem;
                text-align: center;
            }
        }

        /* Custom Scrollbar */
        .sidebar-content::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-content::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.1);
        }

        .sidebar-content::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.3);
            border-radius: 2px;
        }

        .sidebar-content::-webkit-scrollbar-thumb:hover {
            background: rgba(255,255,255,0.5);
        }

        /* Card Improvements */
        .card {
            border: none;
            box-shadow: 0 0.125rem 0.5rem rgba(0, 0, 0, 0.1);
            margin-bottom: 1.5rem;
        }

        .card-header {
            background: var(--header-bg);
            border-bottom: 1px solid var(--border-color);
            font-weight: 600;
        }

        /* Table Improvements */
        .table {
            margin-bottom: 0;
        }

        .table th {
            border-top: none;
            font-weight: 600;
            background: var(--header-bg);
        }

        /* Badge Improvements */
        .badge {
            font-weight: 500;
        }

        /* Button Improvements */
        .btn {
            border-radius: 0.375rem;
            font-weight: 500;
        }

        .btn-sm {
            padding: 0.25rem 0.75rem;
            font-size: 0.875rem;
        }
    </style>
    
    @stack('styles')
</head>
<body class="admin-layout">
    <!-- Loading Spinner -->
    <div id="loadingSpinner" class="loading-spinner">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- Navigation Sidebar -->
    <nav id="sidebar" class="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
                <div class="brand-logo">
                    <i class="fas fa-crown"></i>
                </div>
                <div class="brand-text">
                    <span class="brand-title">{{ config('app.name', 'Admin Panel') }}</span>
                    <small class="brand-subtitle">Admin Panel</small>
                </div>
            </a>
            <button class="sidebar-toggle" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <div class="sidebar-content">
            <!-- User Profile -->
            <div class="sidebar-user">
                <div class="user-avatar">
                    @if(Auth::user()->avatar)
                        <img src="{{ Auth::user()->avatar }}" alt="User Avatar" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <span style="display: none;">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</span>
                    @else
                        <span>{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</span>
                    @endif
                </div>
                <div class="user-info">
                    <span class="user-name">{{ Auth::user()->name }}</span>
                    <span class="user-role">{{ Auth::user()->role }}</span>
                </div>
            </div>

            <!-- Navigation Menu -->
            <ul class="sidebar-nav">
                <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>
                
                <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.sitemap.index') }}">
                                <i class="fas fa-sitemap"></i> Sitemap
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.jobs.index') }}">
                                <i class="fas fa-briefcase"></i> Jobs
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.results.index') }}">
                                <i class="fas fa-chart-bar"></i> Results
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.admit-cards.index') }}">
                                <i class="fas fa-ticket-alt"></i> Admit Cards
                            </a>
                        </li>

                <!-- Jobs Section -->
                <li class="nav-item nav-category">Jobs Management</li>
                <li class="nav-item {{ request()->routeIs('admin.jobs.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.jobs.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-briefcase"></i>
                        <span class="nav-text">All Jobs</span>
                        <span class="nav-badge badge bg-primary">{{ \App\Models\Job::count() }}</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('admin.jobs.create') ? 'active' : '' }}">
                    <a href="{{ route('admin.jobs.create') }}" class="nav-link">
                        <i class="nav-icon fas fa-plus-circle"></i>
                        <span class="nav-text">Add New Job</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.jobs.index', ['status' => 'active']) }}" class="nav-link">
                        <i class="nav-icon fas fa-toggle-on"></i>
                        <span class="nav-text">Active Jobs</span>
                        <span class="nav-badge badge bg-success">{{ \App\Models\Job::where('is_active', true)->count() }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.jobs.index', ['featured' => true]) }}" class="nav-link">
                        <i class="nav-icon fas fa-star"></i>
                        <span class="nav-text">Featured Jobs</span>
                        <span class="nav-badge badge bg-warning">{{ \App\Models\Job::where('is_featured', true)->count() }}</span>
                    </a>
                </li>

                <!-- Results Section -->
                <li class="nav-item nav-category">Results & Admit Cards</li>
                <li class="nav-item {{ request()->routeIs('admin.results.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.results.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <span class="nav-text">Results</span>
                        <span class="nav-badge badge bg-info">{{ \App\Models\Result::count() }}</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('admin.admit-cards.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.admit-cards.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-id-card"></i>
                        <span class="nav-text">Admit Cards</span>
                        <span class="nav-badge badge bg-info">{{ \App\Models\AdmitCard::count() }}</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('admin.answer-keys.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.answer-keys.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-key"></i>
                        <span class="nav-text">Answer Keys</span>
                        <span class="nav-badge badge bg-info">{{ \App\Models\AnswerKey::count() }}</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('admin.score-analytics.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.score-analytics.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <span class="nav-text">Score Analytics</span>
                        <span class="nav-badge badge bg-danger">{{ \App\Models\AnswerKeyCalculation::count() }}</span>
                    </a>
                </li>

                <!-- Admissions Section -->
                <li class="nav-item nav-category">Admissions Management</li>
                <li class="nav-item {{ request()->routeIs('admin.admissions.index') || request()->routeIs('admin.admissions.edit') ? 'active' : '' }}">
                    <a href="{{ route('admin.admissions.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-graduation-cap"></i>
                        <span class="nav-text">All Admissions</span>
                        <span class="nav-badge badge bg-success">{{ \App\Models\Admission::count() }}</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('admin.admissions.create') ? 'active' : '' }}">
                    <a href="{{ route('admin.admissions.create') }}" class="nav-link">
                        <i class="nav-icon fas fa-plus-circle"></i>
                        <span class="nav-text">Add New Admission</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('admin.universities.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.universities.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-university"></i>
                        <span class="nav-text">Universities</span>
                        <span class="nav-badge badge bg-info">{{ \App\Models\University::count() }}</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.courses.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-book-open"></i>
                        <span class="nav-text">Courses</span>
                        <span class="nav-badge badge bg-secondary">{{ \App\Models\Course::count() }}</span>
                    </a>
                </li>

                <!-- Categories Section -->
                <li class="nav-item nav-category">Content Management</li>
                <li class="nav-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.categories.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-list"></i>
                        <span class="nav-text">Categories</span>
                        <span class="nav-badge badge bg-secondary">{{ \App\Models\Category::count() }}</span>
                    </a>
                </li>

                <!-- Documents Section -->
                <li class="nav-item nav-category">Notice & Document</li>
                <li class="nav-item {{ request()->routeIs('admin.documents.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.documents.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-list"></i>
                        <span class="nav-text">Documents</span>
                    
                    </a>
                </li>

                <!-- User Management -->
                <li class="nav-item nav-category">User Management</li>
                <li class="nav-item {{ request()->routeIs('admin.users.index') || request()->routeIs('admin.users.edit') || request()->routeIs('admin.users.show') ? 'active' : '' }}">
                    <a href="{{ route('admin.users.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <span class="nav-text">All Users</span>
                        <span class="nav-badge badge bg-success">{{ \App\Models\User::count() }}</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('admin.users.create') ? 'active' : '' }}">
                    <a href="{{ route('admin.users.create') }}" class="nav-link">
                        <i class="nav-icon fas fa-user-plus"></i>
                        <span class="nav-text">Add New User</span>
                    </a>
                </li>

                <!-- System Section -->
                <li class="nav-item nav-category">System</li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cog"></i>
                        <span class="nav-text">Settings</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-history"></i>
                        <span class="nav-text">Activity Log</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Sidebar Footer -->
        <div class="sidebar-footer">
            <div class="theme-switcher">
                <button class="btn btn-sm btn-outline-secondary" id="themeToggle">
                    <i class="fas fa-moon"></i> Dark Mode
                </button>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Header -->
        <header class="top-header">
            <div class="header-left">
                <button class="header-toggle" id="headerToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="breadcrumb">
                    @yield('breadcrumb', 'Dashboard')
                </div>
            </div>

            <div class="header-right">
                <!-- Search Box -->
                <div class="search-box">
                    <input type="text" class="form-control" placeholder="Search...">
                    <button class="search-btn">
                        <i class="fas fa-search"></i>
                    </button>
                </div>

                <!-- Notifications -->
                <div class="header-item dropdown">
                    <button class="header-icon dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">3</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end notification-dropdown">
                        <div class="dropdown-header">
                            <h6 class="mb-0">Notifications</h6>
                            <a href="#" class="text-muted small">Mark all as read</a>
                        </div>
                        <div class="dropdown-body">
                            <a href="#" class="dropdown-item">
                                <div class="notification-icon bg-primary">
                                    <i class="fas fa-briefcase"></i>
                                </div>
                                <div class="notification-content">
                                    <p class="mb-0">New job posted</p>
                                    <small class="text-muted">2 minutes ago</small>
                                </div>
                            </a>
                            <a href="#" class="dropdown-item">
                                <div class="notification-icon bg-success">
                                    <i class="fas fa-chart-bar"></i>
                                </div>
                                <div class="notification-content">
                                    <p class="mb-0">New result published</p>
                                    <small class="text-muted">1 hour ago</small>
                                </div>
                            </a>
                        </div>
                        <div class="dropdown-footer">
                            <a href="#" class="text-primary">View all notifications</a>
                        </div>
                    </div>
                </div>

                <!-- User Menu -->
                <div class="header-item dropdown">
                    <button class="user-dropdown dropdown-toggle" data-bs-toggle="dropdown">
                        <div class="user-avatar-sm">
                            @if(Auth::user()->avatar)
                                <img src="{{ Auth::user()->avatar }}" alt="User Avatar" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <span style="display: none;">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                            @else
                                <span>{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                            @endif
                        </div>
                        <span class="user-name-sm">{{ Str::limit(Auth::user()->name, 15) }}</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end user-dropdown-menu">
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-user me-2"></i>My Profile
                        </a>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-cog me-2"></i>Settings
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="content-wrapper">
            <!-- Page Header -->
            <div class="page-header">
                @hasSection('page-header')
                    @yield('page-header')
                @else
                    <h1 class="page-title">
                        <i class="fas @yield('icon', 'fa-tachometer-alt') me-2"></i>
                        @yield('title', 'Dashboard')
                    </h1>
                    <div class="page-actions">
                        @yield('page-actions')
                    </div>
                @endif
            </div>

            <!-- Alert Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(isset($errors) && $errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Please fix the following errors:</strong>
                    <ul class="mb-0 mt-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Page Content -->
            <div class="page-content">
                @yield('content')
            </div>
        </main>

        <!-- Footer -->
        <footer class="main-footer">
            <div class="footer-left">
                <p class="mb-0">&copy; {{ date('Y') }} {{ config('app.name', 'Admin Panel') }}. All rights reserved.</p>
            </div>
            <div class="footer-right">
                <p class="mb-0">Version 2.0.0 | Server Time: <span id="serverTime">{{ now()->format('M j, Y H:i:s') }}</span></p>
            </div>
        </footer>
    </div>

    <!-- Toast Container -->
    <div class="toast-container position-fixed top-0 end-0 p-3">
        <!-- Toast messages will be inserted here -->
    </div>

    <!-- Scripts -->
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    
    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <!-- Custom Admin JS -->
    <script>
        class AdminPanel {
            constructor() {
                this.init();
            }

            init() {
                this.initSidebar();
                this.initTheme();
                this.initNotifications();
                this.initLoading();
                this.initServerTime();
                this.initEventListeners();
            }

            // Sidebar functionality
            initSidebar() {
                const sidebar = document.getElementById('sidebar');
                const sidebarToggle = document.getElementById('sidebarToggle');
                const headerToggle = document.getElementById('headerToggle');

                // Toggle sidebar collapse
                if (sidebarToggle) {
                    sidebarToggle.addEventListener('click', () => {
                        sidebar.classList.toggle('collapsed');
                        this.savePreference('sidebarCollapsed', sidebar.classList.contains('collapsed'));
                    });
                }

                // Mobile sidebar toggle
                if (headerToggle) {
                    headerToggle.addEventListener('click', () => {
                        sidebar.classList.toggle('mobile-open');
                    });
                }

                // Load sidebar state
                const sidebarCollapsed = this.getPreference('sidebarCollapsed');
                if (sidebarCollapsed === 'true') {
                    sidebar.classList.add('collapsed');
                }

                // Close sidebar when clicking outside on mobile
                document.addEventListener('click', (e) => {
                    if (window.innerWidth <= 768 && 
                        !sidebar.contains(e.target) && 
                        !headerToggle.contains(e.target)) {
                        sidebar.classList.remove('mobile-open');
                    }
                });
            }

            // Theme functionality
            initTheme() {
                const themeToggle = document.getElementById('themeToggle');
                const currentTheme = this.getPreference('theme') || 'light';

                // Set initial theme
                document.documentElement.setAttribute('data-bs-theme', currentTheme);
                this.updateThemeButton(currentTheme);

                // Toggle theme
                if (themeToggle) {
                    themeToggle.addEventListener('click', () => {
                        const newTheme = currentTheme === 'light' ? 'dark' : 'light';
                        document.documentElement.setAttribute('data-bs-theme', newTheme);
                        this.savePreference('theme', newTheme);
                        this.updateThemeButton(newTheme);
                        this.showToast(`Switched to ${newTheme} mode`, 'success');
                    });
                }
            }

            updateThemeButton(theme) {
                const themeToggle = document.getElementById('themeToggle');
                if (themeToggle) {
                    if (theme === 'dark') {
                        themeToggle.innerHTML = '<i class="fas fa-sun"></i> Light Mode';
                        themeToggle.classList.remove('btn-outline-secondary');
                        themeToggle.classList.add('btn-outline-warning');
                    } else {
                        themeToggle.innerHTML = '<i class="fas fa-moon"></i> Dark Mode';
                        themeToggle.classList.remove('btn-outline-warning');
                        themeToggle.classList.add('btn-outline-secondary');
                    }
                }
            }

            // Notification system
            initNotifications() {
                // Initialize tooltips
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            }

            // Loading states
            initLoading() {
                // Global loading handler for forms
                document.addEventListener('submit', (e) => {
                    const form = e.target;
                    if (form.method !== 'get') {
                        this.showLoading();
                    }
                });

                // Hide loading when page finishes loading
                window.addEventListener('load', () => {
                    this.hideLoading();
                });
            }

            showLoading() {
                const spinner = document.getElementById('loadingSpinner');
                if (spinner) {
                    spinner.classList.add('show');
                }
            }

            hideLoading() {
                const spinner = document.getElementById('loadingSpinner');
                if (spinner) {
                    spinner.classList.remove('show');
                }
            }

            // Server time
            initServerTime() {
                this.updateServerTime();
                setInterval(() => this.updateServerTime(), 1000);
            }

            updateServerTime() {
                const now = new Date();
                const timeElement = document.getElementById('serverTime');
                if (timeElement) {
                    timeElement.textContent = now.toLocaleString('en-US', {
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit',
                        hour12: false
                    });
                }
            }

            // Toast notifications
            showToast(message, type = 'info', duration = 5000) {
                const toastContainer = document.querySelector('.toast-container');
                if (!toastContainer) return;

                const toastId = 'toast-' + Date.now();
                const toastHtml = `
                    <div id="${toastId}" class="toast align-items-center text-bg-${type} border-0" role="alert">
                        <div class="d-flex">
                            <div class="toast-body">
                                <i class="fas fa-${this.getToastIcon(type)} me-2"></i>
                                ${message}
                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                        </div>
                    </div>
                `;

                toastContainer.insertAdjacentHTML('beforeend', toastHtml);
                const toastElement = document.getElementById(toastId);
                const toast = new bootstrap.Toast(toastElement, { delay: duration });
                
                toast.show();

                // Remove from DOM after hide
                toastElement.addEventListener('hidden.bs.toast', () => {
                    toastElement.remove();
                });
            }

            getToastIcon(type) {
                const icons = {
                    success: 'check-circle',
                    error: 'exclamation-circle',
                    warning: 'exclamation-triangle',
                    info: 'info-circle'
                };
                return icons[type] || 'info-circle';
            }

            // Preferences management
            savePreference(key, value) {
                localStorage.setItem(`admin_${key}`, value);
            }

            getPreference(key) {
                return localStorage.getItem(`admin_${key}`);
            }

            // Event listeners
            initEventListeners() {
                // Confirmations for destructive actions
                document.addEventListener('click', (e) => {
                    if (e.target.classList.contains('confirm-action')) {
                        const message = e.target.getAttribute('data-confirm') || 'Are you sure you want to perform this action?';
                        if (!confirm(message)) {
                            e.preventDefault();
                        }
                    }
                });

                // Auto-dismiss alerts
                const autoDismissAlerts = document.querySelectorAll('.alert[data-auto-dismiss]');
                autoDismissAlerts.forEach(alert => {
                    const delay = parseInt(alert.getAttribute('data-auto-dismiss')) || 5000;
                    setTimeout(() => {
                        const bsAlert = new bootstrap.Alert(alert);
                        bsAlert.close();
                    }, delay);
                });

                // Initialize DataTables if present
                if (typeof $.fn.DataTable === 'function') {
                    $('table.datatable').DataTable({
                        responsive: true,
                        pageLength: 25,
                        language: {
                            search: "_INPUT_",
                            searchPlaceholder: "Search...",
                            lengthMenu: "_MENU_ records per page",
                            info: "Showing _START_ to _END_ of _TOTAL_ records",
                            infoEmpty: "Showing 0 to 0 of 0 records",
                            infoFiltered: "(filtered from _MAX_ total records)"
                        }
                    });
                }

                // Initialize Select2 if present
                if (typeof $.fn.select2 === 'function') {
                    $('.select2').select2({
                        theme: 'bootstrap-5',
                        width: '100%'
                    });
                }
            }

            // Utility methods
            formatNumber(number) {
                return new Intl.NumberFormat().format(number);
            }

            formatDate(date) {
                return new Date(date).toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                });
            }

            formatDateTime(date) {
                return new Date(date).toLocaleString('en-US', {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });
            }

            // AJAX helper
            async ajaxRequest(url, options = {}) {
                const defaultOptions = {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                };

                const mergedOptions = { ...defaultOptions, ...options };
                
                try {
                    this.showLoading();
                    const response = await fetch(url, mergedOptions);
                    const data = await response.json();
                    return data;
                } catch (error) {
                    console.error('AJAX request failed:', error);
                    this.showToast('An error occurred while processing your request', 'error');
                    throw error;
                } finally {
                    this.hideLoading();
                }
            }
        }

        // Initialize admin panel when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            window.Admin = new AdminPanel();
        });

        // Make Admin available globally
        window.showToast = (message, type, duration) => {
            if (window.Admin) {
                window.Admin.showToast(message, type, duration);
            }
        };

        window.showLoading = () => {
            if (window.Admin) {
                window.Admin.showLoading();
            }
        };

        window.hideLoading = () => {
            if (window.Admin) {
                window.Admin.hideLoading();
            }
        };
    </script>
    
    @stack('scripts')
</body>
</html>