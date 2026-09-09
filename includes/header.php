<?php
/**
 * header.php – Page Header
 */

// ============================================================
// LOAD CONFIGURATION
// ============================================================

require_once __DIR__ . '/../config/config.php';

// ============================================================
// LOAD SESSION & TRACKING (cookies.php does ALL the work)
// ============================================================

require_once __DIR__ . '/cookies.php';

// ============================================================
// DEFAULT METADATA
// ============================================================

$pageTitle = $pageTitle ?? SITE_NAME . ' – Forge Your Saga';
$pageDescription = $pageDescription ?? 'NexusValhalla is a secure, next-gen social network fusing Norse mythology with sci-fi futurism.';
$pageBodyClass = $pageBodyClass ?? '';
$isLoggedIn = isLoggedIn();

// ============================================================
// OUTPUT HTML HEAD
// ============================================================

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= htmlspecialchars($pageDescription, ENT_QUOTES, 'UTF-8') ?>">
    <meta name="theme-color" content="#0a0e17">
    
    <title><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?></title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= IMAGES_URL ?>/favicon.png">
    
    <!-- Local Dependencies -->
    <link rel="stylesheet" href="<?= BOOTSTRAP_CSS ?>">
    <link rel="stylesheet" href="<?= FONTAWESOME_CSS ?>">
    <link rel="stylesheet" href="<?= GOOGLE_FONTS_CSS ?>">
    <link rel="stylesheet" href="<?= CSS_URL ?>/main.css">
    
    <!-- JavaScript -->
    <script src="<?= BOOTSTRAP_JS ?>" defer></script>
    <script src="<?= FONTAWESOME_JS ?>" defer></script>
    <script src="<?= JS_URL ?>/main.js" defer></script>
</head>
<body class="<?= htmlspecialchars($pageBodyClass, ENT_QUOTES, 'UTF-8') ?> <?= $isLoggedIn ? 'logged-in' : 'logged-out' ?>">

<!-- Skip to content -->
<a href="#main-content" class="visually-hidden-focusable">Skip to main content</a>

<!-- Navigation -->
<?php require_once __DIR__ . '/nav.php'; ?>

<!-- Main Content -->
<main id="main-content">
    <div id="nebula-bg" aria-hidden="true"></div>