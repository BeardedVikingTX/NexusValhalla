<?php
/**
 * cookies.php – Session & Security Kernel
 * 
 * This file MUST be included at the very top of every page,
 * BEFORE any HTML output or session_start().
 */

// ============================================================
// 1. SESSION CONFIGURATION (before session_start)
// ============================================================

// Name the session cookie something unique (not PHPSESSID)
$sessionName = 'NXS_VALHALLA';
session_name($sessionName);

// Secure cookie parameters
$lifetime = 3600 * 24 * 7; // 7 days
$path     = '/';
$domain   = $_SERVER['HTTP_HOST'] ?? ''; // auto‑detect
$secure   = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
$httponly = true;
$samesite = 'Strict';

// PHP 7.3+ supports SameSite via an array
session_set_cookie_params([
    'lifetime' => $lifetime,
    'path'     => $path,
    'domain'   => $domain,
    'secure'   => $secure,
    'httponly' => $httponly,
    'samesite' => $samesite
]);

// ============================================================
// 2. START THE SESSION
// ============================================================

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ============================================================
// 3. REGENERATE ID PERIODICALLY (fixation protection)
// ============================================================

if (!isset($_SESSION['_last_regeneration'])) {
    $_SESSION['_last_regeneration'] = time();
} elseif (time() - $_SESSION['_last_regeneration'] > 300) { // 5 minutes
    session_regenerate_id(true);
    $_SESSION['_last_regeneration'] = time();
}

// ============================================================
// 4. CUSTOM SESSION TOKEN (for API / Ajax double‑submit)
// ============================================================

if (!isset($_SESSION['session_token'])) {
    $_SESSION['session_token'] = bin2hex(random_bytes(32));
}

// Optionally set a cookie with the same token (signed later)
// This is a simple double‑submit pattern – you can expand to JWT later.
if (!isset($_COOKIE['NXS_TOKEN'])) {
    setcookie(
        'NXS_TOKEN',
        $_SESSION['session_token'],
        time() + $lifetime,
        $path,
        $domain,
        $secure,
        $httponly
    );
}

// ============================================================
// 5. SECURITY HEADERS (sent with every response)
// ============================================================

// Prevent clickjacking
header('X-Frame-Options: SAMEORIGIN');

// Enforce HTTPS for 1 year (only if using HTTPS)
if ($secure) {
    header('Strict-Transport-Security: max-age=31536000; includeSubDomains; preload');
}

// Block MIME type sniffing
header('X-Content-Type-Options: nosniff');

// Referrer policy – only send for same origin
header('Referrer-Policy: strict-origin-when-cross-origin');

// Content‑Security‑Policy (CSP) – adjust as you add CDNs / external scripts
// We allow Bootstrap, FontAwesome, Google Fonts, and our own assets.
$csp = [
    "default-src 'self'",
    "script-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://code.jquery.com https://cdnjs.cloudflare.com",
    "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdn.jsdelivr.net",
    "font-src 'self' https://fonts.gstatic.com https://cdnjs.cloudflare.com",
    "img-src 'self' data: https:",
    "connect-src 'self'",
    "frame-ancestors 'none'"
];
header('Content-Security-Policy: ' . implode('; ', $csp));

// ============================================================
// 6. (OPTIONAL) CSRF token for forms – generate if needed
// ============================================================

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// ============================================================
// 7. CLEANUP & STATUS
// ============================================================

// Ensure the session is written at the end (done automatically)
// You can log session activity here later.