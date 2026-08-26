import './bootstrap';
import * as bootstrap from 'bootstrap';

window.bootstrap = bootstrap;

// Custom Interactive Quote Cart Handling
document.addEventListener('DOMContentLoaded', () => {
    // Enable tooltips & popovers
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

    // Scroll handler for auto-hide navbar on home page
    const autoHideNav = document.querySelector('.home-navbar-auto-hide');
    if (autoHideNav) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 380) {
                autoHideNav.classList.add('navbar-scrolled-show');
            } else {
                autoHideNav.classList.remove('navbar-scrolled-show');
            }
        });
    }

    console.log('Alex Marine Platform JS Initialized');
});
