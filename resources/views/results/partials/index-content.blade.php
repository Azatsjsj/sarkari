{{-- resources/views/results/partials/index-content.blade.php --}}
<div class="container mt-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="display-5 fw-bold text-primary">
                <i class="fas fa-chart-line"></i> Latest Results
            </h2>
            <p class="text-muted">Check your Sarkari Result, Exam Results, and Recruitment Updates</p>
        </div>
        <div class="col-md-4">
            <div class="input-group">
                <input type="text" 
                       id="resultSearch" 
                       class="form-control" 
                       placeholder="Search results..." 
                       aria-label="Search results">
                <button class="btn btn-primary" type="button" id="searchBtn">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <label for="categoryFilter" class="form-label">
                        <i class="fas fa-filter"></i> Category
                    </label>
                    <select id="categoryFilter" class="form-select">
                        <option value="">All Categories</option>
                        @foreach($categories ?? [] as $category)
                            <option value="{{ $category->slug }}" 
                                {{ request('category') == $category->slug ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label for="yearFilter" class="form-label">
                        <i class="fas fa-calendar"></i> Year
                    </label>
                    <select id="yearFilter" class="form-select">
                        <option value="">All Years</option>
                        @for($year = date('Y'); $year >= date('Y')-5; $year--)
                            <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endfor
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label for="sortFilter" class="form-label">
                        <i class="fas fa-sort"></i> Sort By
                    </label>
                    <select id="sortFilter" class="form-select">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest First</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                        <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                        <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>Title (A-Z)</option>
                        <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>Title (Z-A)</option>
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <div>
                        <button id="resetFilters" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-undo-alt"></i> Reset Filters
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Results Count and View Toggle -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <span class="badge bg-primary fs-6">
                <i class="fas fa-chart-simple"></i> Total Results: 
                <span id="resultCount">{{ $results->total() }}</span>
            </span>
        </div>
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-outline-secondary active" id="gridViewBtn">
                <i class="fas fa-th-large"></i> Grid
            </button>
            <button type="button" class="btn btn-outline-secondary" id="listViewBtn">
                <i class="fas fa-list"></i> List
            </button>
        </div>
    </div>

    <!-- Results Grid/List View -->
    <div id="resultsContainer">
        @if($results->count() > 0)
            <div class="row" id="resultsGrid">
                @foreach($results as $result)
                    <div class="col-md-6 col-lg-4 mb-4 result-item" 
                         data-title="{{ strtolower($result->title) }}"
                         data-category="{{ $result->job->category->slug ?? '' }}"
                         data-year="{{ $result->result_date ? date('Y', strtotime($result->result_date)) : '' }}">
                        <div class="card h-100 shadow-sm result-card">
                            <!-- Badge Section -->
                            <div class="position-absolute top-0 end-0 m-2">
                                <span class="badge bg-success">
                                    <i class="fas fa-check-circle"></i> Published
                                </span>
                            </div>
                            
                            <!-- Card Header -->
                            <div class="card-header bg-white border-bottom-0 pt-3">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="result-icon bg-light rounded p-2">
                                        <i class="fas fa-file-pdf text-danger fs-2"></i>
                                    </div>
                                    <small class="text-muted">
                                        <i class="far fa-calendar-alt"></i>
                                        {{ \Carbon\Carbon::parse($result->result_date)->format('d M Y') }}
                                    </small>
                                </div>
                            </div>
                            
                            <!-- Card Body -->
                            <div class="card-body">
                                <h5 class="card-title text-primary">
                                    <a href="{{ route('results.show', $result->slug) }}" 
                                       class="text-decoration-none stretched-link">
                                        {{ Str::limit($result->title, 60) }}
                                    </a>
                                </h5>
                                
                                <div class="mb-2">
                                    <span class="badge bg-info text-dark">
                                        <i class="fas fa-briefcase"></i> 
                                        {{ Str::limit($result->job->title ?? 'N/A', 30) }}
                                    </span>
                                    <span class="badge bg-secondary">
                                        <i class="fas fa-building"></i> 
                                        {{ $result->job->category->name ?? 'General' }}
                                    </span>
                                </div>
                                
                                @if($result->job->total_post)
                                <div class="small text-muted mb-2">
                                    <i class="fas fa-users"></i> Total Posts: {{ $result->job->total_post }}
                                </div>
                                @endif
                                
                                <div class="result-preview mt-2">
                                    <p class="small text-muted">
                                        {{ Str::limit(strip_tags($result->description ?? 'Click to view detailed result information.'), 100) }}
                                    </p>
                                </div>
                            </div>
                            
                            <!-- Card Footer -->
                            <div class="card-footer bg-white border-top-0 pb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group w-100" role="group">
                                        <a href="{{ $result->result_link }}" 
                                           target="_blank"  rel="nofollow noopener noreferrer"
                                           class="btn btn-sm btn-outline-success"
                                           data-bs-toggle="tooltip" 
                                           title="View on Official Website">
                                            <i class="fas fa-external-link-alt"></i> View
                                        </a>
                                        @if($result->result_file)
                                        <a href="{{ Storage::url($result->result_file) }}" 
                                           download 
                                           class="btn btn-sm btn-outline-primary"
                                           data-bs-toggle="tooltip" 
                                           title="Download PDF">
                                            <i class="fas fa-download"></i> PDF
                                        </a>
                                        @endif
                                        <button class="btn btn-sm btn-outline-secondary share-result" 
                                                data-url="{{ route('results.show', $result->slug) }}"
                                                data-title="{{ $result->title }}"
                                                data-bs-toggle="tooltip" 
                                                title="Share Result">
                                            <i class="fas fa-share-alt"></i> Share
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- List View (Hidden by default) -->
            <div id="resultsList" class="d-none">
                <div class="list-group">
                    @foreach($results as $result)
                        <a href="{{ route('results.show', $result->slug) }}" 
                           class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1 text-primary">
                                        <i class="fas fa-chart-bar"></i> {{ $result->title }}
                                    </h6>
                                    <small class="text-muted">
                                        <i class="fas fa-briefcase"></i> {{ $result->job->title ?? 'N/A' }} | 
                                        <i class="fas fa-building"></i> {{ $result->job->category->name ?? 'General' }} | 
                                        <i class="far fa-calendar"></i> {{ \Carbon\Carbon::parse($result->result_date)->format('d M Y') }}
                                    </small>
                                </div>
                                <div class="btn-group">
                                    <a href="{{ $result->result_link }}" 
                                       target="_blank"  rel="nofollow noopener noreferrer"
                                       class="btn btn-sm btn-success">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                    @if($result->result_file)
                                    <a href="{{ Storage::url($result->result_file) }}" 
                                       download 
                                       class="btn btn-sm btn-primary">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $results->withQueryString()->links() }}
            </div>
            
        @else
            <!-- No Results Found -->
            <div class="text-center py-5">
                <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                <h3 class="text-muted">No Results Found</h3>
                <p class="text-muted">Try adjusting your search or filter criteria</p>
                <button id="clearAllFilters" class="btn btn-primary">
                    <i class="fas fa-eraser"></i> Clear All Filters
                </button>
            </div>
        @endif
    </div>
    
    <!-- Load More Button (Optional - for infinite scroll) -->
    @if($results->hasMorePages())
    <div class="text-center mt-4">
        <button id="loadMoreBtn" class="btn btn-outline-primary btn-lg">
            <i class="fas fa-spinner fa-spin d-none"></i>
            Load More Results
        </button>
    </div>
    @endif
