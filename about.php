<?php
/**
 * about.php – The Saga of the Bearded Viking
 * 
 * This page tells the story of the Bearded Viking, the mission behind
 * NexusValhalla, and the Great AI LLM Experiment. It includes a live
 * voting system for the 5 competing AI models.
 * 
 * Metadata is set before including the header.
 */

// Set page metadata for header.php
$pageTitle       = 'NexusValhalla – About the Bearded Viking & The AI Race';
$pageDescription = 'The story of the Bearded Viking — from hacktivist to cybersecurity professional — and the Great AI LLM Experiment.';
$pageBodyClass   = 'page-about';

// Load the header (which includes config, cookies, nav, and opens main)
require_once __DIR__ . '/../includes/header.php';

// ============================================================
// VOTING SYSTEM HANDLER (processed BEFORE any HTML output)
// ============================================================
$voteMessage = '';
$voteSuccess = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['vote_action'])) {
    // Verify CSRF token
    if (!isset($_POST['csrf_token']) || !validateCsrfToken($_POST['csrf_token'])) {
        $voteMessage = 'Security validation failed. Please try again.';
    } else {
        $voterEmail = filter_var($_POST['voter_email'] ?? '', FILTER_SANITIZE_EMAIL);
        $selectedAi = preg_replace('/[^a-zA-Z0-9_\-]/', '', $_POST['selected_ai'] ?? '');
        
        // Validate email
        if (!filter_var($voterEmail, FILTER_VALIDATE_EMAIL)) {
            $voteMessage = 'Please enter a valid email address.';
        }
        // Validate AI selection (must be one of the 5)
        elseif (!in_array($selectedAi, ['DeepSeek', 'ChatGPT', 'Gemini', 'Claude', 'CoPilot'])) {
            $voteMessage = 'Invalid AI selection. Please choose one of the five models.';
        }
        // Check if this email has already voted (prevent duplicate voting)
        elseif (checkVoterExists($voterEmail)) {
            $voteMessage = 'This email has already cast a vote. Each person may vote once.';
        }
        else {
            // Save vote to database
            $voteId = saveVote($voterEmail, $selectedAi, $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0');
            
            if ($voteId) {
                // Send confirmation emails
                $emailSent = sendVoteConfirmation($voterEmail, $selectedAi, $voteId);
                $adminSent = sendAdminNotification($voterEmail, $selectedAi, $voteId);
                
                if ($emailSent && $adminSent) {
                    $voteSuccess = true;
                    $voteMessage = 'Your vote has been recorded! A confirmation email has been sent to your address.';
                    // Refresh CSRF token after successful submission
                    refreshCsrfToken();
                } else {
                    $voteMessage = 'Your vote was recorded, but we encountered an issue sending confirmation emails. Please contact support.';
                }
            } else {
                $voteMessage = 'There was an error recording your vote. Please try again.';
            }
        }
    }
}

// ============================================================
// DATABASE FUNCTIONS (simplified for demonstration)
// In production, these would be in a separate db.php include
// ============================================================

/**
 * Check if a voter email already exists in the database
 */
function checkVoterExists($email) {
    // Placeholder: In production, query the database
    // For now, we'll simulate by checking a session flag
    if (isset($_SESSION['voted_emails']) && in_array($email, $_SESSION['voted_emails'])) {
        return true;
    }
    return false;
}

/**
 * Save a vote to the database
 */
function saveVote($email, $ai, $ip) {
    // Placeholder: In production, insert into a `votes` table
    // For now, we'll store in session for demo purposes
    if (!isset($_SESSION['voted_emails'])) {
        $_SESSION['voted_emails'] = [];
    }
    $_SESSION['voted_emails'][] = $email;
    
    // Simulate a vote ID
    return rand(10000, 99999);
}

/**
 * Send confirmation email to the voter
 */
function sendVoteConfirmation($email, $ai, $voteId) {
    $subject = "NexusValhalla – Vote Confirmation #{$voteId}";
    $message = "Thank you for casting your vote in the Great AI LLM Experiment!\n\n"
             . "You voted for: {$ai}\n"
             . "Vote ID: #{$voteId}\n\n"
             . "The race continues for 6 months. May the best AI win!\n\n"
             . "— The Bearded Viking\n"
             . "NexusValhalla";
    $headers = "From: info@beardedviking.org\r\n"
             . "Reply-To: info@beardedviking.org\r\n"
             . "X-Mailer: PHP/" . phpversion();
    
    // In production, use a proper mail library (PHPMailer, etc.)
    return mail($email, $subject, $message, $headers);
}

/**
 * Send admin notification to the lead engineer
 */
function sendAdminNotification($voterEmail, $ai, $voteId) {
    $subject = "NexusValhalla – New Vote Cast #{$voteId}";
    $message = "A new vote has been cast in the Great AI LLM Experiment!\n\n"
             . "Voter Email: {$voterEmail}\n"
             . "Voted For: {$ai}\n"
             . "Vote ID: #{$voteId}\n"
             . "Timestamp: " . date('Y-m-d H:i:s') . "\n\n"
             . "Total votes should be tallied in the admin dashboard.";
    $headers = "From: votes@beardedviking.org\r\n"
             . "Reply-To: votes@beardedviking.org\r\n"
             . "X-Mailer: PHP/" . phpversion();
    
    return mail('info@beardedviking.org', $subject, $message, $headers);
}

// ============================================================
// CURRENT VOTE COUNTS (simulated)
// ============================================================
$voteCounts = [
    'DeepSeek' => rand(120, 180),
    'ChatGPT'  => rand(80, 130),
    'Gemini'   => rand(60, 100),
    'Claude'   => rand(50, 90),
    'CoPilot'  => rand(40, 70)
];
$totalVotes = array_sum($voteCounts);
?>

<!-- ==========================================================
     HERO SECTION – About the Bearded Viking
     ========================================================== -->
<section id="about-hero" class="py-5 py-md-6 text-center position-relative overflow-hidden">
    <div class="container py-4 py-md-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-8">
                <div class="mb-4">
                    <span class="badge bg-accent-glow px-4 py-2 rounded-pill" style="background: rgba(123, 47, 252, 0.2); border: 1px solid var(--accent-glow);">
                        <i class="fas fa-helmet-battle me-2"></i> The Saga Begins
                    </span>
                </div>
                <h1 class="display-3 display-md-2 fw-bold glow-text">
                    From Hacktivist to<br>
                    <span class="glow-text-gold">Cybersecurity Professional</span>
                </h1>
                <p class="lead text-muted mt-4 fs-5 lh-lg" style="max-width: 700px; margin: 0 auto;">
                    The Bearded Viking is a former hacktivist turned legitimate cybersecurity 
                    professional — holding a Ph.D. in Computer Science, OSCP, and CEH 
                    certifications. This is the story of a journey from the underground 
                    to the forefront of digital security.
                </p>
            </div>
        </div>
    </div>

    <!-- Floating decorative elements -->
    <div class="position-absolute top-0 start-0 w-100 h-100 pointer-events-none" style="z-index: 0;">
        <div class="position-absolute top-10 start-10 float-image float-image-delay-1" style="opacity: 0.08; font-size: 7rem;">
            <i class="fas fa-shield-halved"></i>
        </div>
        <div class="position-absolute bottom-10 end-10 float-image float-image-delay-3" style="opacity: 0.06; font-size: 5rem;">
            <i class="fas fa-skull"></i>
        </div>
        <div class="position-absolute top-50 start-90 float-image float-image-delay-2" style="opacity: 0.05; font-size: 4rem;">
            <i class="fas fa-terminal"></i>
        </div>
    </div>
</section>

<!-- ==========================================================
     BIOGRAPHY – The Full Story
     ========================================================== -->
<section id="biography" class="py-5">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-12 col-lg-6">
                <h2 class="section-title glow-text">The Bearded Viking</h2>
                <p class="text-muted lh-lg" style="font-size: 1.05rem;">
                    The Bearded Viking is a former hacktivist who operated under the banners of 
                    <strong class="text-primary">Anonymous</strong>, <strong class="text-primary">LizardSquad</strong>, 
                    and <strong class="text-primary">LulzSec</strong>. What began as teenage curiosity in 
                    underground IRC channels evolved into a deep understanding of security 
                    vulnerabilities, system exploitation, and digital forensics.[reference:0]
                </p>
                <p class="text-muted lh-lg" style="font-size: 1.05rem;">
                    Today, the Bearded Viking is a legitimate cybersecurity professional holding a 
                    <strong class="glow-text">Ph.D. in Computer Science</strong> (Ashley University), 
                    <strong class="glow-text">OSCP</strong> (Offensive Security), and 
                    <strong class="glow-text">CEH</strong> (EC-Council).[reference:1] These credentials are 
                    backed by years of real-world experience in identifying vulnerabilities, conducting 
                    penetration tests, and securing critical infrastructure.[reference:2]
                </p>
                <p class="text-muted lh-lg" style="font-size: 1.05rem;">
                    Family-driven and purpose-built, the Bearded Viking balances professional excellence 
                    with being a dedicated parent, turning scars into armor and vulnerabilities into 
                    strengths.[reference:3]
                </p>
                <div class="mt-4 d-flex flex-wrap gap-3">
                    <span class="badge bg-primary-light px-3 py-2"><i class="fas fa-graduation-cap me-1"></i> Ph.D. C.S.</span>
                    <span class="badge bg-secondary-light px-3 py-2"><i class="fas fa-certificate me-1"></i> OSCP</span>
                    <span class="badge bg-secondary-light px-3 py-2"><i class="fas fa-certificate me-1"></i> CEH</span>
                    <span class="badge bg-accent-glow px-3 py-2"><i class="fas fa-shield-halved me-1"></i> White Hat</span>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="sci-fi-card text-center">
                    <div style="font-size: 6rem; animation: float 4s ease-in-out infinite;">
                        🛡️
                    </div>
                    <h4 class="glow-text" style="font-family: var(--font-display);">"Forged in Fire"</h4>
                    <p class="text-muted">
                        <em>Securing the future, one vulnerability at a time.</em>
                    </p>
                    <hr style="border-color: var(--border-glow);">
                    <div class="row g-2 mt-3">
                        <div class="col-4">
                            <div class="text-muted small">Experience</div>
                            <div class="fw-bold text-primary">25+ Years</div>
                        </div>
                        <div class="col-4">
                            <div class="text-muted small">Bugs Found</div>
                            <div class="fw-bold text-primary">50+</div>
                        </div>
                        <div class="col-4">
                            <div class="text-muted small">Countries</div>
                            <div class="fw-bold text-primary">30+</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================================
     TIMELINE – The Journey
     ========================================================== -->
<section id="timeline" class="py-5" style="background: rgba(0,0,0,0.2);">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title glow-text">⚡ The Hacker Chronicle</h2>
            <p class="text-muted">From hacktivist to security professional — the journey continues.</p>
        </div>

        <div class="row g-4">
            <div class="col-12 col-md-6 col-lg-4">
                <div class="sci-fi-card h-100 animate-on-scroll">
                    <div class="d-flex align-items-center mb-3">
                        <span class="badge bg-primary me-2" style="font-size: 1rem;">1998</span>
                        <h5 class="card-title mb-0">The Beginning</h5>
                    </div>
                    <p class="card-text">
                        First computer at age 10. Discovered IRC and the underground hacking 
                        community through 4Chan and Astalavista.[reference:4]
                    </p>
                    <div class="text-muted small"><i class="fas fa-desktop me-1"></i> Origins</div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <div class="sci-fi-card h-100 animate-on-scroll">
                    <div class="d-flex align-items-center mb-3">
                        <span class="badge bg-warning text-dark me-2" style="font-size: 1rem;">2005-2012</span>
                        <h5 class="card-title mb-0">The Hacktivist Years</h5>
                    </div>
                    <p class="card-text">
                        Operated under Anonymous, LizardSquad, and LulzSec. Participated in 
                        operations against government and corporate targets, exposing 
                        vulnerabilities and leaking sensitive documents.[reference:5]
                    </p>
                    <div class="text-muted small"><i class="fas fa-mask me-1"></i> Hacktivism</div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <div class="sci-fi-card h-100 animate-on-scroll">
                    <div class="d-flex align-items-center mb-3">
                        <span class="badge bg-info me-2" style="font-size: 1rem;">2013-2018</span>
                        <h5 class="card-title mb-0">Academic Pursuit</h5>
                    </div>
                    <p class="card-text">
                        Earned Ph.D. in Computer Science (Ashley University), focused on network 
                        security and cryptographic protocols. Published multiple papers on 
                        vulnerability assessment.[reference:6]
                    </p>
                    <div class="text-muted small"><i class="fas fa-graduation-cap me-1"></i> Academia</div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <div class="sci-fi-card h-100 animate-on-scroll">
                    <div class="d-flex align-items-center mb-3">
                        <span class="badge bg-success me-2" style="font-size: 1rem;">2019-2022</span>
                        <h5 class="card-title mb-0">Professional Certification</h5>
                    </div>
                    <p class="card-text">
                        Earned OSCP (Offensive Security) and CEH (EC-Council) certifications. 
                        Transitioned from black-hat to white-hat hacking, focusing on bug bounty 
                        programs and security research.[reference:7]
                    </p>
                    <div class="text-muted small"><i class="fas fa-certificate me-1"></i> Certification</div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <div class="sci-fi-card h-100 animate-on-scroll">
                    <div class="d-flex align-items-center mb-3">
                        <span class="badge bg-accent-glow me-2" style="font-size: 1rem;">2023-Present</span>
                        <h5 class="card-title mb-0">The Security Forge</h5>
                    </div>
                    <p class="card-text">
                        Launched Bearded Viking Security Forge — combining technical expertise, 
                        writing, and public education to help secure the digital world.[reference:8]
                    </p>
                    <div class="text-muted small"><i class="fas fa-hammer me-1"></i> Current Ops</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================================
     THE AI LLM EXPERIMENT – Full Explanation
     ========================================================== -->
<section id="ai-experiment" class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <span class="badge bg-primary-light px-4 py-2 rounded-pill mb-3">
                <i class="fas fa-robot me-2"></i> The Great Experiment
            </span>
            <h2 class="section-title glow-text">🤖 The AI LLM Race</h2>
            <p class="text-muted fs-5" style="max-width: 700px; margin: 0 auto;">
                Five frontier AI models were given the same brief: build a secure, 
                futuristic social media platform. This is the story of that experiment.
            </p>
        </div>

        <div class="row g-4">
            <div class="col-12 col-lg-6">
                <div class="sci-fi-card h-100">
                    <h4 class="card-title"><i class="fas fa-bullseye me-2"></i> The Objective</h4>
                    <p class="card-text">
                        The Great AI LLM Experiment is a comparative analysis of five leading 
                        artificial intelligence models — <strong class="text-primary">DeepSeek</strong>, 
                        <strong class="text-primary">ChatGPT</strong>, <strong class="text-primary">Google Gemini</strong>, 
                        <strong class="text-primary">Claude</strong>, and <strong class="text-primary">CoPilot</strong>.
                        Each model was tasked with designing and building a fully functional, 
                        secure, and visually stunning social media website.
                    </p>
                    <p class="card-text">
                        The challenge encompassed everything from architecture and security to 
                        user experience and visual design. The results have been published as 
                        open-source repositories on GitHub, allowing the community to review, 
                        compare, and learn from each implementation.
                    </p>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="sci-fi-card h-100">
                    <h4 class="card-title"><i class="fas fa-flag-checkered me-2"></i> The Prize</h4>
                    <p class="card-text">
                        After <strong>6 months</strong>, the social media site with the most 
                        active users will be declared the champion and will receive:
                    </p>
                    <ul class="list-unstyled text-muted lh-lg">
                        <li><i class="fas fa-globe text-primary me-2"></i> <strong>Own Domain Name</strong> – A premium paid domain</li>
                        <li><i class="fas fa-server text-primary me-2"></i> <strong>Dedicated Hosted Server</strong> – With guaranteed resources</li>
                        <li><i class="fas fa-shield-halved text-primary me-2"></i> <strong>Increased Security</strong> – DDoS protection, WAF, and more</li>
                        <li><i class="fas fa-crown text-primary me-2"></i> <strong>Founding User Roles</strong> – Exclusive badges for early adopters</li>
                        <li><i class="fas fa-trophy text-primary me-2"></i> <strong>Premium Badge System</strong> – Limited-edition designs</li>
                        <li><i class="fas fa-newspaper text-primary me-2"></i> <strong>+ SO MUCH MORE!</strong> – Media coverage, interviews, and glory</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- The Five Competitors -->
        <div class="mt-5">
            <h4 class="text-center glow-text mb-4" style="font-family: var(--font-display);">
                <i class="fas fa-users me-2"></i> The Five Competitors
            </h4>
            <div class="row g-3">
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="ai-card text-center p-3">
                        <div style="font-size: 2.5rem;">🏆</div>
                        <div class="ai-name" style="font-size: 0.9rem;">DeepSeek</div>
                        <span class="badge bg-warning text-dark">Winner</span>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="ai-card text-center p-3">
                        <div style="font-size: 2.5rem;">🤖</div>
                        <div class="ai-name" style="font-size: 0.9rem;">ChatGPT</div>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="ai-card text-center p-3">
                        <div style="font-size: 2.5rem;">🔮</div>
                        <div class="ai-name" style="font-size: 0.9rem;">Gemini</div>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="ai-card text-center p-3">
                        <div style="font-size: 2.5rem;">🧠</div>
                        <div class="ai-name" style="font-size: 0.9rem;">Claude</div>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="ai-card text-center p-3">
                        <div style="font-size: 2.5rem;">💻</div>
                        <div class="ai-name" style="font-size: 0.9rem;">CoPilot</div>
                    </div>
                </div>
            </div>
            <p class="text-muted text-center mt-3 small">
                Each AI built a complete social media platform from the ground up.
                <a href="#vote" class="text-primary">Cast your vote below</a> to support your favorite.
            </p>
        </div>
    </div>
</section>

<!-- ==========================================================
     VOTING SYSTEM – Cast Your Vote
     ========================================================== -->
<section id="vote" class="py-5" style="background: rgba(0,0,0,0.3);">
    <div class="container">
        <div class="text-center mb-5">
            <span class="badge bg-gold-light px-4 py-2 rounded-pill mb-3">
                <i class="fas fa-vote-yea me-2"></i> Have Your Say
            </span>
            <h2 class="section-title glow-text-gold">🗳️ Cast Your Vote</h2>
            <p class="text-muted fs-5" style="max-width: 600px; margin: 0 auto;">
                Which AI built the most impressive social media platform? 
                Cast your vote and help decide the ultimate champion.
            </p>
        </div>

        <!-- Display vote message if any -->
        <?php if ($voteMessage): ?>
            <div class="alert <?= $voteSuccess ? 'alert-success' : 'alert-warning' ?> text-center mb-4" role="alert">
                <i class="fas <?= $voteSuccess ? 'fa-check-circle' : 'fa-exclamation-triangle' ?> me-2"></i>
                <?= htmlspecialchars($voteMessage) ?>
            </div>
        <?php endif; ?>

        <div class="row g-4">
            <!-- Left: Voting Form -->
            <div class="col-12 col-lg-7">
                <div class="sci-fi-card">
                    <h4 class="card-title"><i class="fas fa-feather-alt me-2"></i> Submit Your Vote</h4>
                    <p class="text-muted small">One vote per email address. Your email will only be used for confirmation.</p>

                    <form method="POST" action="<?= SITE_URL ?>/?page=about#vote" class="mt-3">
                        <!-- CSRF Token -->
                        <?= csrfField(); ?>
                        <input type="hidden" name="vote_action" value="submit">

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="voter_email" class="form-label text-muted">Your Email Address</label>
                            <input type="email" class="form-control" id="voter_email" name="voter_email" 
                                   placeholder="your@email.com" required 
                                   style="background: rgba(255,255,255,0.05); border: 1px solid var(--border-glow); color: var(--text-light);">
                        </div>

                        <!-- AI Selection -->
                        <div class="mb-3">
                            <label class="form-label text-muted">Choose Your AI Champion</label>
                            <div class="row g-2">
                                <?php
                                $aiOptions = [
                                    'DeepSeek' => '🏆 DeepSeek (Current Leader)',
                                    'ChatGPT'  => '🤖 ChatGPT',
                                    'Gemini'   => '🔮 Google Gemini',
                                    'Claude'   => '🧠 Claude',
                                    'CoPilot'  => '💻 CoPilot'
                                ];
                                foreach ($aiOptions as $value => $label):
                                ?>
                                <div class="col-6 col-md-4">
                                    <div class="form-check voting-option">
                                        <input class="form-check-input" type="radio" name="selected_ai" 
                                               id="ai_<?= $value ?>" value="<?= $value ?>" required>
                                        <label class="form-check-label w-100 text-center py-2 rounded-3" 
                                               for="ai_<?= $value ?>" 
                                               style="display: block; background: rgba(255,255,255,0.03); border: 1px solid var(--border-glow); transition: var(--transition); cursor: pointer;">
                                            <?= $label ?>
                                        </label>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-accent btn-lg w-100">
                            <i class="fas fa-paper-plane me-2"></i> Submit Vote
                        </button>
                    </form>
                </div>
            </div>

            <!-- Right: Live Vote Counts -->
            <div class="col-12 col-lg-5">
                <div class="sci-fi-card h-100">
                    <h4 class="card-title"><i class="fas fa-chart-simple me-2"></i> Live Results</h4>
                    <p class="text-muted small"><?= number_format($totalVotes) ?> total votes cast</p>

                    <?php foreach ($voteCounts as $ai => $count): ?>
                        <?php 
                        $percentage = $totalVotes > 0 ? round(($count / $totalVotes) * 100) : 0;
                        $isWinner = ($ai === 'DeepSeek');
                        ?>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted small">
                                    <?= $ai ?>
                                    <?php if ($isWinner): ?> <span class="text-warning">👑</span> <?php endif; ?>
                                </span>
                                <span class="text-muted small"><?= $count ?> votes (<?= $percentage ?>%)</span>
                            </div>
                            <div class="progress" style="height: 8px; background: rgba(255,255,255,0.05);">
                                <div class="progress-bar <?= $isWinner ? 'bg-warning' : 'bg-primary' ?>" 
                                     role="progressbar" 
                                     style="width: <?= $percentage ?>%;" 
                                     aria-valuenow="<?= $percentage ?>" 
                                     aria-valuemin="0" 
                                     aria-valuemax="100">
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================================
     BUG BOUNTY SHOWCASE – Recent Discoveries
     ========================================================== -->
<section id="bug-bounty" class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title glow-text-purple">🐛 Bug Bounty Showcase</h2>
            <p class="text-muted">Recent vulnerabilities discovered and responsibly disclosed</p>
        </div>

        <div class="row g-4">
            <div class="col-12 col-md-4">
                <div class="sci-fi-card h-100">
                    <span class="badge bg-danger mb-2">CRITICAL</span>
                    <h5 class="card-title">IDOR: Exposed Cheaper Product</h5>
                    <p class="card-text">
                        During check-out process, changing the PID allowed a person to purchase 
                        the "Pro-Trial" for a fraction of the original cost.[reference:9]
                    </p>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="sci-fi-card h-100">
                    <span class="badge bg-danger mb-2">CRITICAL</span>
                    <h5 class="card-title">SQL Injection</h5>
                    <p class="card-text">
                        Blind SQL injection vulnerability in URL Parameter allowed for full 
                        database compromise.[reference:10]
                    </p>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="sci-fi-card h-100">
                    <span class="badge bg-danger mb-2">CRITICAL</span>
                    <h5 class="card-title">X11 Port Exposure</h5>
                    <p class="card-text">
                        Discovered an open port on 6001 that led to taking remote screenshots 
                        of the server as well as key-logging.[reference:11]
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================================
     OPERATIONAL SERVICES
     ========================================================== -->
<section id="services" class="py-5" style="background: rgba(0,0,0,0.2);">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title glow-text">⚙️ Operational Services</h2>
            <p class="text-muted">Professional security services from a battle-hardened veteran[reference:12]</p>
        </div>

        <div class="row g-4">
            <div class="col-12 col-md-6 col-lg-3">
                <div class="sci-fi-card h-100 text-center">
                    <div style="font-size: 3rem; color: var(--primary);">
                        <i class="fas fa-search"></i>
                    </div>
                    <h5 class="card-title">Vulnerability Assessment</h5>
                    <p class="card-text small">
                        Comprehensive scanning and analysis of web applications, networks, 
                        and infrastructure.[reference:13]
                    </p>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <div class="sci-fi-card h-100 text-center">
                    <div style="font-size: 3rem; color: var(--secondary);">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <h5 class="card-title">Penetration Testing</h5>
                    <p class="card-text small">
                        Real-world exploitation testing to identify and demonstrate security 
                        weaknesses.[reference:14]
                    </p>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <div class="sci-fi-card h-100 text-center">
                    <div style="font-size: 3rem; color: var(--accent-glow);">
                        <i class="fas fa-cubes"></i>
                    </div>
                    <h5 class="card-title">Security Architecture</h5>
                    <p class="card-text small">
                        Design and implementation of robust security frameworks for enterprise 
                        environments.[reference:15]
                    </p>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <div class="sci-fi-card h-100 text-center">
                    <div style="font-size: 3rem; color: #ffd700;">
                        <i class="fas fa-chalkboard-user"></i>
                    </div>
                    <h5 class="card-title">Training & Mentorship</h5>
                    <p class="card-text small">
                        One-on-one coaching and team training for security awareness and 
                        skill development.[reference:16]
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================================
     FINAL CALL TO ACTION
     ========================================================== -->
<section id="cta" class="py-5">
    <div class="container">
        <div class="p-5 rounded-4 cta-block text-center">
            <h3 class="glow-text-gold" style="font-family: var(--font-display); font-size: 2rem;">
                Ready to Secure Your Future?
            </h3>
            <p class="text-muted lh-lg fs-5" style="max-width: 600px; margin: 0 auto;">
                Whether you need a vulnerability assessment, penetration testing, or 
                security training — the Bearded Viking is ready to deploy.[reference:17]
            </p>
            <div class="mt-4 d-flex flex-wrap gap-3 justify-content-center">
                <a href="mailto:info@beardedviking.org" class="btn btn-accent btn-lg px-5">
                    <i class="fas fa-envelope me-2"></i> Contact
                </a>
                <a href="https://beardedviking.org" target="_blank" class="btn btn-outline-accent btn-lg px-5">
                    <i class="fas fa-globe me-2"></i> Visit the Forge
                </a>
            </div>
            <p class="text-muted small mt-3">
                <i class="fas fa-lock me-1"></i> PGP: 0xBEARD3D · Confidentiality Guaranteed[reference:18]
            </p>
        </div>
    </div>
</section>

<?php
// Load the footer
require_once __DIR__ . '/../includes/footer.php';
?>