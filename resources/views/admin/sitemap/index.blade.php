{{-- resources/views/admin/sitemap/index.blade.php --}}
@extends('admin.layout')

@section('title', 'Sitemap Management')
@section('page_title', 'Sitemap Management')

@push('styles')
<style>
    .sitemap-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 15px;
        margin-bottom: 25px;
    }
    
    .stat-card {
        background: #fff;
        border-radius: 12px;
        padding: 18px 15px;
        text-align: center;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        border: 1px solid #e9ecef;
        transition: all 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    }
    
    .stat-number {
        font-size: 28px;
        font-weight: 700;
        color: #ab183d;
        line-height: 1.2;
    }
    
    .stat-label {
        font-size: 13px;
        color: #6c757d;
        margin-top: 4px;
    }
    
    .stat-card.total .stat-number { color: #28a745; }
    .stat-card.jobs .stat-number { color: #ab183d; }
    .stat-card.results .stat-number { color: #17a2b8; }
    .stat-card.admit .stat-number { color: #fd7e14; }
    .stat-card.documents .stat-number { color: #6f42c1; }
    
    .sitemap-urls {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 15px 20px;
        margin-top: 15px;
    }
    
    .sitemap-urls .url-item {
        padding: 6px 0;
        border-bottom: 1px solid #e9ecef;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }
    
    .sitemap-urls .url-item:last-child {
        border-bottom: none;
    }
    
    .sitemap-urls .url-label {
        font-weight: 600;
        color: #495057;
        min-width: 100px;
    }
    
    .sitemap-urls .url-link {
        color: #ab183d;
        text-decoration: none;
        word-break: break-all;
        font-size: 13px;
    }
    
    .sitemap-urls .url-link:hover {
        text-decoration: underline;
    }
    
    .action-buttons {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        margin: 20px 0;
    }
    
    .btn-sitemap {
        padding: 10px 24px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }
    
    .btn-sitemap-primary {
        background: #ab183d;
        color: #fff;
    }
    
    .btn-sitemap-primary:hover {
        background: #8b1030;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(171, 24, 61, 0.3);
    }
    
    .btn-sitemap-success {
        background: #28a745;
        color: #fff;
    }
    
    .btn-sitemap-success:hover {
        background: #1e7e34;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
    }
    
    .btn-sitemap-warning {
        background: #ffc107;
        color: #000;
    }
    
    .btn-sitemap-warning:hover {
        background: #e0a800;
        transform: translateY(-2px);
    }
    
    .btn-sitemap-secondary {
        background: #6c757d;
        color: #fff;
    }
    
    .btn-sitemap-secondary:hover {
        background: #5a6268;
        transform: translateY(-2px);
    }
    
    .btn-sitemap-danger {
        background: #dc3545;
        color: #fff;
    }
    
    .btn-sitemap-danger:hover {
        background: #c82333;
        transform: translateY(-2px);
    }
    
    .btn-sitemap-outline {
        background: transparent;
        color: #ab183d;
        border: 2px solid #ab183d;
    }
    
    .btn-sitemap-outline:hover {
        background: #ab183d;
        color: #fff;
        transform: translateY(-2px);
    }
    
    .btn-sitemap-sm {
        padding: 6px 14px;
        font-size: 12px;
    }
    
    .progress-bar-container {
        width: 100%;
        height: 8px;
        background: #e9ecef;
        border-radius: 4px;
        overflow: hidden;
        margin: 10px 0;
    }
    
    .progress-bar-fill {
        height: 100%;
        background: linear-gradient(90deg, #ab183d, #fd7e14);
        border-radius: 4px;
        transition: width 0.5s ease;
        width: 0%;
    }
    
    .last-generated {
        font-size: 13px;
        color: #6c757d;
        padding: 10px 0;
    }
    
    .last-generated strong {
        color: #ab183d;
    }
    
    .status-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    
    .status-badge.success { background: #d4edda; color: #155724; }
    .status-badge.warning { background: #fff3cd; color: #856404; }
    .status-badge.danger { background: #f8d7da; color: #721c24; }
    
    /* Loading Spinner */
    .spinner-sitemap {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 3px solid rgba(255,255,255,0.3);
        border-top-color: #fff;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }
    
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .sitemap-stats {
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }
        
        .stat-number {
            font-size: 22px;
        }
        
        .sitemap-urls .url-item {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .btn-sitemap {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0"><i class="fas fa-sitemap text-primary"></i> Sitemap Management</h4>
            <p class="text-muted small">Generate and manage XML sitemaps for better SEO and Google ranking</p>
        </div>
        <div>
            <span class="status-badge {{ $stats['last_generated'] != 'Never' ? 'success' : 'warning' }}">
                {{ $stats['last_generated'] != 'Never' ? '✅ Active' : '⚠️ Not Generated' }}
            </span>
        </div>
    </div>
    
    <!-- Statistics Cards -->
    <div class="sitemap-stats">
        <div class="stat-card total">
            <div class="stat-number">{{ number_format($stats['total_urls']) }}</div>
            <div class="stat-label">Total URLs</div>
        </div>
        <div class="stat-card jobs">
            <div class="stat-number">{{ number_format($stats['jobs']) }}</div>
            <div class="stat-label"><i class="fas fa-briefcase"></i> Jobs</div>
        </div>
        <div class="stat-card results">
            <div class="stat-number">{{ number_format($stats['results']) }}</div>
            <div class="stat-label"><i class="fas fa-chart-bar"></i> Results</div>
        </div>
        <div class="stat-card admit">
            <div class="stat-number">{{ number_format($stats['admit_cards']) }}</div>
            <div class="stat-label"><i class="fas fa-ticket-alt"></i> Admit Cards</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ number_format($stats['answer_keys']) }}</div>
            <div class="stat-label"><i class="fas fa-key"></i> Answer Keys</div>
        </div>
        <div class="stat-card documents">
            <div class="stat-number">{{ number_format($stats['documents']) }}</div>
            <div class="stat-label"><i class="fas fa-file-alt"></i> Documents</div>
        </div>
    </div>
    
    <!-- Last Generated Info -->
    <div class="last-generated">
        <i class="fas fa-clock"></i> Last Generated: 
        <strong>{{ $stats['last_generated'] }}</strong> 
        | Cache Duration: <strong>{{ $stats['cache_duration'] }}</strong>
    </div>
    
    <!-- Action Buttons -->
    <div class="action-buttons">
        <button type="button" class="btn-sitemap btn-sitemap-primary" id="generateAllBtn">
            <i class="fas fa-sync-alt"></i> Generate All Sitemaps
        </button>
        
        <button type="button" class="btn-sitemap btn-sitemap-success" id="generateAllWithPingBtn">
            <i class="fas fa-bullhorn"></i> Generate & Ping Search Engines
        </button>
        
        <button type="button" class="btn-sitemap btn-sitemap-warning" id="clearCacheBtn">
            <i class="fas fa-trash-alt"></i> Clear Sitemap Cache
        </button>
        
        <a href="{{ route('sitemap.index') }}" target="_blank" class="btn-sitemap btn-sitemap-outline">
            <i class="fas fa-external-link-alt"></i> View Sitemap Index
        </a>
        
        <a href="/robots.txt" target="_blank" class="btn-sitemap btn-sitemap-secondary">
            <i class="fas fa-robot"></i> View Robots.txt
        </a>
    </div>
    
    <!-- Individual Sitemap Generation -->
    <div class="card mt-3">
        <div class="card-header">
            <h6 class="mb-0"><i class="fas fa-plus-circle"></i> Generate Individual Sitemaps</h6>
        </div>
        <div class="card-body">
            <div class="d-flex flex-wrap gap-2">
                <button class="btn btn-outline-primary btn-sm generate-specific" data-type="pages">
                    <i class="fas fa-file"></i> Pages
                </button>
                <button class="btn btn-outline-danger btn-sm generate-specific" data-type="jobs">
                    <i class="fas fa-briefcase"></i> Jobs
                </button>
                <button class="btn btn-outline-success btn-sm generate-specific" data-type="results">
                    <i class="fas fa-chart-bar"></i> Results
                </button>
                <button class="btn btn-outline-info btn-sm generate-specific" data-type="admit-cards">
                    <i class="fas fa-ticket-alt"></i> Admit Cards
                </button>
                <button class="btn btn-outline-warning btn-sm generate-specific" data-type="answer-keys">
                    <i class="fas fa-key"></i> Answer Keys
                </button>
                <button class="btn btn-outline-secondary btn-sm generate-specific" data-type="documents">
                    <i class="fas fa-file-alt"></i> Documents
                </button>
                <button class="btn btn-outline-dark btn-sm generate-specific" data-type="categories">
                    <i class="fas fa-folder"></i> Categories
                </button>
            </div>
        </div>
    </div>
    
    <!-- Sitemap URLs -->
    <div class="card mt-3">
        <div class="card-header">
            <h6 class="mb-0"><i class="fas fa-link"></i> Sitemap URLs</h6>
        </div>
        <div class="card-body">
            <div class="sitemap-urls">
                @foreach($sitemapUrls as $name => $url)
                    <div class="url-item">
                        <span class="url-label">
                            <i class="fas fa-file-code"></i> 
                            {{ ucfirst(str_replace('-', ' ', $name)) }}
                        </span>
                        <a href="{{ $url }}" target="_blank" class="url-link">
                            {{ $url }}
                            <i class="fas fa-external-link-alt ms-1" style="font-size: 11px;"></i>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    
    <!-- Progress Bar -->
    <div id="progressContainer" style="display: none;" class="mt-3">
        <div class="progress-bar-container">
            <div class="progress-bar-fill" id="progressFill"></div>
        </div>
        <p id="progressText" class="text-muted small">Generating sitemaps...</p>
    </div>
    
    <!-- Alert Container -->
    <div id="alertContainer" class="mt-3"></div>
    
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const generateAllBtn = document.getElementById('generateAllBtn');
    const generateAllWithPingBtn = document.getElementById('generateAllWithPingBtn');
    const clearCacheBtn = document.getElementById('clearCacheBtn');
    const generateSpecificBtns = document.querySelectorAll('.generate-specific');
    const progressContainer = document.getElementById('progressContainer');
    const progressFill = document.getElementById('progressFill');
    const progressText = document.getElementById('progressText');
    const alertContainer = document.getElementById('alertContainer');
    
    // Show alert message
    function showAlert(message, type = 'success') {
        const colors = {
            success: 'border-green-500 bg-green-50 text-green-800',
            error: 'border-red-500 bg-red-50 text-red-800',
            warning: 'border-yellow-500 bg-yellow-50 text-yellow-800',
            info: 'border-blue-500 bg-blue-50 text-blue-800'
        };
        
        alertContainer.innerHTML = `
            <div class="p-4 border-l-4 rounded ${colors[type] || colors.info} shadow-sm">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm">${message}</p>
                    </div>
                </div>
            </div>
        `;
        
        // Auto dismiss after 8 seconds
        setTimeout(() => {
            alertContainer.innerHTML = '';
        }, 8000);
    }
    
    // Show progress
    function showProgress(progress, text) {
        progressContainer.style.display = 'block';
        progressFill.style.width = progress + '%';
        progressText.textContent = text;
        
        if (progress >= 100) {
            setTimeout(() => {
                progressContainer.style.display = 'none';
            }, 2000);
        }
    }
    
    // Generate all sitemaps
    function generateAllSitemaps(ping = false) {
        const url = ping 
            ? '{{ route("admin.sitemap.generate") }}?ping=true'
            : '{{ route("admin.sitemap.generate") }}';
        
        // Disable buttons
        generateAllBtn.disabled = true;
        generateAllWithPingBtn.disabled = true;
        generateAllBtn.innerHTML = '<span class="spinner-sitemap"></span> Generating...';
        generateAllWithPingBtn.innerHTML = '<span class="spinner-sitemap"></span> Generating...';
        
        showProgress(10, 'Starting sitemap generation...');
        
        fetch(url, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            showProgress(100, 'Sitemap generation complete!');
            
            if (data.success) {
                showAlert(data.message, 'success');
                
                // Update last generated time
                setTimeout(() => {
                    location.reload();
                }, 2000);
            } else {
                showAlert(data.message, 'error');
            }
        })
        .catch(error => {
            showProgress(100, 'Generation failed!');
            showAlert('An error occurred: ' + error.message, 'error');
        })
        .finally(() => {
            generateAllBtn.disabled = false;
            generateAllWithPingBtn.disabled = false;
            generateAllBtn.innerHTML = '<i class="fas fa-sync-alt"></i> Generate All Sitemaps';
            generateAllWithPingBtn.innerHTML = '<i class="fas fa-bullhorn"></i> Generate & Ping Search Engines';
        });
    }
    
    // Generate specific sitemap
    function generateSpecificSitemap(type) {
        const btn = document.querySelector(`.generate-specific[data-type="${type}"]`);
        const originalText = btn.innerHTML;
        
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-sitemap"></span>';
        
        showProgress(30, `Generating ${type} sitemap...`);
        
        const generateSpecificUrl = "{{ url('admin/sitemap/generate') }}";
        fetch(`${generateSpecificUrl}/${type}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            showProgress(100, `${type} sitemap generated!`);
            
            if (data.success) {
                showAlert(data.message, 'success');
            } else {
                showAlert(data.message, 'error');
            }
        })
        .catch(error => {
            showProgress(100, 'Generation failed!');
            showAlert('An error occurred: ' + error.message, 'error');
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = originalText;
        });
    }
    
    // Clear cache
    function clearSitemapCache() {
        if (!confirm('Are you sure you want to clear all sitemap cache? This will require regeneration.')) {
            return;
        }
        
        clearCacheBtn.disabled = true;
        clearCacheBtn.innerHTML = '<span class="spinner-sitemap"></span>';
        
        showProgress(50, 'Clearing cache...');
        
        fetch('{{ route("admin.sitemap.clear-cache") }}', {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            showProgress(100, 'Cache cleared!');
            
            if (data.success) {
                showAlert(data.message, 'success');
                setTimeout(() => location.reload(), 1500);
            } else {
                showAlert(data.message, 'error');
            }
        })
        .catch(error => {
            showProgress(100, 'Failed!');
            showAlert('An error occurred: ' + error.message, 'error');
        })
        .finally(() => {
            clearCacheBtn.disabled = false;
            clearCacheBtn.innerHTML = '<i class="fas fa-trash-alt"></i> Clear Sitemap Cache';
        });
    }
    
    // Event Listeners
    generateAllBtn.addEventListener('click', function() {
        generateAllSitemaps(false);
    });
    
    generateAllWithPingBtn.addEventListener('click', function() {
        generateAllSitemaps(true);
    });
    
    clearCacheBtn.addEventListener('click', clearSitemapCache);
    
    generateSpecificBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const type = this.dataset.type;
            generateSpecificSitemap(type);
        });
    });
    
    // Refresh stats every 60 seconds
    setInterval(function() {
        fetch('{{ route("admin.sitemap.stats") }}', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data && !data.error) {
                // Update stats quietly
                console.log('Stats updated');
            }
        })
        .catch(error => console.log('Stats update failed'));
    }, 60000);
});
</script>
@endpush
@endsection