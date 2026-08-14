(function() {
    'use strict';

    // ============================================
    // DOM Elements Cache
    // ============================================
    let elements = {};

    function cacheElements() {
        elements = {
            loadingSpinner: document.getElementById('loadingSpinner'),
            backToTop: document.getElementById('backToTop'),
            navbar: document.querySelector('.navbar'),
            navbarCollapse: document.querySelector('.navbar-collapse'),
            navLinks: document.querySelectorAll('.navbar-nav .nav-link'),
            searchForm: document.querySelector('.search-form'),
            notificationWrapper: document.querySelector('.notification-wrapper'),
            mainContent: document.getElementById('main-content'),
            skipLink: document.querySelector('.skip-to-main')
        };
    }

    // ============================================
    // Loading Spinner Management
    // ============================================
    let spinnerTimeout = null;
    let isSpinnerVisible = false;

    function showSpinner() {
        if (!elements.loadingSpinner) return;
        
        // Clear any existing timeout to prevent premature hiding
        if (spinnerTimeout) {
            clearTimeout(spinnerTimeout);
            spinnerTimeout = null;
        }
        
        if (!isSpinnerVisible) {
            elements.loadingSpinner.classList.add('show');
            isSpinnerVisible = true;
        }
    }

    function hideSpinner() {
        if (!elements.loadingSpinner) return;
        
        if (spinnerTimeout) {
            clearTimeout(spinnerTimeout);
            spinnerTimeout = null;
        }
        
        if (isSpinnerVisible) {
            elements.loadingSpinner.classList.remove('show');
            isSpinnerVisible = false;
        }
    }

    function hideSpinnerWithDelay(delay = 500) {
        if (spinnerTimeout) {
            clearTimeout(spinnerTimeout);
        }
        spinnerTimeout = setTimeout(hideSpinner, delay);
    }

    // ============================================
    // Safe Bootstrap Collapse Handler
    // ============================================
    let bsCollapse = null;

    function initBootstrapCollapse() {
        if (!elements.navbarCollapse) return;
        
        // Check if Bootstrap is available and Collapse is defined
        if (typeof bootstrap !== 'undefined' && bootstrap.Collapse) {
            try {
                // Prevent duplicate initialization
                if (!bsCollapse) {
                    bsCollapse = new bootstrap.Collapse(elements.navbarCollapse, { toggle: false });
                }
            } catch (error) {
                console.warn('Bootstrap Collapse initialization failed:', error);
                bsCollapse = null;
            }
        }
    }

    function closeMobileMenu() {
        if (window.innerWidth < 992 && 
            elements.navbarCollapse && 
            elements.navbarCollapse.classList.contains('show') &&
            bsCollapse) {
            try {
                bsCollapse.hide();
            } catch (error) {
                console.warn('Failed to close mobile menu:', error);
                // Fallback: manually remove show class
                elements.navbarCollapse.classList.remove('show');
            }
        }
    }

    // ============================================
    // Navigation Link Active State
    // ============================================
    function setActiveNavLink() {
        if (!elements.navLinks.length) return;
        
        const currentPath = window.location.pathname;
        
        elements.navLinks.forEach(link => {
            const href = link.getAttribute('href');
            if (href && href !== '#' && href !== '') {
                // Handle both exact match and trailing slash scenarios
                const isActive = currentPath === href || 
                                currentPath === href + '/' || 
                                (href !== '/' && currentPath.endsWith(href));
                
                if (isActive) {
                    link.classList.add('active');
                } else {
                    link.classList.remove('active');
                }
            }
        });
    }

    // ============================================
    // Back to Top Button
    // ============================================
    let scrollTimeout = null;

    function initBackToTop() {
        if (!elements.backToTop) return;
        
        function toggleBackToTop() {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            if (scrollTop > 300) {
                elements.backToTop.classList.add('show');
            } else {
                elements.backToTop.classList.remove('show');
            }
        }
        
        // Throttled scroll handler for better performance
        window.addEventListener('scroll', function() {
            if (scrollTimeout) return;
            scrollTimeout = setTimeout(function() {
                toggleBackToTop();
                scrollTimeout = null;
            }, 50);
        }, { passive: true });
        
        elements.backToTop.addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
        
        // Initial check
        toggleBackToTop();
    }

    // ============================================
    // Skip to Main Content Handler
    // ============================================
    function initSkipToMain() {
        if (!elements.skipLink || !elements.mainContent) return;
        
        elements.skipLink.addEventListener('click', function(e) {
            e.preventDefault();
            elements.mainContent.setAttribute('tabindex', '-1');
            elements.mainContent.focus();
            elements.mainContent.addEventListener('blur', function() {
                elements.mainContent.removeAttribute('tabindex');
            }, { once: true });
        });
    }

    // ============================================
    // Smart Navbar Hide/Show on Scroll (Mobile)
    // ============================================
    let lastScrollTop = 0;
    let tickingNavbar = false;
    let navbarHidden = false;

    function initSmartNavbar() {
        if (!elements.navbar) return;
        
        window.addEventListener('scroll', function() {
            if (tickingNavbar || window.innerWidth >= 768) return;
            
            requestAnimationFrame(function() {
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                
                if (scrollTop > lastScrollTop && scrollTop > 100) {
                    // Scrolling down - hide navbar
                    if (!navbarHidden) {
                        elements.navbar.style.transform = 'translateY(-100%)';
                        navbarHidden = true;
                    }
                } else if (scrollTop < lastScrollTop) {
                    // Scrolling up - show navbar
                    if (navbarHidden) {
                        elements.navbar.style.transform = 'translateY(0)';
                        navbarHidden = false;
                    }
                }
                
                lastScrollTop = scrollTop;
                tickingNavbar = false;
            });
            
            tickingNavbar = true;
        }, { passive: true });
    }

    // ============================================
    // Navigation & Page Transition Handling
    // ============================================
    function isInternalLink(link) {
        const href = link.getAttribute('href');
        if (!href) return false;
        
        // Skip anchor links, javascript, empty, blank targets, and download links
        if (href.startsWith('#') || 
            href.startsWith('javascript:') || 
            href === '' || 
            link.target === '_blank' || 
            link.hasAttribute('download')) {
            return false;
        }
        
        // Check if it's same-origin internal link
        try {
            const url = new URL(href, window.location.href);
            const isSameOrigin = url.origin === window.location.origin;
            const isSamePageHash = (url.pathname === window.location.pathname && 
                                    url.hash && 
                                    url.search === window.location.search);
            
            return isSameOrigin && !isSamePageHash;
        } catch (error) {
            // Invalid URL - treat as internal but safe
            return !href.startsWith('http://') && !href.startsWith('https://');
        }
    }

    function initNavigationTransitions() {
        document.body.addEventListener('click', function(e) {
            const link = e.target.closest('a');
            if (!link) return;
            
            if (isInternalLink(link)) {
                showSpinner();
                hideSpinnerWithDelay(3000);
            }
        });
    }

    // ============================================
    // Modern Navigation API (if available)
    // ============================================
    function initNavigationAPI() {
        if (window.navigation && typeof window.navigation.addEventListener === 'function') {
            window.navigation.addEventListener('navigate', function(event) {
                // Don't show spinner for same-document navigations
                if (!event.navigationType || event.navigationType === 'traverse') {
                    return;
                }
                showSpinner();
                hideSpinnerWithDelay(5000);
            });
        }
    }

    // ============================================
    // Global Loading API Exposure (no duplication)
    // ============================================
    if (!window.showLoading) {
        window.showLoading = showSpinner;
    }
    if (!window.hideLoading) {
        window.hideLoading = hideSpinner;
    }

    // ============================================
    // Error & Connection Monitoring
    // ============================================
    function initErrorMonitoring() {
        window.addEventListener('error', function(event) {
            console.error('Page error:', event.error || event.message);
            hideSpinner();
        });
        
        window.addEventListener('unhandledrejection', function(event) {
            console.error('Unhandled promise rejection:', event.reason);
            hideSpinner();
        });
        
        window.addEventListener('online', function() {
            console.log('Connection restored');
            // Optional: Show temporary notification
        });
        
        window.addEventListener('offline', function() {
            console.warn('You are currently offline');
            // Optional: Show offline warning
        });
    }

    // ============================================
    // Search Form Enhancement
    // ============================================
    let searchDebounceTimer = null;

    function initSearchEnhancement() {
        if (!elements.searchForm) return;
        
        const searchInput = elements.searchForm.querySelector('.form-control');
        const searchButton = elements.searchForm.querySelector('.btn');
        
        if (searchInput) {
            // Clear button functionality
            searchInput.addEventListener('search', function() {
                if (this.value === '') {
                    console.log('Search cleared');
                }
            });
            
            // Debounced search
            searchInput.addEventListener('input', function() {
                if (searchDebounceTimer) {
                    clearTimeout(searchDebounceTimer);
                }
                searchDebounceTimer = setTimeout(() => {
                    if (this.value.length >= 2) {
                        console.log('Search query:', this.value);
                    }
                }, 300);
            });
        }
        
        if (searchButton) {
            searchButton.addEventListener('click', function(e) {
                if (searchInput && searchInput.value.trim() === '') {
                    e.preventDefault();
                    searchInput.focus();
                }
            });
        }
    }

    // ============================================
    // Mobile Menu Close on Link Click
    // ============================================
    function initMobileMenuHandler() {
        if (!elements.navLinks.length) return;
        
        elements.navLinks.forEach(link => {
            // Remove existing listeners to prevent duplicates
            link.removeEventListener('click', closeMobileMenu);
            link.addEventListener('click', closeMobileMenu);
        });
    }

    // ============================================
    // Navbar Scroll Class (shadow enhancement)
    // ============================================
    let scrollClassTimeout = null;

    function initNavbarScrollEffect() {
        if (!elements.navbar) return;
        
        function updateNavbarShadow() {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            if (scrollTop > 10) {
                elements.navbar.classList.add('scrolled');
            } else {
                elements.navbar.classList.remove('scrolled');
            }
        }
        
        window.addEventListener('scroll', function() {
            if (scrollClassTimeout) return;
            scrollClassTimeout = setTimeout(function() {
                updateNavbarShadow();
                scrollClassTimeout = null;
            }, 30);
        }, { passive: true });
        
        updateNavbarShadow();
    }

    // ============================================
    // Page Load Handler
    // ============================================
    function handlePageLoad() {
        // Hide spinner after page is fully loaded
        hideSpinnerWithDelay(500);
        
        // Trigger any post-load animations or initializations
        document.body.classList.add('page-loaded');
    }

    // ============================================
    // Resize Handler for Mobile Menu State Reset
    // ============================================
    let resizeTimer = null;

    function initResizeHandler() {
        window.addEventListener('resize', function() {
            if (resizeTimer) {
                clearTimeout(resizeTimer);
            }
            resizeTimer = setTimeout(function() {
                // Reset navbar transform on resize
                if (elements.navbar && window.innerWidth >= 768 && navbarHidden) {
                    elements.navbar.style.transform = '';
                    navbarHidden = false;
                }
                
                // If window becomes large, ensure mobile menu is closed properly
                if (window.innerWidth >= 992 && elements.navbarCollapse && bsCollapse) {
                    try {
                        if (elements.navbarCollapse.classList.contains('show')) {
                            bsCollapse.hide();
                        }
                    } catch (error) {
                        // Fallback
                        elements.navbarCollapse.classList.remove('show');
                    }
                }
            }, 150);
        });
    }

    // ============================================
    // Check if script already initialized
    // ============================================
    if (window._navbarInitialized) {
        return;
    }

    // ============================================
    // Initialize everything
    // ============================================
    function initAll() {
        // Prevent duplicate initialization
        if (window._navbarInitialized) {
            return;
        }
        
        cacheElements();
        
        // Core functionality (always initialize)
        setActiveNavLink();
        initBackToTop();
        initSkipToMain();
        initNavigationTransitions();
        initNavigationAPI();
        initErrorMonitoring();
        initNavbarScrollEffect();
        
        // Conditional/mobile-specific features
        if (elements.navbar) {
            initSmartNavbar();
        }
        
        if (elements.navbarCollapse) {
            initBootstrapCollapse();
            initMobileMenuHandler();
        }
        
        if (elements.searchForm) {
            initSearchEnhancement();
        }
        
        initResizeHandler();
        
        // Page load handler
        if (document.readyState === 'loading') {
            window.addEventListener('load', handlePageLoad);
        } else {
            handlePageLoad();
        }
        
        // Mark as initialized
        window._navbarInitialized = true;
    }

    // ============================================
    // Start when DOM is ready
    // ============================================
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAll);
    } else {
        initAll();
    }

})();