</div>

<!-- Share Modal -->
<div class="modal fade" id="shareModal" tabindex="-1" aria-labelledby="shareModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="shareModalLabel">
                    <i class="fas fa-share-alt"></i> Share Result
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-3" id="shareTitle"></p>
                <div class="input-group mb-3">
                    <input type="text" id="shareLink" class="form-control" readonly>
                    <button class="btn btn-outline-secondary" type="button" id="copyShareLink">
                        <i class="fas fa-copy"></i> Copy
                    </button>
                </div>
                <div class="d-grid gap-2">
                    <button class="btn btn-facebook" id="shareFacebook">
                        <i class="fab fa-facebook-f"></i> Share on Facebook
                    </button>
                    <button class="btn btn-twitter" id="shareTwitter">
                        <i class="fab fa-twitter"></i> Share on Twitter
                    </button>
                    <button class="btn btn-success" id="shareWhatsApp">
                        <i class="fab fa-whatsapp"></i> Share on WhatsApp
                    </button>
                    <button class="btn btn-danger" id="shareTelegram">
                        <i class="fab fa-telegram"></i> Share on Telegram
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.result-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: none;
    overflow: hidden;
}

.result-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}

.result-icon {
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-facebook {
    background-color: #3b5998;
    border-color: #3b5998;
    color: white;
}

.btn-twitter {
    background-color: #1da1f2;
    border-color: #1da1f2;
    color: white;
}

.btn-telegram {
    background-color: #0088cc;
    border-color: #0088cc;
    color: white;
}

.result-item {
    animation: fadeInUp 0.5s ease;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* List view styles */
#resultsList .list-group-item:hover {
    background-color: #f8f9fa;
    transform: translateX(5px);
    transition: all 0.2s ease;
}

/* Loading spinner */
.spinner-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255,255,255,0.8);
    z-index: 9999;
    display: flex;
    justify-content: center;
    align-items: center;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .result-card .btn-group {
        flex-direction: column;
        gap: 5px;
    }
    
    .result-card .btn-group .btn {
        width: 100%;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
    
    // Grid/List View Toggle
    const gridViewBtn = document.getElementById('gridViewBtn');
    const listViewBtn = document.getElementById('listViewBtn');
    const resultsGrid = document.getElementById('resultsGrid');
    const resultsList = document.getElementById('resultsList');
    
    if(gridViewBtn && listViewBtn) {
        // Check localStorage for view preference
        const savedView = localStorage.getItem('resultsViewPreference');
        if(savedView === 'list') {
            showListView();
        }
        
        gridViewBtn.addEventListener('click', function() {
            showGridView();
            localStorage.setItem('resultsViewPreference', 'grid');
        });
        
        listViewBtn.addEventListener('click', function() {
            showListView();
            localStorage.setItem('resultsViewPreference', 'list');
        });
    }
    
    function showGridView() {
        resultsGrid.classList.remove('d-none');
        resultsList.classList.add('d-none');
        gridViewBtn.classList.add('active');
        listViewBtn.classList.remove('active');
    }
    
    function showListView() {
        resultsGrid.classList.add('d-none');
        resultsList.classList.remove('d-none');
        listViewBtn.classList.add('active');
        gridViewBtn.classList.remove('active');
    }
    
    // Search functionality
    const searchInput = document.getElementById('resultSearch');
    const searchBtn = document.getElementById('searchBtn');
    
    function performSearch() {
        const searchTerm = searchInput.value.toLowerCase();
        const resultItems = document.querySelectorAll('#resultsGrid .result-item');
        let visibleCount = 0;
        
        resultItems.forEach(item => {
            const title = item.dataset.title;
            if(title.includes(searchTerm)) {
                item.style.display = '';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });
        
        // Update visible count
        document.getElementById('resultCount').textContent = visibleCount;
        
        // Show/hide no results message
        const noResultsMsg = document.getElementById('noResultsMessage');
        if(visibleCount === 0 && resultItems.length > 0) {
            if(!noResultsMsg) {
                const msg = document.createElement('div');
                msg.id = 'noResultsMessage';
                msg.className = 'alert alert-warning text-center mt-3';
                msg.innerHTML = '<i class="fas fa-search"></i> No matching results found';
                document.getElementById('resultsGrid').appendChild(msg);
            }
        } else if(noResultsMsg) {
            noResultsMsg.remove();
        }
    }
    
    if(searchBtn) {
        searchBtn.addEventListener('click', performSearch);
        searchInput.addEventListener('keyup', function(e) {
            if(e.key === 'Enter') {
                performSearch();
            }
        });
    }
    
    // Filter functionality
    const categoryFilter = document.getElementById('categoryFilter');
    const yearFilter = document.getElementById('yearFilter');
    const sortFilter = document.getElementById('sortFilter');
    const resetFilters = document.getElementById('resetFilters');
    const clearAllFilters = document.getElementById('clearAllFilters');
    
    function applyFilters() {
        const selectedCategory = categoryFilter ? categoryFilter.value : '';
        const selectedYear = yearFilter ? yearFilter.value : '';
        const resultItems = document.querySelectorAll('#resultsGrid .result-item');
        let visibleCount = 0;
        
        resultItems.forEach(item => {
            const itemCategory = item.dataset.category;
            const itemYear = item.dataset.year;
            
            let categoryMatch = !selectedCategory || itemCategory === selectedCategory;
            let yearMatch = !selectedYear || itemYear === selectedYear;
            
            if(categoryMatch && yearMatch) {
                item.style.display = '';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });
        
        // Apply sorting
        applySorting();
        
        document.getElementById('resultCount').textContent = visibleCount;
        
        // Update URL with filters (optional)
        updateURLParams();
    }
    
    function applySorting() {
        const sortValue = sortFilter ? sortFilter.value : 'latest';
        const grid = document.getElementById('resultsGrid');
        const items = Array.from(grid.children);
        
        items.sort((a, b) => {
            const titleA = a.querySelector('.card-title').innerText;
            const titleB = b.querySelector('.card-title').innerText;
            const dateA = a.querySelector('.text-muted small').innerText;
            const dateB = b.querySelector('.text-muted small').innerText;
            
            switch(sortValue) {
                case 'title_asc':
                    return titleA.localeCompare(titleB);
                case 'title_desc':
                    return titleB.localeCompare(titleA);
                case 'oldest':
                    return new Date(dateA) - new Date(dateB);
                case 'latest':
                default:
                    return new Date(dateB) - new Date(dateA);
            }
        });
        
        items.forEach(item => grid.appendChild(item));
    }
    
    function updateURLParams() {
        const params = new URLSearchParams();
        if(categoryFilter && categoryFilter.value) params.set('category', categoryFilter.value);
        if(yearFilter && yearFilter.value) params.set('year', yearFilter.value);
        if(sortFilter && sortFilter.value) params.set('sort', sortFilter.value);
        
        const newUrl = `${window.location.pathname}${params.toString() ? '?' + params.toString() : ''}`;
        window.history.pushState({}, '', newUrl);
    }
    
    function resetAllFilters() {
        if(categoryFilter) categoryFilter.value = '';
        if(yearFilter) yearFilter.value = '';
        if(sortFilter) sortFilter.value = 'latest';
        if(searchInput) searchInput.value = '';
        
        applyFilters();
        performSearch();
    }
    
    if(categoryFilter) categoryFilter.addEventListener('change', applyFilters);
    if(yearFilter) yearFilter.addEventListener('change', applyFilters);
    if(sortFilter) sortFilter.addEventListener('change', applySorting);
    if(resetFilters) resetFilters.addEventListener('click', resetAllFilters);
    if(clearAllFilters) clearAllFilters.addEventListener('click', resetAllFilters);
    
    // Share functionality
    const shareModal = new bootstrap.Modal(document.getElementById('shareModal'));
    let currentShareUrl = '';
    let currentShareTitle = '';
    
    document.querySelectorAll('.share-result').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            currentShareUrl = this.dataset.url;
            currentShareTitle = this.dataset.title;
            
            document.getElementById('shareTitle').innerHTML = `<strong>${currentShareTitle}</strong>`;
            document.getElementById('shareLink').value = window.location.origin + currentShareUrl;
            
            shareModal.show();
        });
    });
    
    document.getElementById('copyShareLink')?.addEventListener('click', function() {
        const shareLink = document.getElementById('shareLink');
        shareLink.select();
        document.execCommand('copy');
        
        // Show feedback
        const originalText = this.innerHTML;
        this.innerHTML = '<i class="fas fa-check"></i> Copied!';
        setTimeout(() => {
            this.innerHTML = originalText;
        }, 2000);
    });
    
    document.getElementById('shareFacebook')?.addEventListener('click', function() {
        const url = encodeURIComponent(window.location.origin + currentShareUrl);
        window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, '_blank', 'width=600,height=400');
    });
    
    document.getElementById('shareTwitter')?.addEventListener('click', function() {
        const url = encodeURIComponent(window.location.origin + currentShareUrl);
        const text = encodeURIComponent(currentShareTitle);
        window.open(`https://twitter.com/intent/tweet?url=${url}&text=${text}`, '_blank', 'width=600,height=400');
    });
    
    document.getElementById('shareWhatsApp')?.addEventListener('click', function() {
        const url = encodeURIComponent(window.location.origin + currentShareUrl);
        const text = encodeURIComponent(currentShareTitle);
        window.open(`https://wa.me/?text=${text}%20${url}`, '_blank');
    });
    
    document.getElementById('shareTelegram')?.addEventListener('click', function() {
        const url = encodeURIComponent(window.location.origin + currentShareUrl);
        const text = encodeURIComponent(currentShareTitle);
        window.open(`https://t.me/share/url?url=${url}&text=${text}`, '_blank');
    });
    
    // Load More functionality (AJAX)
    const loadMoreBtn = document.getElementById('loadMoreBtn');
    let currentPage = 1;
    
    if(loadMoreBtn) {
        loadMoreBtn.addEventListener('click', async function() {
            const spinner = this.querySelector('.fa-spinner');
            spinner.classList.remove('d-none');
            currentPage++;
            
            try {
                const response = await fetch(`${window.location.pathname}?page=${currentPage}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                const html = await response.text();
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = html;
                const newResults = tempDiv.querySelectorAll('#resultsGrid .result-item');
                
                newResults.forEach(result => {
                    document.getElementById('resultsGrid').appendChild(result);
                });
                
                // Update pagination if needed
                if(!tempDiv.querySelector('#loadMoreBtn')) {
                    loadMoreBtn.style.display = 'none';
                }
            } catch(error) {
                console.error('Error loading more results:', error);
            } finally {
                spinner.classList.add('d-none');
            }
        });
    }
    
    // Animate results on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if(entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    document.querySelectorAll('.result-item').forEach(item => {
        item.style.opacity = '0';
        item.style.transform = 'translateY(20px)';
        item.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        observer.observe(item);
    });
});
</script>
@endpush
