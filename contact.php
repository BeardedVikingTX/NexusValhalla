<?php
/**
 * contact.php – The Raven's Call
 * 
 * This page serves as the primary contact gateway for NexusValhalla.
 * It features a secure contact form, social media integration, location
 * information, and a rich narrative that reflects the Bearded Viking's
 * journey from hacktivist to cybersecurity professional.
 * 
 * Metadata is set before including the header.
 */


// Set page metadata for header.php
$pageTitle       = 'NexusValhalla – Contact the Bearded Viking';
$pageDescription = 'Reach out to the Bearded Viking — cybersecurity professional, bug bounty hunter, and author. Connect via secure contact form, email, or social media.';
$pageBodyClass   = 'page-contact';

// Load the header (which includes config, cookies, nav, and opens main)
require_once __DIR__ . '/includes/header.php';

// ============================================================
// CONTACT FORM HANDLER (processed BEFORE any HTML output)
// ============================================================
$formMessage = '';
$formSuccess = false;
$debugInfo = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contact_action'])) {
    // Verify CSRF token
    if (!isset($_POST['csrf_token']) || !validateCsrfToken($_POST['csrf_token'])) {
        $formMessage = 'Security validation failed. Please try again.';
        $debugInfo = 'CSRF token validation failed.';
    } else {
        // Sanitize and validate inputs
        $name = trim(strip_tags($_POST['name'] ?? ''));
        $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
        $subject = trim(strip_tags($_POST['subject'] ?? ''));
        $message = trim(strip_tags($_POST['message'] ?? ''));
        $priority = isset($_POST['priority']) ? preg_replace('/[^a-zA-Z]/', '', $_POST['priority']) : 'normal';
        
        // Validate required fields
        if (empty($name) || strlen($name) < 2) {
            $formMessage = 'Please enter your full name (minimum 2 characters).';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $formMessage = 'Please enter a valid email address.';
        } elseif (empty($subject) || strlen($subject) < 3) {
            $formMessage = 'Please enter a subject (minimum 3 characters).';
        } elseif (empty($message) || strlen($message) < 10) {
            $formMessage = 'Please enter a message (minimum 10 characters).';
        } else {
            // Build the email
            $to = 'info@beardedviking.org';
            $emailSubject = "[NexusValhalla] {$subject}";
            
            $emailBody = "You have received a new message from the NexusValhalla contact form.\n\n"
                       . "Name: {$name}\n"
                       . "Email: {$email}\n"
                       . "Priority: " . ucfirst($priority) . "\n"
                       . "IP Address: " . ($_SERVER['REMOTE_ADDR'] ?? 'Unknown') . "\n"
                       . "User Agent: " . ($_SERVER['HTTP_USER_AGENT'] ?? 'Unknown') . "\n"
                       . "Timestamp: " . date('Y-m-d H:i:s T') . "\n\n"
                       . "Message:\n" . wordwrap($message, 72) . "\n\n"
                       . "---\n"
                       . "This message was sent via the NexusValhalla contact form.\n"
                       . "Reply-To: {$email}";
            
            $headers = "From: {$email}\r\n"
                     . "Reply-To: {$email}\r\n"
                     . "X-Mailer: PHP/" . phpversion() . "\r\n"
                     . "X-Priority: " . ($priority === 'urgent' ? '1 (Highest)' : '3 (Normal)') . "\r\n"
                     . "X-Originating-IP: " . ($_SERVER['REMOTE_ADDR'] ?? 'Unknown');
            
            // Send the email
            $mailSent = mail($to, $emailSubject, $emailBody, $headers);
            
            if ($mailSent) {
                $formSuccess = true;
                $formMessage = 'Your message has been sent successfully! The Bearded Viking will respond within 24-48 hours.';
                refreshCsrfToken(); // Refresh token after successful submission
            } else {
                // Log the error for debugging
                error_log('NexusValhalla: Contact form email failed to send.');
                $formMessage = 'There was an error sending your message. Please try again or contact us directly at info@beardedviking.org.';
                $debugInfo = 'mail() function returned false.';
            }
        }
    }
}

