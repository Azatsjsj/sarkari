// public/js/admin.js
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