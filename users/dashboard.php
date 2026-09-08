<?php
/**
 * dashboard.php – The Great Hall
 * 
 * User dashboard after successful login.
 * AI-powered interface with real-time stats and personalized experience.
 */

// ============================================================
// 1. CHECK LOGIN FIRST – BEFORE ANY OUTPUT
// ============================================================
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/registration_functions.php';

if (!isLoggedIn()) {
    header('Location: ' . SITE_URL . '/?page=login');
    exit;
}

// ============================================================
// 2. NOW LOAD HEADER (which includes nav.php)
// ============================================================
require_once __DIR__ . '/../includes/header.php';

// Get current user data
$user = getCurrentUser();

if (!$user) {
    // User not found in database (shouldn't happen)
    logoutUser();
    header('Location: ' . SITE_URL . '/?page=login');
    exit;
}

// ============================================================
// DASHBOARD STATS (simulated - replace with real data later)
// ============================================================
$stats = [
    'posts' => rand(0, 50),
    'comments' => rand(0, 200),
    'reputation' => rand(0, 500),
    'friends' => rand(0, 100),
    'messages' => rand(0, 25),
    'notifications' => rand(0, 10)
];

// Online status
$online_status = rand(0, 1) ? 'Online' : 'Away';
$online_color = $online_status === 'Online' ? '#00ff88' : '#ffaa00';

// Welcome messages based on time of day
$hour = date('H');
if ($hour < 12) {
    $greeting = 'Good Morning';
} elseif ($hour < 17) {
    $greeting = 'Good Afternoon';
} elseif ($hour < 21) {
    $greeting = 'Good Evening';
} else {
    $greeting = 'Good Night';
}
?>

<!-- ========================================================== -->
<!-- HTML OUTPUT STARTS HERE (after all redirects/headers)      -->
<!-- ========================================================== -->

<div class="container-fluid px-4 py-4 py-lg-5">

    <!-- Welcome Header -->
    <div class="row g-4 align-items-center mb-4">
        <div class="col-12 col-lg-8">
            <div class="d-flex align-items-center gap-3">
                <?php if ($user['avatar']): ?>
                    <img src="<?= SITE_URL . $user['avatar'] ?>" 
                         alt="<?= htmlspecialchars($user['alias']) ?>" 
                         class="rounded-circle" 
                         style="width: 72px; height: 72px; object-fit: cover; border: 2px solid rgba(0,212,255,0.3);">
                <?php else: ?>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" 
                         style="width: 72px; height: 72px; background: rgba(0,212,255,0.1); border: 2px solid rgba(0,212,255,0.3); font-size: 2rem; color: #00d4ff;">
                        <i class="fas fa-user"></i>
                    </div>
                <?php endif; ?>
                <div>
                    <h1 class="display-5 fw-bold mb-0 glow-text">
                        <?= $greeting ?>, <?= htmlspecialchars($user['alias']) ?>!
                    </h1>
                    <div class="d-flex align-items-center gap-3 mt-1">
                        <span style="color: <?= $online_color ?>;">
                            <i class="fas fa-circle" style="font-size: 0.6rem;"></i> <?= $online_status ?>
                        </span>
                        <?php if ($user['role'] === 'admin'): ?>
                            <span class="badge bg-danger">Admin</span>
                        <?php elseif ($user['role'] === 'moderator'): ?>
                            <span class="badge bg-primary">Moderator</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">Warrior</span>
                        <?php endif; ?>
                        <span class="badge" style="background: rgba(0,212,255,0.15); color: #00d4ff;">
                            <i class="fas fa-calendar-alt me-1"></i> 
                            <?= date('F d, Y') ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4 text-lg-end">
            <a href="<?= SITE_URL ?>/?page=logout" class="btn btn-outline-danger btn-sm rounded-pill px-4">
                <i class="fas fa-sign-out-alt me-2"></i> Logout
            </a>
        </div>
    </div>

    <!-- Stats Cards (same as before) -->
    <!-- ... (stats cards code unchanged) ... -->

    <!-- Quick Actions & Profile Info (same as before) -->
    <!-- ... (rest of dashboard content unchanged) ... -->

</div>

<?php
// Load footer
require_once __DIR__ . '/../includes/footer.php';
?>