// ============================================================
// SOCIAL MEDIA LINKS
// ============================================================
$socialLinks = [
    'Medium' => [
        'url' => 'https://beardedviking.medium.com/',
        'icon' => 'fa-brands fa-medium',
        'color' => '#000000',
        'bio' => 'Cybersecurity | Bug Bounty Hunter | Ethical Hacker | Author'
    ],
    'LinkedIn' => [
        'url' => 'https://www.linkedin.com/in/bearded-viking-3112a8431/',
        'icon' => 'fa-brands fa-linkedin-in',
        'color' => '#0A66C2',
        'bio' => 'Professional network & cybersecurity connections'
    ],
    'Facebook' => [
        'url' => 'https://www.facebook.com/BeardedVikingTX',
        'icon' => 'fa-brands fa-facebook-f',
        'color' => '#1877F2',
        'bio' => 'Community & public updates'
    ],
    'X (Twitter)' => [
        'url' => 'https://x.com/TXBeardedViking',
        'icon' => 'fa-brands fa-x-twitter',
        'color' => '#000000',
        'bio' => 'Real-time updates & AI Code-A-Thon coverage'
    ],
    'TikTok' => [
        'url' => 'https://www.tiktok.com/@beardedvikingtx',
        'icon' => 'fa-brands fa-tiktok',
        'color' => '#000000',
        'bio' => 'Short-form cybersecurity content & hacking demos'
    ],
    'GitHub' => [
        'url' => 'https://github.com/BeardedVikingTX',
        'icon' => 'fa-brands fa-github',
        'color' => '#181717',
        'bio' => 'Open-source tools & repositories'
    ]
];

// ============================================================
// LOCATIONS
// ============================================================
$locations = [
    'Texas' => [
        'flag' => '🤠',
        'description' => 'HQ — Deep in the heart of Texas, where the code runs hot and the security is tight.'
    ],
    'Illinois' => [
        'flag' => '🌽',
        'description' => 'Secondary operations — bridging the Midwest with world-class cybersecurity expertise.'
    ]
];
?>

<!-- ==========================================================
     HERO SECTION
     ========================================================== -->
<section id="contact-hero" class="py-5 py-md-6 text-center position-relative overflow-hidden">
    <div class="container py-4 py-md-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-8">
                <div class="mb-4">
                    <span class="badge px-4 py-2 rounded-pill" style="background: rgba(123, 47, 252, 0.2); border: 1px solid rgba(123, 47, 252, 0.3);">
                        <i class="fas fa-ravens me-2"></i> The Raven's Call
                    </span>
                </div>
                <h1 class="display-3 display-md-2 fw-bold">
                    <span class="glow-text">Send a Signal</span><br>
                    <span class="glow-text-gold">Across the Realms</span>
                </h1>
                <p class="lead text-muted mt-4 fs-5 lh-lg" style="max-width: 700px; margin: 0 auto;">
                    Whether you're seeking cybersecurity expertise, collaboration opportunities, 
                    or simply wish to connect — the Bearded Viking is listening. 
                    <strong class="text-primary">Every message is a rune carved into the digital stone.</strong>
                </p>
            </div>
        </div>
    </div>

    <!-- Floating decorative elements -->
    <div class="position-absolute top-0 start-0 w-100 h-100 pointer-events-none" style="z-index: 0;">
        <div class="position-absolute float-image float-image-delay-1" style="opacity: 0.06; font-size: 7rem; top: 10%; left: 5%;">
            <i class="fas fa-ravens"></i>
        </div>
        <div class="position-absolute float-image float-image-delay-3" style="opacity: 0.05; font-size: 5rem; bottom: 10%; right: 5%;">
            <i class="fas fa-feather-alt"></i>
        </div>
        <div class="position-absolute float-image float-image-delay-2" style="opacity: 0.04; font-size: 4rem; top: 50%; right: 2%;">
            <i class="fas fa-scroll"></i>
        </div>
    </div>
</section>

