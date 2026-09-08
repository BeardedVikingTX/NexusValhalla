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
require_once __DIR__ . '/includes/header.php';

// Include the database connector
require_once __DIR__ . '/includes/db.php';

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
// DATABASE FUNCTIONS (production-ready)
// ============================================================

/**
 * Check if a voter email already exists in the database
 */
function checkVoterExists($email) {
    $db = Database::getInstance();
    $result = $db->fetchOne(
        'SELECT id FROM votes WHERE email = ?',
        [$email]
    );
    return ($result !== false);
}

/**
 * Save a vote to the database
 */
function saveVote($email, $ai, $ip) {
    $db = Database::getInstance();
    $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
    $sql = 'INSERT INTO votes (email, ai_selected, ip_address, user_agent) VALUES (?, ?, ?, ?)';
    try {
        $id = $db->insert($sql, [$email, $ai, $ip, $userAgent]);
        return $id;
    } catch (PDOException $e) {
        // Log the error (duplicate entry, etc.)
        error_log('Vote save failed: ' . $e->getMessage());
        return false;
    }
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
             . "NexusValhalla\n"
             . "https://nexusvalhalla.beardedviking.org";
    $headers = "From: info@beardedviking.org\r\n"
             . "Reply-To: info@beardedviking.org\r\n"
             . "X-Mailer: PHP/" . phpversion();
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
             . "Total votes can be counted using: SELECT COUNT(*) FROM votes;";
    $headers = "From: votes@beardedviking.org\r\n"
             . "Reply-To: votes@beardedviking.org\r\n"
             . "X-Mailer: PHP/" . phpversion();
    return mail('info@beardedviking.org', $subject, $message, $headers);
}

// ============================================================
// FETCH REAL VOTE COUNTS FROM DATABASE
// ============================================================
$db = Database::getInstance();
$results = $db->fetchAll('SELECT ai_selected, COUNT(*) as count FROM votes GROUP BY ai_selected');
$voteCounts = [];
$totalVotes = 0;
foreach ($results as $row) {
    $voteCounts[$row['ai_selected']] = (int)$row['count'];
    $totalVotes += $row['count'];
}
// Ensure all five AIs appear even with zero votes
$allAIs = ['DeepSeek', 'ChatGPT', 'Gemini', 'Claude', 'CoPilot'];
foreach ($allAIs as $ai) {
    if (!isset($voteCounts[$ai])) {
        $voteCounts[$ai] = 0;
    }
}
// Sort for display (optional)
ksort($voteCounts);
?>

<!-- ==========================================================
     HERO SECTION
     ========================================================== -->
<section id="about-hero" class="py-5 py-md-6 text-center position-relative overflow-hidden">
    <div class="container py-4 py-md-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-8">
                <div class="mb-4">
                    <span class="badge px-4 py-2 rounded-pill" style="background: rgba(123, 47, 252, 0.2); border: 1px solid rgba(123, 47, 252, 0.3);">
                        <i class="fas fa-helmet-battle me-2"></i> The Saga Begins
                    </span>
                </div>
                <h1 class="display-3 display-md-2 fw-bold">
                    <span class="glow-text">From Hacktivist to</span><br>
                    <span class="glow-text-gold">Cybersecurity Professional</span>
                </h1>
                <p class="lead text mt-4 fs-5 lh-lg" style="max-width: 700px; margin: 0 auto;">
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
        <div class="position-absolute float-image float-image-delay-1" style="opacity: 0.06; font-size: 7rem; top: 10%; left: 5%;">
            <i class="fas fa-shield-halved"></i>
        </div>
        <div class="position-absolute float-image float-image-delay-3" style="opacity: 0.05; font-size: 5rem; bottom: 10%; right: 5%;">
            <i class="fas fa-skull"></i>
        </div>
        <div class="position-absolute float-image float-image-delay-2" style="opacity: 0.04; font-size: 4rem; top: 50%; right: 2%;">
            <i class="fas fa-terminal"></i>
        </div>
    </div>
</section>

<!-- ==========================================================
     BIOGRAPHY
     ========================================================== -->
