// resources/js/components/loading-spinner.js
export const loadingSpinner = () => {
    const spinner = document.getElementById('loadingSpinner');
    
    if (!spinner) return;
    
    // Show spinner on page navigation
    document.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', (e) => {
            const href = link.getAttribute('href');
            if (href && !href.startsWith('#') && !href.startsWith('javascript:')) {
                spinner.classList.add('active');
            }
        });
    });
    
    // Hide spinner when page loads
    window.addEventListener('load', () => {
        setTimeout(() => {
            spinner.classList.remove('active');
        }, 500);
    });
};

// Initialize
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', loadingSpinner);
} else {
    loadingSpinner();
}