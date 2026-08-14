document.addEventListener('DOMContentLoaded', function() {
    // ==================== COUNTDOWN TIMER ====================
    function updateCountdowns() {
        const now = new Date().getTime();
        
        document.querySelectorAll('.countdown-timer[data-end]').forEach(function(element) {
            const endDate = new Date(element.getAttribute('data-end')).getTime();
            const distance = endDate - now;
            
            if (distance < 0) {
                element.innerHTML = '<i class="fas fa-clock me-1"></i>Expired';
                element.classList.remove('bg-primary', 'bg-warning', 'bg-success');
                element.classList.add('bg-danger');
                element.setAttribute('data-expired', 'true');
            } else {
                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                
                let displayText = '';
                let urgencyClass = '';
                
                if (days > 0) {
                    displayText = `${days}d ${hours}h left`;
                    if (days <= 3) urgencyClass = 'bg-danger';
                    else if (days <= 7) urgencyClass = 'bg-warning text-dark';
                    else urgencyClass = 'bg-primary';
                } else if (hours > 0) {
                    displayText = `${hours}h ${minutes}m left`;
                    urgencyClass = hours <= 6 ? 'bg-danger' : 'bg-warning text-dark';
                } else {
                    displayText = `${minutes}m left`;
                    urgencyClass = 'bg-danger';
                }
                
                element.innerHTML = `<i class="fas fa-hourglass-half me-1"></i>${displayText}`;
                element.classList.remove('bg-primary', 'bg-warning', 'bg-danger', 'bg-success');
                element.classList.add(urgencyClass);
                element.removeAttribute('data-expired');
            }
        });
    }

    updateCountdowns();
    const countdownInterval = setInterval(updateCountdowns, 60000);
    
    // Cleanup interval on page unload
    window.addEventListener('beforeunload', function() {
        clearInterval(countdownInterval);
    });

    // ==================== LOADING STATES FOR BUTTONS ====================
    function addLoadingState(button, originalText) {
        button.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Loading...';
        button.classList.add('disabled');
        button.setAttribute('disabled', 'disabled');
        button.style.opacity = '0.7';
        
        // Store original text for restoration
        button.setAttribute('data-original-text', originalText);
        
        // Auto-restore after 10 seconds (prevents stuck loading state)
        const timeoutId = setTimeout(function() {
            restoreButtonState(button);
        }, 10000);
        
        button.setAttribute('data-timeout-id', timeoutId);
    }
    
    function restoreButtonState(button) {
        const originalText = button.getAttribute('data-original-text');
        const timeoutId = button.getAttribute('data-timeout-id');
        
        if (timeoutId) {
            clearTimeout(parseInt(timeoutId));
            button.removeAttribute('data-timeout-id');
        }
        
        if (originalText) {
            button.innerHTML = originalText;
            button.classList.remove('disabled');
            button.removeAttribute('disabled');
            button.style.opacity = '';
            button.removeAttribute('data-original-text');
        }
    }
    
    // Handle clickable buttons and links
    document.querySelectorAll('a.btn:not([href^="#"]):not([href^="javascript:"]), button[type="submit"], .btn:not(a)').forEach(function(element) {
        element.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            const isFormSubmit = this.getAttribute('type') === 'submit';
            const isDisabled = this.classList.contains('disabled') || this.hasAttribute('disabled');
            
            // Skip if already disabled
            if (isDisabled) {
                e.preventDefault();
                return false;
            }
            
            // Skip anchor links
            if (href && (href.startsWith('#') || href.startsWith('javascript:'))) {
                return;
            }
            
            // Skip external links (opens in new tab)
            if (href && href.startsWith('http') && !href.includes(window.location.hostname)) {
                const target = this.getAttribute('target');
                if (target !== '_blank') {
                    return;
                }
            }
            
            // Don't add loading state for file downloads
            if (href && (href.endsWith('.pdf') || href.endsWith('.doc') || href.endsWith('.docx') || 
                         href.endsWith('.xls') || href.endsWith('.xlsx') || href.includes('download='))) {
                return;
            }
            
            // Add loading state for form submissions and internal links
            if ((href && !href.startsWith('http')) || isFormSubmit) {
                const originalText = this.innerHTML;
                
                // Prevent double submission for forms
                if (isFormSubmit && this.form) {
                    const form = this.form;
                    if (form.getAttribute('data-submitting') === 'true') {
                        e.preventDefault();
                        return false;
                    }
                    form.setAttribute('data-submitting', 'true');
                }
                
                addLoadingState(this, originalText);
                
                // For links, don't prevent default - let navigation happen
                if (!isFormSubmit && href) {
                    // For same-page navigation, restore button state after navigation
                    setTimeout(function() {
                        restoreButtonState(element);
                    }, 500);
                }
            }
        });
    });
    
    // ==================== FORM SUBMISSION HANDLING ====================
    const forms = document.querySelectorAll('form');
    forms.forEach(function(form) {
        // Remove submitting flag when form is reset
        form.addEventListener('reset', function() {
            this.removeAttribute('data-submitting');
            const submitButton = this.querySelector('button[type="submit"]');
            if (submitButton) {
                restoreButtonState(submitButton);
            }
        });
        
        // Handle form submission
        form.addEventListener('submit', function(e) {
            const submitButton = this.querySelector('button[type="submit"]');
            
            // Check if already submitting
            if (this.getAttribute('data-submitting') === 'true') {
                e.preventDefault();
                return false;
            }
            
            // Mark as submitting
            this.setAttribute('data-submitting', 'true');
            
            // Add loading state to submit button if not already done
            if (submitButton && !submitButton.classList.contains('disabled')) {
                const originalText = submitButton.innerHTML;
                addLoadingState(submitButton, originalText);
            }
            
            // Re-enable after 30 seconds (in case of network issues)
            setTimeout(function() {
                if (form.getAttribute('data-submitting') === 'true') {
                    form.removeAttribute('data-submitting');
                    if (submitButton && submitButton.classList.contains('disabled')) {
                        restoreButtonState(submitButton);
                    }
                }
            }, 30000);
        });
    });
    
    // ==================== SEARCH/FILTER DEBOUNCE ====================
    // Add debounced search to any search inputs
    document.querySelectorAll('input[data-search], .search-input, input[type="search"]').forEach(function(searchInput) {
        let debounceTimer;
        
        searchInput.addEventListener('input', function() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(function() {
                const searchTerm = searchInput.value.toLowerCase().trim();
                const targetSelector = searchInput.getAttribute('data-target') || '.job-list-item, .result-item';
                const items = document.querySelectorAll(targetSelector);
                
                items.forEach(function(item) {
                    const text = item.textContent.toLowerCase();
                    if (searchTerm === '' || text.includes(searchTerm)) {
                        item.style.display = '';
                        item.style.opacity = '1';
                    } else {
                        item.style.display = 'none';
                        item.style.opacity = '0';
                    }
                });
                
                // Show/hide no results message
                const noResultsMsg = document.querySelector('.no-search-results');
                const visibleItems = document.querySelectorAll(`${targetSelector}:not([style*="display: none"])`);
                
                if (visibleItems.length === 0 && searchTerm !== '') {
                    if (!noResultsMsg) {
                        const msg = document.createElement('div');
                        msg.className = 'no-search-results alert alert-info text-center mt-3';
                        msg.innerHTML = '<i class="fas fa-search me-2"></i>No results found for "' + searchTerm + '"';
                        searchInput.parentNode.insertAdjacentElement('afterend', msg);
                    } else {
                        noResultsMsg.style.display = 'block';
                        noResultsMsg.innerHTML = '<i class="fas fa-search me-2"></i>No results found for "' + searchTerm + '"';
                    }
                } else if (noResultsMsg) {
                    noResultsMsg.style.display = 'none';
                }
            }, 300);
        });
    });
    
    // ==================== SMOOTH SCROLL TO TOP ====================
    // Create scroll to top button if not exists
    if (!document.querySelector('.scroll-to-top')) {
        const scrollBtn = document.createElement('button');
        scrollBtn.className = 'scroll-to-top btn btn-primary rounded-circle';
        scrollBtn.innerHTML = '<i class="fas fa-arrow-up"></i>';
        scrollBtn.style.cssText = `
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            display: none;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            border: none;
            cursor: pointer;
        `;
        document.body.appendChild(scrollBtn);
        
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                scrollBtn.style.display = 'flex';
                scrollBtn.style.alignItems = 'center';
                scrollBtn.style.justifyContent = 'center';
            } else {
                scrollBtn.style.display = 'none';
            }
        });
        
        scrollBtn.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
    
    // ==================== CARD CLICK HANDLER ====================
    // Make entire cards clickable when they have data-href attribute
    document.querySelectorAll('[data-href]').forEach(function(card) {
        card.style.cursor = 'pointer';
        card.addEventListener('click', function(e) {
            // Don't trigger if clicking on a link or button inside
            if (e.target.tagName === 'A' || e.target.tagName === 'BUTTON' || e.target.closest('a') || e.target.closest('button')) {
                return;
            }
            const href = this.getAttribute('data-href');
            if (href) {
                window.location.href = href;
            }
        });
    });
    
    // ==================== LAZY LOADING FOR IMAGES ====================
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver(function(entries, observer) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    const src = img.getAttribute('data-src');
                    if (src) {
                        img.src = src;
                        img.removeAttribute('data-src');
                    }
                    observer.unobserve(img);
                }
            });
        });
        
        document.querySelectorAll('img[data-src]').forEach(function(img) {
            imageObserver.observe(img);
        });
    }
    
    // ==================== TOOLTIP INITIALIZATION ====================
    // Initialize Bootstrap tooltips if available
    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
    
    // ==================== RESPONSIVE TABLE WRAPPER ====================
    // Wrap tables in responsive container if not already wrapped
    document.querySelectorAll('table:not(.table-responsive table)').forEach(function(table) {
        if (!table.closest('.table-responsive')) {
            const wrapper = document.createElement('div');
            wrapper.className = 'table-responsive';
            table.parentNode.insertBefore(wrapper, table);
            wrapper.appendChild(table);
        }
    });
    
    // ==================== CONSOLE LOGGING FOR DEBUG (remove in production) ====================
    if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
        console.log('✅ Dashboard JS loaded successfully');
        console.log(`📊 Found ${document.querySelectorAll('.countdown-timer[data-end]').length} countdown timers`);
        console.log(`📝 Found ${forms.length} forms`);
        console.log(`🔘 Found ${document.querySelectorAll('a.btn, button[type="submit"]').length} interactive buttons`);
    }
});