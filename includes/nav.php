<?php
/**
 * nav.php – Dynamic Navigation
 * 
 * Fully responsive navigation with user state detection
 * and active page highlighting.
 */

if (!defined('SITE_URL')) {
    die('Direct access not permitted.');
}

// Get current user state
$isLoggedIn = isLoggedIn();
$userAlias = getCurrentUserAlias();
$userAvatar = $_SESSION['user_avatar'] ?? null;

// Active page detection
$currentPage = $_GET['page'] ?? 'home';
$isActive = function($page) use ($currentPage) {
    return $currentPage === $page ? 'active' : '';
};
?>

<nav id="nexus-nav" class="navbar navbar-expand-lg sticky-top" aria-label="Main Navigation">
    <div class="container-fluid px-3 px-lg-4">

        <!-- ==========================================================
             BRAND
             ========================================================== -->
        <a class="navbar-brand d-flex align-items-center" href="<?= SITE_URL ?>">
            <i class="fas fa-helmet-battle me-2" aria-hidden="true" style="color: #00d4ff; font-size: 1.2rem;"></i>
            <span class="brand-text" style="font-family: 'Orbitron', monospace; font-weight: 700; font-size: 1.2rem;">
                NexusValhalla
            </span>
        </a>

        <!-- ==========================================================
             MOBILE TOGGLER
             ========================================================== -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMain" 
                aria-controls="navMain" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- ==========================================================
             NAVBAR LINKS & USER CONTROLS
             ========================================================== -->
        <div class="collapse navbar-collapse" id="navMain">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-1 gap-lg-2">

                <!-- ==========================================================
                     PRIMARY NAVIGATION
                     ========================================================== -->
                <li class="nav-item">
                    <a class="nav-link <?= $isActive('home') ?>" href="<?= SITE_URL ?>" aria-current="<?= $isActive('home') ? 'page' : 'false' ?>">
                        <i class="fas fa-house-chimney me-1"></i> <span class="d-none d-md-inline">Home</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= $isActive('about') ?>" href="<?= SITE_URL ?>/?page=about">
                        <i class="fas fa-compass me-1"></i> <span class="d-none d-md-inline">About</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= $isActive('contact') ?>" href="<?= SITE_URL ?>/?page=contact">
                        <i class="fas fa-paper-plane me-1"></i> <span class="d-none d-md-inline">Contact</span>
                    </a>
                </li>

                <!-- ==========================================================
                     DIVIDER (Desktop only)
                     ========================================================== -->
                <li class="nav-item d-none d-lg-block">
                    <span class="nav-divider" style="color: rgba(255,255,255,0.1);">|</span>
                </li>

                <!-- ==========================================================
                     USER CONTROLS (Logged In vs Guest)
                     ========================================================== -->
                <?php if ($isLoggedIn): ?>

                    <!-- User Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" 
                           href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" 
                           aria-expanded="false" style="padding: 0.4rem 0.8rem;">
                            <?php if ($userAvatar): ?>
                                <img src="<?= SITE_URL . $userAvatar ?>" 
                                     alt="<?= htmlspecialchars($userAlias) ?>" 
                                     class="rounded-circle" 
                                     style="width: 32px; height: 32px; object-fit: cover; border: 1px solid rgba(0,212,255,0.3);">
                            <?php else: ?>
                                <i class="fas fa-user-circle fa-lg" style="color: #00d4ff; font-size: 1.6rem;"></i>
                            <?php endif; ?>
                            <span class="d-none d-md-inline" style="font-weight: 500; color: #b0c4de;">
                                <?= htmlspecialchars($userAlias) ?>
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown"
                            style="background: rgba(10, 14, 23, 0.95); backdrop-filter: blur(20px); border: 1px solid rgba(0,212,255,0.15); border-radius: 12px; padding: 8px 0; min-width: 200px;">
                            <li>
                                <a class="dropdown-item" href="<?= SITE_URL ?>/users/dashboard.php" style="padding: 8px 20px; border-radius: 6px; color: #b0c4de;">
                                    <i class="fas fa-tachometer-alt me-2" style="color: #00d4ff;"></i> Dashboard
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#" style="padding: 8px 20px; border-radius: 6px; color: #b0c4de;">
                                    <i class="fas fa-user me-2" style="color: #7b2ffc;"></i> Profile
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#" style="padding: 8px 20px; border-radius: 6px; color: #b0c4de;">
                                    <i class="fas fa-rss me-2" style="color: #ffd700;"></i> Feed
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#" style="padding: 8px 20px; border-radius: 6px; color: #b0c4de;">
                                    <i class="fas fa-envelope me-2" style="color: #ff6b35;"></i> Messages
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?= SITE_URL ?>/?page=contact" style="padding: 8px 20px; border-radius: 6px; color: #b0c4de;">
                                    <i class="fas fa-paper-plane me-2" style="color: #00d4ff;"></i> Contact
                                </a>
                            </li>
                            <li><hr class="dropdown-divider" style="border-color: rgba(0,212,255,0.1); margin: 4px 0;"></li>
                            <li>
                                <a class="dropdown-item text-danger" href="<?= SITE_URL ?>/?page=logout" style="padding: 8px 20px; border-radius: 6px; font-weight: 600;">
                                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </li>

                <?php else: ?>

                    <!-- Guest Controls -->
                    <li class="nav-item">
                        <a href="<?= SITE_URL ?>/?page=login" class="btn btn-outline-accent btn-sm px-3 py-1 rounded-pill" 
                           style="font-size: 0.8rem; font-weight: 600; letter-spacing: 0.5px;">
                            <i class="fas fa-key me-1"></i> Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= SITE_URL ?>/?page=register" class="btn btn-accent btn-sm px-3 py-1 rounded-pill"
                           style="font-size: 0.8rem; font-weight: 600; letter-spacing: 0.5px;">
                            <i class="fas fa-user-plus me-1"></i> Register
                        </a>
                    </li>

                <?php endif; ?>

            </ul>
        </div>
    </div>
</nav>

<!-- ==========================================================
     MOBILE RESPONSIVE STYLES
     ========================================================== -->
<style>
/* Mobile-first responsive adjustments */
@media (max-width: 991.98px) {
    #nexus-nav .navbar-nav {
        padding-top: 10px;
        border-top: 1px solid rgba(0,212,255,0.05);
        margin-top: 8px;
    }
    #nexus-nav .nav-link {
        padding: 10px 12px !important;
        font-size: 0.9rem;
        border-radius: 8px;
        transition: background 0.2s ease;
    }
    #nexus-nav .nav-link:hover {
        background: rgba(0,212,255,0.05);
    }
    #nexus-nav .nav-divider {
        display: none !important;
    }
    #nexus-nav .btn {
        width: 100%;
        text-align: center;
        margin: 4px 0;
    }
    .dropdown-menu {
        background: rgba(10, 14, 23, 0.98) !important;
        border: 1px solid rgba(0,212,255,0.1) !important;
        border-radius: 12px !important;
        margin-top: 8px !important;
        padding: 4px 0 !important;
        width: 100% !important;
    }
    .dropdown-item {
        padding: 10px 16px !important;
        border-radius: 6px !important;
    }
    .dropdown-item:hover {
        background: rgba(0,212,255,0.05) !important;
    }
}

@media (max-width: 576px) {
    #nexus-nav .navbar-brand .brand-text {
        font-size: 1rem !important;
    }
    #nexus-nav .navbar-brand i {
        font-size: 1rem !important;
    }
    .btn-accent, .btn-outline-accent {
        font-size: 0.75rem !important;
        padding: 6px 16px !important;
    }
}
</style>