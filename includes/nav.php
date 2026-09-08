<?php
/**
 * nav.php – The Navigation Helm (Enhanced with User Dropdown)
 * 
 * This loads the main navigation bar. Shows login/register for guests,
 * and a user dropdown with profile/dashboard/feed/messages/contact for logged-in users.
 */

// Ensure SITE_URL is defined (it is, from header.php)
if (!defined('SITE_URL')) {
    die('Direct access not permitted.');
}

// Determine active page for highlighting
$current_page = $_GET['page'] ?? 'home';

// Check if user is logged in (session must be active)
$isLoggedIn = isset($_SESSION['user_id']) && isset($_SESSION['user_alias']);
$userAlias = $isLoggedIn ? $_SESSION['user_alias'] : '';
$userAvatar = $isLoggedIn && isset($_SESSION['user_avatar']) ? $_SESSION['user_avatar'] : '';
?>
<nav id="nexus-nav" class="navbar navbar-expand-lg sticky-top" aria-label="Main Navigation">
    <div class="container-fluid px-4 px-xl-5">

        <!-- Brand -->
        <a class="navbar-brand" href="<?= SITE_URL ?>/?page=home">
            <i class="fas fa-helmet-battle me-2" aria-hidden="true"></i>
            <span class="brand-glow">NexusValhalla</span>
        </a>

        <!-- Mobile Toggler -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMain" 
                aria-controls="navMain" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Links -->
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

                <?php if ($isLoggedIn): ?>
                    <!-- DIVIDER (visible on desktop) -->
                    <li class="nav-item d-none d-lg-block">
                        <span class="nav-divider text-muted">|</span>
                    </li>

                    <!-- ==========================================================
                         USER DROPDOWN (Logged In)
                         ========================================================== -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" 
                           href="#" 
                           id="userDropdown" 
                           role="button" 
                           data-bs-toggle="dropdown" 
                           aria-expanded="false">
                            <?php if ($userAvatar): ?>
                                <img src="<?= SITE_URL . $userAvatar ?>" 
                                     alt="<?= htmlspecialchars($userAlias) ?>" 
                                     class="rounded-circle" 
                                     style="width: 32px; height: 32px; object-fit: cover; border: 1px solid rgba(0,212,255,0.3);">
                            <?php else: ?>
                                <i class="fas fa-user-circle fa-lg" style="color: #00d4ff;"></i>
                            <?php endif; ?>
                            <span class="d-none d-md-inline"><?= htmlspecialchars($userAlias) ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown" 
                            style="background: rgba(10,14,23,0.95); backdrop-filter: blur(10px); border: 1px solid rgba(0,212,255,0.15);">
                            <li><a class="dropdown-item" href="<?= SITE_URL ?>/users/dashboard.php">
                                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                            </a></li>
                            <li><a class="dropdown-item" href="#">
                                <i class="fas fa-user me-2"></i> Profile
                            </a></li>
                            <li><a class="dropdown-item" href="#">
                                <i class="fas fa-rss me-2"></i> Feed
                            </a></li>
                            <li><a class="dropdown-item" href="#">
                                <i class="fas fa-envelope me-2"></i> Messages
                            </a></li>
                            <li><a class="dropdown-item" href="<?= SITE_URL ?>/?page=contact">
                                <i class="fas fa-paper-plane me-2"></i> Contact
                            </a></li>
                            <li><hr class="dropdown-divider" style="border-color: rgba(0,212,255,0.1);"></li>
                            <li><a class="dropdown-item text-danger" href="<?= SITE_URL ?>/?page=logout">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </a></li>
                        </ul>
                    </li>

                <?php else: ?>
                    <!-- ==========================================================
                         GUEST BUTTONS (Logged Out)
                         ========================================================== -->
                    <li class="nav-item d-none d-lg-block">
                        <span class="nav-divider text-muted">|</span>
                    </li>
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
                <?php endif; ?>

            </ul>
        </div>
    </div>
</nav>