<!-- ==========================================================
     CONTACT FORM & INFO GRID
     ========================================================== -->
<section id="contact-form" class="py-5">
    <div class="container">
        <div class="row g-5">

            <!-- LEFT: Contact Form -->
            <div class="col-12 col-lg-7">
                <div class="sci-fi-card p-4 rounded-4" style="background: rgba(10,14,23,0.85); border: 1px solid rgba(0,212,255,0.1);">
                    <h4 class="card-title">
                        <i class="fas fa-feather-alt me-2"></i> Send a Raven
                    </h4>
                    <p class="text-muted small">
                        Fill out the form below and your message will be delivered directly to 
                        <strong class="text-primary">info@beardedviking.org</strong>. 
                        All communications are treated with confidentiality and respect.
                    </p>

                    <?php if ($formMessage): ?>
                        <div class="alert <?= $formSuccess ? 'alert-success' : 'alert-warning' ?> mt-3" role="alert">
                            <i class="fas <?= $formSuccess ? 'fa-check-circle' : 'fa-exclamation-triangle' ?> me-2"></i>
                            <?= htmlspecialchars($formMessage) ?>
                            <?php if ($debugInfo && !$formSuccess): ?>
                                <br><small class="text-muted">(Debug: <?= htmlspecialchars($debugInfo) ?>)</small>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?= SITE_URL ?>/?page=contact#contact-form" class="mt-3">
                        <!-- CSRF Token -->
                        <?= csrfField(); ?>
                        <input type="hidden" name="contact_action" value="submit">

                        <div class="row g-3">
                            <!-- Name -->
                            <div class="col-12 col-md-6">
                                <label for="contact_name" class="form-label text-muted small">Your Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="contact_name" name="name" 
                                       placeholder="Odin Allfather" required
                                       style="background: rgba(255,255,255,0.05); border: 1px solid rgba(0,212,255,0.15); color: #e8e8e8;">
                            </div>

                            <!-- Email -->
                            <div class="col-12 col-md-6">
                                <label for="contact_email" class="form-label text-muted small">Your Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="contact_email" name="email" 
                                       placeholder="raven@valhalla.asgard" required
                                       style="background: rgba(255,255,255,0.05); border: 1px solid rgba(0,212,255,0.15); color: #e8e8e8;">
                            </div>

                            <!-- Subject -->
                            <div class="col-12">
                                <label for="contact_subject" class="form-label text-muted small">Subject <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="contact_subject" name="subject" 
                                       placeholder="Security Consultation Request" required
                                       style="background: rgba(255,255,255,0.05); border: 1px solid rgba(0,212,255,0.15); color: #e8e8e8;">
                            </div>

                            <!-- Priority -->
                            <div class="col-12">
                                <label class="form-label text-muted small">Priority</label>
                                <div class="d-flex gap-3 flex-wrap">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="priority" id="priority_normal" value="normal" checked>
                                        <label class="form-check-label text-muted small" for="priority_normal">Normal</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="priority" id="priority_urgent" value="urgent">
                                        <label class="form-check-label text-warning small" for="priority_urgent">
                                            <i class="fas fa-exclamation-triangle me-1"></i> Urgent
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Message -->
                            <div class="col-12">
                                <label for="contact_message" class="form-label text-muted small">Message <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="contact_message" name="message" 
                                          rows="6" placeholder="Your message to the Bearded Viking..." required
                                          style="background: rgba(255,255,255,0.05); border: 1px solid rgba(0,212,255,0.15); color: #e8e8e8; resize: vertical;"></textarea>
                                <div class="text-muted small mt-1">
                                    <i class="fas fa-info-circle me-1"></i> Minimum 10 characters. All messages are encrypted in transit.
                                </div>
                            </div>

                            <!-- Submit -->
                            <div class="col-12">
                                <button type="submit" class="btn btn-accent btn-lg w-100">
                                    <i class="fas fa-paper-plane me-2"></i> Send the Raven
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Direct Email Fallback -->
                    <div class="mt-3 text-center">
                        <span class="text-muted small">Prefer direct email?</span>
                        <a href="mailto:info@beardedviking.org" class="text-primary text-decoration-none">
                            <i class="fas fa-envelope me-1"></i> info@beardedviking.org
                        </a>
                        <span class="text-muted small mx-2">|</span>
                        <span class="text-muted small">
                            <i class="fas fa-lock me-1"></i> PGP: Available upon request
                        </span>
                    </div>
                </div>
            </div>

            <!-- RIGHT: Quick Info & Stats -->
            <div class="col-12 col-lg-5">
                <div class="sci-fi-card h-100 p-4 rounded-4" style="background: rgba(10,14,23,0.85); border: 1px solid rgba(0,212,255,0.1);">
                    <h4 class="card-title">
                        <i class="fas fa-bolt me-2"></i> Quick Connect
                    </h4>
                    <p class="text-muted small">
                        The Bearded Viking is a <strong class="text-primary">cybersecurity professional</strong> 
                        with over two decades of experience — from hacktivism to white-hat security.
                    </p>

                    <!-- Credentials Badge -->
                    <div class="credentials-badge p-3 rounded-3 mb-3" style="background: rgba(0,212,255,0.05); border: 1px solid rgba(0,212,255,0.1);">
                        <div class="d-flex flex-wrap gap-2 justify-content-center">
                            <span class="badge px-3 py-2" style="background: rgba(0,212,255,0.15);"><i class="fas fa-graduation-cap me-1"></i> Ph.D. C.S.</span>
                            <span class="badge px-3 py-2" style="background: rgba(255,255,255,0.05);"><i class="fas fa-certificate me-1"></i> OSCP</span>
                            <span class="badge px-3 py-2" style="background: rgba(255,255,255,0.05);"><i class="fas fa-certificate me-1"></i> CEH</span>
                            <span class="badge px-3 py-2" style="background: rgba(123,47,252,0.2);"><i class="fas fa-shield-halved me-1"></i> White Hat</span>
                        </div>
                    </div>

                    <!-- Response Time -->
                    <div class="response-time p-3 rounded-3 mb-3" style="background: rgba(255,215,0,0.03); border: 1px solid rgba(255,215,0,0.1);">
                        <div class="d-flex align-items-center">
                            <div style="font-size: 2rem; margin-right: 1rem;">⏱️</div>
                            <div>
                                <span class="text-muted small d-block">Typical Response Time</span>
                                <span class="fw-bold text-primary">24-48 hours</span>
                                <span class="text-muted small d-block">Urgent matters: <span class="text-warning">Priority handled</span></span>
                            </div>
                        </div>
                    </div>

                    <!-- Locations -->
                    <div class="locations mb-3">
                        <span class="text-muted small d-block mb-2">Operating From:</span>
                        <div class="d-flex flex-wrap gap-3">
                            <?php foreach ($locations as $state => $data): ?>
                                <div class="location-badge d-flex align-items-center gap-2 px-3 py-2 rounded-3" 
                                     style="background: rgba(255,255,255,0.03); border: 1px solid rgba(0,212,255,0.1);">
                                    <span style="font-size: 1.5rem;"><?= $data['flag'] ?></span>
                                    <div>
                                        <span class="fw-bold text-primary"><?= $state ?></span>
                                        <span class="text-muted small d-block"><?= $data['description'] ?></span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Availability -->
                    <div class="availability p-3 rounded-3" style="background: rgba(0,212,255,0.03); border: 1px solid rgba(0,212,255,0.1);">
                        <div class="d-flex align-items-center">
                            <span class="status-dot me-2" style="display: inline-block; width: 10px; height: 10px; background: #00ff88; border-radius: 50%; box-shadow: 0 0 20px #00ff88;"></span>
                            <span class="text-muted small">Currently <strong class="text-success">available</strong> for consultations and collaborations</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================================
     SOCIAL MEDIA – The Warband
     ========================================================== -->
