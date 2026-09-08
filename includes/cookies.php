<?php
/**
 * cookies.php – Session & Security Kernel (Enhanced)
 * 
 * This file MUST be included at the very top of every page,
 * BEFORE any HTML output or session_start().
 * 
 * Features:
 * - Secure session configuration (HttpOnly, Secure, SameSite)
 * - Session fingerprinting (binds to user agent + IP)
 * - Idle timeout (auto-logout after 30 minutes of inactivity)
 * - Encrypted cookie tokens (double-submit pattern with AES-256)
 * - CSRF protection with token generation & validation
 * - Content Security Policy (CSP) with nonce support
 * - Security headers (HSTS, X-Frame-Options, etc.)
 * - Error logging for security events
 * - Session garbage collection tuning
 */

// ============================================================
// 0. ERROR HANDLING – Prevent session errors from breaking the site
// ============================================================

// Ensure we don't output anything before headers
if (headers_sent()) {
    // Log the issue but continue (graceful degradation)
    error_log('NexusValhalla: cookies.php loaded after headers sent. Session may not work correctly.');
}

// ============================================================
// 1. SESSION CONFIGURATION (before session_start)
// ============================================================

// Session name – unique and not easily guessable
$sessionName = 'NXS_VALHALLA_' . md5($_SERVER['HTTP_HOST'] ?? 'localhost');
session_name($sessionName);

// Security parameters
$lifetime = 3600 * 24 * 7; // 7 days (session cookie lifetime)
$idleTimeout = 1800; // 30 minutes of inactivity before session expires
$path = '/';
$domain = $_SERVER['HTTP_HOST'] ?? '';
$secure = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
$httponly = true;
$samesite = 'Strict';

// PHP 7.3+ supports SameSite via an array
session_set_cookie_params([
    'lifetime' => $lifetime,
    'path' => $path,
    'domain' => $domain,
    'secure' => $secure,
    'httponly' => $httponly,
    'samesite' => $samesite
]);

// Increase session entropy and security
ini_set('session.use_strict_mode', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', $secure ? 1 : 0);
ini_set('session.cookie_samesite', 'Strict');
ini_set('session.sid_length', 48);
ini_set('session.sid_bits_per_character', 6);

// ============================================================
// 1b. SESSION GARBAGE COLLECTION (must be set BEFORE session_start)
// ============================================================
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 100);

// ============================================================
// 2. START THE SESSION
// ============================================================

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ============================================================
// 3. SESSION FINGERPRINTING (prevent session hijacking)
// ============================================================

// Build the fingerprint
$userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
$ipHash = hash('sha256', ($_SERVER['REMOTE_ADDR'] ?? '0.0.0.0') . ($_SERVER['HTTP_X_FORWARDED_FOR'] ?? ''));
$fingerprint = hash('sha256', $userAgent . $ipHash);

// Validate fingerprint on every request
if (isset($_SESSION['_fingerprint'])) {
    if ($_SESSION['_fingerprint'] !== $fingerprint) {
        // Potential session hijacking – destroy and restart
        error_log('NexusValhalla: Session fingerprint mismatch. Potential hijacking attempt detected.');
        session_unset();
        session_destroy();
        
        // Regenerate a new session
        session_start();
        $_SESSION['_fingerprint'] = $fingerprint;
        $_SESSION['_initialized'] = time();
        
        // Log the incident (you can expand this)
        error_log('NexusValhalla: New session created after fingerprint validation failure.');
    }
} else {
    // First visit – set the fingerprint
    $_SESSION['_fingerprint'] = $fingerprint;
    $_SESSION['_initialized'] = time();
}

// ============================================================
// 4. SESSION IDLE TIMEOUT (auto-logout)
// ============================================================

