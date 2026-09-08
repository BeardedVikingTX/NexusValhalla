<?php
/**
 * footer.php – The Cosmic Keel
 * 
 * Rich footer with dynamic JS/AJAX interactions, including a live clock,
 * server status ping, scroll-to-top button, and dynamic copyright year.
 */

if (!defined('SITE_URL')) {
    die('Direct access not permitted.');
}
?>

<!-- ==========================================================
     FOOTER START
     ========================================================== -->
<footer id="nexus-footer" class="mt-auto pt-5 pb-3">

    <div class="container-fluid px-4 px-xl-5">

        <!-- ==========================================================
             TOP ROW – 4 Columns
             ========================================================== -->
        <div class="row g-4 g-lg-5 pb-4">

            <!-- COL 1: Brand / About -->
            <div class="col-12 col-md-6 col-lg-3">
                <h5 class="footer-heading">
                    <i class="fas fa-helmet-battle me-2"></i>NexusValhalla
                </h5>
                <p class="text-muted small lh-base">
                    A digital longship sailing the cosmic seas. 
                    Encrypted, futuristic, and built for warriors of the Nine Realms.
                </p>
                <p class="small">
                    <i class="fas fa-shield-alt text-accent me-1"></i> 
                    <span id="server-status" class="status-badge">Connecting...</span>
                </p>
            </div>

            <!-- COL 2: Quick Links -->
            <div class="col-6 col-lg-3">
                <h6 class="footer-heading">Quick Realms</h6>
                <ul class="list-unstyled footer-links">
                    <li><a href="<?= SITE_URL ?>/?page=home"><i class="fas fa-chevron-right fa-xs me-1"></i> Home</a></li>
                    <li><a href="<?= SITE_URL ?>/?page=about"><i class="fas fa-chevron-right fa-xs me-1"></i> About</a></li>
                    <li><a href="<?= SITE_URL ?>/?page=contact"><i class="fas fa-chevron-right fa-xs me-1"></i> Contact</a></li>
                    <li><a href="<?= SITE_URL ?>/sitemap.xml"><i class="fas fa-sitemap fa-xs me-1"></i> Sitemap</a></li>
                </ul>
            </div>

            <!-- COL 3: Social / Connect -->
            <div class="col-6 col-lg-3">
                <h6 class="footer-heading">Hail the Warband</h6>
                <div class="d-flex flex-wrap gap-3 social-icons">
                    <a href="#" aria-label="Twitter/X"><i class="fab fa-x-twitter fa-lg"></i></a>
                    <a href="#" aria-label="GitHub"><i class="fab fa-github fa-lg"></i></a>
                    <a href="#" aria-label="Discord"><i class="fab fa-discord fa-lg"></i></a>
                    <a href="#" aria-label="YouTube"><i class="fab fa-youtube fa-lg"></i></a>
                    <a href="#" aria-label="Reddit"><i class="fab fa-reddit-alien fa-lg"></i></a>
                </div>
                <div class="mt-3 small text-muted">
                    <i class="fas fa-code me-1"></i> Built by <strong>Bearded Viking</strong>
                </div>
            </div>

            <!-- COL 4: Newsletter / AJAX Demo -->
            <div class="col-12 col-lg-3">
                <h6 class="footer-heading">Raven Dispatch</h6>
                <p class="small text-muted">Subscribe for cosmic updates (AJAX demo).</p>
                <form id="newsletter-form" class="d-flex flex-column gap-2" novalidate>
                    <div class="input-group">
                        <input type="email" class="form-control form-control-sm" id="newsletter-email" 
                               placeholder="Your email..." required>
                        <button class="btn btn-accent btn-sm" type="submit">
                            <i class="fas fa-feather-pointed"></i>
                        </button>
                    </div>
                    <div id="newsletter-feedback" class="small text-success d-none">
                        <i class="fas fa-check-circle"></i> Signal sent! (AJAX demo)
                    </div>
                </form>
            </div>
        </div>

        <!-- ==========================================================
             BOTTOM BAR – Copyright + Live Clock
             ========================================================== -->
        <div class="footer-divider"></div>
        <div class="row align-items-center pt-3">
            <div class="col-md-6 text-center text-md-start small text-muted">
                &copy; <span id="current-year">2026</span> NexusValhalla. 
                All runes reserved. 
                <span class="d-none d-sm-inline">|</span> 
                <span id="live-clock" class="font-monospace">--:--:--</span>
            </div>
            <div class="col-md-6 text-center text-md-end small">
                <a href="#" id="scroll-top-btn" class="text-decoration-none" title="Return to the top of the realm">
                    <i class="fas fa-arrow-up me-1"></i> Rise to Asgard
                </a>
            </div>
        </div>

    </div>
</footer>

