<?php
/**
 * cookies.php – SIMPLIFIED (No Tracking)
 */

// Load config
if (!defined('SITE_URL')) {
    require_once __DIR__ . '/../config/config.php';
}

// Session config
$sessionName = 'NXS_VALHALLA_' . md5($_SERVER['HTTP_HOST'] ?? 'localhost');
session_name($sessionName);

$secure = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';

session_set_cookie_params([
    'lifetime' => 604800,
    'path' => '/',
    'domain' => $_SERVER['HTTP_HOST'] ?? '',
    'secure' => $secure,
    'httponly' => true,
    'samesite' => 'Strict'
]);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Fingerprint
$fingerprint = hash('sha256', 
    ($_SERVER['HTTP_USER_AGENT'] ?? 'unknown') . 
    ($_SERVER['REMOTE_ADDR'] ?? '0.0.0.0')
);

if (isset($_SESSION['_fingerprint']) && $_SESSION['_fingerprint'] !== $fingerprint) {
    session_unset();
    session_destroy();
    session_start();
    $_SESSION['_fingerprint'] = $fingerprint;
    $_SESSION['_initialized'] = time();
} else {
    $_SESSION['_fingerprint'] = $fingerprint;
    $_SESSION['_initialized'] = time();
}

// Idle timeout
$idleTimeout = 1800;
if (isset($_SESSION['_last_activity'])) {
    if (time() - $_SESSION['_last_activity'] > $idleTimeout) {
        session_unset();
        session_destroy();
        session_start();
        $_SESSION['_fingerprint'] = $fingerprint;
        $_SESSION['_initialized'] = time();
        $_SESSION['_idle_timeout'] = true;
    }
}
$_SESSION['_last_activity'] = time();

// Regeneration
if (!isset($_SESSION['_last_regeneration'])) {
    $_SESSION['_last_regeneration'] = time();
} elseif (time() - $_SESSION['_last_regeneration'] > 300) {
    session_regenerate_id(true);
    $_SESSION['_last_regeneration'] = time();
}

// CSRF
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

function getCsrfToken() {
    return $_SESSION['csrf_token'] ?? '';
}

function csrfField() {
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8') . '">';
}

function validateCsrfToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

function refreshCsrfToken() {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Security Headers
header('X-Frame-Options: SAMEORIGIN');
header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: strict-origin-when-cross-origin');
if ($secure) {
    header('Strict-Transport-Security: max-age=31536000; includeSubDomains; preload');
}

// Helper functions
function isLoggedIn() {
    return isset($_SESSION['user_id']) && isset($_SESSION['user_alias']);
}

function getCurrentUserId() {
    return $_SESSION['user_id'] ?? null;
}

function getCurrentUserAlias() {
    return $_SESSION['user_alias'] ?? null;
}

// Log session start (once)
if (!isset($_SESSION['_session_logged'])) {
    error_log('[NEXUS] Session started (simplified): ' . session_id());
    $_SESSION['_session_logged'] = true;
}