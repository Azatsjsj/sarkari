


<?php $__env->startPush('styles'); ?>
    
    <style>
        /* -------------------- Base & Reset -------------------- */
        * {
            -webkit-tap-highlight-color: transparent;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            overflow-x: hidden;
            width: 100%;
            background-color: #f8fafc;
            font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }

        /* -------------------- Typography & Utilities -------------------- */
        .text-gradient-primary {
            background: linear-gradient(135deg, #0f2b4b 0%, #1a4a7a 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .bg-gradient-modern {
            background: linear-gradient(145deg, #0f2b4b 0%, #1b3a6b 100%);
        }

        .bg-gradient-accent {
            background: linear-gradient(145deg, #d4a373 0%, #b5835a 100%);
        }

        .shadow-soft {
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
        }

        .shadow-hover {
            transition: all 0.25s ease-in-out;
        }
        .shadow-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.08);
        }

        .border-radius-16 {
            border-radius: 16px;
        }
        .border-radius-12 {
            border-radius: 12px;
        }

        /* -------------------- Hero Section -------------------- */
        .hero-section {
            position: relative;
            overflow: hidden;
            background: linear-gradient(145deg, #0f2b4b 0%, #1a4a7a 100%);
            border-radius: 20px;
            padding: 2.5rem 2rem;
            margin-bottom: 1.5rem;
        }
        .hero-section::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 300px;
            height: 300px;
            background: rgba(212, 163, 115, 0.15);
            border-radius: 50%;
            pointer-events: none;
        }
        .hero-section .hero-content {
            position: relative;
            z-index: 2;
        }
        .hero-title {
            font-weight: 700;
            font-size: 2.6rem;
            letter-spacing: -0.02em;
            color: #fff;
        }
        .hero-title i {
            color: #f4c542;
        }
        .hero-subtitle {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.85);
            max-width: 600px;
            margin: 0.5rem auto 0;
        }
        .hero-badge {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(4px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            color: #fff;
            padding: 0.35rem 1rem;
            border-radius: 40px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        /* -------------------- Marquee -------------------- */
        .marquee-modern {
            background: #fef9f2;
            border: 1px solid #f0e3d4;
            border-radius: 40px;
            padding: 0.6rem 0;
            margin: 1.5rem 0 1.8rem;
        }
        marquee a {
            color: #1a4a7a;
            font-weight: 500;
            text-decoration: none;
            margin: 0 12px;
            transition: color 0.2s;
        }
        marquee a:hover {
            color: #b5835a;
            text-decoration: underline;
        }
        marquee {
            font-size: 0.9rem;
        }

        /* -------------------- Quick Grid (Cards) -------------------- */
        .quick-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            margin: 1.8rem 0 2rem;
        }
        .quick-card {
            background: #ffffff;
            border: 1px solid #eef2f6;
            border-radius: 16px;
            padding: 1rem 0.75rem;
            text-align: center;
            text-decoration: none;
            color: #1e293b;
            font-weight: 500;
            font-size: 0.85rem;
            transition: all 0.25s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            flex-wrap: wrap;
            min-height: 70px;
        }
        .quick-card i {
            font-size: 1.4rem;
            color: #1a4a7a;
            transition: transform 0.2s;
        }
        .quick-card span {
            color: inherit;
            font-size: 0.85rem;
        }
        .quick-card:hover {
            background: #0f2b4b;
            border-color: #0f2b4b;
            color: #fff;
            transform: translateY(-3px);
            box-shadow: 0 12px 28px rgba(15, 43, 75, 0.15);
        }
        .quick-card:hover i {
            color: #f4c542;
            transform: scale(1.05);
        }

        /* -------------------- Card Headers (Unique Colors) -------------------- */
        .card-header-jobs {
            background: linear-gradient(145deg, #1a4a7a, #0f2b4b);
            color: #fff;
            border: none;
            border-radius: 16px 16px 0 0 !important;
            padding: 0.9rem 1.2rem;
        }
        .card-header-admit {
            background: linear-gradient(145deg, #2b6c8a, #1a4f6b);
            color: #fff;
            border: none;
            border-radius: 16px 16px 0 0 !important;
            padding: 0.9rem 1.2rem;
        }
        .card-header-result {
            background: linear-gradient(145deg, #2d7d5a, #1d5e41);
            color: #fff;
            border: none;
            border-radius: 16px 16px 0 0 !important;
            padding: 0.9rem 1.2rem;
        }
        .card-header-answer {
            background: linear-gradient(145deg, #b68b5c, #9a7348);
            color: #fff;
            border: none;
            border-radius: 16px 16px 0 0 !important;
            padding: 0.9rem 1.2rem;
        }
        .card-header-doc {
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
            color: #fff;
            border: none;
            border-radius: 16px 16px 0 0 !important;
            padding: 1rem 1.4rem;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.15);
        }

        /* -------------------- Cards & List Items -------------------- */
        .card-modern {
            border: none;
            border-radius: 16px;
            background: #ffffff;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.03);
            transition: box-shadow 0.25s ease;
            height: 100%;
        }
        .card-modern:hover {
            box-shadow: 0 12px 36px rgba(0, 0, 0, 0.06);
        }

        .list-item-modern {
            padding: 0.9rem 1rem;
            border-bottom: 1px solid #f1f5f9;
            transition: background 0.15s ease, border-color 0.15s;
            border-left: 3px solid transparent;
        }
        .list-item-modern:hover {
            background: #fafcff;
            border-left-color: #d4a373;
        }
        .list-item-modern:last-child {
            border-bottom: none;
        }

        .item-title {
            font-weight: 600;
            font-size: 0.95rem;
            color: #0f2b4b;
            text-decoration: none;
            transition: color 0.2s;
        }
        .item-title:hover {
            color: #b5835a;
        }
        .item-meta {
            font-size: 0.75rem;
            color: #64748b;
            display: flex;
            flex-wrap: wrap;
            gap: 0.6rem 1.2rem;
        }
        .item-meta i {
            width: 14px;
            color: #94a3b8;
        }

        .badge-soft {
            font-weight: 500;
            padding: 0.25rem 0.7rem;
            border-radius: 40px;
            font-size: 0.7rem;
        }
        .badge-soft-warning {
            background: #fef3c7;
            color: #92400e;
        }
        .badge-soft-danger {
            background: #fee2e2;
            color: #991b1b;
        }
        .badge-soft-success {
            background: #dcfce7;
            color: #166534;
        }
        .badge-soft-primary {
            background: #dbeafe;
            color: #1e40af;
        }

        /* -------------------- Two Column Grid -------------------- */
        .two-col-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        /* -------------------- Document Cards -------------------- */
        .document-card-modern {
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 1.15rem 1.25rem;
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            height: 100%;
            position: relative;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
        }
        .document-card-modern:hover {
            border-color: #3b82f6;
            transform: translateY(-4px);
            box-shadow: 0 12px 28px rgba(37, 99, 235, 0.12);
        }
        .doc-icon-badge {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: linear-gradient(135deg, #dbeafe 0%, #eff6ff 100%);
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(37, 99, 235, 0.12);
            transition: transform 0.2s ease, background 0.2s ease, color 0.2s ease;
        }
        .document-card-modern:hover .doc-icon-badge {
            transform: scale(1.08);
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: #ffffff;
        }
        .doc-title-link {
            font-weight: 600;
            font-size: 0.95rem;
            color: #1e293b;
            text-decoration: none;
            line-height: 1.4;
            transition: color 0.2s ease;
        }
        .doc-title-link:hover {
            color: #2563eb;
        }
        .doc-meta-tag {
            font-size: 0.72rem;
            font-weight: 500;
            padding: 0.25rem 0.75rem;
            border-radius: 50px;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            transition: all 0.2s ease;
        }
        .doc-tag-notice {
            background: #e0f2fe;
            color: #0369a1;
            border: 1px solid #bae6fd;
        }
        .doc-tag-certificate {
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
        }
        .doc-tag-syllabus {
            background: #f3e8ff;
            color: #6b21a8;
            border: 1px solid #e9d5ff;
        }
        .doc-tag-result {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }
        .doc-tag-department {
            background: #f1f5f9;
            color: #475569;
            border: 1px solid #e2e8f0;
        }
        .doc-tag-date {
            background: #ffffff;
            color: #64748b;
            border: 1px solid #e2e8f0;
        }

        /* -------------------- Search -------------------- */
        .search-wrapper {
            background: #fff;
            border-radius: 60px;
            padding: 0.2rem 0.2rem 0.2rem 1.5rem;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.02);
            border: 1px solid #eef2f6;
            transition: border-color 0.2s;
        }
        .search-wrapper:focus-within {
            border-color: #d4a373;
        }
        .search-wrapper input {
            border: none;
            padding: 0.7rem 0;
            font-size: 0.95rem;
            background: transparent;
            outline: none;
            flex: 1;
        }
        .search-wrapper input:focus {
            outline: none;
            box-shadow: none;
        }
        .search-wrapper .btn-search {
            background: #0f2b4b;
            color: #fff;
            border-radius: 40px;
            padding: 0.6rem 1.8rem;
            font-weight: 500;
            border: none;
            transition: background 0.2s;
        }
        .search-wrapper .btn-search:hover {
            background: #1a4a7a;
        }

        /* -------------------- Stats -------------------- */
        .stat-card {
            border: none;
            border-radius: 16px;
            padding: 0.8rem 0.5rem;
            text-align: center;
            background: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
            transition: transform 0.2s;
        }
        .stat-card:hover {
            transform: translateY(-3px);
        }
        .stat-number {
            font-size: 1.8rem;
            font-weight: 700;
            color: #0f2b4b;
            line-height: 1.2;
        }
        .stat-label {
            font-size: 0.75rem;
            color: #64748b;
            font-weight: 500;
        }

        /* -------------------- Content Area (from provided styles) -------------------- */
        .content_area{max-width:100%;}
        .containertitle{max-width:1280px;margin:0 auto;padding:24px 20px 48px;background-color:#fff}
        .heading{font-size:1.8rem;font-weight:700;color:#1e3a5f;margin:1.8rem 0 1rem 0;padding-bottom:0.5rem;border-bottom:3px solid #f39c12;display:inline-block;line-height:1.3}
        h3.heading:first-of-type{margin-top:0}
        h4.heading{font-size:1.45rem;border-bottom:2px solid #f39c12}
        .content_area p{font-size:1rem;margin-bottom:1rem;text-align:justify;color:#2c3e3f;line-height:1.65}
        .content_area ul{margin:0.75rem 0 1rem 1.6rem}
        .content_area li{margin-bottom:0.5rem;font-size:1rem;line-height:1.5}
        .content_area a{color:#e67e22;text-decoration:none;font-weight:500;transition:color 0.2s}
        .content_area a:hover{color:#b85e0a;text-decoration:underline}
        .content_area strong{color:#1e466e;font-weight:700}
        .social-card{background:linear-gradient(135deg,#fef9e6,#fff4e0);padding:1.5rem 1.8rem;border-radius:24px;margin:24px 0;border-left:6px solid #f39c12;box-shadow:0 6px 14px rgba(0,0,0,0.03)}
        .card{border-radius:20px;overflow:hidden;margin-bottom:28px;border:none}
        .card.shadow-sm{box-shadow:0 8px 20px rgba(0,0,0,0.06)!important}
        .card-body{padding:1.8rem}
        .bg-soft-primary{background-color:#f0f4fa}
        .rounded-xl{border-radius:20px!important}
        .accordion-item{border:1px solid #e9ecef;margin-bottom:12px;border-radius:16px!important;overflow:hidden}
        .accordion-button{background:#fbfdff;font-weight:600;padding:1rem 1.3rem}
        .accordion-button:not(.collapsed){background:#f39c12;color:#fff}
        .accordion-button:not(.collapsed)::after{filter:brightness(0) invert(1);}
        .accordion-body{padding:1.4rem;background:#ffffff}
        .feature-list{list-style:none;padding-left:0}
        .feature-list li{padding:10px 0;border-bottom:1px solid #edf2f7;display:flex;align-items:center;gap:10px}
        .feature-list li:last-child{border-bottom:none}
        .btn-primary-custom{background:#f39c12;color:#1e2a3a;padding:10px 28px;border-radius:40px;display:inline-flex;align-items:center;gap:10px;font-weight:600;transition:0.2s;text-decoration:none;border:none}
        .btn-primary-custom:hover{background:#e67e22;transform:translateY(-2px);color:white;text-decoration:none}
        .table-custom{width:100%;border-collapse:collapse;background:white;border-radius:20px;overflow:hidden;box-shadow:0 2px 10px rgba(0,0,0,0.05)}
        .table-custom th,.table-custom td{padding:14px 12px;text-align:left;border-bottom:1px solid #eef2f6}
        .table-custom th{background:#1e3a5f;color:white;font-weight:600}
        .status-badge{background:#f39c12;color:#1e2a3a;padding:4px 12px;border-radius:30px;font-size:0.8rem;font-weight:600;display:inline-block}
        .status-soon{background:#2c7a47;color:white}
        .status-upcoming{background:#5a6e85;color:white}
        .text-primary-custom{color:#1e3a5f}
        .bg-glow{background:radial-gradient(circle at 10% 30%, rgba(243,156,18,0.05), rgba(30,58,95,0.02))}
        @media (max-width:768px){.containertitle{padding:16px 16px 32px}.heading{font-size:1.5rem}.card-body{padding:1.2rem}.social-card{padding:1rem}}
        hr{background:linear-gradient(90deg,#e2e8f0,#f39c12,#e2e8f0);height:2px;border:0;margin:2rem 0}
        .footer-note{font-size:0.85rem;text-align:center;margin-top:2rem;color:#5a6874}

        /* -------------------- Responsive -------------------- */
        @media (max-width: 992px) {
            .two-col-grid {
                gap: 1.2rem;
            }
            .hero-title {
                font-size: 2.2rem;
            }
        }

        @media (max-width: 768px) {
            .container {
                padding-left: 14px;
                padding-right: 14px;
            }
            .two-col-grid {
                grid-template-columns: 1fr;
                gap: 1.2rem;
            }
            .quick-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 10px;
            }
            .hero-section {
                padding: 2rem 1rem;
            }
            .hero-title {
                font-size: 1.7rem;
            }
            .hero-subtitle {
                font-size: 0.95rem;
            }
            .search-wrapper {
                border-radius: 30px;
                padding: 0.2rem 0.2rem 0.2rem 1rem;
            }
            .search-wrapper .btn-search {
                padding: 0.5rem 1.2rem;
                font-size: 0.85rem;
            }
            .stat-number {
                font-size: 1.4rem;
            }
            .item-title {
                font-size: 0.88rem;
            }
            .list-item-modern {
                padding: 0.7rem 0.8rem;
            }
        }

        @media (max-width: 480px) {
            .quick-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 8px;
            }
            .quick-card {
                padding: 0.7rem 0.4rem;
                font-size: 0.75rem;
                min-height: 60px;
            }
            .quick-card i {
                font-size: 1.2rem;
            }
            .hero-title {
                font-size: 1.4rem;
            }
        }

        /* -------------------- Accessibility & Touch -------------------- */
        @media (hover: none) and (pointer: coarse) {
            .btn, .list-item-modern, .quick-card, a[href] {
                min-height: 44px;
                cursor: pointer;
            }
        }

        /* -------------------- Misc -------------------- */
        .section-spacing {
            margin-bottom: 0;
        }
        .text-ellipsis {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container mt-2 mt-md-3">

        
        <div class="hero-section shadow-soft">
            <div class="hero-content text-center">
                <h1 class="hero-title">
                    <i class="fas fa-flag me-2"></i>Sarkari Result mobi
                </h1>
                <p class="hero-subtitle">
                    SarkariResult.mobi – Get Latest Government Jobs, Admit Cards, Results &amp; Online Forms 2026
                </p>
                <div class="d-flex flex-wrap gap-2 justify-content-center mt-3">
                    <span class="hero-badge"><i class="fas fa-check-circle me-1"></i> 10K+ Jobs</span>
                    <span class="hero-badge"><i class="fas fa-clock me-1"></i> Updated Today</span>
                    <span class="hero-badge"><i class="fas fa-shield-alt me-1"></i> Govt. Verified</span>
                </div>
            </div>
        </div>

        
        <?php
            $hasMarqueeItems = false;
            if(isset($marqueeJobs) && $marqueeJobs->count()) $hasMarqueeItems = true;
            if(isset($marqueeResults) && $marqueeResults->count()) $hasMarqueeItems = true;
            if(isset($marqueeAdmitCards) && $marqueeAdmitCards->count()) $hasMarqueeItems = true;
            if(isset($marqueeAnswerKeys) && $marqueeAnswerKeys->count()) $hasMarqueeItems = true;
            if(isset($marqueeAdmissions) && $marqueeAdmissions->count()) $hasMarqueeItems = true;
        ?>

        <?php if($hasMarqueeItems): ?>
            <div class="marquee-modern shadow-soft">
                <div class="container px-2">
                    <marquee behavior="alternate" onmouseover="this.stop();" onmouseout="this.start();">
                        <?php if(isset($marqueeJobs)): ?>
                            <?php $__currentLoopData = $marqueeJobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="<?php echo e(route('job.show', $job->slug)); ?>"><?php echo e($job->title); ?> Apply Online <?php echo e(date('Y')); ?></a> ||
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                        <?php if(isset($marqueeResults)): ?>
                            <?php $__currentLoopData = $marqueeResults; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="<?php echo e(route('results.show', $result->slug)); ?>"><?php echo e($result->title); ?> Coming Soon</a> ||
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                        <?php if(isset($marqueeAdmitCards)): ?>
                            <?php $__currentLoopData = $marqueeAdmitCards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $admitCard): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="<?php echo e($admitCard->slug ? route('admit-card.show', $admitCard->slug) : route('admit-cards')); ?>"><?php echo e($admitCard->title); ?> Admit Card</a> ||
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                        <?php if(isset($marqueeAnswerKeys)): ?>
                            <?php $__currentLoopData = $marqueeAnswerKeys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $answerKey): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="<?php echo e(route('answer-key.show', $answerKey->slug)); ?>"><?php echo e($answerKey->title); ?> Answer Key</a> ||
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                        <?php if(isset($marqueeAdmissions)): ?>
                            <?php $__currentLoopData = $marqueeAdmissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $admission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="<?php echo e(route('admissions.show', $admission->slug)); ?>"><?php echo e($admission->title); ?> Admissions <?php echo e(date('Y')); ?></a>
                                <?php if(!$loop->last): ?> || <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </marquee>
                </div>
            </div>
        <?php endif; ?>

        
        <div class="quick-grid">
            <?php
                $maxItems = 8;
                $allItems = [];
                if(isset($quickJobs) && $quickJobs->count()) {
                    foreach($quickJobs as $job) { $allItems[] = ['type' => 'job', 'data' => $job, 'icon' => 'fa-briefcase']; }
                }
                if(isset($quickResults) && $quickResults->count()) {
                    foreach($quickResults as $result) { $allItems[] = ['type' => 'result', 'data' => $result, 'icon' => 'fa-chart-bar']; }
                }
                if(isset($quickAdmitCards) && $quickAdmitCards->count()) {
                    foreach($quickAdmitCards as $admit) { $allItems[] = ['type' => 'admit-card', 'data' => $admit, 'icon' => 'fa-ticket-alt']; }
                }
                if(isset($quickAdmissions) && $quickAdmissions->count()) {
                    foreach($quickAdmissions as $admission) { $allItems[] = ['type' => 'admission', 'data' => $admission, 'icon' => 'fa-graduation-cap']; }
                }
                if(isset($additionalJobs) && $additionalJobs->count()) {
                    $needed = $maxItems - count($allItems);
                    if($needed > 0) {
                        foreach($additionalJobs as $job) {
                            if($needed-- <= 0) break;
                            $allItems[] = ['type' => 'job', 'data' => $job, 'icon' => 'fa-briefcase'];
                        }
                    }
                }
                $allItems = array_slice($allItems, 0, $maxItems);
            ?>

            <?php $__currentLoopData = $allItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $data = $item['data'];
                    $route = $item['type'] === 'job' ? route('job.show', $data->slug)
                             : ($item['type'] === 'result' ? route('results.show', $data->slug)
                             : ($item['type'] === 'admit-card' ? ($data->slug ? route('admit-card.show', $data->slug) : route('admit-cards'))
                             : route('admissions.show', $data->slug)));
                ?>
                <a href="<?php echo e($route); ?>" class="quick-card">
                    <i class="fas <?php echo e($item['icon']); ?>"></i>
                    <span><?php echo e(Str::limit($data->title, 45)); ?></span>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        
        <div class="two-col-grid">

            
            <div class="card-modern card">
                <div class="card-header-jobs d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 fs-5 fw-semibold"><i class="fas fa-star me-2"></i>Featured Jobs</h4>
                    <a href="<?php echo e(route('jobs')); ?>?featured=1" class="btn btn-light btn-sm rounded-pill px-3">View All <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
                <div class="card-body p-0">
                    <?php if(isset($featuredJobs) && $featuredJobs->count()): ?>
                        <?php $__empty_1 = true; $__currentLoopData = $featuredJobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="list-item-modern">
                                <div class="d-flex flex-wrap align-items-start justify-content-between gap-1">
                                    <a href="<?php echo e(route('job.show', $job->slug)); ?>" class="item-title"><?php echo e(Str::limit($job->title, 55)); ?></a>
                                    <div class="d-flex gap-1 flex-wrap">
                                        <span class="badge-soft badge-soft-warning"><i class="fas fa-star me-1"></i>Featured</span>
                                        <?php if(isset($job->last_date) && \Carbon\Carbon::parse($job->last_date)->isPast()): ?>
                                            <span class="badge-soft badge-soft-danger">Expired</span>
                                        <?php elseif(isset($job->last_date) && \Carbon\Carbon::parse($job->last_date)->diffInDays(now()) <= 3): ?>
                                            <span class="badge-soft badge-soft-danger">Urgent</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="item-meta mt-1">
                                    <span><i class="fas fa-building"></i> <?php echo e($job->category->name ?? 'N/A'); ?></span>
                                    <?php if(isset($job->last_date)): ?>
                                        <span><i class="fas fa-calendar-alt"></i> Last: <span class="<?php echo e(\Carbon\Carbon::parse($job->last_date)->isPast() ? 'text-danger' : 'text-success'); ?>"><?php echo e(\Carbon\Carbon::parse($job->last_date)->format('d M Y')); ?></span></span>
                                    <?php endif; ?>
                                    <?php if(isset($job->total_post)): ?>
                                        <span><i class="fas fa-users"></i> <?php echo e($job->total_post); ?> Posts</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="text-center py-5 text-muted"><i class="fas fa-briefcase fa-2x mb-2 opacity-25"></i><p class="mb-0">No featured jobs</p></div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="text-center py-5 text-muted"><i class="fas fa-briefcase fa-2x mb-2 opacity-25"></i><p class="mb-0">No featured jobs</p></div>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="card-modern card">
                <div class="card-header-jobs d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 fs-5 fw-semibold"><i class="fas fa-briefcase me-2"></i>Latest Jobs</h4>
                    <a href="<?php echo e(route('jobs')); ?>" class="btn btn-light btn-sm rounded-pill px-3">View All <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
                <div class="card-body p-0">
                    <?php if(isset($latestJobs) && $latestJobs->count()): ?>
                        <?php $__empty_1 = true; $__currentLoopData = $latestJobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="list-item-modern">
                                <div class="d-flex flex-wrap align-items-start justify-content-between gap-1">
                                    <a href="<?php echo e(route('job.show', $job->slug)); ?>" class="item-title"><?php echo e(Str::limit($job->title, 55)); ?></a>
                                    <?php if(isset($job->is_featured) && $job->is_featured): ?>
                                        <span class="badge-soft badge-soft-warning"><i class="fas fa-star me-1"></i>Featured</span>
                                    <?php endif; ?>
                                </div>
                                <div class="item-meta mt-1">
                                    <span><i class="fas fa-building"></i> <?php echo e($job->category->name ?? 'N/A'); ?></span>
                                    <?php if(isset($job->last_date)): ?>
                                        <span><i class="fas fa-calendar-alt"></i> Last: <span class="<?php echo e(\Carbon\Carbon::parse($job->last_date)->isPast() ? 'text-danger' : 'text-success'); ?>"><?php echo e(\Carbon\Carbon::parse($job->last_date)->format('d M Y')); ?></span></span>
                                    <?php endif; ?>
                                    <?php if(isset($job->total_post)): ?>
                                        <span><i class="fas fa-users"></i> <?php echo e($job->total_post); ?> Posts</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="text-center py-5 text-muted"><i class="fas fa-briefcase fa-2x mb-2 opacity-25"></i><p class="mb-0">No latest jobs</p></div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="text-center py-5 text-muted"><i class="fas fa-briefcase fa-2x mb-2 opacity-25"></i><p class="mb-0">No latest jobs</p></div>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="card-modern card">
                <div class="card-header-admit d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 fs-5 fw-semibold"><i class="fas fa-ticket-alt me-2"></i>Admit Cards</h4>
                    <a href="<?php echo e(route('admit-cards')); ?>" class="btn btn-light btn-sm rounded-pill px-3">View All <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
                <div class="card-body p-0">
                    <?php if(isset($latestAdmitCards) && $latestAdmitCards->count()): ?>
                        <?php $__currentLoopData = $latestAdmitCards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $admit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="list-item-modern">
                                <a href="<?php echo e($admit->slug ? route('admit-card.show', $admit->slug) : route('admit-cards')); ?>" class="item-title d-block"><?php echo e(Str::limit($admit->title, 50)); ?></a>
                                <div class="item-meta mt-1">
                                    <span><i class="fas fa-building"></i> <?php echo e($admit->job->title ?? 'N/A'); ?></span>
                                    <?php if(isset($admit->admit_card_date)): ?>
                                        <span><i class="fas fa-calendar"></i> <?php echo e(safe_date_format($admit->admit_card_date, 'd M Y')); ?></span>
                                    <?php endif; ?>
                                    <?php if(isset($admit->download_link)): ?>
                                        <a href="<?php echo e(htmlspecialchars($admit->download_link)); ?>" target="_blank" rel="noopener" class="badge-soft badge-soft-success text-decoration-none"><i class="fas fa-download me-1"></i>Download</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <div class="text-center py-5 text-muted"><i class="fas fa-ticket-alt fa-2x mb-2 opacity-25"></i><p class="mb-0">No admit cards</p></div>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="card-modern card">
                <div class="card-header-result d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 fs-5 fw-semibold"><i class="fas fa-chart-bar me-2"></i>Results</h4>
                    <a href="<?php echo e(route('results')); ?>" class="btn btn-light btn-sm rounded-pill px-3">View All <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
                <div class="card-body p-0">
                    <?php if(isset($latestResults) && $latestResults->count()): ?>
                        <?php $__empty_1 = true; $__currentLoopData = $latestResults; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="list-item-modern">
                                <div class="d-flex flex-wrap justify-content-between align-items-start gap-1">
                                    <a href="<?php echo e(route('results.show', $result->slug)); ?>" class="item-title"><?php echo e(Str::limit($result->title, 50)); ?></a>
                                    <span class="badge-soft badge-soft-success"><i class="fas fa-newspaper me-1"></i>New</span>
                                </div>
                                <div class="item-meta mt-1">
                                    <span><i class="fas fa-calendar"></i> <?php echo e(isset($result->result_date) ? \Carbon\Carbon::parse($result->result_date)->format('d M Y') : 'N/A'); ?></span>
                                    <a href="<?php echo e(route('results.show', $result->slug)); ?>" class="text-primary text-decoration-none fw-medium">Check Result <i class="fas fa-arrow-right ms-1"></i></a>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="text-center py-5 text-muted"><i class="fas fa-chart-bar fa-2x mb-2 opacity-25"></i><p class="mb-0">No results</p></div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="text-center py-5 text-muted"><i class="fas fa-chart-bar fa-2x mb-2 opacity-25"></i><p class="mb-0">No results</p></div>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="card-modern card">
                <div class="card-header-answer d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 fs-5 fw-semibold"><i class="fas fa-key me-2"></i>Answer Keys</h4>
                    <a href="<?php echo e(route('answer-keys')); ?>" class="btn btn-light btn-sm rounded-pill px-3">View All <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
                <div class="card-body p-0">
                    <?php if(isset($latestAnswerKeys) && $latestAnswerKeys->count()): ?>
                        <?php $__empty_1 = true; $__currentLoopData = $latestAnswerKeys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="list-item-modern">
                                <div class="d-flex flex-wrap justify-content-between align-items-start gap-1">
                                    <a href="<?php echo e(route('answer-key.show', $key->slug)); ?>" class="item-title"><?php echo e(Str::limit($key->title, 50)); ?></a>
                                    <span class="badge-soft badge-soft-primary"><i class="fas fa-key me-1"></i>Answer Key</span>
                                </div>
                                <div class="item-meta mt-1">
                                    <span><i class="fas fa-calendar"></i> <?php echo e(isset($key->answer_key_date) ? \Carbon\Carbon::parse($key->answer_key_date)->format('d M Y') : 'N/A'); ?></span>
                                    <a href="<?php echo e(route('answer-key.show', $key->slug)); ?>" class="text-primary text-decoration-none fw-medium">View Key <i class="fas fa-arrow-right ms-1"></i></a>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="text-center py-5 text-muted"><i class="fas fa-key fa-2x mb-2 opacity-25"></i><p class="mb-0">No answer keys</p></div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="text-center py-5 text-muted"><i class="fas fa-key fa-2x mb-2 opacity-25"></i><p class="mb-0">No answer keys</p></div>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="card-modern card" style="grid-column: 1 / -1;">
                <div class="card-header-doc d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div class="d-flex align-items-center">
                        <span class="fs-5 fw-bold text-white me-2"><i class="fas fa-file-alt me-2"></i>Government Notices &amp; Certificates</span>
                        <span class="badge rounded-pill bg-white text-primary fw-semibold px-3 py-1 shadow-sm"><i class="fas fa-check-circle text-primary me-1"></i> Verified Official</span>
                    </div>
                    <a href="<?php echo e(route('documents.index')); ?>" class="btn btn-light btn-sm rounded-pill px-3 fw-semibold shadow-sm text-primary">View All <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
                <div class="card-body p-3 p-md-4">
                    <?php if(isset($featuredDocuments) && $featuredDocuments->count()): ?>
                        <div class="row g-3">
                            <?php $__currentLoopData = $featuredDocuments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-lg-4 col-md-6">
                                    <div class="document-card-modern">
                                        <div class="d-flex align-items-start gap-3">
                                            <div class="doc-icon-badge">
                                                <i class="fas <?php echo e($doc->getFileIcon() ?? 'fa-file-alt'); ?>"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <a href="<?php echo e(route('documents.show', $doc->slug)); ?>" class="doc-title-link mb-1"><?php echo e(Str::limit($doc->title, 55)); ?></a>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-wrap gap-1 mt-auto pt-2 border-top">
                                            <?php if(isset($doc->type)): ?>
                                                <span class="doc-meta-tag <?php echo e($doc->type == 'notice' ? 'doc-tag-notice' : ($doc->type == 'certificate' ? 'doc-tag-certificate' : ($doc->type == 'syllabus' ? 'doc-tag-syllabus' : 'doc-tag-result'))); ?>">
                                                    <?php if($doc->type == 'notice'): ?> <i class="fas fa-bullhorn"></i> Notice
                                                    <?php elseif($doc->type == 'certificate'): ?> <i class="fas fa-certificate"></i> Certificate
                                                    <?php elseif($doc->type == 'syllabus'): ?> <i class="fas fa-book"></i> Syllabus
                                                    <?php elseif($doc->type == 'result'): ?> <i class="fas fa-chart-line"></i> Result
                                                    <?php endif; ?>
                                                </span>
                                            <?php endif; ?>
                                            <?php if(isset($doc->department)): ?>
                                                <span class="doc-meta-tag doc-tag-department"><i class="fas fa-building"></i> <?php echo e(Str::limit($doc->department, 18)); ?></span>
                                            <?php endif; ?>
                                            <?php if(isset($doc->issue_date)): ?>
                                                <span class="doc-meta-tag doc-tag-date"><i class="fas fa-calendar-alt"></i> <?php echo e(safe_date_format($doc->issue_date, 'd M Y')); ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5 text-muted"><i class="fas fa-file-alt fa-2x mb-2 opacity-25"></i><p class="mb-0">No documents available</p></div>
                    <?php endif; ?>

                    <?php if(isset($latestDocuments) && $latestDocuments->count() > ($featuredDocuments->count() ?? 0)): ?>
                        <hr class="my-4">
                        <h6 class="fw-semibold mb-3 text-dark"><i class="fas fa-clock me-2 text-primary"></i>Recently Added Notices &amp; Certificates</h6>
                        <div class="list-group list-group-flush">
                            <?php $__currentLoopData = $latestDocuments->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="<?php echo e(route('documents.show', $doc->slug)); ?>" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center px-2 border-0 border-bottom py-2 rounded">
                                    <span><i class="fas <?php echo e($doc->getFileIcon() ?? 'fa-file-alt'); ?> me-2 text-primary"></i><?php echo e(Str::limit($doc->title, 55)); ?></span>
                                    <small class="text-muted"><?php echo e($doc->created_at->diffForHumans()); ?></small>
                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endif; ?>
                    <div class="text-center mt-4">
                        <a href="<?php echo e(route('documents.index')); ?>" class="btn btn-outline-primary rounded-pill px-4 fw-semibold">View All Government Documents &amp; Notices <i class="fas fa-arrow-right ms-2"></i></a>
                    </div>
                </div>
            </div>

            
            <div class="card-modern card">
                <div class="card-header" style="background: #0f2b4b; color:#fff; border:none; border-radius:16px 16px 0 0; padding:0.9rem 1.2rem;">
                    <h4 class="mb-0 fs-5 fw-semibold"><i class="fas fa-link me-2"></i>Quick Links</h4>
                </div>
                <div class="card-body p-3">
                    <div class="d-grid gap-2">
                        <a href="<?php echo e(route('jobs')); ?>" class="btn btn-outline-primary text-start py-2 px-3 rounded-pill"><i class="fas fa-briefcase me-2"></i>Browse All Jobs</a>
                        <a href="<?php echo e(route('results')); ?>" class="btn btn-outline-success text-start py-2 px-3 rounded-pill"><i class="fas fa-chart-bar me-2"></i>Check Results</a>
                        <a href="<?php echo e(route('admit-cards')); ?>" class="btn btn-outline-info text-start py-2 px-3 rounded-pill"><i class="fas fa-ticket-alt me-2"></i>Admit Cards</a>
                        <a href="<?php echo e(route('answer-keys')); ?>" class="btn btn-outline-warning text-start py-2 px-3 rounded-pill"><i class="fas fa-key me-2"></i>Answer Keys</a>
                        <a href="<?php echo e(route('jobs')); ?>?status=active" class="btn btn-outline-secondary text-start py-2 px-3 rounded-pill"><i class="fas fa-clock me-2"></i>Active Jobs</a>
                        <a href="<?php echo e(route('results')); ?>?filter=upcoming" class="btn btn-outline-danger text-start py-2 px-3 rounded-pill"><i class="fas fa-bell me-2"></i>Upcoming Results</a>
                    </div>
                </div>
            </div>
        </div>
        

        
        <?php if(isset($featuredAdmissions) && $featuredAdmissions->count()): ?>
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card-modern card">
                        <div class="card-header" style="background:linear-gradient(145deg,#4f2d5e,#2d1a3a); color:#fff; border:none; border-radius:16px 16px 0 0; padding:0.9rem 1.2rem;">
                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                <h4 class="mb-0 fs-5 fw-semibold"><i class="fas fa-graduation-cap me-2"></i>Featured Admissions</h4>
                                <a href="<?php echo e(route('admissions')); ?>?featured=1" class="btn btn-light btn-sm rounded-pill px-3">View All <i class="fas fa-arrow-right ms-1"></i></a>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <div class="row g-3">
                                <?php $__currentLoopData = $featuredAdmissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $admission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-xl-3 col-lg-4 col-md-6">
                                        <div class="card h-100 border-0 shadow-soft shadow-hover border-radius-12">
                                            <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center px-3 pt-3 pb-0">
                                                <span class="badge-soft badge-soft-warning"><i class="fas fa-star me-1"></i>Featured</span>
                                                <?php if(isset($admission->last_date) && \Carbon\Carbon::parse($admission->last_date)->isPast()): ?>
                                                    <span class="badge-soft badge-soft-danger">Expired</span>
                                                <?php elseif(isset($admission->last_date) && \Carbon\Carbon::parse($admission->last_date)->diffInDays(now()) <= 3): ?>
                                                    <span class="badge-soft badge-soft-danger">Urgent</span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="card-body px-3 pt-2">
                                                <h6 class="fw-semibold text-primary"><?php echo e(Str::limit($admission->title, 40)); ?></h6>
                                                <?php if(isset($admission->university)): ?>
                                                    <p class="text-muted small mb-1"><i class="fas fa-university me-1"></i><?php echo e(Str::limit($admission->university->name ?? 'N/A', 20)); ?></p>
                                                <?php endif; ?>
                                                <?php if(isset($admission->course)): ?>
                                                    <p class="text-muted small mb-1"><i class="fas fa-graduation-cap me-1"></i><?php echo e(Str::limit($admission->course->name ?? 'N/A', 20)); ?></p>
                                                <?php endif; ?>
                                                <?php if(isset($admission->last_date)): ?>
                                                    <p class="text-muted small mb-0"><i class="fas fa-clock me-1"></i>Last: <span class="<?php echo e(\Carbon\Carbon::parse($admission->last_date)->isPast() ? 'text-danger' : 'text-success'); ?>"><?php echo e(\Carbon\Carbon::parse($admission->last_date)->format('d M Y')); ?></span></p>
                                                <?php endif; ?>
                                            </div>
                                            <div class="card-footer bg-transparent border-0 d-flex gap-2 px-3 pb-3 pt-0">
                                                <a href="<?php echo e(route('admissions.show', $admission->slug)); ?>" class="btn btn-outline-primary btn-sm flex-fill rounded-pill"><i class="fas fa-eye me-1"></i>View</a>
                                                <?php if(isset($admission->apply_url) && isset($admission->last_date) && !\Carbon\Carbon::parse($admission->last_date)->isPast()): ?>
                                                    <a href="<?php echo e($admission->apply_url); ?>" target="_blank" rel="noreferrer" class="btn btn-success btn-sm flex-fill rounded-pill"><i class="fas fa-external-link-alt me-1"></i>Apply</a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        
        <div class="row my-4">
            <div class="col-12">
                <form action="<?php echo e(route('jobs')); ?>" method="GET" class="search-wrapper d-flex align-items-center">
                    <i class="fas fa-search text-muted me-2"></i>
                    <input type="text" name="search" class="flex-grow-1" placeholder="Search jobs, categories, keywords..." value="<?php echo e(request('search')); ?>">
                    <button type="submit" class="btn-search"><i class="fas fa-search me-2"></i>Search</button>
                </form>
            </div>
        </div>

        
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3"><div class="stat-card"><div class="stat-number"><?php echo e($totalJobs ?? 0); ?></div><div class="stat-label"><i class="fas fa-briefcase me-1"></i>Total Jobs</div></div></div>
            <div class="col-6 col-md-3"><div class="stat-card"><div class="stat-number"><?php echo e($totalResults ?? 0); ?></div><div class="stat-label"><i class="fas fa-chart-bar me-1"></i>Results</div></div></div>
            <div class="col-6 col-md-3"><div class="stat-card"><div class="stat-number"><?php echo e($activeJobs ?? 0); ?></div><div class="stat-label"><i class="fas fa-clock me-1"></i>Active Jobs</div></div></div>
            <div class="col-6 col-md-3"><div class="stat-card"><div class="stat-number"><?php echo e($upcomingResults ?? 0); ?></div><div class="stat-label"><i class="fas fa-bell me-1"></i>Upcoming</div></div></div>
        </div>

        
        <div class="content_area">
            <div class="containertitle">

                <!-- Hero / Trust Introduction - completely rewritten, natural flow -->
                <div class="row mt-2">
                    <div class="col-12">
                        <div class="card shadow-sm border-0 bg-white">
                            <div class="card-body p-4 p-md-5">
                                <div class="d-flex flex-wrap align-items-center justify-content-between mb-3">
                                    <h2 class="display-6 fw-bold text-primary-custom" style="font-size: 2rem;">Sarkari Result 2026 <i class="fas fa-chart-line text-warning"></i></h2>
                                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill"><i class="fas fa-users"></i> Trusted by 12M+ aspirants</span>
                                </div>
                                <p class="text-muted small">Your single destination for authentic sarkari naukri updates, exam notifications and instant result links — updated hourly.</p>
                                <hr class="my-2">
                                <p class="lead mb-3">Navigating India's competitive government recruitment landscape requires precision, speed, and accurate guidance. <strong>SarkariResult.mobi</strong> has emerged as the go-to digital companion for millions — delivering real-time updates, official notifications, and end-to-end exam support without clutter.</p>
                                <p>From UPSC's prestigious civil services to state police constable exams, from banking sector probationary officers to railway technical posts — every career-defining announcement finds its way onto our platform within minutes of official release. Our commitment remains unwavering: delivering verified, mobile-optimised, and distraction-free information to job seekers across every corner of India.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- why choose us and core stats - no keyword stuffing, human friendly -->
                <div class="row g-4 mt-2">
                    <div class="col-lg-7">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <h3 class="h4 fw-bold text-primary-custom mb-3"><i class="fas fa-bullhorn me-2 text-warning"></i> Your exam companion: What makes us different?</h3>
                                <p>We understand that a delayed alert can mean a missed opportunity. That's why our team works around the clock to filter through hundreds of official sources — from central recruitment boards to district-level offices — and present clear, actionable updates.</p>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <ul class="feature-list">
                                            <li><i class="fas fa-clock text-warning fa-fw"></i> <strong>Lightning updates</strong> — within 30 minutes of official release</li>
                                            <li><i class="fas fa-mobile-alt text-primary fa-fw"></i> <strong>Mobile-first architecture</strong> — seamless on 2G/3G/4G</li>
                                            <li><i class="fas fa-filter text-info fa-fw"></i> <strong>Smart filters</strong> (state, qualification, category)</li>
                                            <li><i class="fas fa-bell text-danger fa-fw"></i> <strong>Instant alerts</strong> via Telegram, WhatsApp & email</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <ul class="feature-list">
                                            <li><i class="fas fa-shield-alt text-success fa-fw"></i> <strong>Verified authenticity</strong> — no misleading links or rumours</li>
                                            <li><i class="fas fa-database text-primary fa-fw"></i> <strong>50k+ active openings</strong> indexed across sectors</li>
                                            <li><i class="fas fa-chart-simple text-warning fa-fw"></i> <strong>Exam insights</strong> — previous cutoffs, syllabus, patterns</li>
                                            <li><i class="fas fa-phone-alt text-secondary fa-fw"></i> <strong>Dedicated support</strong> for admit card & result queries</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="mt-3"><a href="<?php echo e(route('jobs')); ?>" class="btn-primary-custom"><i class="fas fa-search"></i> Explore latest vacancies</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="card h-100 border-0 bg-soft-primary">
                            <div class="card-body">
                                <h3 class="h5 fw-bold"><i class="fas fa-chart-simple me-1 text-warning"></i> 2026 opportunity snapshot</h3>
                                <div class="my-3">
                                    <div class="d-flex justify-content-between"><span>Railways (RRB)</span><strong>12,500+</strong></div>
                                    <div class="progress mb-2" style="height: 8px;"><div class="progress-bar bg-warning" style="width: 78%"></div></div>
                                    <div class="d-flex justify-content-between"><span>Banking (IBPS/SBI/RBI)</span><strong>8,200+</strong></div>
                                    <div class="progress mb-2" style="height: 8px;"><div class="progress-bar bg-warning" style="width: 65%"></div></div>
                                    <div class="d-flex justify-content-between"><span>SSC & Central exams</span><strong>15,000+</strong></div>
                                    <div class="progress mb-2" style="height: 8px;"><div class="progress-bar bg-warning" style="width: 82%"></div></div>
                                    <div class="d-flex justify-content-between"><span>State PSC & Police</span><strong>14,500+</strong></div>
                                    <div class="progress mb-2" style="height: 8px;"><div class="progress-bar bg-warning" style="width: 70%"></div></div>
                                </div>
                                <hr class="my-3">
                                <p class="mb-0"><i class="fas fa-check-circle text-success"></i> <strong>Pro tip:</strong> Early application & regular tracking increases success probability by 3X. Enable notifications now.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main opportunity categories (original approach replaced with fresh text) -->
                <h3 class="heading mt-4"><i class="fas fa-briefcase me-2"></i> Explore opportunities across sectors & qualifications</h3>
                <p>In 2026, recruitment drives cover everything from Matric (10th) to Doctorate levels. Whether you're eyeing a technical role in PSUs or a gazetted officer post through UPSC, the right doorway is just a click away. Our platform categorises openings by educational background, ensuring you never waste time browsing irrelevant listings.</p>
                <div class="row mt-3 g-3">
                    <div class="col-md-4"><div class="p-3 border rounded-3 bg-white"><i class="fas fa-graduation-cap fa-2x text-warning mb-2"></i><h5 class="fw-semibold">10th/12th based</h5><p class="small">Railway Group D, Police Constable, Forest Guard, MTS, Peon, LDC</p></div></div>
                    <div class="col-md-4"><div class="p-3 border rounded-3 bg-white"><i class="fas fa-university fa-2x text-primary mb-2"></i><h5 class="fw-semibold">Graduate level</h5><p class="small">SSC CGL, Banking PO, RRB NTPC, State PCS, Income Tax Inspector, CDS</p></div></div>
                    <div class="col-md-4"><div class="p-3 border rounded-3 bg-white"><i class="fas fa-microchip fa-2x text-info mb-2"></i><h5 class="fw-semibold">Diploma/ITI / B.E.</h5><p class="small">Junior Engineer, Technician, Fitter, Electrician, Overseer posts</p></div></div>
                </div>

                <!-- Official social channels - concise and clean -->
                <h2 class="heading mt-5"><i class="fab fa-telegram me-2"></i> Official digital presence – stay scam-free</h2>
                <p>We maintain verified handles to counter misinformation. Join our community for instant, reliable updates.</p>
                <div class="social-card">
                    <div class="row row-cols-2 row-cols-md-3 g-2">
                        <div><i class="fab fa-telegram text-primary"></i> <strong>Telegram</strong> <a href="#">@sarkariresult_mobi</a></div>
                        <div><i class="fab fa-whatsapp text-success"></i> <strong>WhatsApp Channel</strong> <a href="#">Sarkari Result Updates</a></div>
                        <div><i class="fab fa-twitter text-info"></i> <strong>X (Twitter)</strong> <a href="#">@sarkariresult</a></div>
                        <div><i class="fab fa-instagram text-danger"></i> <strong>Instagram</strong> <a href="#">@sarkariresult.official</a></div>
                        <div><i class="fab fa-facebook text-primary"></i> <strong>Facebook</strong> <a href="#">SarkariResultCommunity</a></div>
                        <div><i class="fab fa-youtube text-danger"></i> <strong>YouTube</strong> <a href="#">Exam Strategy Hub</a></div>
                    </div>
                    <p class="mt-3 mb-0 small"><i class="fas fa-exclamation-triangle text-warning"></i> Alert: SarkariResult.mobi never asks for money or OTP. Beware of fake pages claiming affiliation.</p>
                </div>

                <!-- Recruitment cycle coverage - concise and helpful -->
                <h3 class="heading">Complete lifecycle of exam tracking</h3>
                <p>From "Notification out" to "Final Merit", we support you at every phase:</p>
                <div class="row mb-4">
                    <div class="col-md-6"><ul><li><i class="fas fa-file-alt text-warning"></i> Admit card downloads (direct official links)</li><li><i class="fas fa-key"></i> Official answer keys & response sheets</li><li><i class="fas fa-chart-line"></i> Cut-off marks & category-wise analysis</li></ul></div>
                    <div class="col-md-6"><ul><li><i class="fas fa-trophy"></i> Final results & merit list PDFs</li><li><i class="fas fa-envelope-open-text"></i> Document verification schedules</li><li><i class="fas fa-print"></i> Interview call letters / DV dates</li></ul></div>
                </div>
                
                <!-- State wise coverage : clearer representation -->
                <h4 class="heading">Pan-India coverage: every state matters</h4>
                <p>We track job announcements from every major state including <strong>Uttar Pradesh, Bihar, Madhya Pradesh, Rajasthan, Maharashtra, Tamil Nadu, Karnataka, West Bengal, Gujarat, Punjab, Haryana, Jharkhand, Odisha, Assam, Kerala, Delhi NCR, Telangana, Andhra Pradesh, Chhattisgarh</strong> and more — all at one place.</p>

                <hr>

                <!-- Why Govt Jobs (value proposition) rewritten uniquely -->
                <h3 class="heading">Why government employment remains the gold standard</h3>
                <p>In an era of uncertainty, public sector roles offer unmatched stability, perks, and work-life balance. More than 70% of graduates still prioritise Sarkari Naukri due to factors like lifetime security, timely promotions, and social prestige.</p>
                <div class="row g-3 mt-1">
                    <div class="col-lg-4"><div class="p-3 bg-light rounded-3"><i class="fas fa-shield-heart fa-2x text-warning mb-2"></i><h6>Job for life</h6><p class="small">No layoffs, defined career progression</p></div></div>
                    <div class="col-lg-4"><div class="p-3 bg-light rounded-3"><i class="fas fa-coins fa-2x text-warning mb-2"></i><h6>7th Pay Commission</h6><p class="small">Lucrative salary + DA, HRA, transport allowance</p></div></div>
                    <div class="col-lg-4"><div class="p-3 bg-light rounded-3"><i class="fas fa-house-chimney fa-2x text-warning mb-2"></i><h6>Retirement benefits</h6><p class="small">NPS, gratuity, pension schemes, medical coverage</p></div></div>
                </div>

                <!-- Simplified roadmap : 6 concise steps -->
                <h2 class="heading mt-4">6-step roadmap to secure a government job in 2026</h2>
                <div class="bg-glow rounded-4 p-4 mb-4">
                    <div class="row gy-3">
                        <div class="col-md-4"><span class="badge bg-warning rounded-circle p-2 me-2">1</span> <strong>Daily monitoring</strong> – visit SarkariResult.mobi or enable push alerts</div>
                        <div class="col-md-4"><span class="badge bg-warning rounded-circle p-2 me-2">2</span> <strong>Check eligibility</strong> – read official PDF thoroughly</div>
                        <div class="col-md-4"><span class="badge bg-warning rounded-circle p-2 me-2">3</span> <strong>Apply early</strong> – avoid last-minute technical glitches</div>
                        <div class="col-md-4"><span class="badge bg-warning rounded-circle p-2 me-2">4</span> <strong>Structured prep</strong> – use previous papers, free mock tests</div>
                        <div class="col-md-4"><span class="badge bg-warning rounded-circle p-2 me-2">5</span> <strong>Admit card tracking</strong> – download 10 days before exam</div>
                        <div class="col-md-4"><span class="badge bg-warning rounded-circle p-2 me-2">6</span> <strong>Post-exam vigilance</strong> – answer key, result, cut-off monitoring</div>
                    </div>
                </div>

                <!-- Top Govt Jobs Table (fresh layout) -->
                <h4 class="heading">📊 Trending recruitments: March–June 2026</h4>
                <div style="overflow-x:auto">
                    <table class="table-custom">
                        <thead><tr><th>Exam / Board</th><th>Post</th><th>Vacancies (approx)</th><th>Application deadline</th><th>Status</th></tr></thead>
                        <tbody>
                            <tr><td>UPSC</td><td>CSE Prelims 2026</td><td>1056</td><td>15 Mar 2026</td><td><span class="status-badge">Active</span></td></tr>
                            <tr><td>SSC</td><td>CGL Tier 1</td><td>~12000</td><td>10 Apr 2026</td><td><span class="status-badge status-soon">Soon</span></td></tr>
                            <tr><td>RRB</td><td>NTPC Graduate & UG</td><td>8600+</td><td>Sep 2026</td><td><span class="status-badge status-upcoming">Upcoming</span></td></tr>
                            <tr><td>IBPS</td><td>PO/MT 2026-27</td><td>4800</td><td>Aug 2026</td><td><span class="status-badge status-upcoming">Notification awaited</span></td></tr>
                            <tr><td>State PSC (UPPSC/BPSC)</td><td>Various officer posts</td><td>3400+</td><td>May–June 2026</td><td><span class="status-badge">Apply soon</span></td></tr>
                        </tbody>
                    </table>
                </div>
                
                <!-- Mobile app highlight -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card bg-soft-primary border-0 p-3 p-md-4">
                            <div class="row align-items-center">
                                <div class="col-md-8"><h4 class="fw-bold"><i class="fab fa-android me-2"></i> Sarkari Result Mobile App – instant alerts at your fingertips</h4><p>Get offline access, personalised exam calendar, push notifications for admit cards and results. Lightweight & free.</p></div>
                                <div class="col-md-4 text-md-end"><a href="#" class="btn-primary-custom"><i class="fas fa-download"></i> Download for Android</a></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FAQ Accordion (fully rewritten Q&A) -->
                <div class="row mt-5">
                    <div class="col-12">
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-4 p-md-5">
                                <h2 class="h3 mb-4 text-primary-custom"><i class="fas fa-circle-question me-2"></i> Frequently asked questions (clearing doubts)</h2>
                                <div class="accordion" id="faqAccordionNew">
                                    <div class="accordion-item"><h3 class="accordion-header"><button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faqNew1">How can I check my Sarkari exam result online safely?</button></h3><div id="faqNew1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordionNew"><div class="accordion-body">Visit SarkariResult.mobi, select the exam name, enter your roll number/DOB, then click on the direct result link which redirects to the official board. We never ask for personal credentials.</div></div></div>
                                    <div class="accordion-item"><h3 class="accordion-header"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqNew2">Is SarkariResult.mobi a genuine website?</button></h3><div id="faqNew2" class="accordion-collapse collapse"><div class="accordion-body">Absolutely. Over 10 million monthly visitors rely on our platform. We only index official PDF links and notifications verified by original recruiting agencies.</div></div></div>
                                    <div class="accordion-item"><h3 class="accordion-header"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqNew3">How to set free job alerts for 2026?</button></h3><div id="faqNew3" class="accordion-collapse collapse"><div class="accordion-body">You can subscribe to our Telegram/WhatsApp channels or enable browser push notifications. All services are completely free.</div></div></div>
                                    <div class="accordion-item"><h3 class="accordion-header"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqNew4">Which government exam has highest salary in 2026?</button></h3><div id="faqNew4" class="accordion-collapse collapse"><div class="accordion-body">Top paying include RBI Grade B officer (₹77k–1.2L), UPSC IAS/IPS (₹56k–2.5L), PSU Management Trainees (₹70k–1.8L).</div></div></div>
                                    <div class="accordion-item"><h3 class="accordion-header"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqNew5">How to download admit card from SarkariResult.mobi?</button></h3><div id="faqNew5" class="accordion-collapse collapse"><div class="accordion-body">Navigate to the 'Admit Card' section, locate your exam, click the link, enter registration number and DOB, then download PDF. We provide direct official gateway.</div></div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Conclusion & final CTA - encouraging but natural -->
                <div class="mt-5 text-center p-4 rounded-4" style="background: linear-gradient(120deg, #fef5e7, #fff);">
                    <i class="fas fa-flag-checkered fa-3x text-warning mb-3"></i>
                    <h3 class="fw-bold">Your career in government service starts with the right information.</h3>
                    <p class="mx-auto" style="max-width:720px">With more than 50,000 vacancies expected in 2026-27, staying ahead matters. Bookmark <strong>SarkariResult.Mobi</strong>, follow our official channels, and turn your preparation into success. Every update we share is a step closer to your dream job.</p>
                    <div class="mt-3"><a href="#" class="btn-primary-custom"><i class="fas fa-bookmark"></i> Bookmark now →</a> <span class="ms-3 small text-muted"><i class="fas fa-sync-alt"></i> Refreshed daily with new openings</span></div>
                </div>
            </div>
        </div>

    </div>

    <?php if(View::exists('components.maincantent')): ?>
        <?php if (isset($component)) { $__componentOriginald7d25cf0c0ced61ac19130e667fe5548 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald7d25cf0c0ced61ac19130e667fe5548 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.maincantent','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('maincantent'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald7d25cf0c0ced61ac19130e667fe5548)): ?>
<?php $attributes = $__attributesOriginald7d25cf0c0ced61ac19130e667fe5548; ?>
<?php unset($__attributesOriginald7d25cf0c0ced61ac19130e667fe5548); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald7d25cf0c0ced61ac19130e667fe5548)): ?>
<?php $component = $__componentOriginald7d25cf0c0ced61ac19130e667fe5548; ?>
<?php unset($__componentOriginald7d25cf0c0ced61ac19130e667fe5548); ?>
<?php endif; ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Update countdown timers if present
        document.querySelectorAll('.countdown-timer[data-end]').forEach(function(el) {
            // Simple placeholder, can be extended
        });

        // prevent double submits
        document.querySelectorAll('form').forEach(function(form) {
            form.addEventListener('submit', function(e) {
                const btn = this.querySelector('button[type="submit"]');
                if (btn && btn.classList.contains('disabled')) {
                    e.preventDefault();
                    return false;
                }
                if (btn) {
                    btn.classList.add('disabled');
                    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Loading...';
                    setTimeout(() => { btn.classList.remove('disabled'); btn.innerHTML = btn.getAttribute('data-original') || 'Submit'; }, 10000);
                }
            });
        });

        // Initialize Bootstrap accordion if needed
        if (typeof bootstrap !== 'undefined' && bootstrap.Accordion) {
            document.querySelectorAll('.accordion').forEach(function(accordionEl) {
                new bootstrap.Accordion(accordionEl);
            });
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\SARKARIMOBI\sarkariresult.mobi\resources\views/home.blade.php ENDPATH**/ ?>