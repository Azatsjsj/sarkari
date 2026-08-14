import './bootstrap';

// Import Bootstrap JS
import 'bootstrap/dist/js/bootstrap.bundle.min.js';

// Custom JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Back to top button
    const backToTop = document.getElementById('backToTop');
    if (backToTop) {
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                backToTop.classList.add('show');
            } else {
                backToTop.classList.remove('show');
            }
        });
        
        backToTop.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    console.log('Sarkari Result app loaded');
    
    // Loading spinner
    const spinner = document.getElementById('loadingSpinner');
    if (spinner) {
        document.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', (e) => {
                const href = link.getAttribute('href');
                if (href && !href.startsWith('#') && !href.startsWith('javascript:')) {
                    spinner.classList.add('active');
                }
            });
        });
        
        window.addEventListener('load', () => {
            setTimeout(() => spinner.classList.remove('active'), 500);
        });
    }
});