<section id="social-media" class="py-5" style="background: rgba(0,0,0,0.2);">
    <div class="container">
        <div class="text-center mb-5">
            <span class="badge px-4 py-2 rounded-pill mb-3" style="background: rgba(0,212,255,0.15);">
                <i class="fas fa-users me-2"></i> Join the Warband
            </span>
            <h2 class="section-title glow-text">🌐 Connect Across the Realms</h2>
            <p class="text-muted fs-5" style="max-width: 700px; margin: 0 auto;">
                Follow the Bearded Viking across the digital multiverse. Each platform offers 
                a unique glimpse into the mind of a hacker, author, and cybersecurity professional.
            </p>
        </div>

        <div class="row g-4">
            <?php foreach ($socialLinks as $platform => $data): ?>
                <div class="col-12 col-sm-6 col-lg-4">
                    <a href="<?= htmlspecialchars($data['url']) ?>" 
                       target="_blank" 
                       rel="noopener noreferrer" 
                       class="text-decoration-none social-card d-block h-100">
                        <div class="sci-fi-card h-100 text-center p-4 rounded-4" style="background: rgba(10,14,23,0.85); border: 1px solid rgba(0,212,255,0.1); transition: all 0.3s ease;">
                            <div style="font-size: 2.5rem; color: <?= $data['color'] ?>; margin-bottom: 0.5rem;">
                                <i class="<?= $data['icon'] ?>"></i>
                            </div>
                            <h5 class="card-title" style="font-size: 1.1rem;"><?= $platform ?></h5>
                            <p class="text-muted small mb-0"><?= $data['bio'] ?></p>
                            <span class="text-primary small mt-2 d-inline-block">
                                <i class="fas fa-arrow-right me-1"></i> Follow
                            </span>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- GitHub Highlight -->
        <div class="mt-4 p-4 rounded-4" style="background: rgba(24, 23, 23, 0.3); border: 1px solid rgba(255,255,255,0.05);">
            <div class="row align-items-center g-3">
                <div class="col-12 col-md-8">
                    <h5 class="glow-text" style="font-family: 'Orbitron', monospace; font-size: 1.1rem;">
                        <i class="fa-brands fa-github me-2"></i> Open Source Arsenal
                    </h5>
                    <p class="text-muted small mb-0">
                        Explore the Bearded Viking's GitHub repositories — including 
                        <strong class="text-primary">AsgardArmory</strong>, 
                        <strong class="text-primary">FenrirTraverse</strong>, 
                        <strong class="text-primary">SQLMap_Tampers</strong>, and the 
                        <strong class="text-primary">NexusValhalla</strong> AI experiment repos.
                    </p>
                </div>
                <div class="col-12 col-md-4 text-center">
                    <a href="https://github.com/BeardedVikingTX" 
                       target="_blank" 
                       rel="noopener noreferrer" 
                       class="btn btn-outline-accent btn-sm px-4">
                        <i class="fa-brands fa-github me-2"></i> View Repos
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================================
     THE AI CODE-A-THON – Featured Section
     ========================================================== -->
