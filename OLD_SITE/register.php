<?php
/**
 * register.php – Forge Your Saga
 */

// ============================================================
// LOAD EVERYTHING WITH ERROR REPORTING ON
// ============================================================
error_reporting(E_ALL);
ini_set('display_errors', 1);


// Set page metadata
$pageTitle       = 'NexusValhalla – Forge Your Saga';
$pageDescription = 'Register for NexusValhalla — create your account and join the AI LLM race.';
$pageBodyClass   = 'page-register';

// Load config, header, and registration functions
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/registration_functions.php';

// ============================================================
// REGISTRATION HANDLER
// ============================================================
$regMessage = '';
$regSuccess = false;
$selectedType = isset($_GET['type']) && $_GET['type'] === 'anonymous' ? 'anonymous' : 'professional';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register_action'])) {
    error_log("[NEXUS] ===== FORM SUBMITTED =====");
    error_log("[NEXUS] POST data: " . print_r($_POST, true));
    error_log("[NEXUS] FILES data: " . print_r($_FILES, true));
    
    // Verify CSRF token
    if (!isset($_POST['csrf_token']) || !validateCsrfToken($_POST['csrf_token'])) {
        $regMessage = 'Security validation failed. Please try again.';
        error_log("[NEXUS] CSRF validation FAILED");
    } else {
        error_log("[NEXUS] CSRF validation PASSED");
        
        // Prepare registration data
        $regData = [
            'registration_type' => $_POST['registration_type'] ?? 'professional',
            'alias' => trim($_POST['alias'] ?? ''),
            'password' => $_POST['password'] ?? '',
            'confirm_password' => $_POST['confirm_password'] ?? '',
        ];
        
        // Professional registration fields
        if ($regData['registration_type'] === 'professional') {
            $regData['first_name'] = trim($_POST['first_name'] ?? '');
            $regData['last_name'] = trim($_POST['last_name'] ?? '');
            $regData['email'] = trim($_POST['email'] ?? '');
        }
        
        // Handle avatar upload
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $regData['avatar_file'] = $_FILES['avatar'];
            error_log("[NEXUS] Avatar uploaded: " . $_FILES['avatar']['name']);
        }
        
        error_log("[NEXUS] Calling registerUser()");
        $result = registerUser($regData);
        error_log("[NEXUS] registerUser() result: " . print_r($result, true));
        
        if ($result['success']) {
            $regSuccess = true;
            $regMessage = $result['message'];
            
            // If no verification needed, log the user in automatically
            if (!$result['needs_verification']) {
                $_SESSION['user_id'] = $result['user_id'];
                $_SESSION['user_alias'] = $result['alias'];
                $_SESSION['logged_in'] = true;
                error_log("[NEXUS] Auto-login successful, redirecting to dashboard");
                echo '<meta http-equiv="refresh" content="2;url=' . SITE_URL . '/users/dashboard.php">';
            } else {
                error_log("[NEXUS] Verification needed, redirecting to login");
                echo '<meta http-equiv="refresh" content="3;url=' . SITE_URL . '/?page=login">';
            }
        } else {
            $regMessage = $result['message'];
            error_log("[NEXUS] Registration FAILED: " . $regMessage);
        }
    }
}
?>

<!-- ========================================================== -->
<!-- REGISTRATION FORM (SAME AS BEFORE, BUT WITH DEBUG INFO)    -->
<!-- ========================================================== -->