<section id="biography" class="py-5">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-12 col-lg-6">
                <h2 class="section-title glow-text">The Bearded Viking</h2>
                <p class="text lh-lg" style="font-size: 1.05rem;">
                    The Bearded Viking is a former hacktivist who operated under the banners of 
                    <strong class="text-primary">Anonymous</strong>, <strong class="text-primary">LizardSquad</strong>, 
                    and <strong class="text-primary">LulzSec</strong>. What began as teenage curiosity in 
                    underground IRC channels evolved into a deep understanding of security 
                    vulnerabilities, system exploitation, and digital forensics.
                </p>
                <p class="text lh-lg" style="font-size: 1.05rem;">
                    Today, the Bearded Viking is a legitimate cybersecurity professional holding a 
                    <strong class="glow-text">Ph.D. in Computer Science</strong> (Ashley University), 
                    <strong class="glow-text">OSCP</strong> (Offensive Security), and 
                    <strong class="glow-text">CEH</strong> (EC-Council). These credentials are 
                    backed by years of real-world experience in identifying vulnerabilities, conducting 
                    penetration tests, and securing critical infrastructure.
                </p>
                <p class="text lh-lg" style="font-size: 1.05rem;">
                    Family-driven and purpose-built, the Bearded Viking balances professional excellence 
                    with being a dedicated parent, turning scars into armor and vulnerabilities into 
                    strengths.
                </p>
                <div class="mt-4 d-flex flex-wrap gap-3">
                    <span class="badge px-3 py-2" style="background: rgba(0,212,255,0.15);"><i class="fas fa-graduation-cap me-1"></i> Ph.D. C.S.</span>
                    <span class="badge px-3 py-2" style="background: rgba(255,255,255,0.05);"><i class="fas fa-certificate me-1"></i> OSCP</span>
                    <span class="badge px-3 py-2" style="background: rgba(255,255,255,0.05);"><i class="fas fa-certificate me-1"></i> CEH</span>
                    <span class="badge px-3 py-2" style="background: rgba(123,47,252,0.2);"><i class="fas fa-shield-halved me-1"></i> White Hat</span>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="sci-fi-card text-center p-4 rounded-4" style="background: rgba(10,14,23,0.85); border: 1px solid rgba(0,212,255,0.15);">
                    <div style="font-size: 6rem; animation: float 4s ease-in-out infinite;">
                        🛡️
                    </div>
                    <h4 class="glow-text" style="font-family: 'Orbitron', monospace;">"Forged in Fire"</h4>
                    <p class="text">
                        <em>Securing the future, one vulnerability at a time.</em>
                    </p>
                    <hr style="border-color: rgba(0,212,255,0.1);">
                    <div class="row g-2 mt-3">
                        <div class="col-4">
                            <div class="text small">Experience</div>
                            <div class="fw-bold text-primary">25+ Years</div>
                        </div>
                        <div class="col-4">
                            <div class="text small">Bugs Found</div>
                            <div class="fw-bold text-primary">50+</div>
                        </div>
                        <div class="col-4">
                            <div class="text small">Countries</div>
                            <div class="fw-bold text-primary">30+</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================================
     TIMELINE
     ========================================================== -->