<section id="ai-codeathon" class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <span class="badge px-4 py-2 rounded-pill mb-3" style="background: rgba(255,215,0,0.15); color: #ffd700;">
                <i class="fas fa-robot me-2"></i> Featured Experiment
            </span>
            <h2 class="section-title glow-text-gold">⚔️ The AI Code-A-Thon</h2>
            <p class="text-muted fs-5" style="max-width: 700px; margin: 0 auto;">
                Be part of the experiment! Follow the race between 5 AI LLMs 
                as they build social media platforms from scratch.
            </p>
        </div>

        <div class="row g-4 align-items-center">
            <div class="col-12 col-lg-7">
                <div class="sci-fi-card p-4 rounded-4" style="background: rgba(10,14,23,0.85); border: 1px solid rgba(0,212,255,0.1);">
                    <h4 class="card-title">
                        <i class="fas fa-flag-checkered me-2"></i> The Great AI LLM Experiment
                    </h4>
                    <p class="card-text">
                        Five frontier AI models — <strong class="text-primary">DeepSeek</strong>, 
                        <strong class="text-primary">ChatGPT</strong>, <strong class="text-primary">Gemini</strong>, 
                        <strong class="text-primary">Claude</strong>, and <strong class="text-primary">CoPilot</strong> 
                        — were challenged to build a secure, futuristic social media platform. 
                        The results are published as open-source repositories on GitHub.
                    </p>
                    <div class="d-flex flex-wrap gap-2 mt-3">
                        <a href="https://beardedviking.org/article.php?slug=the-ultimate-ai-code-a-thon-challenge_part1_introduction" 
                           target="_blank" 
                           rel="noopener noreferrer" 
                           class="btn btn-accent btn-sm">
                            <i class="fas fa-book-open me-1"></i> Read Part 1
                        </a>
                        <a href="https://beardedviking.medium.com/the-ultimate-ai-code-a-thon-challenge-part-1-introduction-5136ca955100" 
                           target="_blank" 
                           rel="noopener noreferrer" 
                           class="btn btn-outline-accent btn-sm">
                            <i class="fa-brands fa-medium me-1"></i> Read on Medium
                        </a>
                        <a href="https://github.com/BeardedVikingTX" 
                           target="_blank" 
                           rel="noopener noreferrer" 
                           class="btn btn-outline-accent btn-sm">
                            <i class="fa-brands fa-github me-1"></i> View Repos
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-5">
                <div class="sci-fi-card text-center p-4 rounded-4" style="background: rgba(10,14,23,0.85); border: 1px solid rgba(0,212,255,0.1);">
                    <div style="font-size: 3rem; margin-bottom: 0.5rem;">
                        🏆
                    </div>
                    <h5 class="glow-text" style="font-family: 'Orbitron', monospace; font-size: 1rem;">
                        Current Leader: DeepSeek
                    </h5>
                    <p class="text-muted small">
                        DeepSeek has taken the lead with superior architectural vision, 
                        security-first thinking, and a level of creative polish that 
                        captures the <em>NexusValhalla</em> spirit.
                    </p>
                    <span class="badge bg-warning text-dark px-3 py-2">
                        <i class="fas fa-crown me-1"></i> Reigning Champion
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================================
     FINAL CALL TO ACTION
     ========================================================== -->
