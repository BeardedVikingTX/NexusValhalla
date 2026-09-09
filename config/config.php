<?php
/**
 * config.php – NexusValhalla Configuration
 * 
 * Loads environment variables from .env and defines constants.
 */

// ============================================================
// LOAD ENVIRONMENT VARIABLES
// ============================================================

function loadEnv($path) {
    if (!file_exists($path)) {
        error_log('[NEXUS] .env file not found at ' . $path);
        return;
    }
    
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        // Skip comments
        if (strpos($line, '#') === 0) {
            continue;
        }
        // Skip lines without '='
        if (strpos($line, '=') === false) {
            continue;
        }
        
        list($key, $value) = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value);
        
        // Remove surrounding quotes (single or double)
        if (strlen($value) >= 2) {
            if (($value[0] === '"' && $value[strlen($value)-1] === '"') ||
                ($value[0] === "'" && $value[strlen($value)-1] === "'")) {
                $value = substr($value, 1, -1);
            }
        }
        
        putenv("{$key}={$value}");
        $_ENV[$key] = $value;
        $_SERVER[$key] = $value;
    }
}

// Load .env from root directory
loadEnv(__DIR__ . '/../.env');

// ============================================================
// DEFINE CONSTANTS
// ============================================================

define('SITE_URL', getenv('SITE_URL') ?: 'https://nexusvalhalla.beardedviking.org');
define('SITE_NAME', getenv('SITE_NAME') ?: 'NexusValhalla');
define('SITE_EMAIL', getenv('SITE_EMAIL') ?: 'info@beardedviking.org');
define('SITE_EMAIL_NAME', getenv('SITE_EMAIL_NAME') ?: 'NexusValhalla');

define('ENV', getenv('ENV') ?: 'production');
define('DEBUG', getenv('DEBUG') === 'true' ? true : false);

// Database
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_NAME', getenv('DB_NAME') ?: 'nexusvalhalla');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');

// Encryption Key
define('ENCRYPTION_KEY', getenv('ENCRYPTION_KEY') ?: 'default-key-change-me-now');

// ============================================================
// ASSET PATHS
// ============================================================

define('VENDOR_PATH', __DIR__ . '/../includes/vendors');
define('VENDOR_URL', SITE_URL . '/includes/vendors');
define('BOOTSTRAP_CSS', VENDOR_URL . '/Bootstrap/css/bootstrap.min.css');
define('BOOTSTRAP_JS', VENDOR_URL . '/Bootstrap/js/bootstrap.bundle.min.js');
define('FONTAWESOME_CSS', VENDOR_URL . '/FontAwesome/css/all.min.css');
define('FONTAWESOME_JS', VENDOR_URL . '/FontAwesome/js/all.min.js');
define('GOOGLE_FONTS_CSS', VENDOR_URL . '/GoogleFonts/css/fonts.css');
define('CHART_JS', VENDOR_URL . '/ChartJS/chart.min.js');

define('ASSETS_URL', SITE_URL . '/assets');
define('CSS_URL', ASSETS_URL . '/css');
define('JS_URL', ASSETS_URL . '/js');
define('IMAGES_URL', ASSETS_URL . '/img');
define('PAGES_DIR', __DIR__ . '/../pages');
define('USERS_DIR', __DIR__ . '/../users');
define('AVATARS_DIR', USERS_DIR . '/images/avatars');
define('BANNERS_DIR', USERS_DIR . '/images/banners');
define('AVATARS_URL', SITE_URL . '/users/images/avatars');
define('BANNERS_URL', SITE_URL . '/users/images/banners');

// ============================================================
// ERROR REPORTING
// ============================================================

if (DEBUG) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    ini_set('error_log', __DIR__ . '/../logs/error.log');
}

// ============================================================
// DEBUG: LOG THE LOADED VALUES (REMOVE IN PRODUCTION)
// ============================================================
error_log('[NEXUS] Config loaded: DB_NAME=' . DB_NAME . ' DB_USER=' . DB_USER);