<section id="timeline" class="py-5" style="background: rgba(0,0,0,0.2);">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title glow-text">⚡ The Hacker Chronicle</h2>
            <p class="text">From hacktivist to security professional — the journey continues.</p>
        </div>

        <div class="row g-4">
            <div class="col-12 col-md-6 col-lg-4">
                <div class="sci-fi-card h-100 animate-on-scroll p-4 rounded-4" style="background: rgba(10,14,23,0.85); border: 1px solid rgba(0,212,255,0.1);">
                    <div class="d-flex align-items-center mb-3">
                        <span class="badge me-2" style="background: #00d4ff; font-size: 1rem;">1998</span>
                        <h5 class="card-title mb-0">The Beginning</h5>
                    </div>
                    <p class="card-text">
                        First computer at age 10. Discovered IRC and the underground hacking 
                        community through 4Chan and Astalavista.
                    </p>
                    <div class="text small"><i class="fas fa-desktop me-1"></i> Origins</div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <div class="sci-fi-card h-100 animate-on-scroll p-4 rounded-4" style="background: rgba(10,14,23,0.85); border: 1px solid rgba(0,212,255,0.1);">
                    <div class="d-flex align-items-center mb-3">
                        <span class="badge me-2" style="background: #ffd700; color: #000; font-size: 1rem;">2005-2012</span>
                        <h5 class="card-title mb-0">The Hacktivist Years</h5>
                    </div>
                    <p class="card-text">
                        Operated under Anonymous, LizardSquad, and LulzSec. Participated in 
                        operations against government and corporate targets.
                    </p>
                    <div class="text small"><i class="fas fa-mask me-1"></i> Hacktivism</div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <div class="sci-fi-card h-100 animate-on-scroll p-4 rounded-4" style="background: rgba(10,14,23,0.85); border: 1px solid rgba(0,212,255,0.1);">
                    <div class="d-flex align-items-center mb-3">
                        <span class="badge me-2" style="background: #7b2ffc; font-size: 1rem;">2013-2018</span>
                        <h5 class="card-title mb-0">Academic Pursuit</h5>
                    </div>
                    <p class="card-text">
                        Earned Ph.D. in Computer Science (Ashley University), focused on network 
                        security and cryptographic protocols.
                    </p>
                    <div class="text small"><i class="fas fa-graduation-cap me-1"></i> Academia</div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <div class="sci-fi-card h-100 animate-on-scroll p-4 rounded-4" style="background: rgba(10,14,23,0.85); border: 1px solid rgba(0,212,255,0.1);">
                    <div class="d-flex align-items-center mb-3">
                        <span class="badge me-2" style="background: #00c853; font-size: 1rem;">2019-2022</span>
                        <h5 class="card-title mb-0">Professional Certification</h5>
                    </div>
                    <p class="card-text">
                        Earned OSCP (Offensive Security) and CEH (EC-Council) certifications. 
                        Transitioned to white-hat hacking.
                    </p>
                    <div class="text small"><i class="fas fa-certificate me-1"></i> Certification</div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <div class="sci-fi-card h-100 animate-on-scroll p-4 rounded-4" style="background: rgba(10,14,23,0.85); border: 1px solid rgba(0,212,255,0.1);">
                    <div class="d-flex align-items-center mb-3">
                        <span class="badge me-2" style="background: #7b2ffc; font-size: 1rem;">2023-Present</span>
                        <h5 class="card-title mb-0">The Security Forge</h5>
                    </div>
                    <p class="card-text">
                        Launched Bearded Viking Security Forge — combining technical expertise, 
                        writing, and public education to help secure the digital world.
                    </p>
                    <div class="text small"><i class="fas fa-hammer me-1"></i> Current Ops</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================================
     THE AI LLM EXPERIMENT
     ========================================================== -->
<section id="ai-experiment" class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <span class="badge px-4 py-2 rounded-pill mb-3" style="background: rgba(0,212,255,0.15);">
                <i class="fas fa-robot me-2"></i> The Great Experiment
            </span>
            <h2 class="section-title glow-text">🤖 The AI LLM Race</h2>
            <p class="text fs-5" style="max-width: 700px; margin: 0 auto;">
                Five frontier AI models were given the same brief: build a secure, 
                futuristic social media platform. This is the story of that experiment.
            </p>
        </div>

        <div class="row g-4">
            <div class="col-12 col-lg-6">
                <div class="sci-fi-card h-100 p-4 rounded-4" style="background: rgba(10,14,23,0.85); border: 1px solid rgba(0,212,255,0.1);">
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
                <div class="sci-fi-card h-100 p-4 rounded-4" style="background: rgba(10,14,23,0.85); border: 1px solid rgba(0,212,255,0.1);">
                    <h4 class="card-title"><i class="fas fa-flag-checkered me-2"></i> The Prize</h4>
                    <p class="card-text">
                        After <strong>6 months</strong>, the social media site with the most 
                        active users will be declared the champion and will receive:
                    </p>
                    <ul class="list-unstyled text lh-lg">
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
            <h4 class="text-center glow-text mb-4" style="font-family: 'Orbitron', monospace;">
                <i class="fas fa-users me-2"></i> The Five Competitors
            </h4>
            <div class="row g-3 justify-content-center">
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="text-center p-3 rounded-4" style="background: rgba(10,14,23,0.85); border: 1px solid rgba(255,215,0,0.3);">
                        <div style="font-size: 2.5rem;">🏆</div>
                        <div class="fw-bold text-warning" style="font-size: 0.9rem;">DeepSeek</div>
                        <span class="badge bg-warning text-dark">Winner</span>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="text-center p-3 rounded-4" style="background: rgba(10,14,23,0.85); border: 1px solid rgba(255,255,255,0.05);">
                        <div style="font-size: 2.5rem;">🤖</div>
                        <div class="fw-bold text" style="font-size: 0.9rem;">ChatGPT</div>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="text-center p-3 rounded-4" style="background: rgba(10,14,23,0.85); border: 1px solid rgba(255,255,255,0.05);">
                        <div style="font-size: 2.5rem;">🔮</div>
                        <div class="fw-bold text" style="font-size: 0.9rem;">Gemini</div>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="text-center p-3 rounded-4" style="background: rgba(10,14,23,0.85); border: 1px solid rgba(255,255,255,0.05);">
                        <div style="font-size: 2.5rem;">🧠</div>
                        <div class="fw-bold text" style="font-size: 0.9rem;">Claude</div>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="text-center p-3 rounded-4" style="background: rgba(10,14,23,0.85); border: 1px solid rgba(255,255,255,0.05);">
                        <div style="font-size: 2.5rem;">💻</div>
                        <div class="fw-bold text" style="font-size: 0.9rem;">CoPilot</div>
                    </div>
                </div>
            </div>
            <p class="text text-center mt-3 small">
                Each AI built a complete social media platform from the ground up.
                <a href="#vote" class="text-primary">Cast your vote below</a> to support your favorite.
            </p>
        </div>
    </div>
