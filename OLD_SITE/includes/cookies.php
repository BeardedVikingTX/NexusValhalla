<?php
/**
 * cookies.php – Session Management
 * 
 * Simple, reliable session handling with CSRF protection.
 * No over-engineering – just clean code that works.
 */

// ============================================================
// SESSION CONFIGURATION
// ============================================================

// Set session name
$sessionName = 'NXS_VALHALLA';
session_name($sessionName);

// Session cookie parameters
$secure = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';

session_set_cookie_params([
    'lifetime' => 86400 * 7, // 7 days
    'path'     => '/',
    'domain'   => $_SERVER['HTTP_HOST'] ?? '',
    'secure'   => $secure,
    'httponly' => true,
    'samesite' => 'Lax'
]);

// ============================================================
// START SESSION
// ============================================================

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ============================================================
// CSRF TOKEN GENERATION
// ============================================================

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

/**
 * Get CSRF token
 */
function getCsrfToken() {
    return $_SESSION['csrf_token'] ?? '';
}

/**
 * Generate CSRF hidden field
 */
function csrfField() {
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars(getCsrfToken()) . '">';
}

/**
 * Validate CSRF token
 */
function validateCsrfToken($token) {
    if (!isset($_SESSION['csrf_token'])) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Refresh CSRF token
 */
function refreshCsrfToken() {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// ============================================================
// SECURITY HEADERS (Simple but effective)
// ============================================================

header('X-Frame-Options: SAMEORIGIN');
header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: strict-origin-when-cross-origin');

// Simple CSP (allows CDNs)
header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://code.jquery.com https://cdnjs.cloudflare.com; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdn.jsdelivr.net; font-src 'self' https://fonts.gstatic.com https://cdnjs.cloudflare.com; img-src 'self' data: https:;");