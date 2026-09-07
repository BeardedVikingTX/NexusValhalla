<?php
/**
 * header.php – The Cosmic Layout Engine
 * 
 * This file is the single entry point for all front‑end pages.
 * It loads sessions, security, assets, navigation, content, and footer.
 */

// ------------------------------------------------------------------
// 0. BOOTSTRAP SESSIONS & SECURITY
// ------------------------------------------------------------------

// Include cookie/session manager (must be first)
require_once __DIR__ . '/cookies.php';

// ------------------------------------------------------------------
// 1. SITE CONFIGURATION
// ------------------------------------------------------------------

// Base URL (auto‑detect for dev / production)
define('SITE_URL', (isset($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST']);
define('SITE_NAME', 'NexusValhalla');

// Paths to our includes and assets
define('ASSETS_URL', SITE_URL . '/assets');
define('CSS_URL', ASSETS_URL . '/css');
define('JS_URL', ASSETS_URL . '/js');
define('PAGES_DIR', __DIR__ . '/../pages');

// ------------------------------------------------------------------
// 2. DYNAMIC PAGE ROUTING
// ------------------------------------------------------------------

// Get the requested page (sanitise)
$page = isset($_GET['page']) ? preg_replace('/[^a-zA-Z0-9_\-]/', '', $_GET['page']) : 'home';

// Security: whitelist of allowed pages (prevents directory traversal)
$allowed_pages = ['home', 'profile', 'messages', 'friends', 'settings', 'admin', 'notifications', 'explore'];
if (!in_array($page, $allowed_pages)) {
    $page = 'home'; // fallback to home if unknown
}

// Build the full path to the page file
$page_file = PAGES_DIR . '/' . $page . '.php';

// If page file doesn't exist, show a 404 (or fallback)
if (!file_exists($page_file)) {
    http_response_code(404);
    $page_file = PAGES_DIR . '/404.php';
    // You may want to create a default 404 page
    if (!file_exists($page_file)) {
        die('<h1>404 – Page Not Found</h1><p>We could not locate that realm.</p>');
    }
}

// ------------------------------------------------------------------
// 3. PAGE TITLE (optional dynamic per page)
// ------------------------------------------------------------------

$page_titles = [
    'home'         => 'The Great Hall',
    'profile'      => 'Your Saga',
    'messages'     => 'Raven Post',
    'friends'      => 'Warband',
    'settings'     => 'Forge Your Gear',
    'admin'        => 'Odin’s Throne',
    'notifications' => 'Heralds',
    'explore'      => 'Explore the Realms'
];
$title = SITE_NAME . ' – ' . ($page_titles[$page] ?? 'Valhalla');

// ------------------------------------------------------------------
// 4. NOW OUTPUT HTML
// ------------------------------------------------------------------

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="NexusValhalla – A Sci‑Fi Viking social realm. Encrypted, futuristic, and built for warriors.">
    <title><?= htmlspecialchars($title) ?></title>

    <!-- ========== FAVICON (placeholder) ========== -->
    <link rel="icon" href="<?= ASSETS_URL ?>/img/favicon.ico" type="image/x-icon">

    <!-- ========== BOOTSTRAP 5 ========== -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- ========== FONT AWESOME 6 (free) ========== -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- ========== GOOGLE FONTS – Orbitron (Sci‑Fi) & Cinzel (Viking) ========== -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;600;700;900&family=Cinzel:wght@400;600;700;900&display=swap" rel="stylesheet">

    <!-- ========== OUR CUSTOM SCI‑FI CSS ========== -->
    <link rel="stylesheet" href="<?= CSS_URL ?>/main.css?v=<?= filemtime(__DIR__ . '/../assets/css/main.css') ?>">

    <!-- ========== JAVASCRIPT (deferred) ========== -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="<?= JS_URL ?>/functions.js?v=<?= filemtime(__DIR__ . '/../assets/js/functions.js') ?>" defer></script>

</head>
<body>

    <!-- ==========================================================
         NAVIGATION (includes/nav.php)
         ========================================================== -->
    <?php require_once __DIR__ . '/nav.php'; ?>

    <!-- ==========================================================
         MAIN WRAPPER – dynamic content
         ========================================================== -->
    <main id="nexus-main" class="container-fluid px-0">

        <!-- Sci‑Fi decorative glows / floating elements (CSS handles these) -->
        <div id="nebula-bg" aria-hidden="true"></div>

        <!-- PAGE CONTENT -->
        <div class="row g-0 justify-content-center">
            <div class="col-12 col-xl-10 col-xxl-8">
                <?php include $page_file; ?>
            </div>
        </div>

    </main>

    <!-- ==========================================================
         FOOTER (includes/footer.php)
         ========================================================== -->
    <?php require_once __DIR__ . '/footer.php'; ?>

    <!-- ==========================================================
         COOKIE CONSENT / ALERTS (you can extend later)
         ========================================================== -->
    <!-- Optional: include a cookie consent banner here -->

</body>
</html>