<?php
/**
 * ============================================================
 *  NexusValhalla :: includes/header.php
 * ------------------------------------------------------------
 *  The dynamic top-level shell for every page on the site.
 *
 *  USAGE (at the top of any page, e.g. index.php):
 *
 *      <?php
 *      define('NEXUSVALHALLA_APP', true);
 *      $pageTitle       = 'NexusValhalla – Forge Your Saga';
 *      $pageDescription = 'Connect, post, and build reputation on NexusValhalla.';
 *      $pageBodyClass   = 'page-home';   // optional, for page-specific CSS hooks
 *      require_once __DIR__ . '/includes/header.php';
 *      ?>
 *
 *      ... your page content goes here ...
 *
 *      <?php require_once __DIR__ . '/includes/footer.php'; ?>
 * ============================================================
 */

// Guard flag so cookies.php (and future includes) know they were
// pulled in through the proper front door, not accessed directly.
if (!defined('NEXUSVALHALLA_APP')) {
    define('NEXUSVALHALLA_APP', true);
}

// Load configuration (if not already loaded)
if (!defined('SITE_URL')) {
    require_once __DIR__ . '/config.php';
}

// Load session & security kernel
require_once __DIR__ . '/cookies.php';

// ------------------------------------------------------------
// Dynamic page metadata — every page can override these before
// including this file. Sensible defaults live here as a fallback.
// ------------------------------------------------------------
$pageTitle       = $pageTitle       ?? 'NexusValhalla – Forge Your Saga. Conquer the Digital Realms.';
$pageDescription = $pageDescription ?? 'NexusValhalla is a secure, next-gen social network fusing Norse mythology with sci-fi futurism.';
$pageBodyClass   = $pageBodyClass   ?? '';

// Never trust raw output into HTML — always escape.
$safeTitle       = htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8');
$safeDescription = htmlspecialchars($pageDescription, ENT_QUOTES, 'UTF-8');
$safeBodyClass   = htmlspecialchars($pageBodyClass, ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= $safeDescription ?>">
    <meta name="theme-color" content="#0a0e17">

    <!-- Security-related meta / headers -->
    <meta http-equiv="X-Content-Type-Options" content="nosniff">
    <meta name="referrer" content="strict-origin-when-cross-origin">

    <title><?= $safeTitle ?></title>

    <!-- Favicon (swap for your real asset once branding is locked) -->
    <link rel="icon" type="image/png" href="<?= ASSETS_URL ?>/img/favicon.png">

    <!-- ================= Google Fonts ================= -->
    <!-- Orbitron: sci-fi display headers | Rajdhani: techy sub-headers | Exo 2: clean body copy -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500;700;900&family=Rajdhani:wght@500;600;700&family=Exo+2:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- ================= Bootstrap 5 ================= -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- ================= Font Awesome 6 ================= -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
          integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer">

    <!-- ================= NexusValhalla Custom Theme ================= -->
    <link rel="stylesheet" href="<?= ASSETS_URL ?>/css/main.css">

    <!-- ================= JavaScript (deferred, in head for preload) ================= -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" 
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="<?= ASSETS_URL ?>/js/functions.js" defer></script>
</head>
<body class="<?= $safeBodyClass ?>">

<!-- Skip-to-content link for keyboard/screen-reader users -->
<a href="#main-content" class="visually-hidden-focusable">Skip to main content</a>

<!-- ==========================================================
     NAVIGATION (includes/nav.php)
     ========================================================== -->
<?php require_once __DIR__ . '/nav.php'; ?>

<!-- ==========================================================
     MAIN WRAPPER – dynamic content will be injected here
     ========================================================== -->
<main id="main-content">

<!-- The nebula background is handled by CSS, but we keep a container -->
<div id="nebula-bg" aria-hidden="true"></div>

<!-- The page content will go here (after header inclusion) -->