/**
 * main.js – NexusValhalla Core JavaScript
 * 
 * Handles:
 * - Responsive navigation enhancements
 * - User interactions
 * - Form enhancements
 * - Real-time feedback
 */

document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    // ==========================================================
    // 1. NAVIGATION: Auto-close mobile menu on link click
    // ==========================================================
    const navLinks = document.querySelectorAll('#navMain .nav-link');
    const navToggler = document.querySelector('.navbar-toggler');
    const navCollapse = document.getElementById('navMain');

    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth <= 991.98 && navCollapse.classList.contains('show')) {
                navToggler.click();
            }
        });
    });

    // ==========================================================
    // 2. ACTIVE PAGE HIGHLIGHTING (Fallback)
    // ==========================================================
    const currentPath = window.location.pathname + window.location.search;
    document.querySelectorAll('#navMain .nav-link').forEach(link => {
        const href = link.getAttribute('href');
        if (href && href !== '#' && currentPath.includes(href)) {
            link.classList.add('active');
        }
    });

    // ==========================================================
    // 3. FORM VALIDATION ENHANCEMENTS
    // ==========================================================
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(e) {
            const requiredFields = this.querySelectorAll('[required]');
            let isValid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('is-invalid');
                } else {
                    field.classList.remove('is-invalid');
                }

                // Email validation
                if (field.type === 'email' && field.value.trim()) {
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(field.value.trim())) {
                        isValid = false;
                        field.classList.add('is-invalid');
                    }
                }

                // Password confirmation
                if (field.id === 'confirm_password' || field.name === 'confirm_password') {
                    const passwordField = document.getElementById('password') || document.querySelector('[name="password"]');
                    if (passwordField && field.value !== passwordField.value) {
                        isValid = false;
                        field.classList.add('is-invalid');
                    }
                }
            });

            if (!isValid) {
                e.preventDefault();
                // Scroll to first invalid field
                const firstInvalid = this.querySelector('.is-invalid');
                if (firstInvalid) {
                    firstInvalid.focus();
                    firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
        });

        // Real-time validation feedback
        form.querySelectorAll('input, textarea, select').forEach(field => {
            field.addEventListener('blur', function() {
                if (this.hasAttribute('required') && !this.value.trim()) {
                    this.classList.add('is-invalid');
                } else {
                    this.classList.remove('is-invalid');
                }
            });
            field.addEventListener('input', function() {
                if (this.value.trim()) {
                    this.classList.remove('is-invalid');
                }
            });
        });
    });

    // ==========================================================
    // 4. PASSWORD VISIBILITY TOGGLE
    // ==========================================================
    document.querySelectorAll('.password-toggle').forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.closest('.input-group').querySelector('input');
            if (input) {
                const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                input.setAttribute('type', type);
                this.querySelector('i').classList.toggle('fa-eye');
                this.querySelector('i').classList.toggle('fa-eye-slash');
            }
        });
    });

    // ==========================================================
    // 5. CONFIRMATION DIALOGS (For destructive actions)
    // ==========================================================
    document.querySelectorAll('[data-confirm]').forEach(el => {
        el.addEventListener('click', function(e) {
            const message = this.getAttribute('data-confirm') || 'Are you sure?';
            if (!confirm(message)) {
                e.preventDefault();
            }
        });
    });

    // ==========================================================
    // 6. SMOOTH SCROLL FOR ANCHOR LINKS
    // ==========================================================
    document.querySelectorAll('a[href^="#"]:not([href="#"])').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href');
            if (targetId && targetId !== '#') {
                const target = document.querySelector(targetId);
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }
        });
    });

    // ==========================================================
    // 7. DYNAMIC YEAR IN FOOTER
    // ==========================================================
    const yearElement = document.querySelector('.current-year');
    if (yearElement) {
        yearElement.textContent = new Date().getFullYear();
    }

    // ==========================================================
    // 8. SERVER STATUS CHECK (Optional)
    // ==========================================================
    if (document.getElementById('server-status')) {
        fetch('/ping.php', {
            method: 'GET',
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.json())
        .then(data => {
            const statusEl = document.getElementById('server-status');
            if (statusEl) {
                if (data.status === 'online') {
                    statusEl.innerHTML = '<span class="text-success"><i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i> Online</span>';
                } else {
                    statusEl.innerHTML = '<span class="text-warning"><i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i> Degraded</span>';
                }
            }
        })
        .catch(() => {
            const statusEl = document.getElementById('server-status');
            if (statusEl) {
                statusEl.innerHTML = '<span class="text-muted"><i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i> Unknown</span>';
            }
        });
    }

    // ==========================================================
    // 9. CONSOLE WELCOME (Easter Egg)
    // ==========================================================
    console.log('%c⚔️ NexusValhalla ⚔️', 'font-size: 24px; font-weight: bold; color: #00d4ff;');
    console.log('%cForge your saga across the digital realms.', 'font-size: 14px; color: #b0c4de;');
    console.log('%cFollow the AI race: https://nexusvalhalla.beardedviking.org', 'font-size: 12px; color: #8899aa;');

    console.log('🛡️ Skål! 🍻');

});

// ==========================================================
// 10. DEBOUNCE UTILITY (For performance)
// ==========================================================
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// ==========================================================
// COUNTER ANIMATION (Intersection Observer based)
// ==========================================================
function initCounters() {
    const counters = document.querySelectorAll('.counter:not(.animated)');
    
    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const counter = entry.target;
                    counter.classList.add('animated');
                    const target = parseInt(counter.getAttribute('data-target'));
                    let current = 0;
                    const increment = Math.ceil(target / 80);
                    
                    const timer = setInterval(() => {
                        current += increment;
                        if (current >= target) {
                            current = target;
                            clearInterval(timer);
                        }
                        counter.textContent = current.toLocaleString();
                    }, 25);
                    
                    observer.unobserve(counter);
                }
            });
        }, { threshold: 0.5 });
        
        counters.forEach(counter => observer.observe(counter));
    } else {
        // Fallback: animate all counters
        counters.forEach(counter => {
            const target = parseInt(counter.getAttribute('data-target'));
            let current = 0;
            const increment = Math.ceil(target / 80);
            
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }
                counter.textContent = current.toLocaleString();
            }, 25);
        });
    }
}

// ==========================================================
// SMOOTH SCROLL WITH OFFSET (for sticky nav)
// ==========================================================
function initSmoothScroll() {
    const navHeight = document.querySelector('#nexus-nav')?.offsetHeight || 70;
    
    document.querySelectorAll('a[href^="#"]:not([href="#"])').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href');
            if (targetId && targetId !== '#') {
                const target = document.querySelector(targetId);
                if (target) {
                    e.preventDefault();
                    const targetPosition = target.getBoundingClientRect().top + window.pageYOffset - navHeight;
                    window.scrollTo({ top: targetPosition, behavior: 'smooth' });
                }
            }
        });
    });
}

// ==========================================================
// CHARTJS LOADING CHECK
// ==========================================================
function checkCharts() {
    if (typeof Chart === 'undefined') {
        console.warn('ChartJS not loaded. Charts will not render.');
        return;
    }
    // Charts are initialized in the page-specific script
}

// ==========================================================
// INIT ON DOM READY
// ==========================================================
document.addEventListener('DOMContentLoaded', function() {
    initCounters();
    initSmoothScroll();
    checkCharts();
});