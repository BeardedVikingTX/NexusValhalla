<?php
/**
 * nav.php – The Navigation Helm
 * 
 * This loads the main navigation bar. It uses Bootstrap 5's nav component
 * with our custom Sci-Fi/Viking flair. The login/register buttons are
 * conditionally placeholder-ready (guest state assumed for now).
 */

// Ensure SITE_URL is defined (it is, from header.php)
if (!defined('SITE_URL')) {
    die('Direct access not permitted.');
}

// Determine active page for highlighting (optional, but good for UX)
$current_page = $_GET['page'] ?? 'home';
?>
<nav id="nexus-nav" class="navbar navbar-expand-lg sticky-top" aria-label="Main Navigation">
    <div class="container-fluid px-4 px-xl-5">

        <!-- ==========================================================
             LEFT SIDE – BRAND / SITE NAME
             ========================================================== -->
        <a class="navbar-brand" href="<?= SITE_URL ?>/?page=home">
            <i class="fas fa-helmet-battle me-2" aria-hidden="true"></i>
            <span class="brand-glow">NexusValhalla</span>
        </a>

        <!-- Mobile Toggler (hamburger) -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMain" 
                aria-controls="navMain" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- ==========================================================
             RIGHT SIDE – NAVIGATION LINKS & AUTH BUTTONS
             ========================================================== -->
        <div class="collapse navbar-collapse" id="navMain">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center gap-1 gap-lg-3">

                <!-- Home -->
                <li class="nav-item">
                    <a class="nav-link <?= ($current_page === 'home') ? 'active' : '' ?>" 
                       href="<?= SITE_URL ?>/?page=home" 
                       aria-current="<?= ($current_page === 'home') ? 'page' : 'false' ?>">
                        <i class="fas fa-house-chimney me-1"></i> Home
                    </a>
                </li>

                <!-- About -->
                <li class="nav-item">
                    <a class="nav-link <?= ($current_page === 'about') ? 'active' : '' ?>" 
                       href="<?= SITE_URL ?>/?page=about">
                        <i class="fas fa-compass me-1"></i> About
                    </a>
                </li>

                <!-- Contact -->
                <li class="nav-item">
                    <a class="nav-link <?= ($current_page === 'contact') ? 'active' : '' ?>" 
                       href="<?= SITE_URL ?>/?page=contact">
                        <i class="fas fa-paper-plane me-1"></i> Contact
                    </a>
                </li>

                <!-- DIVIDER (vertical line, hidden on mobile) -->
                <li class="nav-item d-none d-lg-block">
                    <span class="nav-divider text-muted">|</span>
                </li>

                <!-- ==========================================================
                     AUTH BUTTONS – Login | Register
                     (Since we're in placeholder mode, these just link to pages)
                     ========================================================== -->
                <li class="nav-item">
                    <a href="<?= SITE_URL ?>/?page=login" class="btn btn-outline-accent btn-sm px-3 py-1 rounded-pill">
                        <i class="fas fa-key me-1"></i> Login
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= SITE_URL ?>/?page=register" class="btn btn-accent btn-sm px-3 py-1 rounded-pill">
                        <i class="fas fa-user-plus me-1"></i> Register
                    </a>
                </li>

                <!-- FUTURE: Avatar / User Dropdown will go here -->
                <!-- 
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-astronaut fa-lg"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="#">Logout</a></li>
                    </ul>
                </li>
                -->

            </ul>
        </div>
    </div>
</nav>