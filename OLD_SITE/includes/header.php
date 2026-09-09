<?php
/**
 * header.php – Page Header & Layout
 * 
 * Simple, reliable header that loads config, sessions, and outputs HTML.
 */

// ============================================================
// LOAD CONFIGURATION
// ============================================================
require_once __DIR__ . '/config.php';

// ============================================================
// LOAD SESSION HANDLER
// ============================================================
require_once __DIR__ . '/cookies.php';

// ============================================================
// PAGE METADATA (with sensible defaults)
// ============================================================
$pageTitle       = $pageTitle       ?? 'NexusValhalla – Forge Your Saga';
$pageDescription = $pageDescription ?? 'NexusValhalla is a secure, next-gen social network fusing Norse mythology with sci-fi futurism.';
$pageBodyClass   = $pageBodyClass   ?? '';

// Escape for safety
$safeTitle       = htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8');
$safeDescription = htmlspecialchars($pageDescription, ENT_QUOTES, 'UTF-8');
$safeBodyClass   = htmlspecialchars($pageBodyClass, ENT_QUOTES, 'UTF-8');

// ============================================================
// OUTPUT HTML
// ============================================================
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= $safeDescription ?>">
    <meta name="theme-color" content="#0a0e17">
    <meta http-equiv="X-Content-Type-Options" content="nosniff">
    <meta name="referrer" content="strict-origin-when-cross-origin">
    
    <title><?= $safeTitle ?></title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/assets/img/favicon.png">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500;700;900&family=Rajdhani:wght@500;600;700&family=Exo+2:wght@400;500;600&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/assets/css/main.css">
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script src="/assets/js/functions.js" defer></script>
</head>
<body class="<?= $safeBodyClass ?>">

<!-- Skip to content -->
<a href="#main-content" class="visually-hidden-focusable">Skip to main content</a>

<!-- Navigation -->
<?php require_once __DIR__ . '/nav.php'; ?>

<!-- Main Content -->
<main id="main-content">
    <div id="nebula-bg" aria-hidden="true"></div>