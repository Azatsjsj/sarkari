


<?php $__env->startSection('title', 'Latest Results - Sarkari Result 2026, SarkariResult.mobi'); ?>
<?php $__env->startSection('meta_description', 'Check all the latest Sarkari Result updates, exam results, and recruitment outcomes from various government departments including SSC, UPSC, Railway, Bank, Police, and more.'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    /* Sarkari Result Original Style */
    body {
        background: #f5f5f5;
        font-family: Arial, Helvetica, sans-serif;
    }
    
    .sarkari-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 15px;
    }
    
    /* Header Section */
    .sarkari-header {
        background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
        color: #fff;
        padding: 25px 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        text-align: center;
    }
    
    .sarkari-header h1 {
        font-size: 24px;
        margin-bottom: 10px;
    }
    
    .sarkari-header p {
        font-size: 14px;
        margin-bottom: 0;
        opacity: 0.9;
    }
    
    /* Breadcrumb */
    .sarkari-breadcrumb {
        background: #fff;
        padding: 10px 15px;
        border-radius: 5px;
        margin-bottom: 20px;
        border: 1px solid #e0e0e0;
        font-size: 12px;
    }
    
    .sarkari-breadcrumb a {
        color: #28a745;
        text-decoration: none;
    }
    
    .sarkari-breadcrumb a:hover {
        text-decoration: underline;
    }
    
    /* Search Box */
    .search-box {
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
    }
    
    .search-title {
        background: #28a745;
        color: #fff;
        padding: 10px 15px;
        margin: -20px -20px 20px -20px;
        border-radius: 8px 8px 0 0;
        font-size: 16px;
        font-weight: bold;
    }
    
    /* Stats Row */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        margin-bottom: 20px;
    }
    
    .stat-card {
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        text-align: center;
        padding: 15px;
        transition: all 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    
    .stat-number {
        font-size: 28px;
        font-weight: bold;
        margin-bottom: 5px;
        color: #28a745;
    }
    
    .stat-label {
        font-size: 12px;
        color: #666;
    }
    
    /* Section Box */
    .section-box {
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        margin-bottom: 20px;
        overflow: hidden;
    }
    
    .section-header {
        background: #28a745;
        color: #fff;
        padding: 12px 20px;
        font-size: 18px;
        font-weight: bold;
    }
    
    .section-header i {
        margin-right: 10px;
    }
    
    .section-content {
        padding: 20px;
    }
    
    /* Result Item */
    .result-item {
        border-bottom: 1px solid #e0e0e0;
        padding: 15px;
        transition: all 0.2s ease;
    }
    
    .result-item:last-child {
        border-bottom: none;
    }
    
    .result-item:hover {
        background: #f8f9fa;
    }
    
    .result-title {
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 8px;
    }
    
    .result-title a {
        color: #333;
        text-decoration: none;
    }
    
    .result-title a:hover {
        color: #28a745;
        text-decoration: underline;
    }
    
    .result-meta {
        font-size: 12px;
        color: #666;
        margin-bottom: 8px;
    }
    
    .result-meta i {
        margin-right: 5px;
    }
    
    .result-meta span {
        margin-right: 15px;
    }
    
    .result-desc {
        font-size: 13px;
        color: #555;
        margin-bottom: 10px;
    }
    
    /* Badges */
    .badge-upcoming {
        background: #ffc107;
        color: #000;
        font-size: 10px;
        padding: 2px 6px;
        border-radius: 4px;
        margin-left: 8px;
        display: inline-block;
    }
    
    .badge-category {
        background: #6c757d;
        color: #fff;
        font-size: 10px;
        padding: 2px 6px;
        border-radius: 4px;
        margin-right: 5px;
    }
    
    .badge-new {
        background: #28a745;
        color: #fff;
        font-size: 10px;
        padding: 2px 6px;
        border-radius: 4px;
        margin-left: 8px;
        display: inline-block;
    }
    
    /* Result Buttons */
    .result-link {
        color: #28a745;
        font-weight: bold;
        text-decoration: none;
        font-size: 13px;
    }
    
    .result-link:hover {
        text-decoration: underline;
    }
    
    .download-link {
        color: #007bff;
        font-weight: bold;
        text-decoration: none;
        font-size: 13px;
    }
    
    /* Sidebar */
    .sidebar-box {
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        margin-bottom: 20px;
        overflow: hidden;
    }
    
    .sidebar-header {
        background: #28a745;
        color: #fff;
        padding: 10px 15px;
        font-size: 16px;
        font-weight: bold;
    }
    
    .sidebar-content {
        padding: 15px;
    }
    
    .recent-item {
        border-bottom: 1px solid #e0e0e0;
        padding: 10px 0;
    }
    
    .recent-item:last-child {
        border-bottom: none;
    }
    
    .recent-title {
        font-size: 13px;
        font-weight: 500;
        margin-bottom: 5px;
    }
    
    .recent-title a {
        color: #333;
        text-decoration: none;
    }
    
    .recent-title a:hover {
        color: #28a745;
    }
    
    .recent-date {
        font-size: 11px;
        color: #888;
    }
    
    /* Category List */
    .category-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .category-list li {
        border-bottom: 1px solid #e0e0e0;
    }
    
    .category-list li:last-child {
        border-bottom: none;
    }
    
    .category-list a {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        text-decoration: none;
        color: #333;
        font-size: 13px;
    }
    
    .category-list a:hover {
        color: #28a745;
    }
    
    .category-count {
        background: #28a745;
        color: #fff;
        padding: 2px 6px;
        border-radius: 20px;
        font-size: 11px;
    }
    
    /* Notice Box */
    .notice-box {
        background: #fff3cd;
        border-left: 4px solid #ffc107;
        padding: 15px;
        margin-top: 20px;
        font-size: 12px;
    }
    
    .notice-box ul {
        margin: 10px 0 0 20px;
    }
    
    /* Pagination */
    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 20px;
        gap: 5px;
    }
    
    .pagination .page-item {
        list-style: none;
    }
    
    .pagination .page-link {
        display: block;
        padding: 8px 12px;
        background: #fff;
        border: 1px solid #e0e0e0;
        color: #28a745;
        text-decoration: none;
        border-radius: 4px;
        font-size: 13px;
    }
    
    .pagination .page-link:hover {
        background: #28a745;
        color: #fff;
        border-color: #28a745;
    }
    
    .pagination .active .page-link {
        background: #28a745;
        color: #fff;
        border-color: #28a745;
    }
    
    /* No Results */
    .no-results {
        text-align: center;
        padding: 50px 20px;
    }
    
    .no-results i {
        font-size: 48px;
        color: #ccc;
        margin-bottom: 15px;
    }
    
    /* Form Control */
    .form-control {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 14px;
    }
    
    /* Button Styles */
    .btn {
        display: inline-block;
        font-weight: 400;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        user-select: none;
        border: 1px solid transparent;
        padding: 10px 20px;
        font-size: 14px;
        line-height: 1.5;
        border-radius: 5px;
        cursor: pointer;
    }
    
    .btn-primary {
        background: #28a745;
        color: #fff;
    }
    
    .btn-secondary {
        background: #6c757d;
        color: #fff;
    }
    
    /* Mobile Responsive */
    @media (max-width: 992px) {
        .stats-row {
            grid-template-columns: repeat(3, 1fr);
        }
    }
    
    @media (max-width: 768px) {
        .sarkari-header h1 {
            font-size: 18px;
        }
        
        .sarkari-header p {
            font-size: 12px;
        }
        
        .stat-number {
            font-size: 22px;
        }
        
        .stat-label {
            font-size: 10px;
        }
        
        .result-title {
            font-size: 14px;
        }
        
        .result-meta span {
            display: block;
            margin-bottom: 5px;
        }
        
        .result-item .row {
            flex-direction: column;
        }
        
        .result-item .text-end {
            text-align: left !important;
            margin-top: 10px;
        }
        
        .section-header {
            font-size: 16px;
        }
    }
    
    @media (max-width: 576px) {
        .stats-row {
            grid-template-columns: 1fr;
            gap: 10px;
        }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="sarkari-container">
    
    <!-- Breadcrumb -->
    <div class="sarkari-breadcrumb">
        <a href="<?php echo e(route('home')); ?>"><i class="fas fa-home"></i> Home</a> &gt;
        <span>Results</span>
    </div>
    
    <!-- Header -->
    <div class="sarkari-header">
        <h1><i class="fas fa-chart-bar"></i> Latest Results - Sarkari Result 2026</h1>
        <p>Check all the latest Sarkari Result updates, exam results, and recruitment outcomes from various government departments including SSC, UPSC, Railway, Bank, Police, and more.</p>
    </div>
    
    <!-- Search Box -->
    <div class="search-box">
        <div class="search-title">
            <i class="fas fa-search"></i> Search Results
        </div>
        <form action="<?php echo e(route('results')); ?>" method="GET">
            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <div style="flex: 3; min-width: 200px;">
                    <input type="text" name="search" class="form-control" 
                           placeholder="Search results by title, exam name, or keywords..."
                           value="<?php echo e(request('search')); ?>">
                </div>
                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Search
                    </button>
                    <?php if(request()->has('search')): ?>
                    <a href="<?php echo e(route('results')); ?>" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Reset
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </form>
    </div>
    
    <!-- Quick Stats -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-number"><?php echo e($results->total() ?? 0); ?></div>
            <div class="stat-label">Total Results</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?php echo e($recentCount ?? 0); ?></div>
            <div class="stat-label">Recent Results</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?php echo e($upcomingCount ?? 0); ?></div>
            <div class="stat-label">Upcoming Results</div>
        </div>
    </div>
    
    <div class="row" style="display: flex; gap: 20px; flex-wrap: wrap;">
        
        <!-- Main Content - Results List -->
        <div style="flex: 2.5; min-width: 280px;">
            
            <?php if(isset($results) && $results->count() > 0): ?>
            <div class="section-box">
                <div class="section-header">
                    <i class="fas fa-list"></i> All Results
                    <?php if(request()->has('search')): ?>
                    <span style="font-size: 12px; background: rgba(255,255,255,0.2); padding: 2px 8px; border-radius: 20px; margin-left: 10px;">
                        Search: "<?php echo e(request('search')); ?>"
                    </span>
                    <?php endif; ?>
                </div>
                <div class="section-content" style="padding: 0;">
                    
                    <div style="padding: 10px 15px; background: #f8f9fa; border-bottom: 1px solid #e0e0e0; font-size: 13px;">
                        <i class="fas fa-info-circle"></i> Showing <?php echo e($results->firstItem()); ?> - <?php echo e($results->lastItem()); ?> of <?php echo e($results->total()); ?> results
                    </div>
                    
                    <?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="result-item">
                        <div style="display: flex; flex-wrap: wrap; justify-content: space-between;">
                            <div style="flex: 2; min-width: 200px;">
                                <div class="result-title">
                                    <a href="<?php echo e(route('results.show', $result->slug ?? $result->id)); ?>">
                                        <?php echo e($result->title ?? 'Untitled Result'); ?>

                                    </a>
                                    <?php
                                        $resultDate = safe_carbon($result->result_date ?? null);
                                        $isUpcoming = is_future_date($resultDate);
                                        $isRecent = $resultDate && $resultDate->diffInDays(now()) <= 7 && !$isUpcoming;
                                    ?>
                                    <?php if($isUpcoming): ?>
                                    <span class="badge-upcoming"><i class="fas fa-clock"></i> Upcoming</span>
                                    <?php endif; ?>
                                    <?php if($isRecent): ?>
                                    <span class="badge-new"><i class="fas fa-newspaper"></i> New</span>
                                    <?php endif; ?>
                                </div>
                                <div class="result-meta">
                                    <?php if(isset($result->job) && $result->job && isset($result->job->category)): ?>
                                    <span><i class="fas fa-building"></i> <?php echo e($result->job->category->name); ?></span>
                                    <?php endif; ?>
                                    <?php if(isset($result->job) && $result->job): ?>
                                    <span><i class="fas fa-briefcase"></i> <?php echo e(Str::limit($result->job->title, 40)); ?></span>
                                    <?php endif; ?>
                                    <?php if($resultDate): ?>
                                    <span><i class="fas fa-calendar-alt"></i> Date: <?php echo e($resultDate->format('d M Y')); ?></span>
                                    <?php endif; ?>
                                </div>
                                <?php if(!empty($result->short_description)): ?>
                                <div class="result-desc">
                                    <?php echo e(Str::limit($result->short_description, 100)); ?>

                                </div>
                                <?php endif; ?>
                                <div class="result-meta">
                                    <span><i class="fas fa-eye"></i> Views: <?php echo e($result->views ?? 0); ?></span>
                                    <span><i class="fas fa-download"></i> Downloads: <?php echo e($result->download_count ?? 0); ?></span>
                                </div>
                            </div>
                            <div style="flex: 1; min-width: 180px; text-align: right;">
                                <?php if(!empty($result->result_link)): ?>
                                <div style="margin-bottom: 8px;">
                                    <a href="<?php echo e($result->result_link); ?>" target="_blank" rel="nofollow noopener noreferrer" class="result-link" style="display: inline-block; margin-bottom: 8px;">
                                        <i class="fas fa-external-link-alt"></i> <?php echo e($isUpcoming ? 'View Details' : 'View Result'); ?>

                                    </a>
                                </div>
                                <?php endif; ?>
                                <?php if(!empty($result->result_file)): ?>
                                <div>
                                    <a href="<?php echo e(Storage::url($result->result_file)); ?>" target="_blank" class="download-link">
                                        <i class="fas fa-file-pdf"></i> Download PDF
                                    </a>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                    <!-- Pagination -->
                    <?php if(method_exists($results, 'hasPages') && $results->hasPages()): ?>
                    <div style="padding: 15px; border-top: 1px solid #e0e0e0;">
                        <?php echo e($results->appends(request()->query())->links()); ?>

                    </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <?php else: ?>
            <!-- No Results Found -->
            <div class="section-box">
                <div class="section-header">
                    <i class="fas fa-search"></i> No Results Found
                </div>
                <div class="no-results">
                    <i class="fas fa-inbox"></i>
                    <h4>No Results Found</h4>
                    <p style="color: #666;">
                        <?php if(request()->has('search')): ?>
                        No results found for "<?php echo e(request('search')); ?>". Try different keywords or browse all results.
                        <?php else: ?>
                        There are no results published yet. Please check back later for updates.
                        <?php endif; ?>
                    </p>
                    <div style="display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">
                        <?php if(request()->has('search')): ?>
                        <a href="<?php echo e(route('results')); ?>" style="background: #28a745; color: #fff; padding: 10px 20px; border-radius: 5px; text-decoration: none;">
                            <i class="fas fa-sync"></i> View All Results
                        </a>
                        <?php endif; ?>
                        <a href="<?php echo e(route('jobs')); ?>" style="background: #17a2b8; color: #fff; padding: 10px 20px; border-radius: 5px; text-decoration: none;">
                            <i class="fas fa-briefcase"></i> Browse Jobs
                        </a>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
        
        <!-- Sidebar -->
        <div style="flex: 1; min-width: 250px;">
            
            <!-- Recent Results -->
            <div class="sidebar-box">
                <div class="sidebar-header">
                    <i class="fas fa-clock"></i> Recent Results
                </div>
                <div class="sidebar-content">
                    <?php $__empty_1 = true; $__currentLoopData = ($recentResults ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="recent-item">
                        <div class="recent-title">
                            <a href="<?php echo e(route('results.show', $recent->slug ?? $recent->id)); ?>">
                                <?php echo e(Str::limit($recent->title ?? 'Untitled', 45)); ?>

                            </a>
                        </div>
                        <div class="recent-date">
                            <i class="fas fa-calendar-alt"></i> 
                            <?php
                                $recentDate = $recent->result_date ?? null;
                                if ($recentDate && is_string($recentDate)) {
                                    $recentDate = \Carbon\Carbon::parse($recentDate);
                                }
                            ?>
                            <?php echo e($recentDate ? $recentDate->format('d M Y') : 'Date not set'); ?>

                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div style="text-align: center; color: #888; padding: 20px;">
                        No recent results
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Result Categories -->
            <div class="sidebar-box">
                <div class="sidebar-header">
                    <i class="fas fa-tags"></i> Result Categories
                </div>
                <div class="sidebar-content">
                    <ul class="category-list">
                        <?php $__empty_1 = true; $__currentLoopData = ($resultCategories ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <li>
                            <a href="<?php echo e(route('results.category', $category->slug ?? $category->id)); ?>">
                                <span><i class="fas fa-folder"></i> <?php echo e($category->name ?? 'Unnamed Category'); ?></span>
                                <span class="category-count"><?php echo e($category->results_count ?? 0); ?></span>
                            </a>
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <li style="text-align: center; color: #888; padding: 10px;">No categories found</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            
            <!-- Upcoming Results -->
            <?php if(isset($upcomingResults) && $upcomingResults->count() > 0): ?>
            <div class="sidebar-box">
                <div class="sidebar-header" style="background: #ffc107; color: #000;">
                    <i class="fas fa-bell"></i> Upcoming Results
                </div>
                <div class="sidebar-content">
                    <?php $__currentLoopData = $upcomingResults; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $upcoming): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="recent-item">
                        <div class="recent-title">
                            <a href="<?php echo e(route('results.show', $upcoming->slug ?? $upcoming->id)); ?>">
                                <?php echo e(Str::limit($upcoming->title ?? 'Untitled', 40)); ?>

                            </a>
                        </div>
                        <div class="recent-date">
                            <i class="fas fa-calendar text-warning"></i> 
                            <?php
                                $upcomingDate = $upcoming->result_date ?? null;
                                if ($upcomingDate && is_string($upcomingDate)) {
                                    $upcomingDate = \Carbon\Carbon::parse($upcomingDate);
                                }
                            ?>
                            Expected: <?php echo e($upcomingDate ? $upcomingDate->format('d M Y') : 'Date TBA'); ?>

                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Quick Links -->
            <div class="sidebar-box">
                <div class="sidebar-header" style="background: #007bff;">
                    <i class="fas fa-link"></i> Quick Links
                </div>
                <div class="sidebar-content">
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        <a href="<?php echo e(route('jobs')); ?>" style="display: block; padding: 8px 12px; background: #f8f9fa; color: #333; text-decoration: none; border-radius: 5px; font-size: 13px;">
                            <i class="fas fa-briefcase"></i> Latest Jobs
                        </a>
                        <a href="<?php echo e(route('admit-cards')); ?>" style="display: block; padding: 8px 12px; background: #f8f9fa; color: #333; text-decoration: none; border-radius: 5px; font-size: 13px;">
                            <i class="fas fa-ticket-alt"></i> Admit Cards
                        </a>
                        <a href="<?php echo e(route('answer-keys')); ?>" style="display: block; padding: 8px 12px; background: #f8f9fa; color: #333; text-decoration: none; border-radius: 5px; font-size: 13px;">
                            <i class="fas fa-key"></i> Answer Keys
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Important Notice -->
            <div class="sidebar-box">
                <div class="sidebar-header" style="background: #dc3545;">
                    <i class="fas fa-exclamation-triangle"></i> Important Notice
                </div>
                <div class="sidebar-content">
                    <ul style="margin: 0; padding-left: 20px; font-size: 12px; color: #555;">
                        <li>Verify results on official websites</li>
                        <li>Keep your roll number ready</li>
                        <li>Download and save result copies</li>
                        <li>Contact official helpdesk for queries</li>
                        <li>Beware of fake result websites</li>
                    </ul>
                </div>
            </div>
            
            <!-- Social Links -->
            <div class="sidebar-box">
                <div class="sidebar-header" style="background: #ab183d;">
                    <i class="fas fa-share-alt"></i> Connect with Us
                </div>
                <div class="sidebar-content" style="text-align: center;">
                    <div style="display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">
                        <a href="https://t.me/" target="_blank" rel="nofollow noopener noreferrer" style="background: #0088cc; color: #fff; padding: 8px 12px; border-radius: 5px; text-decoration: none; font-size: 12px;">
                            <i class="fab fa-telegram"></i> Telegram
                        </a>
                        <a href="https://whatsapp.com/channel/" target="_blank" rel="nofollow noopener noreferrer" style="background: #25d366; color: #fff; padding: 8px 12px; border-radius: 5px; text-decoration: none; font-size: 12px;">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                        <a href="https://www.facebook.com/SarkariResult.Mobi/" target="_blank" rel="nofollow noopener noreferrer" style="background: #1877f2; color: #fff; padding: 8px 12px; border-radius: 5px; text-decoration: none; font-size: 12px;">
                            <i class="fab fa-facebook"></i> Facebook
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
    // Add loading effect on result links
    const links = document.querySelectorAll('.result-link, .download-link');
    links.forEach(link => {
        link.addEventListener('click', function(e) {
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
            this.style.opacity = '0.7';
            setTimeout(() => {
                if (this.innerHTML.includes('Loading')) {
                    this.innerHTML = originalText;
                    this.style.opacity = '';
                }
            }, 3000);
        });
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\SARKARIMOBI\sarkariresult.mobi\resources\views/results/index.blade.php ENDPATH**/ ?>