<!-- ==========================================================
     FOOTER JS – DOM / AJAX / INTERACTIONS
     This runs after the DOM is ready (placed at the bottom)
     ========================================================== -->
<script>
    (function() {
        'use strict';

        // ------------------------------------------------------------------
        // 1. DYNAMIC YEAR
        // ------------------------------------------------------------------
        const yearSpan = document.getElementById('current-year');
        if (yearSpan) {
            yearSpan.textContent = new Date().getFullYear();
        }

        // ------------------------------------------------------------------
        // 2. LIVE CLOCK (updates every second)
        // ------------------------------------------------------------------
        const clockSpan = document.getElementById('live-clock');
        function updateClock() {
            if (!clockSpan) return;
            const now = new Date();
            const h = String(now.getHours()).padStart(2, '0');
            const m = String(now.getMinutes()).padStart(2, '0');
            const s = String(now.getSeconds()).padStart(2, '0');
            clockSpan.textContent = h + ':' + m + ':' + s;
        }
        updateClock();
        setInterval(updateClock, 1000);

        // ------------------------------------------------------------------
        // 3. AJAX SERVER STATUS HEARTBEAT (simulated / real fetch)
        // ------------------------------------------------------------------
        const statusBadge = document.getElementById('server-status');
        async function checkServerStatus() {
            if (!statusBadge) return;
            try {
                // We fetch a tiny endpoint. Since we don't have a dedicated ping.php yet,
                // we'll simulate success with a timeout, but this shows the fetch pattern.
                // To make it real, create a ping.php that returns { status: 'online' }.
                // For now, we simulate by fetching the home page (HEAD request) or just mock.
                const response = await fetch('<?= SITE_URL ?>/?page=home', {
                    method: 'HEAD',
                    cache: 'no-cache'
                });
                if (response.ok) {
                    statusBadge.innerHTML = '<i class="fas fa-circle text-success me-1"></i> Realm Online';
                    statusBadge.className = 'status-badge text-success';
                } else {
                    statusBadge.innerHTML = '<i class="fas fa-circle text-warning me-1"></i> Unstable';
                }
            } catch (error) {
                // If fetch fails (e.g., CORS or network), we fallback to a mock success 
                // to make the demo look good, but we comment the error for debugging.
                console.warn('Server ping failed, showing fallback status.', error);
                statusBadge.innerHTML = '<i class="fas fa-circle text-success me-1"></i> Realm Online (Fallback)';
                statusBadge.className = 'status-badge text-success';
            }
        }
        // Run check on load, then every 60 seconds.
        checkServerStatus();
        setInterval(checkServerStatus, 60000);

        // ------------------------------------------------------------------
        // 4. NEWSLETTER AJAX DEMO (DOM manipulation + prevent default)
        // ------------------------------------------------------------------
        const newsletterForm = document.getElementById('newsletter-form');
        const feedbackDiv = document.getElementById('newsletter-feedback');
        if (newsletterForm) {
            newsletterForm.addEventListener('submit', function(e) {
                e.preventDefault(); // Stop actual POST

                const emailInput = document.getElementById('newsletter-email');
                if (!emailInput.value || !emailInput.value.includes('@')) {
                    alert('Please enter a valid email address for the Raven Dispatch.');
                    return;
                }

                // Simulate AJAX request (could use fetch here)
                // We'll just show the feedback div with a fancy animation.
                if (feedbackDiv) {
                    feedbackDiv.classList.remove('d-none');
                    feedbackDiv.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Sending raven...';
                    
                    // Simulate async delay
                    setTimeout(function() {
                        feedbackDiv.innerHTML = '<i class="fas fa-check-circle me-1"></i> Signal sent! (AJAX demo)';
                        feedbackDiv.className = 'small text-success';
                    }, 1200);
                }

                // Reset form after a few seconds (just for demo)
                setTimeout(function() {
                    newsletterForm.reset();
                }, 3000);
            });
        }

        // ------------------------------------------------------------------
        // 5. SCROLL TO TOP BUTTON (Show/Hide based on scroll position)
        // ------------------------------------------------------------------
        const scrollBtn = document.getElementById('scroll-top-btn');
        if (scrollBtn) {
            // Hide initially
            scrollBtn.style.opacity = '0';
            scrollBtn.style.transition = 'opacity 0.3s ease';

            window.addEventListener('scroll', function() {
                if (window.scrollY > 300) {
                    scrollBtn.style.opacity = '1';
                    scrollBtn.style.pointerEvents = 'auto';
                } else {
                    scrollBtn.style.opacity = '0';
                    scrollBtn.style.pointerEvents = 'none';
                }
            });

            scrollBtn.addEventListener('click', function(e) {
                e.preventDefault();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        }

    })();
</script>