<section id="final-cta" class="py-5" style="background: rgba(0,0,0,0.3); border-top: 1px solid rgba(0,212,255,0.1);">
    <div class="container">
        <div class="p-5 rounded-4 text-center" style="background: linear-gradient(135deg, rgba(0,212,255,0.05), rgba(123,47,252,0.05)); border: 1px solid rgba(0,212,255,0.15);">
            <h3 class="glow-text" style="font-family: 'Orbitron', monospace; font-size: 2rem;">
                <i class="fas fa-shield-halved me-2"></i>
                Ready to Secure Your Future?
            </h3>
            <p class="text-muted lh-lg fs-5" style="max-width: 600px; margin: 0 auto;">
                Whether you need a vulnerability assessment, penetration testing, 
                security training, or just want to connect — the Bearded Viking is ready.
            </p>
            <div class="mt-4 d-flex flex-wrap gap-3 justify-content-center">
                <a href="#contact-form" class="btn btn-accent btn-lg px-5">
                    <i class="fas fa-feather-alt me-2"></i> Send a Raven
                </a>
                <a href="mailto:info@beardedviking.org" class="btn btn-outline-accent btn-lg px-5">
                    <i class="fas fa-envelope me-2"></i> Direct Email
                </a>
                <a href="https://beardedviking.org" target="_blank" class="btn btn-outline-gold btn-lg px-5">
                    <i class="fas fa-globe me-2"></i> Visit the Forge
                </a>
            </div>
            <p class="text-muted small mt-3">
                <i class="fas fa-lock me-1"></i> PGP: Available upon request · 
                <i class="fas fa-shield-halved me-1"></i> Confidentiality Guaranteed
            </p>
        </div>
    </div>
</section>

<?php
// Load the footer
require_once __DIR__ . '/includes/footer.php';
?>