</section>

<!-- ==========================================================
     VOTING SYSTEM
     ========================================================== -->
<section id="vote" class="py-5" style="background: rgba(0,0,0,0.3);">
    <div class="container">
        <div class="text-center mb-5">
            <span class="badge px-4 py-2 rounded-pill mb-3" style="background: rgba(255,215,0,0.15); color: #ffd700;">
                <i class="fas fa-vote-yea me-2"></i> Have Your Say
            </span>
            <h2 class="section-title" style="color: #ffd700; text-shadow: 0 0 20px rgba(255,215,0,0.3);">🗳️ Cast Your Vote</h2>
            <p class="text fs-5" style="max-width: 600px; margin: 0 auto;">
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
                <div class="sci-fi-card p-4 rounded-4" style="background: rgba(10,14,23,0.85); border: 1px solid rgba(0,212,255,0.1);">
                    <h4 class="card-title"><i class="fas fa-feather-alt me-2"></i> Submit Your Vote</h4>
                    <p class="text small">One vote per email address. Your email will only be used for confirmation.</p>

                    <form method="POST" action="<?= SITE_URL ?>/?page=about#vote" class="mt-3">
                        <?= csrfField(); ?>
                        <input type="hidden" name="vote_action" value="submit">

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="voter_email" class="form-label text">Your Email Address</label>
                            <input type="email" class="form-control" id="voter_email" name="voter_email" 
                                   placeholder="your@email.com" required 
                                   style="background: rgba(255,255,255,0.05); border: 1px solid rgba(0,212,255,0.15); color: #e8e8e8;">
                        </div>

                        <!-- AI Selection -->
                        <div class="mb-3">
                            <label class="form-label text">Choose Your AI Champion</label>
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
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="selected_ai" 
                                               id="ai_<?= $value ?>" value="<?= $value ?>" required>
                                        <label class="form-check-label w-100 text-center py-2 rounded-3" 
                                               for="ai_<?= $value ?>" 
                                               style="display: block; background: rgba(255,255,255,0.03); border: 1px solid rgba(0,212,255,0.1); transition: all 0.3s ease; cursor: pointer; font-size: 0.9rem;">
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
                <div class="sci-fi-card h-100 p-4 rounded-4" style="background: rgba(10,14,23,0.85); border: 1px solid rgba(0,212,255,0.1);">
                    <h4 class="card-title"><i class="fas fa-chart-simple me-2"></i> Live Results</h4>
                    <p class="text small"><?= number_format($totalVotes) ?> total votes cast</p>

                    <?php foreach ($voteCounts as $ai => $count): ?>
                        <?php 
                        $percentage = $totalVotes > 0 ? round(($count / $totalVotes) * 100) : 0;
                        $isWinner = ($ai === 'DeepSeek' && $count > 0);
                        ?>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <span class="text small">
                                    <?= $ai ?>
                                    <?php if ($isWinner): ?> <span class="text-warning">👑</span> <?php endif; ?>
                                </span>
                                <span class="text small"><?= $count ?> votes (<?= $percentage ?>%)</span>
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
     BUG BOUNTY SHOWCASE
     ========================================================== -->
