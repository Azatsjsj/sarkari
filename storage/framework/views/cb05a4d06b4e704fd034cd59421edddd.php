


<?php $__env->startSection('title', 'Latest Government Jobs - Sarkari Results 2026'); ?>
<?php $__env->startSection('meta_description', 'Find latest Sarkari Naukri (Government Jobs) notifications, vacancies, and employment opportunities from various departments like SSC, UPSC, Railway, Bank, Police, and more.'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    /* ============================================
       SARKARI RESULT MODERN STYLE - JOBS INDEX
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
        --sarkari-gray: #6c757d;
        --sarkari-border: #e0e0e0;
        --sarkari-bg-light: #f8f9fa;
        --sarkari-text: #1e293b;
        --sarkari-text-muted: #64748b;
        --transition-speed: 0.25s;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        background: #f5f5f5;
        font-family: 'Inter', 'Segoe UI', Arial, Helvetica, sans-serif;
        line-height: 1.6;
        color: var(--sarkari-text);
    }
    
    /* ========== CONTAINER ========== */
    .sarkari-container {
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 15px 30px;
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    }
    
    /* ========== BREADCRUMB ========== */
    .sarkari-breadcrumb {
        background: var(--sarkari-bg-light);
        padding: 12px 18px;
        border-radius: 12px;
        margin-bottom: 20px;
        font-size: 13px;
        border: 1px solid var(--sarkari-border);
    }
    
    .sarkari-breadcrumb a {
        color: var(--sarkari-primary);
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s;
    }
    
    .sarkari-breadcrumb a:hover {
        color: var(--sarkari-primary-dark);
        text-decoration: underline;
    }
    
    .sarkari-breadcrumb .separator {
        color: #aaa;
        margin: 0 6px;
    }
    
    .sarkari-breadcrumb .current {
        color: var(--sarkari-text-muted);
    }
    
    /* ========== HEADER ========== */
    .sarkari-header {
        background: linear-gradient(135deg, var(--sarkari-primary) 0%, var(--sarkari-primary-dark) 100%);
        color: #fff;
        padding: 28px 24px;
        border-radius: 16px;
        margin-bottom: 24px;
        box-shadow: 0 4px 20px rgba(171, 24, 61, 0.25);
    }
    
    .sarkari-header h1 {
        font-size: 1.65rem;
        font-weight: 700;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .sarkari-header h1 i {
        color: #f4c542;
    }
    
    .sarkari-header p {
        font-size: 0.95rem;
        opacity: 0.9;
        max-width: 700px;
        margin: 0;
        line-height: 1.6;
    }
    
    /* ========== SEARCH BOX ========== */
    .search-box {
        background: #fff;
        border: 1px solid var(--sarkari-border);
        border-radius: 16px;
        margin-bottom: 24px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
    }
    
    .search-title {
        background: var(--sarkari-primary);
        color: #fff;
        padding: 14px 20px;
        font-size: 1rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .search-box form {
        padding: 20px;
    }
    
    .filter-group {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        align-items: flex-end;
    }
    
    .filter-input {
        flex: 2;
        min-width: 200px;
    }
    
    .filter-select {
        flex: 1;
        min-width: 150px;
    }
    
    .filter-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }
    
    .form-control {
        width: 100%;
        padding: 10px 14px;
        border: 2px solid #e9ecef;
        border-radius: 10px;
        font-size: 0.9rem;
        transition: all var(--transition-speed);
        background: #fff;
    }
    
    .form-control:focus {
        outline: none;
        border-color: var(--sarkari-primary);
        box-shadow: 0 0 0 3px rgba(171, 24, 61, 0.1);
    }
    
    .form-control::placeholder {
        color: #adb5bd;
    }
    
    .btn-primary-modern {
        background: var(--sarkari-primary);
        color: #fff;
        padding: 10px 22px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        font-size: 0.9rem;
        font-weight: 600;
        transition: all var(--transition-speed);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-primary-modern:hover {
        background: var(--sarkari-primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(171, 24, 61, 0.3);
    }
    
    .btn-secondary-modern {
        background: var(--sarkari-gray);
        color: #fff;
        padding: 10px 18px;
        border-radius: 10px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 0.9rem;
        font-weight: 600;
        transition: all var(--transition-speed);
        border: none;
        cursor: pointer;
    }
    
    .btn-secondary-modern:hover {
        background: #5a6268;
        color: #fff;
        transform: translateY(-2px);
    }
    
    /* ========== STATS ROW ========== */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 24px;
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
    
    .stat-card-modern.total .stat-number { color: var(--sarkari-success); }
    .stat-card-modern.active .stat-number { color: var(--sarkari-info); }
    .stat-card-modern.featured .stat-number { color: #b5835a; }
    .stat-card-modern.expiring .stat-number { color: var(--sarkari-danger); }
    
    /* ========== SECTION BOX ========== */
    .section-box {
        background: #fff;
        border: 1px solid var(--sarkari-border);
        border-radius: 16px;
        margin-bottom: 24px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
    }
    
    .section-header {
        background: var(--sarkari-primary);
        color: #fff;
        padding: 14px 20px;
        font-size: 1.1rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
    }
    
    .section-header i {
        margin-right: 8px;
        color: #f4c542;
    }
    
    .badge-count {
        font-size: 0.75rem;
        background: rgba(255,255,255,0.2);
        padding: 4px 12px;
        border-radius: 40px;
        font-weight: 600;
    }
    
    .section-content {
        padding: 20px;
    }
    
    .section-content.p-0 {
        padding: 0;
    }
    
    /* ========== FEATURED GRID ========== */
    .featured-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }
    
    .featured-card {
        border: 1px solid var(--sarkari-border);
        border-radius: 12px;
        border-left: 4px solid #b5835a;
        padding: 16px 18px;
        transition: all var(--transition-speed);
        background: #fff;
    }
    
    .featured-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
        border-color: var(--sarkari-primary);
    }
    
    .featured-card .job-title {
        font-size: 0.95rem;
        font-weight: 600;
        margin-bottom: 6px;
    }
    
    .featured-card .job-title a {
        color: var(--sarkari-text);
        text-decoration: none;
        transition: color 0.2s;
    }
    
    .featured-card .job-title a:hover {
        color: var(--sarkari-primary);
    }
    
    /* ========== JOB LIST ITEM ========== */
    .job-item {
        border-bottom: 1px solid #f1f5f9;
        padding: 16px 20px;
        transition: all var(--transition-speed);
    }
    
    .job-item:last-child {
        border-bottom: none;
    }
    
    .job-item:hover {
        background: var(--sarkari-primary-light);
    }
    
    .job-row {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
    }
    
    .job-info {
        flex: 2;
        min-width: 220px;
    }
    
    .job-actions {
        flex: 1;
        min-width: 160px;
        text-align: right;
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 6px;
    }
    
    .job-title {
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 6px;
    }
    
    .job-title a {
        color: var(--sarkari-text);
        text-decoration: none;
        transition: color 0.2s;
    }
    
    .job-title a:hover {
        color: var(--sarkari-primary);
        text-decoration: underline;
    }
    
    .job-meta {
        font-size: 0.8rem;
        color: var(--sarkari-text-muted);
        margin-bottom: 6px;
        display: flex;
        flex-wrap: wrap;
        gap: 12px 18px;
    }
    
    .job-meta i {
        margin-right: 4px;
        width: 16px;
        color: var(--sarkari-primary);
    }
    
    .job-desc {
        font-size: 0.85rem;
        color: var(--sarkari-text);
        margin-bottom: 8px;
        line-height: 1.5;
    }
    
    /* ========== BADGES ========== */
    .badge-modern {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 0.68rem;
        padding: 3px 12px;
        border-radius: 40px;
        font-weight: 600;
        letter-spacing: 0.3px;
    }
    
    .badge-featured {
        background: #fef3c7;
        color: #92400e;
    }
    
    .badge-expired {
        background: #fee2e2;
        color: #991b1b;
    }
    
    .badge-urgent {
        background: #fed7aa;
        color: #9a3412;
    }
    
    .badge-category {
        background: #e9ecef;
        color: #495057;
    }
    
    .badge-new {
        background: #dcfce7;
        color: #166534;
    }
    
    /* ========== LINKS ========== */
    .apply-link, .view-link {
        font-weight: 600;
        text-decoration: none;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 8px;
        transition: all var(--transition-speed);
    }
    
    .apply-link {
        color: #fff;
        background: var(--sarkari-success);
    }
    
    .apply-link:hover {
        background: #1e7e34;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
    }
    
    .view-link {
        color: var(--sarkari-primary);
        background: var(--sarkari-primary-light);
    }
    
    .view-link:hover {
        background: var(--sarkari-primary);
        color: #fff;
        transform: translateY(-2px);
    }
    
    .text-success { color: var(--sarkari-success); }
    .text-danger { color: var(--sarkari-danger); }
    
    /* ========== CATEGORIES GRID ========== */
    .categories-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 12px;
    }
    
    .category-item {
        text-align: center;
        padding: 14px 10px;
        border: 2px solid var(--sarkari-border);
        border-radius: 12px;
        text-decoration: none;
        transition: all var(--transition-speed);
        background: #fff;
    }
    
    .category-item:hover {
        background: var(--sarkari-primary);
        border-color: var(--sarkari-primary);
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(171, 24, 61, 0.15);
    }
    
    .category-item:hover .cat-name,
    .category-item:hover .cat-count {
        color: #fff;
    }
    
    .category-item:hover .cat-icon {
        color: #f4c542;
    }
    
    .cat-icon {
        font-size: 1.8rem;
        color: var(--sarkari-primary);
        margin-bottom: 6px;
        transition: color 0.2s;
    }
    
    .cat-name {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--sarkari-text);
        margin-bottom: 4px;
    }
    
    .cat-count {
        font-size: 0.7rem;
        color: var(--sarkari-text-muted);
    }
    
    /* ========== PAGINATION ========== */
    .pagination-container {
        padding: 16px 20px;
        border-top: 1px solid var(--sarkari-border);
        background: var(--sarkari-bg-light);
    }
    
    .pagination {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 6px;
        margin: 0;
        padding: 0;
    }
    
    .pagination .page-item {
        list-style: none;
    }
    
    .pagination .page-link {
        display: block;
        padding: 8px 14px;
        background: #fff;
        border: 1px solid var(--sarkari-border);
        color: var(--sarkari-primary);
        text-decoration: none;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 500;
        transition: all var(--transition-speed);
    }
    
    .pagination .page-link:hover {
        background: var(--sarkari-primary);
        color: #fff;
        border-color: var(--sarkari-primary);
        transform: translateY(-2px);
    }
    
    .pagination .active .page-link {
        background: var(--sarkari-primary);
        color: #fff;
        border-color: var(--sarkari-primary);
    }
    
    .pagination .disabled .page-link {
        color: #999;
        cursor: not-allowed;
        transform: none;
    }
    
    /* ========== INFO TEXT ========== */
    .info-text {
        background: #fef9f2;
        border-left: 4px solid #b5835a;
        padding: 14px 18px;
        font-size: 0.85rem;
        border-radius: 10px;
        color: #78350f;
        margin-top: 4px;
    }
    
    .info-text i {
        color: #b5835a;
    }
    
    /* ========== NO RESULTS ========== */
    .no-results {
        text-align: center;
        padding: 50px 20px;
    }
    
    .no-results i {
        font-size: 3.5rem;
        color: #d1d5db;
        margin-bottom: 16px;
    }
    
    .no-results h4 {
        font-size: 1.2rem;
        margin-bottom: 8px;
        color: var(--sarkari-text);
    }
    
    .no-results p {
        color: var(--sarkari-text-muted);
        max-width: 500px;
        margin: 0 auto 16px;
    }
    
    /* ========== STATS INFO ========== */
    .stats-info {
        background: var(--sarkari-bg-light);
        padding: 10px 20px;
        border-bottom: 1px solid var(--sarkari-border);
        font-size: 0.85rem;
        color: var(--sarkari-text-muted);
    }
    
    .stats-info i {
        color: var(--sarkari-primary);
        margin-right: 6px;
    }
    
    /* ========== RESPONSIVE ========== */
    @media (max-width: 992px) {
        .stats-row {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .featured-grid {
            grid-template-columns: 1fr;
        }
    }
    
    @media (max-width: 768px) {
        .sarkari-container {
            padding: 0 10px 20px;
            border-radius: 12px;
        }
        
        .sarkari-header {
            padding: 20px 16px;
        }
        
        .sarkari-header h1 {
            font-size: 1.25rem;
        }
        
        .sarkari-header p {
            font-size: 0.85rem;
        }
        
        .stat-number {
            font-size: 1.4rem;
        }
        
        .job-row {
            flex-direction: column;
        }
        
        .job-actions {
            text-align: left;
            align-items: flex-start;
            width: 100%;
        }
        
        .section-header {
            font-size: 0.95rem;
            padding: 12px 16px;
        }
        
        .filter-group {
            flex-direction: column;
        }
        
        .filter-input, .filter-select {
            width: 100%;
        }
        
        .filter-actions {
            width: 100%;
        }
        
        .filter-actions .btn-primary-modern,
        .filter-actions .btn-secondary-modern {
            flex: 1;
            justify-content: center;
        }
        
        .categories-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    
    @media (max-width: 480px) {
        .stats-row {
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }
        
        .stat-card-modern {
            padding: 12px 8px;
        }
        
        .stat-number {
            font-size: 1.2rem;
        }
        
        .job-meta {
            font-size: 0.7rem;
            gap: 6px 10px;
        }
        
        .job-title {
            font-size: 0.88rem;
        }
        
        .job-item {
            padding: 12px 14px;
        }
        
        .categories-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
        }
        
        .category-item {
            padding: 10px 6px;
        }
        
        .cat-icon {
            font-size: 1.4rem;
        }
        
        .cat-name {
            font-size: 0.75rem;
        }
    }
    
    /* ========== ACCESSIBILITY ========== */
    @media (prefers-reduced-motion: reduce) {
        * {
            transition: none !important;
            animation: none !important;
        }
    }
    
    .sr-only {
        position: absolute;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        border: 0;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="sarkari-container">
    
    
    <nav class="sarkari-breadcrumb" aria-label="breadcrumb">
        <a href="<?php echo e(route('home')); ?>"><i class="fas fa-home" aria-hidden="true"></i> Home</a>
        <span class="separator">›</span>
        <span class="current">Latest Jobs</span>
    </nav>
    
    
    <div class="sarkari-header">
        <h1>
            <i class="fas fa-briefcase" aria-hidden="true"></i>
            Latest Government Jobs - Sarkari Result 2026
        </h1>
        <p>Find all the latest Sarkari Naukri notifications, vacancies, and employment opportunities from various departments including SSC, UPSC, Railway, Bank, Police, and more.</p>
    </div>
    
    
    <div class="search-box">
        <div class="search-title">
            <i class="fas fa-search" aria-hidden="true"></i> Search / Filter Jobs
        </div>
        <form action="<?php echo e(route('jobs')); ?>" method="GET" role="search" aria-label="Filter jobs">
            <div class="filter-group">
                <div class="filter-input">
                    <input type="text" 
                           name="search" 
                           class="form-control" 
                           placeholder="Search by job title, qualification, or keywords..."
                           value="<?php echo e(request('search')); ?>"
                           aria-label="Search jobs by keyword">
                </div>
                <div class="filter-select">
                    <select name="category" class="form-control" aria-label="Filter by job category">
                        <option value="">All Categories</option>
                        <?php $__currentLoopData = $categories ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($category->id); ?>" 
                                <?php echo e(request('category') == $category->id ? 'selected' : ''); ?>>
                                <?php echo e($category->name); ?> (<?php echo e($category->jobs_count ?? $category->jobs->count() ?? 0); ?>)
                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="filter-actions">
                    <button type="submit" class="btn-primary-modern">
                        <i class="fas fa-filter" aria-hidden="true"></i> Filter
                    </button>
                    <?php if(request()->hasAny(['search', 'category'])): ?>
                    <a href="<?php echo e(route('jobs')); ?>" class="btn-secondary-modern">
                        <i class="fas fa-times" aria-hidden="true"></i> Reset
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </form>
    </div>
    
    
    <div class="stats-row">
        <div class="stat-card-modern total">
            <div class="stat-number"><?php echo e(number_format($totalJobs ?? 0)); ?></div>
            <div class="stat-label"><i class="fas fa-briefcase" aria-hidden="true"></i> Total Jobs</div>
        </div>
        <div class="stat-card-modern active">
            <div class="stat-number"><?php echo e(number_format($activeJobs ?? 0)); ?></div>
            <div class="stat-label"><i class="fas fa-clock" aria-hidden="true"></i> Active Jobs</div>
        </div>
        <div class="stat-card-modern featured">
            <div class="stat-number"><?php echo e(number_format($featuredJobs ?? 0)); ?></div>
            <div class="stat-label"><i class="fas fa-star" aria-hidden="true"></i> Featured Jobs</div>
        </div>
        <div class="stat-card-modern expiring">
            <div class="stat-number"><?php echo e(number_format($expiringSoon ?? 0)); ?></div>
            <div class="stat-label"><i class="fas fa-hourglass-end" aria-hidden="true"></i> Expiring Soon</div>
        </div>
    </div>
    
    
    <?php if(isset($featuredJobsList) && $featuredJobsList->isNotEmpty()): ?>
    <div class="section-box">
        <div class="section-header">
            <span><i class="fas fa-star" aria-hidden="true"></i> Featured Jobs</span>
            <span class="badge-count"><?php echo e($featuredJobsList->count()); ?> Jobs</span>
        </div>
        <div class="section-content">
            <div class="featured-grid">
                <?php $__currentLoopData = $featuredJobsList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $lastDate = isset($job->last_date) ? ($job->last_date instanceof \Carbon\Carbon ? $job->last_date : \Carbon\Carbon::parse($job->last_date)) : now();
                    $isExpired = $lastDate->isPast();
                    $isUrgent = !$isExpired && $lastDate->diffInDays(now()) <= 3;
                ?>
                <div class="featured-card">
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 8px; flex-wrap: wrap; gap: 5px;">
                        <span class="badge-modern badge-featured"><i class="fas fa-star" aria-hidden="true"></i> Featured</span>
                        <?php if($isExpired): ?>
                            <span class="badge-modern badge-expired"><i class="fas fa-times-circle" aria-hidden="true"></i> Expired</span>
                        <?php elseif($isUrgent): ?>
                            <span class="badge-modern badge-urgent"><i class="fas fa-exclamation-triangle" aria-hidden="true"></i> Urgent</span>
                        <?php endif; ?>
                    </div>
                    <div class="job-title">
                        <a href="<?php echo e(route('job.show', $job->slug ?? $job->id)); ?>"><?php echo e(\Illuminate\Support\Str::limit($job->title, 55)); ?></a>
                    </div>
                    <div class="job-meta">
                        <span><i class="fas fa-building" aria-hidden="true"></i> <?php echo e($job->category->name ?? 'N/A'); ?></span>
                        <span><i class="fas fa-users" aria-hidden="true"></i> <?php echo e($job->total_post ?? 'N/A'); ?> Posts</span>
                        <span><i class="fas fa-calendar-alt" aria-hidden="true"></i> Last: <?php echo e($lastDate->format('d M Y')); ?></span>
                    </div>
                    <?php if(!empty($job->short_description)): ?>
                    <div class="job-desc">
                        <?php echo e(\Illuminate\Support\Str::limit($job->short_description, 80)); ?>

                    </div>
                    <?php endif; ?>
                    <div style="margin-top: 10px; display: flex; gap: 10px; flex-wrap: wrap;">
                        <a href="<?php echo e(route('job.show', $job->slug ?? $job->id)); ?>" class="view-link">
                            <i class="fas fa-eye" aria-hidden="true"></i> View Details
                        </a>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    
    <div class="section-box">
        <div class="section-header">
            <span><i class="fas fa-list" aria-hidden="true"></i> All Government Jobs</span>
            <?php if(request()->hasAny(['search', 'category'])): ?>
                <span class="badge-count">Filtered Results</span>
            <?php endif; ?>
        </div>
        <div class="section-content p-0">
            
            <?php if(isset($jobs) && $jobs->isNotEmpty()): ?>
            <div class="stats-info">
                <i class="fas fa-info-circle" aria-hidden="true"></i> 
                Showing <strong><?php echo e($jobs->firstItem()); ?></strong> - <strong><?php echo e($jobs->lastItem()); ?></strong> of <strong><?php echo e(number_format($jobs->total())); ?></strong> jobs
            </div>
            <?php endif; ?>
            
            <?php $__empty_1 = true; $__currentLoopData = $jobs ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
                $startDate = isset($job->start_date) ? ($job->start_date instanceof \Carbon\Carbon ? $job->start_date : \Carbon\Carbon::parse($job->start_date)) : now();
                $lastDate = isset($job->last_date) ? ($job->last_date instanceof \Carbon\Carbon ? $job->last_date : \Carbon\Carbon::parse($job->last_date)) : now();
                $isExpired = $lastDate->isPast();
                $isUrgent = !$isExpired && $lastDate->diffInDays(now()) <= 3;
                $isNew = $startDate->diffInDays(now()) <= 3;
            ?>
            <div class="job-item">
                <div class="job-row">
                    <div class="job-info">
                        <div class="job-title">
                            <a href="<?php echo e(route('job.show', $job->slug ?? $job->id)); ?>">
                                <?php echo e($job->title); ?>

                            </a>
                            <div style="display: flex; flex-wrap: wrap; gap: 4px; margin-top: 4px;">
                                <?php if(!empty($job->is_featured)): ?>
                                    <span class="badge-modern badge-featured"><i class="fas fa-star" aria-hidden="true"></i> Featured</span>
                                <?php endif; ?>
                                <?php if($isNew && !$isExpired): ?>
                                    <span class="badge-modern badge-new"><i class="fas fa-clock" aria-hidden="true"></i> New</span>
                                <?php endif; ?>
                                <?php if($isExpired): ?>
                                    <span class="badge-modern badge-expired"><i class="fas fa-times-circle" aria-hidden="true"></i> Expired</span>
                                <?php elseif($isUrgent): ?>
                                    <span class="badge-modern badge-urgent"><i class="fas fa-exclamation-triangle" aria-hidden="true"></i> Urgent</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="job-meta">
                            <span><i class="fas fa-building" aria-hidden="true"></i> <?php echo e($job->category->name ?? 'N/A'); ?></span>
                            <span><i class="fas fa-users" aria-hidden="true"></i> <?php echo e($job->total_post ?? 'N/A'); ?> Posts</span>
                            <span><i class="fas fa-calendar-check" aria-hidden="true"></i> Start: <?php echo e($startDate->format('d M Y')); ?></span>
                            <span><i class="fas fa-calendar-times" aria-hidden="true"></i> Last: 
                                <span class="<?php echo e($isExpired ? 'text-danger' : 'text-success'); ?>">
                                    <?php echo e($lastDate->format('d M Y')); ?>

                                </span>
                            </span>
                        </div>
                        <?php if(!empty($job->short_description)): ?>
                        <div class="job-desc">
                            <?php echo e(\Illuminate\Support\Str::limit($job->short_description, 120)); ?>

                        </div>
                        <?php endif; ?>
                        <?php if(!empty($job->qualification)): ?>
                        <div class="job-meta">
                            <span><i class="fas fa-graduation-cap" aria-hidden="true"></i> Qualification: <?php echo e(\Illuminate\Support\Str::limit($job->qualification, 140)); ?></span>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="job-actions">
                        <a href="<?php echo e(route('job.show', $job->slug ?? $job->id)); ?>" class="view-link">
                            <i class="fas fa-info-circle" aria-hidden="true"></i> Details
                        </a>
                        <?php if(!empty($job->application_link) && !$isExpired): ?>
                            <a href="<?php echo e($job->application_link); ?>" target="_blank" rel="nofollow noopener noreferrer" class="apply-link">
                                <i class="fas fa-paper-plane" aria-hidden="true"></i> Apply Now
                            </a>
                        <?php endif; ?>
                        <?php if(!empty($job->application_fee)): ?>
                            <span class="badge-modern badge-category" style="margin-top: 4px;">
                                <i class="fas fa-money-bill" aria-hidden="true"></i> Fee: <?php echo e($job->application_fee); ?>

                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="no-results">
                <i class="fas fa-inbox" aria-hidden="true"></i>
                <h4>No Jobs Found</h4>
                <p>
                    <?php if(request()->hasAny(['search', 'category'])): ?>
                        No jobs found for your search criteria. Try different keywords or browse all jobs.
                    <?php else: ?>
                        There are no active job openings at the moment. Please check back later.
                    <?php endif; ?>
                </p>
                <a href="<?php echo e(route('jobs')); ?>" class="btn-primary-modern" style="display: inline-block;">
                    <i class="fas fa-sync" aria-hidden="true"></i> Reset Filters
                </a>
            </div>
            <?php endif; ?>
            
            
            <?php if(isset($jobs) && method_exists($jobs, 'links') && $jobs->hasPages()): ?>
            <div class="pagination-container">
                <?php echo e($jobs->links()); ?>

            </div>
            <?php endif; ?>
        </div>
    </div>
    
    
    <?php if(isset($categories) && $categories->isNotEmpty()): ?>
    <div class="section-box">
        <div class="section-header">
            <span><i class="fas fa-tags" aria-hidden="true"></i> Browse Jobs by Category</span>
            <span class="badge-count"><?php echo e($categories->count()); ?> Categories</span>
        </div>
        <div class="section-content">
            <div class="categories-grid">
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('category', $category->slug ?? $category->id)); ?>" class="category-item">
                    <div class="cat-icon">
                        <i class="fas fa-folder-open" aria-hidden="true"></i>
                    </div>
                    <div class="cat-name"><?php echo e(\Illuminate\Support\Str::limit($category->name, 20)); ?></div>
                    <div class="cat-count"><?php echo e(number_format($category->jobs_count ?? $category->jobs->count() ?? 0)); ?> Jobs</div>
                </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    
    <div class="info-text" role="note">
        <i class="fas fa-info-circle" aria-hidden="true"></i> 
        <strong>Note:</strong> Always check the official notification before applying. SarkariResult.Mobi provides information for reference purposes only.
    </div>
    
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ==========================================
    // SEARCH FORM - PREVENT EMPTY SUBMISSION
    // ==========================================
    const searchForm = document.querySelector('.search-box form');
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            const searchInput = this.querySelector('input[name="search"]');
            if (searchInput && searchInput.value.trim() === '') {
                // Remove empty search parameter
                const categorySelect = this.querySelector('select[name="category"]');
                if (categorySelect && categorySelect.value) {
                    // Still submit if category is selected
                    return true;
                }
                // Prevent empty search
                e.preventDefault();
                // Redirect to jobs page without params
                window.location.href = '<?php echo e(route("jobs")); ?>';
            }
        });
    }
    
    // ==========================================
    // LOADING STATE ON BUTTONS
    // ==========================================
    document.querySelectorAll('.apply-link, .view-link').forEach(function(link) {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href && href.startsWith('http') && !href.includes(window.location.hostname)) {
                // External link - show loading state
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin" aria-hidden="true"></i> Loading...';
                this.style.opacity = '0.7';
                this.style.pointerEvents = 'none';
                
                setTimeout(function() {
                    link.innerHTML = originalText;
                    link.style.opacity = '';
                    link.style.pointerEvents = '';
                }, 3000);
            }
        });
    });
    
    // ==========================================
    // EXTERNAL LINK INDICATOR
    // ==========================================
    document.querySelectorAll('.job-actions a[target="_blank"]').forEach(function(link) {
        if (!link.querySelector('.fa-external-link-alt')) {
            link.innerHTML += ' <i class="fas fa-external-link-alt" style="font-size: 10px; opacity: 0.7;" aria-hidden="true"></i>';
        }
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\SARKARIMOBI\sarkariresult.mobi\resources\views/jobs/index.blade.php ENDPATH**/ ?>