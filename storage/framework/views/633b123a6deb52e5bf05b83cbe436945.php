


<?php $__env->startSection('title', $category->name . ' Jobs - Sarkari Result'); ?>
<?php $__env->startSection('meta_description', $category->description ?? 'Browse all latest government jobs in ' . $category->name . ' category. Find vacancies, notifications, and application details.'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    /* ============================================
       SARKARI RESULT MODERN STYLE - CATEGORY PAGE
    ============================================ */
    
    :root {
        --sarkari-primary: #ab183d;
        --sarkari-primary-dark: #8b1030;
        --sarkari-primary-light: #fce8ed;
        --sarkari-success: #28a745;
        --sarkari-info: #17a2b8;
        --sarkari-warning: #ffc107;
        --sarkari-danger: #dc3545;
        --sarkari-urgent: #fd7e14;
        --sarkari-border: #e0e0e0;
        --sarkari-bg-light: #f8f9fa;
        --sarkari-text: #1e293b;
        --sarkari-text-muted: #64748b;
        --transition-speed: 0.25s;
    }

    /* Category Container */
    .category-wrapper {
        max-width: 1280px;
        margin: 0 auto;
        padding: 20px 15px 40px;
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    }

    /* ========== BREADCRUMB ========== */
    .category-breadcrumb {
        background: var(--sarkari-bg-light);
        padding: 12px 18px;
        border-radius: 12px;
        margin-bottom: 24px;
        font-size: 13px;
        border: 1px solid var(--sarkari-border);
    }
    
    .category-breadcrumb a {
        color: var(--sarkari-primary);
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s;
    }
    
    .category-breadcrumb a:hover {
        color: var(--sarkari-primary-dark);
        text-decoration: underline;
    }
    
    .category-breadcrumb .separator {
        color: #aaa;
        margin: 0 6px;
    }
    
    .category-breadcrumb .current {
        color: var(--sarkari-text-muted);
    }

    /* ========== CATEGORY HEADER ========== */
    .category-header {
        background: linear-gradient(135deg, var(--sarkari-primary) 0%, var(--sarkari-primary-dark) 100%);
        border-radius: 16px;
        padding: 30px 32px;
        margin-bottom: 28px;
        box-shadow: 0 4px 20px rgba(171, 24, 61, 0.25);
        position: relative;
        overflow: hidden;
    }
    
    .category-header::after {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
        pointer-events: none;
    }
    
    .category-header-content {
        position: relative;
        z-index: 2;
    }
    
    .category-header h1 {
        font-size: 2rem;
        font-weight: 700;
        color: #fff;
        margin-bottom: 8px;
    }
    
    .category-header h1 i {
        color: #f4c542;
        margin-right: 12px;
    }
    
    .category-header .subtitle {
        color: rgba(255, 255, 255, 0.85);
        font-size: 1rem;
        margin-bottom: 16px;
    }
    
    .category-header .badge-group {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }
    
    .category-header .badge-modern {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 16px;
        border-radius: 40px;
        font-size: 0.8rem;
        font-weight: 600;
        background: rgba(255, 255, 255, 0.15);
        color: #fff;
        backdrop-filter: blur(4px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .category-header .badge-modern i {
        color: #f4c542;
    }
    
    .category-header .description-text {
        color: rgba(255, 255, 255, 0.8);
        font-size: 0.95rem;
        margin-top: 16px;
        padding-top: 16px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    /* ========== STATS ROW ========== */
    .category-stats {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 28px;
    }
    
    .stat-card-modern {
        background: #fff;
        border: 1px solid var(--sarkari-border);
        border-radius: 14px;
        text-align: center;
        padding: 18px 12px;
        transition: all var(--transition-speed);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
    }
    
    .stat-card-modern:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
    }
    
    .stat-number {
        font-size: 1.8rem;
        font-weight: 800;
        margin-bottom: 4px;
        line-height: 1.2;
    }
    
    .stat-label {
        font-size: 0.8rem;
        color: var(--sarkari-text-muted);
        font-weight: 500;
    }
    
    .stat-card-modern.total .stat-number { color: var(--sarkari-primary); }
    .stat-card-modern.active .stat-number { color: var(--sarkari-success); }
    .stat-card-modern.featured .stat-number { color: #b5835a; }
    .stat-card-modern.posts .stat-number { color: var(--sarkari-info); }

    /* ========== SECTION HEADER ========== */
    .section-header-modern {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 2px solid var(--sarkari-primary-light);
    }
    
    .section-header-modern h3 {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--sarkari-text);
        margin: 0;
    }
    
    .section-header-modern h3 i {
        color: var(--sarkari-primary);
        margin-right: 10px;
    }
    
    .section-header-modern .result-count {
        font-size: 0.85rem;
        color: var(--sarkari-text-muted);
    }
    
    .section-header-modern .result-count strong {
        color: var(--sarkari-primary);
    }

    /* ========== SORT DROPDOWN ========== */
    .sort-dropdown .btn {
        border-radius: 10px;
        border: 2px solid var(--sarkari-border);
        padding: 8px 16px;
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--sarkari-text);
        background: #fff;
        transition: all var(--transition-speed);
    }
    
    .sort-dropdown .btn:hover {
        border-color: var(--sarkari-primary);
        background: var(--sarkari-primary-light);
    }
    
    .sort-dropdown .dropdown-menu {
        border-radius: 12px;
        border: 1px solid var(--sarkari-border);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        padding: 6px;
    }
    
    .sort-dropdown .dropdown-item {
        border-radius: 8px;
        padding: 8px 16px;
        font-size: 0.85rem;
        transition: all var(--transition-speed);
    }
    
    .sort-dropdown .dropdown-item:hover {
        background: var(--sarkari-primary-light);
        color: var(--sarkari-primary);
    }

    /* ========== JOB CARD ========== */
    .job-card-modern {
        background: #fff;
        border: 1px solid var(--sarkari-border);
        border-radius: 16px;
        margin-bottom: 20px;
        overflow: hidden;
        transition: all var(--transition-speed);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
    }
    
    .job-card-modern:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.08);
        border-color: var(--sarkari-primary);
    }
    
    .job-card-body {
        padding: 24px;
    }
    
    .job-card-body .job-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--sarkari-text);
        margin-bottom: 10px;
    }
    
    .job-card-body .job-title a {
        color: var(--sarkari-text);
        text-decoration: none;
        transition: color 0.2s;
    }
    
    .job-card-body .job-title a:hover {
        color: var(--sarkari-primary);
    }
    
    .job-card-body .job-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 12px;
    }
    
    .job-card-body .job-meta .badge-modern {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 14px;
        border-radius: 40px;
        font-size: 0.7rem;
        font-weight: 600;
    }
    
    .badge-category {
        background: var(--sarkari-primary-light);
        color: var(--sarkari-primary);
    }
    
    .badge-posts {
        background: #e9ecef;
        color: #495057;
    }
    
    .badge-expired {
        background: #fee2e2;
        color: #991b1b;
    }
    
    .badge-urgent {
        background: #fed7aa;
        color: #9a3412;
    }
    
    .badge-lastweek {
        background: #fef3c7;
        color: #92400e;
    }
    
    .badge-featured {
        background: #fef3c7;
        color: #92400e;
    }
    
    .job-card-body .job-description {
        color: var(--sarkari-text-muted);
        font-size: 0.9rem;
        margin-bottom: 14px;
        line-height: 1.6;
    }
    
    .job-card-body .job-details-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 6px 20px;
        margin-bottom: 14px;
    }
    
    .job-card-body .job-details-grid .detail-item {
        font-size: 0.8rem;
        color: var(--sarkari-text-muted);
    }
    
    .job-card-body .job-details-grid .detail-item strong {
        color: var(--sarkari-text);
    }
    
    .job-card-body .job-details-grid .detail-item i {
        width: 16px;
        color: var(--sarkari-primary);
    }
    
    .job-card-footer {
        background: var(--sarkari-bg-light);
        padding: 14px 24px;
        border-top: 1px solid var(--sarkari-border);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }
    
    .job-card-footer .footer-meta {
        font-size: 0.75rem;
        color: var(--sarkari-text-muted);
    }
    
    .job-card-footer .footer-meta i {
        color: var(--sarkari-primary);
    }
    
    .job-card-footer .footer-actions {
        display: flex;
        gap: 8px;
    }

    /* ========== BUTTONS ========== */
    .btn-modern {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        transition: all var(--transition-speed);
        border: none;
        cursor: pointer;
    }
    
    .btn-primary-modern {
        background: var(--sarkari-primary);
        color: #fff;
    }
    
    .btn-primary-modern:hover {
        background: var(--sarkari-primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(171, 24, 61, 0.3);
        color: #fff;
    }
    
    .btn-success-modern {
        background: var(--sarkari-success);
        color: #fff;
    }
    
    .btn-success-modern:hover {
        background: #1e7e34;
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(40, 167, 69, 0.3);
        color: #fff;
    }
    
    .btn-outline-modern {
        background: transparent;
        color: var(--sarkari-primary);
        border: 2px solid var(--sarkari-primary);
    }
    
    .btn-outline-modern:hover {
        background: var(--sarkari-primary);
        color: #fff;
        transform: translateY(-2px);
    }
    
    .btn-sm-modern {
        padding: 6px 14px;
        font-size: 0.75rem;
        border-radius: 8px;
    }
    
    .btn-disabled-modern {
        background: #e9ecef;
        color: #adb5bd;
        cursor: not-allowed;
        pointer-events: none;
    }

    /* ========== SIDEBAR ========== */
    .sidebar-card {
        background: #fff;
        border: 1px solid var(--sarkari-border);
        border-radius: 16px;
        margin-bottom: 20px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
    }
    
    .sidebar-card-header {
        padding: 14px 20px;
        font-weight: 700;
        font-size: 0.95rem;
        border-bottom: 1px solid var(--sarkari-border);
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .sidebar-card-header.primary {
        background: var(--sarkari-primary);
        color: #fff;
    }
    
    .sidebar-card-header.primary i {
        color: #f4c542;
    }
    
    .sidebar-card-header.success {
        background: var(--sarkari-success);
        color: #fff;
    }
    
    .sidebar-card-header.info {
        background: var(--sarkari-info);
        color: #fff;
    }
    
    .sidebar-card-header.warning {
        background: var(--sarkari-warning);
        color: #000;
    }
    
    .sidebar-card-body {
        padding: 18px 20px;
    }
    
    /* Category Info in Sidebar */
    .category-info-icon {
        text-align: center;
        padding: 10px 0;
    }
    
    .category-info-icon i {
        font-size: 3rem;
        color: var(--sarkari-primary);
        margin-bottom: 10px;
    }
    
    .category-info-icon h5 {
        color: var(--sarkari-primary);
        font-weight: 700;
    }
    
    .category-info-stats {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        margin-top: 14px;
    }
    
    .category-info-stats .info-stat {
        text-align: center;
        padding: 10px;
        background: var(--sarkari-bg-light);
        border-radius: 10px;
    }
    
    .category-info-stats .info-stat .number {
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--sarkari-primary);
    }
    
    .category-info-stats .info-stat .label {
        font-size: 0.7rem;
        color: var(--sarkari-text-muted);
    }

    /* Search in Sidebar */
    .search-form-modern .input-group {
        border-radius: 12px;
        overflow: hidden;
        border: 2px solid var(--sarkari-border);
        transition: all var(--transition-speed);
    }
    
    .search-form-modern .input-group:focus-within {
        border-color: var(--sarkari-primary);
        box-shadow: 0 0 0 3px rgba(171, 24, 61, 0.1);
    }
    
    .search-form-modern .form-control {
        border: none;
        padding: 10px 16px;
        font-size: 0.9rem;
    }
    
    .search-form-modern .form-control:focus {
        box-shadow: none;
    }
    
    .search-form-modern .btn-search {
        background: var(--sarkari-primary);
        color: #fff;
        border: none;
        padding: 10px 18px;
        transition: all var(--transition-speed);
    }
    
    .search-form-modern .btn-search:hover {
        background: var(--sarkari-primary-dark);
    }

    /* Categories List */
    .categories-list .list-group-item {
        border: none;
        border-bottom: 1px solid var(--sarkari-border);
        padding: 12px 16px;
        transition: all var(--transition-speed);
    }
    
    .categories-list .list-group-item:last-child {
        border-bottom: none;
    }
    
    .categories-list .list-group-item:hover {
        background: var(--sarkari-primary-light);
    }
    
    .categories-list .list-group-item.active {
        background: var(--sarkari-primary);
        color: #fff;
        border-radius: 0;
    }
    
    .categories-list .list-group-item.active .badge {
        background: rgba(255, 255, 255, 0.3);
        color: #fff;
    }
    
    .categories-list .list-group-item .badge {
        background: var(--sarkari-primary-light);
        color: var(--sarkari-primary);
        font-weight: 600;
    }

    /* Featured Jobs in Sidebar */
    .featured-job-item {
        padding: 12px 0;
        border-bottom: 1px solid var(--sarkari-border);
    }
    
    .featured-job-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
    
    .featured-job-item h6 {
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 4px;
    }
    
    .featured-job-item h6 a {
        color: var(--sarkari-text);
        text-decoration: none;
        transition: color 0.2s;
    }
    
    .featured-job-item h6 a:hover {
        color: var(--sarkari-primary);
    }
    
    .featured-job-item .meta {
        font-size: 0.7rem;
        color: var(--sarkari-text-muted);
    }

    /* Quick Links */
    .quick-links-grid {
        display: grid;
        gap: 8px;
    }
    
    .quick-links-grid .btn {
        border-radius: 10px;
        padding: 10px 16px;
        font-size: 0.85rem;
        font-weight: 600;
        text-align: left;
        transition: all var(--transition-speed);
    }
    
    .quick-links-grid .btn:hover {
        transform: translateX(4px);
    }

    /* ========== PAGINATION ========== */
    .pagination-modern {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 28px;
        padding-top: 20px;
        border-top: 1px solid var(--sarkari-border);
    }
    
    .pagination-modern .info {
        font-size: 0.85rem;
        color: var(--sarkari-text-muted);
    }
    
    .pagination-modern .info strong {
        color: var(--sarkari-primary);
    }
    
    .pagination-modern .pagination {
        margin: 0;
        gap: 6px;
    }
    
    .pagination-modern .page-link {
        border-radius: 10px;
        padding: 8px 14px;
        font-size: 0.85rem;
        font-weight: 500;
        color: var(--sarkari-text);
        border: 1px solid var(--sarkari-border);
        transition: all var(--transition-speed);
    }
    
    .pagination-modern .page-link:hover {
        background: var(--sarkari-primary);
        color: #fff;
        border-color: var(--sarkari-primary);
    }
    
    .pagination-modern .active .page-link {
        background: var(--sarkari-primary);
        color: #fff;
        border-color: var(--sarkari-primary);
    }
    
    .pagination-modern .disabled .page-link {
        color: #adb5bd;
        cursor: not-allowed;
    }

    /* ========== NO RESULTS ========== */
    .no-results-modern {
        text-align: center;
        padding: 60px 20px;
    }
    
    .no-results-modern i {
        font-size: 4rem;
        color: #d1d5db;
        margin-bottom: 20px;
    }
    
    .no-results-modern h4 {
        font-size: 1.3rem;
        color: var(--sarkari-text);
        margin-bottom: 10px;
    }
    
    .no-results-modern p {
        color: var(--sarkari-text-muted);
        max-width: 500px;
        margin: 0 auto 20px;
    }
    
    .no-results-modern .btn-group {
        display: flex;
        gap: 10px;
        justify-content: center;
        flex-wrap: wrap;
    }

    /* ========== RESPONSIVE ========== */
    @media (max-width: 992px) {
        .category-stats {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    
    @media (max-width: 768px) {
        .category-wrapper {
            padding: 12px 10px 30px;
        }
        
        .category-header {
            padding: 20px;
            border-radius: 12px;
        }
        
        .category-header h1 {
            font-size: 1.5rem;
        }
        
        .category-header .subtitle {
            font-size: 0.9rem;
        }
        
        .category-stats {
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }
        
        .stat-number {
            font-size: 1.4rem;
        }
        
        .job-card-body {
            padding: 16px;
        }
        
        .job-card-body .job-details-grid {
            grid-template-columns: 1fr;
        }
        
        .job-card-footer {
            flex-direction: column;
            align-items: flex-start;
            padding: 12px 16px;
        }
        
        .job-card-footer .footer-actions {
            width: 100%;
        }
        
        .job-card-footer .footer-actions .btn-modern {
            flex: 1;
            justify-content: center;
        }
        
        .section-header-modern {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .pagination-modern {
            flex-direction: column;
            align-items: center;
        }
        
        .pagination-modern .pagination {
            flex-wrap: wrap;
            justify-content: center;
        }
    }
    
    @media (max-width: 480px) {
        .category-header h1 {
            font-size: 1.2rem;
        }
        
        .category-header .badge-group .badge-modern {
            font-size: 0.65rem;
            padding: 4px 12px;
        }
        
        .category-stats {
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }
        
        .stat-card-modern {
            padding: 12px 8px;
        }
        
        .stat-number {
            font-size: 1.2rem;
        }
        
        .job-card-body .job-title {
            font-size: 0.95rem;
        }
        
        .job-card-body .job-meta .badge-modern {
            font-size: 0.6rem;
            padding: 3px 10px;
        }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="category-wrapper">
    
    
    <nav class="category-breadcrumb" aria-label="breadcrumb">
        <a href="<?php echo e(route('home')); ?>"><i class="fas fa-home" aria-hidden="true"></i> Home</a>
        <span class="separator">›</span>
        <a href="<?php echo e(route('jobs')); ?>"><i class="fas fa-briefcase" aria-hidden="true"></i> Jobs</a>
        <span class="separator">›</span>
        <span class="current"><i class="fas fa-folder" aria-hidden="true"></i> <?php echo e($category->name); ?></span>
    </nav>
    
    
    <div class="category-header">
        <div class="category-header-content">
            <h1>
                <i class="fas fa-folder-open" aria-hidden="true"></i>
                <?php echo e($category->name); ?> Jobs
            </h1>
            <p class="subtitle">Explore all government job opportunities in the <?php echo e($category->name); ?> sector</p>
            
            <div class="badge-group">
                <span class="badge-modern">
                    <i class="fas fa-briefcase" aria-hidden="true"></i>
                    <?php echo e($jobs->total()); ?> Jobs Found
                </span>
                <?php
                    $activeJobsCount = $jobs->filter(function($job) {
                        $lastDate = safe_carbon($job->last_date);
                        return is_future_date($lastDate);
                    })->count();
                ?>
                <?php if($activeJobsCount > 0): ?>
                <span class="badge-modern">
                    <i class="fas fa-clock" aria-hidden="true"></i>
                    <?php echo e($activeJobsCount); ?> Active Jobs
                </span>
                <?php endif; ?>
            </div>
            
            <?php if($category->description): ?>
            <div class="description-text">
                <i class="fas fa-info-circle" aria-hidden="true"></i>
                <?php echo e($category->description); ?>

            </div>
            <?php endif; ?>
        </div>
    </div>
    
    
    <?php
        $totalJobs = $jobs->total();
        $featuredJobsCount = $jobs->where('is_featured', true)->count();
        
        $totalPosts = 0;
        foreach ($jobs as $job) {
            $postCount = is_numeric($job->total_post) ? (int)$job->total_post : 0;
            $totalPosts += $postCount;
        }
    ?>
    
    <div class="category-stats">
        <div class="stat-card-modern total">
            <div class="stat-number"><?php echo e(number_format($totalJobs)); ?></div>
            <div class="stat-label"><i class="fas fa-briefcase" aria-hidden="true"></i> Total Jobs</div>
        </div>
        <div class="stat-card-modern active">
            <div class="stat-number"><?php echo e(number_format($activeJobsCount)); ?></div>
            <div class="stat-label"><i class="fas fa-clock" aria-hidden="true"></i> Active Jobs</div>
        </div>
        <div class="stat-card-modern featured">
            <div class="stat-number"><?php echo e(number_format($featuredJobsCount)); ?></div>
            <div class="stat-label"><i class="fas fa-star" aria-hidden="true"></i> Featured Jobs</div>
        </div>
        <div class="stat-card-modern posts">
            <div class="stat-number"><?php echo e(number_format($totalPosts)); ?></div>
            <div class="stat-label"><i class="fas fa-users" aria-hidden="true"></i> Total Posts</div>
        </div>
    </div>
    
    
    <div class="row">
        <div class="col-lg-8">
            
            
            <?php if($jobs->count() > 0): ?>
            <div class="section-header-modern">
                <div>
                    <h3><i class="fas fa-list" aria-hidden="true"></i> <?php echo e($category->name); ?> Jobs</h3>
                    <div class="result-count">
                        Showing <strong><?php echo e($jobs->firstItem()); ?></strong> - <strong><?php echo e($jobs->lastItem()); ?></strong> of <strong><?php echo e(number_format($jobs->total())); ?></strong> jobs
                        <?php if(request()->has('search')): ?>
                        for "<strong><?php echo e(request('search')); ?></strong>"
                        <?php endif; ?>
                    </div>
                </div>
                <div class="sort-dropdown">
                    <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-sort" aria-hidden="true"></i> Sort By
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="<?php echo e(request()->fullUrlWithQuery(['sort' => 'latest'])); ?>"><i class="fas fa-clock" aria-hidden="true"></i> Latest First</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(request()->fullUrlWithQuery(['sort' => 'oldest'])); ?>"><i class="fas fa-history" aria-hidden="true"></i> Oldest First</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(request()->fullUrlWithQuery(['sort' => 'last_date'])); ?>"><i class="fas fa-calendar-alt" aria-hidden="true"></i> Last Date</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(request()->fullUrlWithQuery(['sort' => 'title'])); ?>"><i class="fas fa-sort-alpha-up" aria-hidden="true"></i> Title A-Z</a></li>
                    </ul>
                </div>
            </div>
            
            
            <?php $__currentLoopData = $jobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $lastDate = $job->last_date;
                if (is_string($lastDate)) {
                    $lastDate = \Carbon\Carbon::parse($lastDate);
                }
                $isExpired = $lastDate->lt(now());
                $daysLeft = $lastDate->diffInDays(now());
            ?>
            <div class="job-card-modern">
                <div class="job-card-body">
                    <div class="job-title">
                        <a href="<?php echo e(route('job.show', $job->slug)); ?>">
                            <?php echo e($job->title); ?>

                        </a>
                    </div>
                    
                    <div class="job-meta">
                        <span class="badge-modern badge-category">
                            <i class="fas fa-folder" aria-hidden="true"></i>
                            <?php echo e($job->category->name ?? 'N/A'); ?>

                        </span>
                        <?php if($job->total_post): ?>
                        <span class="badge-modern badge-posts">
                            <i class="fas fa-users" aria-hidden="true"></i>
                            <?php echo e($job->total_post); ?> Posts
                        </span>
                        <?php endif; ?>
                        <?php if($job->is_featured): ?>
                        <span class="badge-modern badge-featured">
                            <i class="fas fa-star" aria-hidden="true"></i> Featured
                        </span>
                        <?php endif; ?>
                        <?php if($isExpired): ?>
                        <span class="badge-modern badge-expired">
                            <i class="fas fa-times-circle" aria-hidden="true"></i> Expired
                        </span>
                        <?php elseif($daysLeft <= 3): ?>
                        <span class="badge-modern badge-urgent">
                            <i class="fas fa-exclamation-triangle" aria-hidden="true"></i> Urgent
                        </span>
                        <?php elseif($daysLeft <= 7): ?>
                        <span class="badge-modern badge-lastweek">
                            <i class="fas fa-clock" aria-hidden="true"></i> Last Week
                        </span>
                        <?php endif; ?>
                    </div>
                    
                    <?php if($job->short_description): ?>
                    <div class="job-description">
                        <?php echo e(Str::limit($job->short_description, 200)); ?>

                    </div>
                    <?php endif; ?>
                    
                    <div class="job-details-grid">
                        <div class="detail-item">
                            <i class="fas fa-calendar-check" aria-hidden="true"></i>
                            <strong>Start Date:</strong> 
                            <?php
                                $startDate = $job->start_date;
                                if (is_string($startDate)) {
                                    $startDate = \Carbon\Carbon::parse($startDate);
                                }
                            ?>
                            <?php echo e($startDate->format('d M Y')); ?>

                        </div>
                        <div class="detail-item">
                            <i class="fas fa-calendar-times" aria-hidden="true"></i>
                            <strong>Last Date:</strong> 
                            <span class="<?php echo e($isExpired ? 'text-danger' : 'text-success'); ?>">
                                <?php echo e($lastDate->format('d M Y')); ?>

                            </span>
                            <?php if(!$isExpired): ?>
                            <span class="text-muted">(<?php echo e($daysLeft); ?> days left)</span>
                            <?php endif; ?>
                        </div>
                        <?php if($job->qualification): ?>
                        <div class="detail-item">
                            <i class="fas fa-graduation-cap" aria-hidden="true"></i>
                            <strong>Qualification:</strong> <?php echo e(Str::limit($job->qualification, 60)); ?>

                        </div>
                        <?php endif; ?>
                        <?php if($job->job_location): ?>
                        <div class="detail-item">
                            <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                            <strong>Location:</strong> <?php echo e($job->job_location); ?>

                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <?php if($job->application_fee): ?>
                    <div class="mt-2">
                        <span class="badge-modern badge-posts">
                            <i class="fas fa-money-bill-wave" aria-hidden="true"></i>
                            Application Fee: ₹<?php echo e($job->application_fee); ?>

                        </span>
                    </div>
                    <?php endif; ?>
                </div>
                
                <div class="job-card-footer">
                    <div class="footer-meta">
                        <i class="fas fa-eye" aria-hidden="true"></i> <?php echo e($job->views ?? 0); ?> views
                        <?php if($job->created_at): ?>
                        <span class="mx-2">|</span>
                        <i class="fas fa-clock" aria-hidden="true"></i>
                        <?php
                            $createdAt = $job->created_at;
                            if (is_string($createdAt)) {
                                $createdAt = \Carbon\Carbon::parse($createdAt);
                            }
                        ?>
                        Posted: <?php echo e($createdAt->format('d M Y')); ?>

                        <?php endif; ?>
                    </div>
                    <div class="footer-actions">
                        <a href="<?php echo e(route('job.show', $job->slug)); ?>" class="btn-modern btn-primary-modern btn-sm-modern">
                            <i class="fas fa-info-circle" aria-hidden="true"></i> View Details
                        </a>
                        <?php if($job->application_link && !$isExpired): ?>
                        <a href="<?php echo e($job->application_link); ?>" target="_blank" rel="nofollow noopener noreferrer" class="btn-modern btn-success-modern btn-sm-modern">
                            <i class="fas fa-paper-plane" aria-hidden="true"></i> Apply
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            
            
            <?php if($jobs->hasPages()): ?>
            <div class="pagination-modern">
                <div class="info">
                    Showing <strong><?php echo e($jobs->firstItem()); ?></strong> to <strong><?php echo e($jobs->lastItem()); ?></strong> of <strong><?php echo e(number_format($jobs->total())); ?></strong> entries
                </div>
                <?php echo e($jobs->appends(request()->query())->links()); ?>

            </div>
            <?php endif; ?>
            
            <?php else: ?>
            
            <div class="no-results-modern">
                <i class="fas fa-inbox" aria-hidden="true"></i>
                <h4>No Jobs Found</h4>
                <p>
                    <?php if(request()->has('search')): ?>
                    No jobs found in <strong><?php echo e($category->name); ?></strong> category for "<strong><?php echo e(request('search')); ?></strong>".
                    <?php else: ?>
                    There are no active jobs in <strong><?php echo e($category->name); ?></strong> category at the moment.
                    <?php endif; ?>
                </p>
                <div class="btn-group">
                    <?php if(request()->has('search')): ?>
                    <a href="<?php echo e(route('category', $category->slug)); ?>" class="btn-modern btn-primary-modern">
                        <i class="fas fa-sync" aria-hidden="true"></i> Show All Jobs
                    </a>
                    <?php endif; ?>
                    <a href="<?php echo e(route('jobs')); ?>" class="btn-modern btn-primary-modern">
                        <i class="fas fa-briefcase" aria-hidden="true"></i> Browse All Jobs
                    </a>
                    <a href="<?php echo e(route('home')); ?>" class="btn-modern btn-outline-modern">
                        <i class="fas fa-home" aria-hidden="true"></i> Go Home
                    </a>
                </div>
            </div>
            <?php endif; ?>
            
        </div>
        
        
        <div class="col-lg-4">
            
            
            <div class="sidebar-card">
                <div class="sidebar-card-header primary">
                    <i class="fas fa-info-circle" aria-hidden="true"></i> Category Information
                </div>
                <div class="sidebar-card-body">
                    <div class="category-info-icon">
                        <i class="fas fa-folder-open" aria-hidden="true"></i>
                        <h5><?php echo e($category->name); ?></h5>
                    </div>
                    <?php if($category->description): ?>
                    <p class="text-muted small text-center"><?php echo e($category->description); ?></p>
                    <?php else: ?>
                    <p class="text-muted small text-center">No description available</p>
                    <?php endif; ?>
                    <div class="category-info-stats">
                        <div class="info-stat">
                            <div class="number"><?php echo e($jobs->total()); ?></div>
                            <div class="label">Total Jobs</div>
                        </div>
                        <div class="info-stat">
                            <div class="number"><?php echo e($activeJobsCount); ?></div>
                            <div class="label">Active Jobs</div>
                        </div>
                    </div>
                </div>
            </div>
            
            
            <div class="sidebar-card">
                <div class="sidebar-card-header info">
                    <i class="fas fa-search" aria-hidden="true"></i> Search in Category
                </div>
                <div class="sidebar-card-body">
                    <form action="<?php echo e(route('category', $category->slug)); ?>" method="GET" class="search-form-modern">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" 
                                   placeholder="Search jobs..." value="<?php echo e(request('search')); ?>">
                            <button class="btn-search" type="submit">
                                <i class="fas fa-search" aria-hidden="true"></i>
                            </button>
                        </div>
                        <?php if(request()->has('search')): ?>
                        <div class="mt-2">
                            <a href="<?php echo e(route('category', $category->slug)); ?>" class="btn-modern btn-outline-modern btn-sm-modern">
                                <i class="fas fa-times" aria-hidden="true"></i> Clear Search
                            </a>
                        </div>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
            
            
            <div class="sidebar-card">
                <div class="sidebar-card-header success">
                    <i class="fas fa-list" aria-hidden="true"></i> All Categories
                </div>
                <div class="sidebar-card-body p-0">
                    <div class="categories-list list-group list-group-flush">
                        <?php
                            $allCategories = \App\Models\Category::where('is_active', true)
                                ->withCount(['jobs' => function($query) {
                                    $query->where('is_active', true)
                                          ->where('last_date', '>=', now());
                                }])
                                ->orderBy('name')
                                ->get();
                        ?>
                        <?php $__empty_1 = true; $__currentLoopData = $allCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <a href="<?php echo e(route('category', $cat->slug)); ?>" 
                           class="list-group-item list-group-item-action d-flex justify-content-between align-items-center 
                                  <?php echo e($cat->id == $category->id ? 'active' : ''); ?>">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-folder me-3 <?php echo e($cat->id == $category->id ? 'text-white' : 'text-primary'); ?>"></i>
                                <span><?php echo e($cat->name); ?></span>
                            </div>
                            <span class="badge"><?php echo e($cat->jobs_count ?? 0); ?></span>
                        </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="text-center py-4">
                            <i class="fas fa-folder-open fa-2x text-muted mb-2" aria-hidden="true"></i>
                            <p class="text-muted mb-0">No categories found</p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            
            <?php
                $featuredCategoryJobs = \App\Models\Job::where('category_id', $category->id)
                    ->where('is_active', true)
                    ->where('is_featured', true)
                    ->where('last_date', '>=', now())
                    ->latest()
                    ->take(5)
                    ->get();
            ?>
            <?php if($featuredCategoryJobs->count() > 0): ?>
            <div class="sidebar-card">
                <div class="sidebar-card-header warning">
                    <i class="fas fa-star" aria-hidden="true"></i> Featured Jobs
                </div>
                <div class="sidebar-card-body">
                    <?php $__currentLoopData = $featuredCategoryJobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $featuredJob): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="featured-job-item">
                        <h6>
                            <a href="<?php echo e(route('job.show', $featuredJob->slug)); ?>">
                                <?php echo e(Str::limit($featuredJob->title, 45)); ?>

                            </a>
                        </h6>
                        <div class="meta">
                            <i class="fas fa-calendar-alt" aria-hidden="true"></i>
                            <?php
                                $lastDate = $featuredJob->last_date;
                                if (is_string($lastDate)) {
                                    $lastDate = \Carbon\Carbon::parse($lastDate);
                                }
                            ?>
                            <?php echo e($lastDate->format('d M Y')); ?>

                            <span class="mx-1">|</span>
                            <span class="badge-modern badge-featured" style="font-size: 0.6rem; padding: 2px 10px;">
                                <i class="fas fa-star" aria-hidden="true"></i> Featured
                            </span>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <div class="text-center mt-3">
                        <a href="<?php echo e(route('jobs')); ?>?category=<?php echo e($category->id); ?>&featured=1" class="btn-modern btn-outline-modern btn-sm-modern">
                            View All Featured <i class="fas fa-arrow-right" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            
            <div class="sidebar-card">
                <div class="sidebar-card-header primary">
                    <i class="fas fa-link" aria-hidden="true"></i> Quick Links
                </div>
                <div class="sidebar-card-body">
                    <div class="quick-links-grid">
                        <a href="<?php echo e(route('jobs')); ?>" class="btn btn-outline-primary">
                            <i class="fas fa-briefcase" aria-hidden="true"></i> All Jobs
                        </a>
                        <a href="<?php echo e(route('results')); ?>" class="btn btn-outline-success">
                            <i class="fas fa-chart-bar" aria-hidden="true"></i> Latest Results
                        </a>
                        <a href="<?php echo e(route('admit-cards')); ?>" class="btn btn-outline-warning">
                            <i class="fas fa-ticket-alt" aria-hidden="true"></i> Admit Cards
                        </a>
                        <a href="<?php echo e(route('answer-keys')); ?>" class="btn btn-outline-info">
                            <i class="fas fa-key" aria-hidden="true"></i> Answer Keys
                        </a>
                        <a href="<?php echo e(route('home')); ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-home" aria-hidden="true"></i> Home Page
                        </a>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ==========================================
    // BUTTON LOADING STATES
    // ==========================================
    document.querySelectorAll('.btn-modern').forEach(button => {
        button.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href && !href.startsWith('#') && !href.startsWith('javascript:')) {
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin" aria-hidden="true"></i> Loading...';
                this.style.opacity = '0.7';
                this.style.pointerEvents = 'none';
                
                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.style.opacity = '';
                    this.style.pointerEvents = '';
                }, 5000);
            }
        });
    });
    
    // ==========================================
    // EXTERNAL LINK INDICATOR
    // ==========================================
    document.querySelectorAll('a[target="_blank"]').forEach(link => {
        if (!link.querySelector('.fa-external-link-alt')) {
            link.innerHTML += ' <i class="fas fa-external-link-alt" style="font-size: 10px; opacity: 0.6;" aria-hidden="true"></i>';
        }
    });
    
    // ==========================================
    // TOAST NOTIFICATIONS
    // ==========================================
    window.showToast = function(message, type = 'info') {
        const colors = {
            success: 'var(--sarkari-success)',
            error: 'var(--sarkari-danger)',
            warning: 'var(--sarkari-warning)',
            info: 'var(--sarkari-info)'
        };
        
        const toast = document.createElement('div');
        toast.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            padding: 14px 24px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.12);
            border-left: 4px solid ${colors[type] || '#17a2b8'};
            font-size: 0.9rem;
            color: var(--sarkari-text);
            max-width: 400px;
            animation: slideIn 0.3s ease;
            display: flex;
            align-items: center;
            gap: 12px;
        `;
        
        const iconMap = {
            success: 'fa-check-circle',
            error: 'fa-exclamation-circle',
            warning: 'fa-exclamation-triangle',
            info: 'fa-info-circle'
        };
        
        toast.innerHTML = `
            <i class="fas ${iconMap[type] || 'fa-info-circle'}" style="color: ${colors[type] || '#17a2b8'}; font-size: 1.2rem;"></i>
            <span>${message}</span>
        `;
        
        document.body.appendChild(toast);
        
        // Add animation styles
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideIn {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
        `;
        document.head.appendChild(style);
        
        setTimeout(() => {
            if (toast.parentNode) {
                toast.style.animation = 'slideIn 0.3s ease reverse';
                setTimeout(() => {
                    if (toast.parentNode) toast.parentNode.removeChild(toast);
                }, 300);
            }
        }, 4000);
    };
    
    // ==========================================
    // BOOKMARK FUNCTIONALITY
    // ==========================================
    window.addToBookmark = function(jobId) {
        const isLoggedIn = <?php echo e(auth()->check() ? 'true' : 'false'); ?>;
        
        if (!isLoggedIn) {
            showToast('Please login to bookmark jobs', 'warning');
            return;
        }
        
        showToast('Adding to bookmarks...', 'info');
        
        fetch('/bookmarks/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ job_id: jobId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('Job added to bookmarks!', 'success');
            } else {
                showToast(data.message || 'Failed to add bookmark', 'error');
            }
        })
        .catch(() => {
            showToast('Failed to add bookmark. Please try again.', 'error');
        });
    };
    
    // ==========================================
    // SHARE FUNCTIONALITY
    // ==========================================
    window.shareJob = function(title, url) {
        if (navigator.share) {
            navigator.share({
                title: title,
                text: 'Check out this job opportunity: ' + title,
                url: url
            }).catch(() => {});
        } else {
            copyToClipboard(url);
        }
    };
    
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            showToast('Job link copied to clipboard!', 'success');
        }).catch(() => {
            const textArea = document.createElement('textarea');
            textArea.value = text;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);
            showToast('Job link copied to clipboard!', 'success');
        });
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\SARKARIMOBI\sarkariresult.mobi\resources\views/category.blade.php ENDPATH**/ ?>