<section id="bug-bounty" class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title" style="color: #7b2ffc; text-shadow: 0 0 20px rgba(123,47,252,0.3);">🐛 Bug Bounty Showcase</h2>
            <p class="text">Recent vulnerabilities discovered and responsibly disclosed</p>
        </div>

        <div class="row g-4">
            <div class="col-12 col-md-4">
                <div class="sci-fi-card h-100 p-4 rounded-4" style="background: rgba(10,14,23,0.85); border: 1px solid rgba(0,212,255,0.1);">
                    <span class="badge bg-danger mb-2">CRITICAL</span>
                    <h5 class="card-title">IDOR: Exposed Cheaper Product</h5>
                    <p class="card-text">
                        During check-out process, changing the PID allowed a person to purchase 
                        the "Pro-Trial" for a fraction of the original cost.
                    </p>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="sci-fi-card h-100 p-4 rounded-4" style="background: rgba(10,14,23,0.85); border: 1px solid rgba(0,212,255,0.1);">
                    <span class="badge bg-danger mb-2">CRITICAL</span>
                    <h5 class="card-title">SQL Injection</h5>
                    <p class="card-text">
                        Blind SQL injection vulnerability in URL Parameter allowed for full 
                        database compromise.
                    </p>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="sci-fi-card h-100 p-4 rounded-4" style="background: rgba(10,14,23,0.85); border: 1px solid rgba(0,212,255,0.1);">
                    <span class="badge bg-danger mb-2">CRITICAL</span>
                    <h5 class="card-title">X11 Port Exposure</h5>
                    <p class="card-text">
                        Discovered an open port on 6001 that led to taking remote screenshots 
                        of the server as well as key-logging.
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
            <p class="text">Professional security services from a battle-hardened veteran</p>
        </div>

        <div class="row g-4">
            <div class="col-12 col-md-6 col-lg-3">
                <div class="sci-fi-card h-100 text-center p-4 rounded-4" style="background: rgba(10,14,23,0.85); border: 1px solid rgba(0,212,255,0.1);">
                    <div style="font-size: 3rem; color: #00d4ff;">
                        <i class="fas fa-search"></i>
                    </div>
                    <h5 class="card-title">Vulnerability Assessment</h5>
                    <p class="card-text small">
                        Comprehensive scanning and analysis of web applications, networks, 
                        and infrastructure.
                    </p>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <div class="sci-fi-card h-100 text-center p-4 rounded-4" style="background: rgba(10,14,23,0.85); border: 1px solid rgba(0,212,255,0.1);">
                    <div style="font-size: 3rem; color: #ff6b35;">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <h5 class="card-title">Penetration Testing</h5>
                    <p class="card-text small">
                        Real-world exploitation testing to identify and demonstrate security 
                        weaknesses.
                    </p>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <div class="sci-fi-card h-100 text-center p-4 rounded-4" style="background: rgba(10,14,23,0.85); border: 1px solid rgba(0,212,255,0.1);">
                    <div style="font-size: 3rem; color: #7b2ffc;">
                        <i class="fas fa-cubes"></i>
                    </div>
                    <h5 class="card-title">Security Architecture</h5>
                    <p class="card-text small">
                        Design and implementation of robust security frameworks for enterprise 
                        environments.
                    </p>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <div class="sci-fi-card h-100 text-center p-4 rounded-4" style="background: rgba(10,14,23,0.85); border: 1px solid rgba(0,212,255,0.1);">
                    <div style="font-size: 3rem; color: #ffd700;">
                        <i class="fas fa-chalkboard-user"></i>
                    </div>
                    <h5 class="card-title">Training & Mentorship</h5>
                    <p class="card-text small">
                        One-on-one coaching and team training for security awareness and 
                        skill development.
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
        <div class="p-5 rounded-4 text-center" style="background: linear-gradient(135deg, rgba(0,212,255,0.05), rgba(123,47,252,0.05)); border: 1px solid rgba(0,212,255,0.15);">
            <h3 class="glow-text-gold" style="font-family: 'Orbitron', monospace; font-size: 2rem;">
                Ready to Secure Your Future?
            </h3>
            <p class="text lh-lg fs-5" style="max-width: 600px; margin: 0 auto;">
                Whether you need a vulnerability assessment, penetration testing, or 
                security training — the Bearded Viking is ready to deploy.
            </p>
            <div class="mt-4 d-flex flex-wrap gap-3 justify-content-center">
                <a href="mailto:info@beardedviking.org" class="btn btn-accent btn-lg px-5">
                    <i class="fas fa-envelope me-2"></i> Contact
                </a>
                <a href="https://beardedviking.org" target="_blank" class="btn btn-outline-accent btn-lg px-5">
                    <i class="fas fa-globe me-2"></i> Visit the Forge
                </a>
                <a href="https://github.com/BeardedVikingTX" target="_blank" class="btn btn-outline-gold btn-lg px-5">
                    <i class="fab fa-github me-2"></i> GitHub
                </a>
            </div>
            <p class="text small mt-3">
                <i class="fas fa-lock me-1"></i> PGP: 0xBEARD3D · Confidentiality Guaranteed
            </p>
        </div>
    </div>
</section>

<?php
// Load the footer
require_once __DIR__ . '/includes/footer.php';
?>