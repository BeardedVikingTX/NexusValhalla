<?php
/**
 * registration_functions.php – User Registration Functions
 * WITH DEBUGGING - All functions log their steps
 */

// ============================================================
// SECURITY LOGGING (Fallback)
// ============================================================
if (!function_exists('logSecurityEvent')) {
    function logSecurityEvent($message, $level = 'info') {
        $timestamp = date('Y-m-d H:i:s');
        error_log("[NEXUS] [{$timestamp}] [{$level}] {$message}");
    }
}

// ============================================================
// SANITIZE USERNAME
// ============================================================
function sanitizeUsername($username) {
    $username = strtolower(trim($username));
    $username = preg_replace('/[^a-zA-Z0-9_\-]/', '', $username);
    $username = str_replace(' ', '_', $username);
    return $username;
}

// ============================================================
// CREATE USER DIRECTORIES
// ============================================================
function createUserDirectories($username) {
    $sanitized = sanitizeUsername($username);
    
    // Use absolute paths from config
    $avatarPath = AVATARS_DIR . '/' . $sanitized;
    $bannerPath = BANNERS_DIR . '/' . $sanitized;
    
    // Log what we're doing
    error_log("[NEXUS] Creating directories for: {$sanitized}");
    error_log("[NEXUS] Avatar path: {$avatarPath}");
    error_log("[NEXUS] Banner path: {$bannerPath}");
    
    // Create avatars directory
    if (!file_exists($avatarPath)) {
        if (!mkdir($avatarPath, 0755, true)) {
            error_log("[NEXUS] FAILED to create avatar directory: {$avatarPath}");
            return false;
        }
        error_log("[NEXUS] Created avatar directory: {$avatarPath}");
    }
    
    // Create banners directory
    if (!file_exists($bannerPath)) {
        if (!mkdir($bannerPath, 0755, true)) {
            error_log("[NEXUS] FAILED to create banner directory: {$bannerPath}");
            return false;
        }
        error_log("[NEXUS] Created banner directory: {$bannerPath}");
    }
    
    return true;
}

// ============================================================
// HANDLE AVATAR UPLOAD
// ============================================================
function handleAvatarUpload($file, $username) {
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
        error_log("[NEXUS] No avatar uploaded or upload error");
        return null;
    }
    
    $sanitized = sanitizeUsername($username);
    $targetDir = AVATARS_DIR . '/' . $sanitized . '/';
    
    // Validate file type
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);
    
    if (!in_array($mimeType, $allowedTypes)) {
        error_log("[NEXUS] Invalid avatar type: {$mimeType}");
        return null;
    }
    
    if ($file['size'] > 2 * 1024 * 1024) {
        error_log("[NEXUS] Avatar too large: {$file['size']}");
        return null;
    }
    
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = 'avatar_' . time() . '.' . $extension;
    $targetPath = $targetDir . $filename;
    
    if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
        error_log("[NEXUS] Failed to move avatar upload");
        return null;
    }
    
    error_log("[NEXUS] Avatar uploaded: {$targetPath}");
    return '/users/images/avatars/' . $sanitized . '/' . $filename;
}