if (isset($_SESSION['_last_activity'])) {
    $inactiveDuration = time() - $_SESSION['_last_activity'];
    if ($inactiveDuration > $idleTimeout) {
        // Session expired due to inactivity
        error_log('NexusValhalla: Session expired due to inactivity (' . $inactiveDuration . 's idle).');
        session_unset();
        session_destroy();
        session_start();
        $_SESSION['_fingerprint'] = $fingerprint;
        $_SESSION['_initialized'] = time();
        $_SESSION['_idle_timeout'] = true; // Flag for the frontend
    }
}
$_SESSION['_last_activity'] = time();

// ============================================================
// 5. SESSION REGENERATION (fixation protection)
// ============================================================

if (!isset($_SESSION['_last_regeneration'])) {
    $_SESSION['_last_regeneration'] = time();
} elseif (time() - $_SESSION['_last_regeneration'] > 300) { // 5 minutes
    session_regenerate_id(true);
    $_SESSION['_last_regeneration'] = time();
}

// ============================================================
// 6. CUSTOM SESSION TOKEN (for API / Ajax double‑submit)
// ============================================================

if (!isset($_SESSION['session_token'])) {
    $_SESSION['session_token'] = bin2hex(random_bytes(32));
}

// Encrypt the token before storing in cookie (double-submit pattern)
function encryptToken($token, $key = null) {
    if ($key === null) {
        $key = defined('ENCRYPTION_KEY') ? ENCRYPTION_KEY : 'default-key-change-me-now';
    }
    $iv = random_bytes(16);
    $encrypted = openssl_encrypt($token, 'AES-256-CBC', $key, 0, $iv);
    return base64_encode($iv . $encrypted);
}

function decryptToken($encrypted, $key = null) {
    if ($key === null) {
        $key = defined('ENCRYPTION_KEY') ? ENCRYPTION_KEY : 'default-key-change-me-now';
    }
    $data = base64_decode($encrypted);
    $iv = substr($data, 0, 16);
    $ciphertext = substr($data, 16);
    return openssl_decrypt($ciphertext, 'AES-256-CBC', $key, 0, $iv);
}

// Store encrypted token in cookie
if (!isset($_COOKIE['NXS_TOKEN'])) {
    $encryptedToken = encryptToken($_SESSION['session_token']);
    setcookie(
        'NXS_TOKEN',
        $encryptedToken,
        time() + $lifetime,
        $path,
        $domain,
        $secure,
        $httponly
    );
} else {
    // Verify the cookie token matches the session token
    try {
        $decrypted = decryptToken($_COOKIE['NXS_TOKEN']);
        if ($decrypted !== $_SESSION['session_token']) {
            // Token mismatch – potential tampering
            error_log('NexusValhalla: Token mismatch detected. Possible cookie tampering.');
            // Don't destroy session, just regenerate the token
            $_SESSION['session_token'] = bin2hex(random_bytes(32));
            $encryptedToken = encryptToken($_SESSION['session_token']);
            setcookie(
                'NXS_TOKEN',
                $encryptedToken,
                time() + $lifetime,
                $path,
                $domain,
                $secure,
                $httponly
            );
        }
    } catch (Exception $e) {
        // Decryption failed – regenerate token
        error_log('NexusValhalla: Cookie decryption failed. Regenerating token.');
        $_SESSION['session_token'] = bin2hex(random_bytes(32));
        $encryptedToken = encryptToken($_SESSION['session_token']);
        setcookie(
            'NXS_TOKEN',
            $encryptedToken,
            time() + $lifetime,
            $path,
            $domain,
            $secure,
            $httponly
        );
    }
}

// ============================================================
// 7. SECURITY HEADERS (sent with every response)
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

// ============================================================
// 8. CONTENT SECURITY POLICY (CSP) with Nonce Support
// ============================================================

// Generate a nonce for inline scripts (if needed)
$nonce = base64_encode(random_bytes(16));
$_SESSION['csp_nonce'] = $nonce;

// Build CSP directives
$csp = [
    "default-src 'self'",
    "script-src 'self' 'unsafe-inline' 'nonce-{$nonce}' https://cdn.jsdelivr.net https://code.jquery.com https://cdnjs.cloudflare.com",
    "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdn.jsdelivr.net",
    "font-src 'self' https://fonts.gstatic.com https://cdnjs.cloudflare.com",
    "img-src 'self' data: https:",
    "connect-src 'self'",
    "frame-ancestors 'none'",
    "form-action 'self'",
    "base-uri 'self'"
];

