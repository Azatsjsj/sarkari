// resources/js/components/back-to-top.js
export const backToTop = () => {
    const button = document.getElementById('backToTop');
    
    if (!button) return;
    
    window.addEventListener('scroll', () => {
        if (window.pageYOffset > 300) {
            button.classList.add('show');
        } else {
            button.classList.remove('show');
        }
    });
    
    button.addEventListener('click', (e) => {
        e.preventDefault();
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
};

// Initialize
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', backToTop);
} else {
    backToTop();
}