<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<h1>🔍 Debugging NexusValhalla</h1>";

// 1. Test Config Loading
echo "<h2>1. Config Loading</h2>";
require_once __DIR__ . '/config/config.php';
echo "SITE_URL: " . SITE_URL . "<br>";
echo "DB_NAME: " . DB_NAME . "<br>";
echo "DB_USER: " . DB_USER . "<br>";

// 2. Test Database Connection
echo "<h2>2. Database Connection</h2>";
require_once __DIR__ . '/includes/db.php';
$db = Database::getInstance();

if ($db->isConnected()) {
    echo "✅ Database connected!<br>";
    $result = $db->query("SELECT NOW() as time");
    if ($result) {
        $row = $result->fetch();
        echo "Server time: " . $row['time'] . "<br>";
    }
} else {
    echo "❌ Database connection failed.<br>";
}

// 3. Test Tracking
echo "<h2>3. Tracking System</h2>";
require_once __DIR__ . '/includes/cookies.php';
echo "Session ID: " . session_id() . "<br>";
echo "Tracking ID: " . ($_SESSION['_tracking_id'] ?? 'none') . "<br>";

// 4. Check User Tracking Table
echo "<h2>4. Check user_tracking Table</h2>";
if ($db->isConnected()) {
    $result = $db->query("SELECT COUNT(*) as count FROM user_tracking");
    if ($result) {
        $row = $result->fetch();
        echo "Total tracking records: " . $row['count'] . "<br>";
    } else {
        echo "❌ Could not query user_tracking table. Does it exist?<br>";
    }
}

echo "<h2>✅ Debug complete!</h2>";