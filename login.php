<?php
/**
 * login.php – Enter the Nexus
 * 
 * User login page with both alias and email support.
 */


// Set page metadata
$pageTitle       = 'NexusValhalla – Enter the Nexus';
$pageDescription = 'Log in to NexusValhalla and continue your saga.';
$pageBodyClass   = 'page-login';

// Load header
require_once __DIR__ . '/includes/header.php';

// Load registration functions
require_once __DIR__ . '/includes/registration_functions.php';

// Redirect if already logged in
if (isLoggedIn()) {
    header('Location: ' . SITE_URL . '/users/dashboard.php');
    exit;
}

// ============================================================
// LOGIN HANDLER
// ============================================================
$loginMessage = '';
$loginSuccess = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login_action'])) {
    // Verify CSRF token
    if (!isset($_POST['csrf_token']) || !validateCsrfToken($_POST['csrf_token'])) {
        $loginMessage = 'Security validation failed. Please try again.';
    } else {
        $identifier = trim($_POST['identifier'] ?? '');
        $password = $_POST['password'] ?? '';
        $remember = isset($_POST['remember']) ? true : false;
        
        if (empty($identifier) || empty($password)) {
            $loginMessage = 'Please enter your alias/email and password.';
        } else {
            $result = loginUser($identifier, $password);
            
            if ($result['success']) {
                $loginSuccess = true;
                $loginMessage = $result['message'];
                
                // Handle remember me
                if ($remember) {
                    // Set a long-lived cookie (30 days)
                    setcookie('NXS_REMEMBER', $result['user']['id'], time() + (86400 * 30), '/', '', false, true);
                }
                
                // Redirect to dashboard
                echo '<meta http-equiv="refresh" content="2;url=' . SITE_URL . '/users/dashboard.php">';
            } else {
                $loginMessage = $result['message'];
            }
        }
    }
}
?>

<!-- ==========================================================
     LOGIN HERO
     ========================================================== -->
<section id="login-hero" class="py-5 text-center position-relative overflow-hidden">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-8">
                <div class="mb-4">
                    <span class="badge px-4 py-2 rounded-pill" style="background: rgba(0,212,255,0.15);">
                        <i class="fas fa-door-open me-2"></i> Enter the Nexus
                    </span>
                </div>
                <h1 class="display-3 fw-bold">
                    <span class="glow-text">Welcome Back,</span><br>
                    <span class="glow-text-gold">Warrior</span>
                </h1>
                <p class="lead text-muted mt-4 fs-5 lh-lg" style="max-width: 500px; margin: 0 auto;">
                    Your saga continues. Enter your credentials to return to the realm.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================================
     LOGIN FORM
     ========================================================== -->
<section id="login-form" class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-6 col-xl-5">

                <!-- Message Display -->
                <?php if ($loginMessage): ?>
                    <div class="alert <?= $loginSuccess ? 'alert-success' : 'alert-warning' ?> text-center" role="alert">
                        <i class="fas <?= $loginSuccess ? 'fa-check-circle' : 'fa-exclamation-triangle' ?> me-2"></i>
                        <?= htmlspecialchars($loginMessage) ?>
                    </div>
                <?php endif; ?>

                <!-- Login Form -->
                <div class="sci-fi-card p-4 rounded-4" style="background: rgba(10,14,23,0.85); border: 1px solid rgba(0,212,255,0.1);">
                    <form method="POST" action="<?= SITE_URL ?>/?page=login#login-form" class="mt-2">
                        <?= csrfField(); ?>
                        <input type="hidden" name="login_action" value="submit">

                        <div class="row g-3">

                            <!-- Identifier (Alias or Email) -->
                            <div class="col-12">
                                <label for="identifier" class="form-label text-muted small">Alias or Email <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="identifier" name="identifier" 
                                       placeholder="Ragnar_Warrior or ragnar@valhalla.asgard" required
                                       style="background: rgba(255,255,255,0.05); border: 1px solid rgba(0,212,255,0.15); color: #e8e8e8;">
                            </div>

                            <!-- Password -->
                            <div class="col-12">
                                <label for="password" class="form-label text-muted small">Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="password" name="password" 
                                       placeholder="••••••••" required
                                       style="background: rgba(255,255,255,0.05); border: 1px solid rgba(0,212,255,0.15); color: #e8e8e8;">
                            </div>

                            <!-- Remember Me & Forgot Password -->
                            <div class="col-12 d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                    <label class="form-check-label text-muted small" for="remember">Remember me</label>
                                </div>
                                <a href="#" class="text-muted small text-decoration-none">Forgot password?</a>
                            </div>

                            <!-- Submit -->
                            <div class="col-12 mt-3">
                                <button type="submit" class="btn btn-accent btn-lg w-100">
                                    <i class="fas fa-sign-in-alt me-2"></i> Enter the Nexus
                                </button>
                            </div>

                            <!-- Register Link -->
                            <div class="col-12 text-center mt-3">
                                <span class="text-muted small">Don't have an account?</span>
                                <a href="<?= SITE_URL ?>/?page=register" class="text-primary text-decoration-none"> Forge your saga</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
// Load footer
require_once __DIR__ . '/includes/footer.php';
?>