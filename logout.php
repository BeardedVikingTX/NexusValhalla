<?php
/**
 * logout.php – Exit the Realm
 * 
 * Logs out the current user and redirects to home.
 */

// Guard against direct access
if (!defined('NEXUSVALHALLA_APP')) {
    die('Direct access not permitted.');
}

// Load registration functions
require_once __DIR__ . '/includes/registration_functions.php';

// Logout the user
logoutUser();

// Redirect to home
header('Location: ' . SITE_URL . '/?page=home');
exit;
?>