// ============================================================
// REGISTER USER – THE MAIN FUNCTION
// ============================================================
function registerUser($data) {
    error_log("[NEXUS] ===== REGISTRATION STARTED =====");
    error_log("[NEXUS] Data received: " . print_r($data, true));
    
    // Get database instance
    $db = Database::getInstance();
    
    // Extract data
    $alias = trim($data['alias'] ?? '');
    $password = $data['password'] ?? '';
    $confirmPassword = $data['confirm_password'] ?? '';
    $registrationType = $data['registration_type'] ?? 'professional';
    
    error_log("[NEXUS] Alias: {$alias}");
    error_log("[NEXUS] Registration Type: {$registrationType}");
    
    // ============================================================
    // VALIDATION
    // ============================================================
    
    if (empty($alias) || strlen($alias) < 3) {
        error_log("[NEXUS] Validation FAILED: Alias too short");
        return ['success' => false, 'message' => 'Alias must be at least 3 characters.'];
    }
    
    if (strlen($alias) > 50) {
        error_log("[NEXUS] Validation FAILED: Alias too long");
        return ['success' => false, 'message' => 'Alias must be 50 characters or less.'];
    }
    
    if (!preg_match('/^[a-zA-Z0-9_\- ]+$/', $alias)) {
        error_log("[NEXUS] Validation FAILED: Invalid characters in alias");
        return ['success' => false, 'message' => 'Alias can only contain letters, numbers, spaces, underscores, and hyphens.'];
    }
    
    if (empty($password) || strlen($password) < 8) {
        error_log("[NEXUS] Validation FAILED: Password too short");
        return ['success' => false, 'message' => 'Password must be at least 8 characters.'];
    }
    
    if ($password !== $confirmPassword) {
        error_log("[NEXUS] Validation FAILED: Passwords don't match");
        return ['success' => false, 'message' => 'Passwords do not match.'];
    }
    
    // Professional registration validation
    if ($registrationType === 'professional') {
        $email = trim($data['email'] ?? '');
        $firstName = trim($data['first_name'] ?? '');
        $lastName = trim($data['last_name'] ?? '');
        
        error_log("[NEXUS] Professional registration - Email: {$email}");
        
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            error_log("[NEXUS] Validation FAILED: Invalid email");
            return ['success' => false, 'message' => 'Please enter a valid email address.'];
        }
        
        if (empty($firstName) || strlen($firstName) < 2) {
            error_log("[NEXUS] Validation FAILED: First name too short");
            return ['success' => false, 'message' => 'First name must be at least 2 characters.'];
        }
        
        if (empty($lastName) || strlen($lastName) < 2) {
            error_log("[NEXUS] Validation FAILED: Last name too short");
            return ['success' => false, 'message' => 'Last name must be at least 2 characters.'];
        }
        
        // Check if email exists
        try {
            $existing = $db->fetchOne('SELECT id FROM users WHERE email = ?', [$email]);
            if ($existing) {
                error_log("[NEXUS] Validation FAILED: Email already exists");
                return ['success' => false, 'message' => 'This email is already registered.'];
            }
        } catch (Exception $e) {
            error_log("[NEXUS] Database error checking email: " . $e->getMessage());
        }
    }
    
    // Check if alias exists
    try {
        $existingAlias = $db->fetchOne('SELECT id FROM users WHERE alias = ?', [$alias]);
        if ($existingAlias) {
            error_log("[NEXUS] Validation FAILED: Alias already exists");
            return ['success' => false, 'message' => 'This alias is already taken. Please choose another.'];
        }
    } catch (Exception $e) {
        error_log("[NEXUS] Database error checking alias: " . $e->getMessage());
    }
    
    error_log("[NEXUS] All validation passed!");
    
    // ============================================================
    // CREATE DIRECTORIES
    // ============================================================
    
    if (!createUserDirectories($alias)) {
        error_log("[NEXUS] FAILED: Could not create directories");
        return ['success' => false, 'message' => 'Failed to create user directories. Please try again.'];
    }
    
    // ============================================================
    // HANDLE AVATAR
    // ============================================================
    
    $avatarPath = null;
    if (isset($data['avatar_file']) && $data['avatar_file']['error'] === UPLOAD_ERR_OK) {
        $avatarPath = handleAvatarUpload($data['avatar_file'], $alias);
        error_log("[NEXUS] Avatar path: " . ($avatarPath ?? 'None'));
    }
    
    // ============================================================
    // HASH PASSWORD
    // ============================================================
    
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    error_log("[NEXUS] Password hashed successfully");
    
    // ============================================================
    // GENERATE VERIFICATION TOKEN
    // ============================================================
    
    $verificationToken = null;
    $status = 'active';
    
    if ($registrationType === 'professional') {
        $verificationToken = bin2hex(random_bytes(32));
        $status = 'pending';
        error_log("[NEXUS] Verification token generated: {$verificationToken}");
    }
    
    // ============================================================
    // INSERT INTO DATABASE
    // ============================================================
    
    try {
        $sql = "INSERT INTO users (
            alias, first_name, last_name, email, password_hash, 
            role, status, avatar, registration_type, 
            verification_token, ip_address, user_agent
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $params = [
            $alias,
            $data['first_name'] ?? null,
            $data['last_name'] ?? null,
            $data['email'] ?? null,
            $passwordHash,
            'user',
            $status,
            $avatarPath,
            $registrationType,
            $verificationToken,
            $_SERVER['REMOTE_ADDR'] ?? null,
            $_SERVER['HTTP_USER_AGENT'] ?? null
        ];
        
        error_log("[NEXUS] SQL: " . $sql);
        error_log("[NEXUS] Params: " . print_r($params, true));
        
        $id = $db->insert($sql, $params);
        
        if (!$id) {
            error_log("[NEXUS] FAILED: Database insert returned no ID");
            return ['success' => false, 'message' => 'Failed to create user account. Please try again.'];
        }
        
        error_log("[NEXUS] User inserted with ID: {$id}");
        
        // ============================================================
        // SEND WELCOME EMAIL
        // ============================================================
        
        if ($registrationType === 'professional' && !empty($data['email'])) {
            error_log("[NEXUS] Sending welcome email to: " . $data['email']);
            $emailSent = sendRegistrationEmail($data['email'], $alias, $verificationToken);
            error_log("[NEXUS] Email sent: " . ($emailSent ? 'YES' : 'NO'));
        }
        
        // ============================================================
        // LOG THE EVENT
        // ============================================================
        
        logSecurityEvent("New user registered: {$alias} (Type: {$registrationType})", 'info');
        
        error_log("[NEXUS] ===== REGISTRATION SUCCESSFUL =====");
        
        return [
            'success' => true,
            'message' => $registrationType === 'professional' 
                ? 'Registration successful! Please check your email to verify your account.'
                : 'Registration successful! Welcome to NexusValhalla.',
            'user_id' => $id,
            'alias' => $alias,
            'needs_verification' => ($registrationType === 'professional')
        ];
        
    } catch (PDOException $e) {
        error_log("[NEXUS] DATABASE ERROR: " . $e->getMessage());
        error_log("[NEXUS] SQL State: " . $e->getCode());
        return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
    } catch (Exception $e) {
        error_log("[NEXUS] GENERAL ERROR: " . $e->getMessage());
        return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
    }
}