header('Content-Security-Policy: ' . implode('; ', $csp));

// ============================================================
// 9. CSRF TOKEN GENERATION & HELPER FUNCTIONS
// ============================================================

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

/**
 * Get the current CSRF token
 * @return string The CSRF token
 */
function getCsrfToken() {
    return $_SESSION['csrf_token'] ?? '';
}

/**
 * Generate a CSRF hidden field for forms
 * @return string HTML hidden input
 */
function csrfField() {
    $token = getCsrfToken();
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token) . '">';
}

/**
 * Validate a CSRF token
 * @param string $token The token to validate
 * @return bool True if valid
 */
function validateCsrfToken($token) {
    if (!isset($_SESSION['csrf_token'])) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Refresh the CSRF token (use after successful form submission)
 */
function refreshCsrfToken() {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// ============================================================
// 10. SESSION CLEANUP & GARBAGE COLLECTION (already set above)
// ============================================================

// The gc settings are already set before session_start.

// ============================================================
// 11. RATE LIMITING STUB (ready to expand)
// ============================================================

/**
 * Simple rate limiting – track requests per IP
 * Usage: checkRateLimit('login', 5, 60) // 5 attempts per minute
 */
function checkRateLimit($action, $limit, $window) {
    $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    $key = "rate_limit_{$action}_{$ip}";
    
    if (!isset($_SESSION[$key])) {
        $_SESSION[$key] = ['count' => 1, 'first_attempt' => time()];
        return true;
    }
    
    $data = $_SESSION[$key];
    $elapsed = time() - $data['first_attempt'];
    
    if ($elapsed > $window) {
        // Reset after window expires
        $_SESSION[$key] = ['count' => 1, 'first_attempt' => time()];
        return true;
    }
    
    if ($data['count'] >= $limit) {
        // Rate limit exceeded
        error_log("NexusValhalla: Rate limit exceeded for {$action} from IP {$ip}");
        return false;
    }
    
    $_SESSION[$key]['count']++;
    return true;
}

// ============================================================
// 12. SESSION STATUS FLAGS
// ============================================================

// Set flags for the frontend to check session state
define('SESSION_ACTIVE', true);
define('SESSION_IDLE_TIMEOUT', isset($_SESSION['_idle_timeout']) && $_SESSION['_idle_timeout']);
if (isset($_SESSION['_idle_timeout'])) {
    unset($_SESSION['_idle_timeout']); // Clear the flag after checking
}

// ============================================================
// 13. LOGGING (security audit trail)
// ============================================================

/**
 * Log security events
 * @param string $message The message to log
 * @param string $level The log level (info, warning, error)
 */
function logSecurityEvent($message, $level = 'info') {
    $timestamp = date('Y-m-d H:i:s');
    $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
    $logEntry = "[{$timestamp}] [{$level}] [IP: {$ip}] [UA: {$userAgent}] {$message}";
    
    // Log to file (you can also use syslog or a database)
    error_log($logEntry);
}

// Example: log a successful session initialization
if (!isset($_SESSION['_logged_init'])) {
    logSecurityEvent('New session initialized', 'info');
    $_SESSION['_logged_init'] = true;
}

// ============================================================
// 14. CLEANUP – Ensure session data is written
// ============================================================

// Session write is handled automatically at the end of the request.
// You can call session_write_close() explicitly if needed.

// ============================================================
// 15. EXPOSE HELPER FUNCTIONS (for use in other parts of the app)
// ============================================================

// The following functions are now available globally:
// - getCsrfToken()
// - csrfField()
// - validateCsrfToken($token)
// - refreshCsrfToken()
// - checkRateLimit($action, $limit, $window)
// - logSecurityEvent($message, $level)

// ============================================================
// END OF cookies.php
// ============================================================