<div class="container py-4 py-md-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-8">

            <!-- Header -->
            <div class="text-center mb-4">
                <span class="badge px-4 py-2 rounded-pill mb-3" style="background: rgba(255,215,0,0.15); color: #ffd700; font-size: 0.9rem;">
                    <i class="fas fa-helmet-battle me-2"></i> Forge Your Saga
                </span>
                <h1 class="display-4 fw-bold">
                    <span class="glow-text">Create Your</span><br>
                    <span class="glow-text-gold">Digital Identity</span>
                </h1>
                <p class="text-light fs-5" style="opacity: 0.8;">
                    Choose your path — anonymous warrior or professional champion.
                </p>
            </div>

            <!-- Message Display -->
            <?php if ($regMessage): ?>
                <div class="alert <?= $regSuccess ? 'alert-success' : 'alert-warning' ?> text-center mb-4" role="alert" style="border-radius: 12px;">
                    <i class="fas <?= $regSuccess ? 'fa-check-circle' : 'fa-exclamation-triangle' ?> me-2"></i>
                    <?= htmlspecialchars($regMessage) ?>
                    <?php if (!$regSuccess): ?>
                        <br><small style="color: #8899aa;">Check the error logs for more details.</small>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <!-- Registration Type Toggle -->
            <div class="d-flex justify-content-center gap-3 mb-4">
                <a href="?page=register&type=professional" 
                   class="btn px-4 py-2 rounded-pill <?= $selectedType === 'professional' ? 'btn-accent' : 'btn-outline-accent' ?>" 
                   style="font-weight: 600;">
                    <i class="fas fa-user-tie me-2"></i> Professional
                </a>
                <a href="?page=register&type=anonymous" 
                   class="btn px-4 py-2 rounded-pill <?= $selectedType === 'anonymous' ? 'btn-accent' : 'btn-outline-accent' ?>" 
                   style="font-weight: 600;">
                    <i class="fas fa-user-secret me-2"></i> Anonymous
                </a>
            </div>

            <!-- Registration Form -->
            <div class="card p-4 p-md-5 rounded-4" style="background: rgba(10,14,23,0.92); border: 1px solid rgba(0,212,255,0.15); backdrop-filter: blur(10px);">
                
                <form method="POST" action="<?= SITE_URL ?>/?page=register" enctype="multipart/form-data">
                    <?= csrfField(); ?>
                    <input type="hidden" name="register_action" value="submit">
                    <input type="hidden" name="registration_type" value="<?= $selectedType ?>">

                    <div class="row g-3">

                        <?php if ($selectedType === 'professional'): ?>
                            <!-- First Name -->
                            <div class="col-12 col-md-6">
                                <label for="first_name" class="form-label" style="color: #b0c4de; font-weight: 500;">First Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="first_name" name="first_name" 
                                       placeholder="Ragnar" required
                                       style="background: rgba(255,255,255,0.05); border: 1px solid rgba(0,212,255,0.2); color: #ffffff; border-radius: 10px; padding: 12px 16px;">
                            </div>

                            <!-- Last Name -->
                            <div class="col-12 col-md-6">
                                <label for="last_name" class="form-label" style="color: #b0c4de; font-weight: 500;">Last Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="last_name" name="last_name" 
                                       placeholder="Lothbrok" required
                                       style="background: rgba(255,255,255,0.05); border: 1px solid rgba(0,212,255,0.2); color: #ffffff; border-radius: 10px; padding: 12px 16px;">
                            </div>

                            <!-- Email -->
                            <div class="col-12">
                                <label for="email" class="form-label" style="color: #b0c4de; font-weight: 500;">Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       placeholder="ragnar@valhalla.asgard" required
                                       style="background: rgba(255,255,255,0.05); border: 1px solid rgba(0,212,255,0.2); color: #ffffff; border-radius: 10px; padding: 12px 16px;">
                                <div class="small mt-1" style="color: #8899aa;">
                                    <i class="fas fa-info-circle me-1"></i> A verification email will be sent to this address.
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Alias -->
                        <div class="col-12">
                            <label for="alias" class="form-label" style="color: #b0c4de; font-weight: 500;">
                                Alias (Username) <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="alias" name="alias" 
                                   placeholder="<?= $selectedType === 'professional' ? 'Ragnar_Warrior' : 'Shadow_Warrior' ?>" 
                                   required minlength="3" maxlength="50"
                                   style="background: rgba(255,255,255,0.05); border: 1px solid rgba(0,212,255,0.2); color: #ffffff; border-radius: 10px; padding: 12px 16px;">
                            <div class="small mt-1" style="color: #8899aa;">
                                <i class="fas fa-info-circle me-1"></i> 3-50 characters. Letters, numbers, underscores, and hyphens only.
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="col-12 col-md-6">
                            <label for="password" class="form-label" style="color: #b0c4de; font-weight: 500;">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password" name="password" 
                                   placeholder="••••••••" required minlength="8"
                                   style="background: rgba(255,255,255,0.05); border: 1px solid rgba(0,212,255,0.2); color: #ffffff; border-radius: 10px; padding: 12px 16px;">
                            <div class="small mt-1" style="color: #8899aa;">
                                <i class="fas fa-info-circle me-1"></i> Minimum 8 characters.
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="col-12 col-md-6">
                            <label for="confirm_password" class="form-label" style="color: #b0c4de; font-weight: 500;">Confirm Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" 
                                   placeholder="••••••••" required minlength="8"
                                   style="background: rgba(255,255,255,0.05); border: 1px solid rgba(0,212,255,0.2); color: #ffffff; border-radius: 10px; padding: 12px 16px;">
                        </div>

                        <!-- Avatar Upload -->
                        <div class="col-12">
                            <label for="avatar" class="form-label" style="color: #b0c4de; font-weight: 500;">Avatar (Optional)</label>
                            <input type="file" class="form-control" id="avatar" name="avatar" 
                                   accept="image/jpeg,image/png,image/gif,image/webp"
                                   style="background: rgba(255,255,255,0.05); border: 1px solid rgba(0,212,255,0.2); color: #ffffff; border-radius: 10px; padding: 8px 12px;">
                            <div class="small mt-1" style="color: #8899aa;">
                                <i class="fas fa-info-circle me-1"></i> Max 2MB. Supported: JPEG, PNG, GIF, WebP.
                            </div>
                            <div id="avatar-preview" class="mt-2 text-center"></div>
                        </div>

                        <!-- Submit -->
                        <div class="col-12 mt-3">
                            <button type="submit" class="btn btn-accent btn-lg w-100 rounded-pill py-3" style="font-weight: 700; letter-spacing: 0.5px;">
                                <i class="fas fa-hammer me-2"></i> Forge Your Account
                            </button>
                        </div>

                        <!-- Login Link -->
                        <div class="col-12 text-center mt-3">
                            <span style="color: #8899aa;">Already have an account?</span>
                            <a href="<?= SITE_URL ?>/?page=login" class="text-primary fw-bold" style="text-decoration: none;"> Log in here</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Avatar Preview JS -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const avatarInput = document.getElementById('avatar');
    const previewDiv = document.getElementById('avatar-preview');
    
    if (avatarInput) {
        avatarInput.addEventListener('change', function(e) {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    previewDiv.innerHTML = `
                        <div class="d-inline-block p-2 rounded-circle" style="background: rgba(0,212,255,0.05); border: 2px solid rgba(0,212,255,0.2);">
                            <img src="${event.target.result}" 
                                 alt="Avatar Preview" 
                                 class="rounded-circle" 
                                 style="width: 100px; height: 100px; object-fit: cover;">
                        </div>
                        <div class="small mt-1" style="color: #8899aa;">Preview</div>
                    `;
                };
                reader.readAsDataURL(file);
            } else {
                previewDiv.innerHTML = '';
            }
        });
    }
});
</script>

<?php
// Load footer
require_once __DIR__ . '/includes/footer.php';
?>