// ============================================================
// SEND REGISTRATION EMAIL
// ============================================================
function sendRegistrationEmail($email, $alias, $token) {
    $subject = "Welcome to NexusValhalla, {$alias}! ⚔️";
    
    $message = "Greetings, Warrior {$alias}!\n\n"
             . "You have successfully registered for NexusValhalla — the digital realm where Vikings meet the future.\n\n"
             . "To complete your journey, please verify your email address by clicking the link below:\n\n"
             . SITE_URL . "/verify.php?token={$token}\n\n"
             . "Once verified, you'll gain access to:\n"
             . "  • Your personal dashboard\n"
             . "  • The ability to connect with fellow warriors\n"
             . "  • Exclusive reputation badges\n"
             . "  • And the glory of Valhalla itself!\n\n"
             . "The AI race is on. Five warriors have built their realms. Now it's YOUR turn.\n\n"
             . "Skål!\n"
             . "— The Bearded Viking\n"
             . "Keeper of the Nexus";
    
    $headers = "From: " . SITE_EMAIL_NAME . " <" . SITE_EMAIL . ">\r\n"
             . "Reply-To: " . SITE_EMAIL . "\r\n"
             . "X-Mailer: PHP/" . phpversion();
    
    error_log("[NEXUS] Sending email to: {$email}");
    $result = mail($email, $subject, $message, $headers);
    error_log("[NEXUS] Email result: " . ($result ? 'true' : 'false'));
    return $result;
}

// ============================================================
// HELPER FUNCTIONS
// ============================================================

function isLoggedIn() {
    return isset($_SESSION['user_id']) && isset($_SESSION['user_alias']);
}

function getCurrentUser() {
    if (!isLoggedIn()) {
        return null;
    }
    $db = Database::getInstance();
    return $db->fetchOne(
        'SELECT id, alias, first_name, last_name, email, avatar, role, status, created_at FROM users WHERE id = ?',
        [$_SESSION['user_id']]
    );
}

function logoutUser() {
    if (isset($_SESSION['user_alias'])) {
        logSecurityEvent("User logged out: {$_SESSION['user_alias']}", 'info');
    }
    session_unset();
    session_destroy();
    session_start();
    return ['success' => true, 'message' => 'You have been logged out.'];
}