<?php
/**
 * config.php – Site Configuration
 * 
 * All site-wide constants and settings.
 */

// ============================================================
// SITE URL (auto-detect)
// ============================================================
define('SITE_URL', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https://' : 'http://') . $_SERVER['HTTP_HOST']);
define('SITE_NAME', 'NexusValhalla');

// ============================================================
// ASSET PATHS
// ============================================================
define('ASSETS_URL', SITE_URL . '/assets');
define('CSS_URL', ASSETS_URL . '/css');
define('JS_URL', ASSETS_URL . '/js');
define('PAGES_DIR', __DIR__ . '/../pages');

// ============================================================
// DATABASE (if needed)
// ============================================================
define('DB_HOST', 'localhost');
define('DB_NAME', 'beardedviking_nexusvalhalla');   // CHANGE THIS
define('DB_USER', 'beardedviking_admin_bvsec');   // CHANGE THIS
define('DB_PASS', '{f8m*q5bm*Jg^4ZRM&'); // CHANGE THIS

// ============================================================
// ENCRYPTION KEY (for cookies.php encryption)
// ============================================================
define('ENCRYPTION_KEY', 'change-this-to-a-secure-key-32-bytes');

// ============================================================
// USER & FILE SYSTEM PATHS
// ============================================================
define('USERS_DIR', __DIR__ . '/../users');
define('AVATARS_DIR', USERS_DIR . '/images/avatars');
define('BANNERS_DIR', USERS_DIR . '/images/banners');
define('AVATARS_URL', SITE_URL . '/users/images/avatars');
define('BANNERS_URL', SITE_URL . '/users/images/banners');

// ============================================================
// EMAIL CONFIGURATION
// ============================================================
define('SITE_EMAIL', 'info@beardedviking.org');
define('SITE_EMAIL_NAME', 'NexusValhalla');