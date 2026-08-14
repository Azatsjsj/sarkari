


<?php $__env->startSection('title', 'Latest Admit Cards - Sarkari Result 2026'); ?>
<?php $__env->startSection('meta_description', 'Download latest admit cards for various government exams. Get hall tickets, exam dates, venues, and important instructions for SSC, UPSC, Railway, Bank, Police and more.'); ?>

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
        background: linear-gradient(135deg, #ffc107 0%, #e6a800 100%);
        color: #000;
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
        color: #e6a800;
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
        background: #ffc107;
        color: #000;
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
        color: #ffc107;
        margin-bottom: 5px;
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
        background: #ffc107;
        color: #000;
        padding: 12px 20px;
        font-size: 18px;
        font-weight: bold;
    }
    
    .section-header i {
        margin-right: 10px;
    }
    
    .section-content {
        padding: 0;
    }
    
    /* Admit Card Item */
    .admit-card-item {
        border-bottom: 1px solid #e0e0e0;
        padding: 15px;
        transition: all 0.2s ease;
    }
    
    .admit-card-item:last-child {
        border-bottom: none;
    }
    
    .admit-card-item:hover {
        background: #f8f9fa;
    }
    
    .admit-card-title {
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 8px;
    }
    
    .admit-card-title a {
        color: #333;
        text-decoration: none;
    }
    
    .admit-card-title a:hover {
        color: #e6a800;
        text-decoration: underline;
    }
    
    .admit-card-meta {
        font-size: 12px;
        color: #666;
        margin-bottom: 8px;
    }
    
    .admit-card-meta i {
        margin-right: 5px;
    }
    
    .admit-card-meta span {
        margin-right: 15px;
    }
    
    .admit-card-desc {
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
    }
    
    /* Download Button */
    .download-link {
        color: #28a745;
        font-weight: bold;
        text-decoration: none;
        font-size: 13px;
    }
    
    .download-link:hover {
        text-decoration: underline;
    }
    
    .view-link {
        color: #e6a800;
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
        background: #ffc107;
        color: #000;
        padding: 12px 15px;
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
        color: #e6a800;
    }
    
    .recent-date {
        font-size: 11px;
        color: #888;
    }
    
    /* Notice Box */
    .notice-box {
        background: #fff3cd;
        border-left: 4px solid #ffc107;
        padding: 15px;
        margin-top: 15px;
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
        color: #e6a800;
        text-decoration: none;
        border-radius: 4px;
        font-size: 13px;
    }
    
    .pagination .page-link:hover {
        background: #ffc107;
        color: #000;
        border-color: #ffc107;
    }
    
    .pagination .active .page-link {
        background: #ffc107;
        color: #000;
        border-color: #ffc107;
    }
    
    /* Info Text */
    .info-text {
        background: #d4edda;
        border-left: 4px solid #28a745;
        padding: 10px 15px;
        font-size: 13px;
        margin-bottom: 20px;
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
        
        .admit-card-title {
            font-size: 14px;
        }
        
        .admit-card-meta span {
            display: block;
            margin-bottom: 5px;
        }
        
        .admit-card-item .row {
            flex-direction: column;
        }
        
        .admit-card-item .text-end {
            text-align: left !important;
            margin-top: 10px;
        }
        
        .section-header {
            font-size: 16px;
        }
        
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
        <span>Admit Cards</span>
    </div>
    
    <!-- Header -->
    <div class="sarkari-header">
        <h1><i class="fas fa-ticket-alt"></i> Latest Admit Cards - Sarkari Result 2026</h1>
        <p>Download admit cards for upcoming government exams. Get your hall tickets, exam dates, venues, and important instructions.</p>
    </div>
    
    <!-- Search Box -->
    <div class="search-box">
        <div class="search-title">
            <i class="fas fa-search"></i> Search Admit Cards
        </div>
        <form action="<?php echo e(route('admit-cards')); ?>" method="GET">
            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <div style="flex: 3; min-width: 200px;">
                    <input type="text" name="search" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;" 
                           placeholder="Search admit cards by exam name, job title, or keywords..."
                           value="<?php echo e(request('search')); ?>">
                </div>
                <div style="flex: 1; min-width: 150px;">
                    <select name="filter" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                        <option value="">All Admit Cards</option>
                        <option value="latest" <?php echo e(request('filter') == 'latest' ? 'selected' : ''); ?>>Latest First</option>
                        <option value="upcoming" <?php echo e(request('filter') == 'upcoming' ? 'selected' : ''); ?>>Upcoming Exams</option>
                    </select>
                </div>
                <div>
                    <button type="submit" class="btn" style="background: #ffc107; color: #000; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">
                        <i class="fas fa-search"></i> Search
                    </button>
                    <?php if(request()->hasAny(['search', 'filter'])): ?>
                    <a href="<?php echo e(route('admit-cards')); ?>" style="background: #6c757d; color: #fff; padding: 10px 15px; border-radius: 5px; text-decoration: none; display: inline-block;">
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
            <div class="stat-number"><?php echo e($admitCards->total() ?? 0); ?></div>
            <div class="stat-label">Total Admit Cards</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?php echo e($recentCount ?? 0); ?></div>
            <div class="stat-label">Recent Admit Cards</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?php echo e($upcomingCount ?? 0); ?></div>
            <div class="stat-label">Upcoming Exams</div>
        </div>
    </div>
    
    <div class="row" style="display: flex; gap: 20px; flex-wrap: wrap;">
        
        <!-- Main Content - Admit Cards List -->
        <div style="flex: 2.5; min-width: 280px;">
            
            <?php if(isset($admitCards) && $admitCards->count() > 0): ?>
            <div class="section-box">
                <div class="section-header">
                    <i class="fas fa-list"></i> All Admit Cards
                    <?php if(request()->has('search')): ?>
                    <span style="font-size: 12px; background: rgba(0,0,0,0.2); padding: 2px 8px; border-radius: 20px; margin-left: 10px;">
                        Search: "<?php echo e(request('search')); ?>"
                    </span>
                    <?php endif; ?>
                </div>
                <div class="section-content">
                    
                    <div style="padding: 10px 15px; background: #f8f9fa; border-bottom: 1px solid #e0e0e0; font-size: 13px;">
                        <i class="fas fa-info-circle"></i> Showing <?php echo e($admitCards->firstItem()); ?> - <?php echo e($admitCards->lastItem()); ?> of <?php echo e($admitCards->total()); ?> admit cards
                    </div>
                    
                    <?php $__currentLoopData = $admitCards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $admitCard): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="admit-card-item">
                        <div class="row" style="display: flex; flex-wrap: wrap;">
                            <div style="flex: 2; min-width: 200px;">
                                <div class="admit-card-title">
                                    <a href="<?php echo e($admitCard->slug ? route('admit-card.show', $admitCard->slug) : route('admit-cards')); ?>">
                                        <i class="fas fa-ticket-alt" style="color: #ffc107;"></i>
                                        <?php echo e($admitCard->title); ?>

                                    </a>
                                    <?php
                                        $admitCardDate = safe_carbon($admitCard->admit_card_date);
                                        $isUpcoming = is_future_date($admitCardDate);
                                        $isRecent = $admitCardDate && $admitCardDate->diffInDays(now()) <= 7 && !$isUpcoming;
                                    ?>
                                    <?php if($isUpcoming): ?>
                                    <span class="badge-upcoming"><i class="fas fa-clock"></i> Upcoming</span>
                                    <?php endif; ?>
                                    <?php if($isRecent): ?>
                                    <span class="badge-new"><i class="fas fa-newspaper"></i> New</span>
                                    <?php endif; ?>
                                </div>
                                <div class="admit-card-meta">
                                    <?php if($admitCard->job && $admitCard->job->category): ?>
                                    <span><i class="fas fa-building"></i> <?php echo e($admitCard->job->category->name); ?></span>
                                    <?php endif; ?>
                                    <?php if($admitCard->job): ?>
                                    <span><i class="fas fa-briefcase"></i> <?php echo e(Str::limit($admitCard->job->title, 40)); ?></span>
                                    <?php endif; ?>
                                    <span><i class="fas fa-calendar-alt"></i> Admit Card: <?php echo e(safe_date_format($admitCardDate, 'd M Y')); ?></span>
                                </div>
                                <?php if($admitCard->exam_date): ?>
                                <div class="admit-card-meta">
                                    <span><i class="fas fa-calendar-check"></i> Exam Date: 
                                        <?php echo e(safe_date_format(safe_carbon($admitCard->exam_date), 'd M Y')); ?>

                                    </span>
                                </div>
                                <?php endif; ?>
                                <?php if($admitCard->short_description): ?>
                                <div class="admit-card-desc">
                                    <?php echo e(Str::limit($admitCard->short_description, 100)); ?>

                                </div>
                                <?php endif; ?>
                                <div class="admit-card-meta">
                                    <span><i class="fas fa-eye"></i> Views: <?php echo e($admitCard->views ?? 0); ?></span>
                                    <span><i class="fas fa-download"></i> Downloads: <?php echo e($admitCard->download_count ?? 0); ?></span>
                                    <?php if($admitCard->exam_venue): ?>
                                    <span><i class="fas fa-map-marker-alt"></i> <?php echo e(Str::limit($admitCard->exam_venue, 30)); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div style="flex: 1; min-width: 180px; text-align: right;">
                                <div style="margin-bottom: 8px;">
                                    <?php if(isset($admitCard->file_path) && $admitCard->file_path): ?>
                                    <a href="<?php echo e(route('admit-card.download', $admitCard->slug ?? $admitCard->id)); ?>" 
                                       class="download-link" 
                                       style="display: inline-block; margin-bottom: 8px;"
                                       onclick="trackDownload(<?php echo e($admitCard->id); ?>)">
                                        <i class="fas fa-download"></i> Download Admit Card
                                    </a>
                                    <?php elseif(isset($admitCard->download_link) && $admitCard->download_link): ?>
                                    <a href="<?php echo e($admitCard->download_link); ?>" target="_blank" class="download-link">
                                        <i class="fas fa-external-link-alt"></i> Download Admit Card
                                    </a>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <a href="<?php echo e($admitCard->slug ? route('admit-card.show', $admitCard->slug) : route('admit-cards')); ?>" class="view-link">
                                        <i class="fas fa-eye"></i> View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                    <!-- Pagination -->
                    <?php if($admitCards->hasPages()): ?>
                    <div style="padding: 15px; border-top: 1px solid #e0e0e0;">
                        <?php echo e($admitCards->appends(request()->query())->links()); ?>

                    </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <?php else: ?>
            <!-- No Admit Cards Found -->
            <div class="section-box">
                <div class="section-header">
                    <i class="fas fa-search"></i> No Admit Cards Found
                </div>
                <div class="no-results">
                    <i class="fas fa-ticket-alt"></i>
                    <h4>No Admit Cards Found</h4>
                    <p style="color: #666;">
                        <?php if(request()->has('search')): ?>
                        No admit cards found for "<?php echo e(request('search')); ?>". Try different keywords or browse all admit cards.
                        <?php else: ?>
                        There are no admit cards published yet. Please check back later for updates.
                        <?php endif; ?>
                    </p>
                    <div style="display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">
                        <?php if(request()->has('search')): ?>
                        <a href="<?php echo e(route('admit-cards')); ?>" style="background: #ffc107; color: #000; padding: 10px 20px; border-radius: 5px; text-decoration: none;">
                            <i class="fas fa-sync"></i> View All Admit Cards
                        </a>
                        <?php endif; ?>
                        <a href="<?php echo e(route('jobs')); ?>" style="background: #17a2b8; color: #fff; padding: 10px 20px; border-radius: 5px; text-decoration: none;">
                            <i class="fas fa-briefcase"></i> Browse Jobs
                        </a>
                        <a href="<?php echo e(route('results')); ?>" style="background: #28a745; color: #fff; padding: 10px 20px; border-radius: 5px; text-decoration: none;">
                            <i class="fas fa-chart-bar"></i> Check Results
                        </a>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
        
        <!-- Sidebar -->
        <div style="flex: 1; min-width: 250px;">
            
            <!-- Recent Admit Cards -->
            <div class="sidebar-box">
                <div class="sidebar-header">
                    <i class="fas fa-clock"></i> Recent Admit Cards
                </div>
                <div class="sidebar-content">
                    <?php $__empty_1 = true; $__currentLoopData = ($recentAdmitCards ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="recent-item">
                        <div class="recent-title">
                            <a href="<?php echo e($recent->slug ? route('admit-card.show', $recent->slug) : route('admit-cards')); ?>">
                                <?php echo e(Str::limit($recent->title, 45)); ?>

                            </a>
                        </div>
                        <div class="recent-date">
                            <i class="fas fa-calendar-alt"></i> 
                            <?php
                                $recentDate = $recent->admit_card_date;
                                if (is_string($recentDate)) {
                                    $recentDate = \Carbon\Carbon::parse($recentDate);
                                }
                            ?>
                            <?php echo e($recentDate->format('d M Y')); ?>

                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div style="text-align: center; color: #888; padding: 20px;">
                        No recent admit cards
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Upcoming Exams -->
            <?php if(isset($upcomingAdmitCards) && $upcomingAdmitCards->count() > 0): ?>
            <div class="sidebar-box">
                <div class="sidebar-header" style="background: #28a745; color: #fff;">
                    <i class="fas fa-bell"></i> Upcoming Exams
                </div>
                <div class="sidebar-content">
                    <?php $__currentLoopData = $upcomingAdmitCards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $upcoming): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="recent-item">
                        <div class="recent-title">
                            <a href="<?php echo e($upcoming->slug ? route('admit-card.show', $upcoming->slug) : route('admit-cards')); ?>">
                                <?php echo e(Str::limit($upcoming->title, 40)); ?>

                            </a>
                        </div>
                        <div class="recent-date">
                            <i class="fas fa-calendar text-success"></i> 
                            <?php
                                $upcomingDate = $upcoming->exam_date ?? $upcoming->admit_card_date;
                                if (is_string($upcomingDate)) {
                                    $upcomingDate = \Carbon\Carbon::parse($upcomingDate);
                                }
                            ?>
                            Exam: <?php echo e($upcomingDate->format('d M Y')); ?>

                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Quick Links -->
            <div class="sidebar-box">
                <div class="sidebar-header" style="background: #007bff; color: #fff;">
                    <i class="fas fa-link"></i> Quick Links
                </div>
                <div class="sidebar-content">
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        <a href="<?php echo e(route('jobs')); ?>" style="display: block; padding: 8px 12px; background: #f8f9fa; color: #333; text-decoration: none; border-radius: 5px; font-size: 13px;">
                            <i class="fas fa-briefcase"></i> Latest Jobs
                        </a>
                        <a href="<?php echo e(route('results')); ?>" style="display: block; padding: 8px 12px; background: #f8f9fa; color: #333; text-decoration: none; border-radius: 5px; font-size: 13px;">
                            <i class="fas fa-chart-bar"></i> Check Results
                        </a>
                        <a href="<?php echo e(route('answer-keys')); ?>" style="display: block; padding: 8px 12px; background: #f8f9fa; color: #333; text-decoration: none; border-radius: 5px; font-size: 13px;">
                            <i class="fas fa-key"></i> Answer Keys
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Important Instructions -->
            <div class="sidebar-box">
                <div class="sidebar-header" style="background: #dc3545; color: #fff;">
                    <i class="fas fa-exclamation-triangle"></i> Important Instructions
                </div>
                <div class="sidebar-content">
                    <ul style="margin: 0; padding-left: 20px; font-size: 12px; color: #555;">
                        <li>Download admit card well in advance</li>
                        <li>Verify all details carefully</li>
                        <li>Carry original ID proof to exam center</li>
                        <li>Reach exam center 1 hour before time</li>
                        <li>Take a printout of admit card</li>
                        <li>Follow COVID-19 guidelines if applicable</li>
                    </ul>
                </div>
            </div>
            
            <!-- Social Links -->
            <div class="sidebar-box">
                <div class="sidebar-header" style="background: #ab183d; color: #fff;">
                    <i class="fas fa-share-alt"></i> Connect with Us
                </div>
                <div class="sidebar-content" style="text-align: center;">
                    <div style="display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">
                        <a href="https://t.me/Sarkari" target="_blank" rel="nofollow, noopener, noreferrer" style="background: #0088cc; color: #fff; padding: 8px 12px; border-radius: 5px; text-decoration: none; font-size: 12px;">
                            <i class="fab fa-telegram"></i> Telegram
                        </a>
                        <a href="https://whatsapp.com/channel/" target="_blank" rel="nofollow, noopener, noreferrer" style="background: #25d366; color: #fff; padding: 8px 12px; border-radius: 5px; text-decoration: none; font-size: 12px;">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                        <a href="https://www.facebook.com/SarkariResult./" target="_blank" rel="nofollow, noopener, noreferrer" style="background: #1877f2; color: #fff; padding: 8px 12px; border-radius: 5px; text-decoration: none; font-size: 12px;">
                            <i class="fab fa-facebook"></i> Facebook
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    
    <!-- Info Box -->
    <div class="info-text">
        <i class="fas fa-info-circle"></i> <strong>Note:</strong> Always download admit cards from official website. SarkariResult.Mobi provides information for reference purposes only.
    </div>
    
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function trackDownload(admitCardId) {
    console.log('Download initiated for admit card:', admitCardId);
    
    // Show loading state
    const btn = event.currentTarget;
    if (btn) {
        const originalHTML = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Preparing...';
        btn.style.opacity = '0.7';
        
        setTimeout(() => {
            btn.innerHTML = originalHTML;
            btn.style.opacity = '1';
        }, 2000);
    }
    
    // Send to Google Analytics if available
    if (typeof gtag !== 'undefined') {
        gtag('event', 'download', {
            'event_category': 'admit_card',
            'event_label': 'Admit Card ID: ' + admitCardId
        });
    }
}
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\SARKARIMOBI\sarkariresult.mobi\resources\views/admit-cards/index.blade.php ENDPATH**/ ?>