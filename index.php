<?php
/**
 * home.php – The Heart of the Realm (MAXIMIZED)
 * 
 * This is the main landing page for NexusValhalla.
 * Showcases the AI LLM race, VDP program, and the ultimate prize.
 * Optimized for maximum engagement, performance, and conversion.
 * 
 * This file is included by index.php via the router.
 */

include('includes/header.php'); 
// ============================================================
// AI MODELS DATA
// ============================================================
$ai_models = [
    'DeepSeek' => [
        'img' => '/assets/img/DeepSeek_Home1.png',
        'site' => 'https://nexusvalhalla.beardedviking.org',
        'repo' => 'https://github.com/BeardedVikingTX/NexusValhalla',
        'winner' => true,
        'score' => 98,
        'strengths' => ['Security', 'UI/UX', 'Performance', 'Documentation'],
        'color' => '#00d4ff'
    ],
    'ChatGPT' => [
        'img' => '/assets/img/ChatGPT_home1.png',
        'site' => 'https://nexora.beardedviking.org',
        'repo' => 'https://github.com/BeardedVikingTX/Nexora',
        'winner' => false,
        'score' => 87,
        'strengths' => ['Design', 'Content', 'Responsiveness'],
        'color' => '#10a37f'
    ],
    'Claude' => [
        'img' => '/assets/img/Claude_home1.png',
        'site' => 'https://ravenwarp.beardedviking.org',
        'repo' => 'https://github.com/BeardedVikingTX/RavenWarp',
        'winner' => false,
        'score' => 84,
        'strengths' => ['Code Quality', 'Architecture', 'Documentation'],
        'color' => '#d97757'
    ],
    'CoPilot' => [
        'img' => '/assets/img/CoPilot_home1.png',
        'site' => 'https://sagasphere.beardedviking.org',
        'repo' => 'https://github.com/BeardedVikingTX/SagaSphere',
        'winner' => false,
        'score' => 79,
        'strengths' => ['Speed', 'Integration', 'Boilerplate'],
        'color' => '#6c5ce7'
    ],
    'Gemini' => [
        'img' => '/assets/img/Gemini_home1.png',
        'site' => 'https://valkyrin.beardedviking.org',
        'repo' => 'https://github.com/BeardedVikingTX/Valkyrin',
        'winner' => false,
        'score' => 76,
        'strengths' => ['Encryption', 'Logging', 'Creativity'],
        'color' => '#4285f4'
    ]
];

// ============================================================
// STATS (simulated for now - replace with real data later)
// ============================================================
$total_users = rand(1234, 5678);
$total_posts = rand(9876, 23456);
$active_users = rand(234, 890);
$start_date = strtotime('2026-09-01');
$days_running = ceil((time() - $start_date) / 86400);
?>

<!-- ==========================================================
     HERO SECTION
     ========================================================== -->
<section id="hero" class="py-6 text-center position-relative overflow-hidden">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-8">
                <!-- Animated Badge -->
                <div class="mb-4">
                    <span class="badge px-4 py-2 rounded-pill" 
                          style="background: rgba(123, 47, 252, 0.2); border: 1px solid rgba(123, 47, 252, 0.3);">
                        <i class="fas fa-helmet-battle me-2"></i> 
                        <span class="typing-text" data-text="The Great AI LLM Experiment">The Great AI LLM Experiment</span>
                    </span>
                </div>

                <!-- Main Headline -->
                <h1 class="display-3 display-md-2 fw-bold">
                    <span class="glow-text">Forge Your Saga</span><br>
                    <span class="glow-text-gold">Across the Digital Realms</span>
                </h1>

                <!-- Subheadline -->
                <p class="lead text-muted mt-4 fs-4 lh-lg" style="max-width: 700px; margin: 0 auto;">
                    Five AI warriors. Five social realms. <span class="text-primary fw-bold">One ultimate champion.</span>
                    <br>
                    Welcome to <strong class="text-primary">NexusValhalla</strong> – where 
                    the spirit of the Vikings meets the frontier of artificial intelligence.
                </p>

                <!-- Stats -->
                <div class="row g-3 mt-5 justify-content-center">
                    <div class="col-4 col-md-2">
                        <div class="stat-item">
                            <span class="stat-number display-6 fw-bold text-primary" data-target="<?= $total_users ?>">0</span>
                            <span class="stat-label d-block text-muted small">Warriors</span>
                        </div>
                    </div>
                    <div class="col-4 col-md-2">
                        <div class="stat-item">
                            <span class="stat-number display-6 fw-bold text-primary" data-target="<?= $total_posts ?>">0</span>
                            <span class="stat-label d-block text-muted small">Stories</span>
                        </div>
                    </div>
                    <div class="col-4 col-md-2">
                        <div class="stat-item">
                            <span class="stat-number display-6 fw-bold text-primary" data-target="<?= $active_users ?>">0</span>
                            <span class="stat-label d-block text-muted small">Online Now</span>
                        </div>
                    </div>
                    <div class="col-4 col-md-2">
                        <div class="stat-item">
                            <span class="display-6 fw-bold text-warning"><?= $days_running ?></span>
                            <span class="stat-label d-block text-muted small">Days Running</span>
                        </div>
                    </div>
                </div>

                <!-- CTA Buttons -->
                <div class="mt-5 d-flex flex-wrap gap-3 justify-content-center">
                    <a href="#ai-race" class="btn btn-accent btn-lg px-5">
                        <i class="fas fa-robot me-2"></i> View the Race
                    </a>
                    <a href="#prizes" class="btn btn-outline-accent btn-lg px-5">
                        <i class="fas fa-trophy me-2"></i> See the Prize
                    </a>
                    <a href="https://nexusvalhalla.beardedviking.org" target="_blank" class="btn btn-outline-gold btn-lg px-5">
                        <i class="fas fa-helmet-battle me-2"></i> Join Now
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Floating Elements -->
    <div class="position-absolute top-0 start-0 w-100 h-100 pointer-events-none" style="z-index: 0;">
        <div class="position-absolute float-image float-image-delay-1" style="opacity: 0.06; font-size: 8rem; top: 10%; left: 5%;">
            <i class="fas fa-galaxy"></i>
        </div>
        <div class="position-absolute float-image float-image-delay-3" style="opacity: 0.05; font-size: 6rem; bottom: 15%; right: 5%;">
            <i class="fas fa-rocket"></i>
        </div>
        <div class="position-absolute float-image float-image-delay-2" style="opacity: 0.04; font-size: 4rem; top: 50%; right: 2%;">
            <i class="fas fa-satellite"></i>
        </div>
    </div>
</section>

<!-- ==========================================================
     THE AI RACE
     ========================================================== -->
<section id="ai-race" class="py-6">
    <div class="container">
        <div class="text-center mb-5">
            <span class="badge bg-primary-light px-4 py-2 rounded-pill mb-3">
                <i class="fas fa-robot me-2"></i> The Competition
            </span>
            <h2 class="section-title glow-text">⚔️ The AI LLM Race</h2>
            <p class="text-muted fs-5" style="max-width: 700px; margin: 0 auto;">
                Five frontier AI models were given the same brief: build a secure, 
                futuristic social media platform. Here's how they performed.
            </p>
        </div>

        <!-- Progress Bar -->
        <div class="mb-5" style="max-width: 600px; margin: 0 auto;">
            <div class="d-flex justify-content-between mb-1">
                <span class="text-muted small">Race Progress</span>
                <span class="text-muted small">6 Months</span>
            </div>
            <div class="progress" style="height: 8px; background: rgba(255,255,255,0.05);">
                <div class="progress-bar progress-bar-striped progress-bar-animated" 
                     role="progressbar" 
                     style="width: 25%; background: linear-gradient(90deg, #00d4ff, #7b2ffc);" 
                     aria-valuenow="25" 
                     aria-valuemin="0" 
                     aria-valuemax="100">
                </div>
            </div>
            <div class="d-flex justify-content-between mt-1">
                <span class="text-muted small">Month 1</span>
                <span class="text-muted small">Month 6</span>
            </div>
        </div>

        <!-- AI Cards -->
        <div class="row g-4">
            <?php foreach ($ai_models as $name => $data): ?>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="ai-card <?= $data['winner'] ? 'winner' : '' ?> animate-on-scroll">
                        <?php if ($data['winner']): ?>
                            <div class="winner-badge">
                                <i class="fas fa-crown me-1"></i> WINNER
                            </div>
                        <?php endif; ?>
                        
                        <div class="ai-image-wrapper">
                            <img src="<?= htmlspecialchars($data['img']) ?>" 
                                 alt="<?= htmlspecialchars($name) ?> Homepage" 
                                 class="img-fluid rounded-3 mb-3"
                                 loading="lazy"
                                 onerror="this.src='/assets/img/placeholder.png'">
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="ai-name">
                                <?= htmlspecialchars($name) ?>
                                <?php if ($data['winner']): ?>
                                    <span class="ms-1">👑</span>
                                <?php endif; ?>
                            </div>
                            <div class="ai-score">
                                <span class="score-number <?= $data['score'] >= 90 ? 'text-success' : ($data['score'] >= 80 ? 'text-warning' : 'text-muted') ?>">
                                    <?= $data['score'] ?>%
                                </span>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-1 mb-3">
                            <?php foreach ($data['strengths'] as $strength): ?>
                                <span class="badge bg-secondary-light text-muted small px-2 py-1">
                                    <?= htmlspecialchars($strength) ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                        
                        <a href="<?= htmlspecialchars($data['site']) ?>" 
                           target="_blank" 
                           rel="noopener noreferrer" 
                           class="ai-link d-block">
                            <i class="fas fa-globe me-1"></i> <?= htmlspecialchars(str_replace('https://', '', $data['site'])) ?>
                        </a>
                        
                        <a href="<?= htmlspecialchars($data['repo']) ?>" 
                           target="_blank" 
                           rel="noopener noreferrer" 
                           class="ai-repo d-block mt-1">
                            <i class="fab fa-github me-1"></i> View Repo
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- DeepSeek Victory Callout -->
        <div class="mt-5 p-4 p-md-5 rounded-4 victory-callout animate-on-scroll"
             style="background: linear-gradient(135deg, rgba(0,212,255,0.05), rgba(123,47,252,0.05)); border: 1px solid rgba(0,212,255,0.15);">
            <div class="row align-items-center g-4">
                <div class="col-12 col-md-8">
                    <h3 class="glow-text" style="font-family: 'Orbitron', monospace; font-size: 1.8rem;">
                        <i class="fas fa-crown me-2" style="color: #ffd700;"></i> 
                        Why DeepSeek Stands Above the Rest
                    </h3>
                    <p class="text-muted lh-lg mb-0" style="font-size: 1.05rem;">
                        While all five AIs delivered functional platforms, <strong class="text-primary">DeepSeek</strong> 
                        demonstrated <strong>superior architectural vision</strong>, security-first thinking, and a level of 
                        creative polish that truly captures the <em>NexusValhalla</em> spirit. From the 
                        encrypted session handling to the futuristic UI design, DeepSeek built not just 
                        a website, but an <strong>experience</strong> – a digital longship worthy of sailing 
                        the cosmic seas.
                    </p>
                    <div class="mt-3 d-flex flex-wrap gap-3">
                        <div class="victory-stat">
                            <span class="stat-label d-block text-muted small">Security</span>
                            <span class="stat-rating text-warning">★★★★★</span>
                        </div>
                        <div class="victory-stat">
                            <span class="stat-label d-block text-muted small">Performance</span>
                            <span class="stat-rating text-warning">★★★★★</span>
                        </div>
                        <div class="victory-stat">
                            <span class="stat-label d-block text-muted small">Innovation</span>
                            <span class="stat-rating text-warning">★★★★★</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4 text-center">
                    <div style="font-size: 5rem; animation: float 4s ease-in-out infinite;">
                        🏆
                    </div>
                    <span class="badge bg-warning text-dark px-4 py-2 rounded-pill fw-bold d-block mx-auto" 
                          style="font-family: 'Orbitron', monospace; letter-spacing: 0.1em; font-size: 0.9rem;">
                        ULTIMATE WINNER
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================================
     VDP & HACKERONE / BUG CROWD
     ========================================================== -->
<section id="vdp" class="py-6" style="background: rgba(0,0,0,0.3);">
    <div class="container">
        <div class="text-center mb-5">
            <span class="badge bg-purple-light px-4 py-2 rounded-pill mb-3">
                <i class="fas fa-shield-halved me-2"></i> Security First
            </span>
            <h2 class="section-title" style="color: #7b2ffc; text-shadow: 0 0 20px rgba(123,47,252,0.3);">🛡️ The Future of Security</h2>
            <p class="text-muted fs-5" style="max-width: 700px; margin: 0 auto;">
                Vulnerability Disclosure Programs (VDP) are the shieldwall of the digital age.
                The winning platform will be forged in the fires of ethical hacking.
            </p>
        </div>

        <div class="row g-4">
            <div class="col-12 col-md-6">
                <div class="sci-fi-card h-100 animate-on-scroll">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-wrapper me-3" style="font-size: 2rem; color: #00d4ff;">
                            <i class="fas fa-shield-halved"></i>
                        </div>
                        <h4 class="card-title mb-0">HackerOne Integration</h4>
                    </div>
                    <p class="card-text">
                        The winning platform will be submitted to <strong class="text-primary">HackerOne</strong>, 
                        the world's leading ethical hacking platform. This means real security researchers 
                        will probe every corner of the application – from the authentication flows to the 
                        encryption layers – ensuring that NexusValhalla becomes a fortress worthy of 
                        Asgard itself.
                    </p>
                    <div class="feature-tags d-flex flex-wrap gap-2 mt-3">
                        <span class="badge bg-primary-light"><i class="fas fa-check-circle text-success me-1"></i> Bug Bounty</span>
                        <span class="badge bg-secondary-light"><i class="fas fa-check-circle text-success me-1"></i> Responsible Disclosure</span>
                        <span class="badge bg-secondary-light"><i class="fas fa-check-circle text-success me-1"></i> Public VDP</span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="sci-fi-card h-100 animate-on-scroll">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-wrapper me-3" style="font-size: 2rem; color: #ff6b35;">
                            <i class="fas fa-bug"></i>
                        </div>
                        <h4 class="card-title mb-0">BugCrowd Collaboration</h4>
                    </div>
                    <p class="card-text">
                        Alongside HackerOne, the winning platform will also launch on 
                        <strong class="text-secondary">BugCrowd</strong>, creating a dual-layer 
                        security net. This ensures maximum coverage and diverse testing 
                        methodologies. The combination will make NexusValhalla one of the 
                        <strong>most thoroughly vetted social media sites in existence</strong>.
                    </p>
                    <div class="feature-tags d-flex flex-wrap gap-2 mt-3">
                        <span class="badge bg-secondary-light"><i class="fas fa-check-circle text-success me-1"></i> Crowdsourced Security</span>
                        <span class="badge bg-secondary-light"><i class="fas fa-check-circle text-success me-1"></i> Continuous Testing</span>
                        <span class="badge bg-secondary-light"><i class="fas fa-check-circle text-success me-1"></i> Global Researchers</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Security Roadmap -->
        <div class="mt-5 p-4 p-md-5 rounded-4" style="background: rgba(123, 47, 252, 0.05); border: 1px solid rgba(123, 47, 252, 0.15);">
            <h5 class="text-center mb-4" style="font-family: 'Orbitron', monospace; color: #7b2ffc; letter-spacing: 0.1em;">
                <i class="fas fa-road me-2"></i> Security Roadmap
            </h5>
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div class="text-center">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto" 
                         style="width: 40px; height: 40px; background: #00d4ff; color: #fff;">
                        <i class="fas fa-check"></i>
                    </div>
                    <span class="text-muted small d-block mt-1">Encryption</span>
                </div>
                <div class="flex-grow-1" style="height: 2px; background: linear-gradient(90deg, #00d4ff, #7b2ffc);"></div>
                <div class="text-center">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto" 
                         style="width: 40px; height: 40px; background: #7b2ffc; color: #fff;">
                        <i class="fas fa-shield"></i>
                    </div>
                    <span class="text-muted small d-block mt-1">VDP Launch</span>
                </div>
                <div class="flex-grow-1" style="height: 2px; background: rgba(255,255,255,0.1);"></div>
                <div class="text-center">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto" 
                         style="width: 40px; height: 40px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #666;">
                        <i class="fas fa-clock"></i>
                    </div>
                    <span class="text-muted small d-block mt-1">HackerOne</span>
                </div>
                <div class="flex-grow-1" style="height: 2px; background: rgba(255,255,255,0.1);"></div>
                <div class="text-center">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto" 
                         style="width: 40px; height: 40px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #666;">
                        <i class="fas fa-clock"></i>
                    </div>
                    <span class="text-muted small d-block mt-1">BugCrowd</span>
                </div>
                <div class="flex-grow-1" style="height: 2px; background: rgba(255,255,255,0.1);"></div>
                <div class="text-center">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto" 
                         style="width: 40px; height: 40px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #666;">
                        <i class="fas fa-check"></i>
                    </div>
                    <span class="text-muted small d-block mt-1">Fortress</span>
                </div>
            </div>
        </div>

        <!-- VDP Vision -->
        <div class="mt-4 p-4 rounded-4" style="background: rgba(0,212,255,0.03); border: 1px solid rgba(0,212,255,0.1);">
            <p class="text-muted lh-lg mb-0 text-center" style="font-size: 1.05rem;">
                <i class="fas fa-quote-left me-2" style="color: #7b2ffc;"></i>
                The VDP program isn't just about finding bugs – it's about building a 
                <strong class="text-primary">culture of security</strong>. By opening our 
                platform to the global ethical hacking community, we demonstrate that 
                NexusValhalla values <strong>transparency, trust, and continuous improvement</strong>.
                <i class="fas fa-quote-right ms-2" style="color: #7b2ffc;"></i>
            </p>
        </div>
    </div>
</section>

<!-- ==========================================================
     THE PRIZE
     ========================================================== -->
<section id="prizes" class="py-6">
    <div class="container">
        <div class="text-center mb-5">
            <span class="badge bg-gold-light px-4 py-2 rounded-pill mb-3">
                <i class="fas fa-trophy me-2"></i> What's at Stake
            </span>
            <h2 class="section-title" style="color: #ffd700; text-shadow: 0 0 20px rgba(255,215,0,0.3);">🏆 The Grand Prize</h2>
            <p class="text-muted fs-5" style="max-width: 700px; margin: 0 auto;">
                After 6 months, the social media site with the most active users will 
                ascend to Valhalla itself. Here's what awaits the champion.
            </p>
        </div>

        <!-- Countdown -->
        <div class="countdown-wrapper mb-5 text-center">
            <div class="countdown-title text-muted small mb-2">Time Remaining</div>
            <div class="countdown-timer d-flex justify-content-center align-items-center gap-2 gap-md-4" id="countdown-timer">
                <div class="countdown-block text-center">
                    <span class="countdown-number display-4 fw-bold text-primary" id="countdown-days">00</span>
                    <span class="countdown-label d-block text-muted small">Days</span>
                </div>
                <span class="countdown-separator display-4 text-muted">:</span>
                <div class="countdown-block text-center">
                    <span class="countdown-number display-4 fw-bold text-primary" id="countdown-hours">00</span>
                    <span class="countdown-label d-block text-muted small">Hours</span>
                </div>
                <span class="countdown-separator display-4 text-muted">:</span>
                <div class="countdown-block text-center">
                    <span class="countdown-number display-4 fw-bold text-primary" id="countdown-minutes">00</span>
                    <span class="countdown-label d-block text-muted small">Minutes</span>
                </div>
                <span class="countdown-separator display-4 text-muted">:</span>
                <div class="countdown-block text-center">
                    <span class="countdown-number display-4 fw-bold text-primary" id="countdown-seconds">00</span>
                    <span class="countdown-label d-block text-muted small">Seconds</span>
                </div>
            </div>
        </div>

        <!-- Prize Pillars -->
        <div class="row g-4">
            <div class="col-12 col-md-4">
                <div class="prize-pillar animate-on-scroll text-center p-4 rounded-4" 
                     style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05);">
                    <div class="prize-icon" style="font-size: 3rem;">🌐</div>
                    <h5 class="mt-3" style="font-family: 'Orbitron', monospace; color: #ffd700;">Own Domain Name</h5>
                    <p class="text-muted small">Premium paid domain for the winning platform</p>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="prize-pillar animate-on-scroll text-center p-4 rounded-4" 
                     style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05);">
                    <div class="prize-icon" style="font-size: 3rem;">⚡</div>
                    <h5 class="mt-3" style="font-family: 'Orbitron', monospace; color: #ffd700;">Dedicated Server</h5>
                    <p class="text-muted small">Guaranteed resources with zero latency</p>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="prize-pillar animate-on-scroll text-center p-4 rounded-4" 
                     style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05);">
                    <div class="prize-icon" style="font-size: 3rem;">🔐</div>
                    <h5 class="mt-3" style="font-family: 'Orbitron', monospace; color: #ffd700;">Advanced Security</h5>
                    <p class="text-muted small">DDoS protection, WAF, and VDP priority</p>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="prize-pillar animate-on-scroll text-center p-4 rounded-4" 
                     style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05);">
                    <div class="prize-icon" style="font-size: 3rem;">👑</div>
                    <h5 class="mt-3" style="font-family: 'Orbitron', monospace; color: #ffd700;">Founding Roles</h5>
                    <p class="text-muted small">Exclusive badges for early adopters</p>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="prize-pillar animate-on-scroll text-center p-4 rounded-4" 
                     style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05);">
                    <div class="prize-icon" style="font-size: 3rem;">🏅</div>
                    <h5 class="mt-3" style="font-family: 'Orbitron', monospace; color: #ffd700;">Premium Badges</h5>
                    <p class="text-muted small">Limited-edition designs for loyal users</p>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="prize-pillar animate-on-scroll text-center p-4 rounded-4" 
                     style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05);">
                    <div class="prize-icon" style="font-size: 3rem;">📰</div>
                    <h5 class="mt-3" style="font-family: 'Orbitron', monospace; color: #ffd700;">+ SO MUCH MORE!</h5>
                    <p class="text-muted small">Media coverage, interviews, and glory</p>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="mt-5 p-5 rounded-4 cta-block animate-on-scroll text-center"
             style="background: linear-gradient(135deg, rgba(255,215,0,0.05), rgba(255,107,53,0.05)); border: 2px solid rgba(255,215,0,0.15);">
            <div class="row align-items-center g-4">
                <div class="col-12 col-lg-8">
                    <h3 class="text-warning" style="font-family: 'Orbitron', monospace; font-size: 2rem;">
                        The Race Is On!
                    </h3>
                    <p class="text-muted lh-lg fs-5 mb-0">
                        Five AI warriors have built their realms. Now, the <strong>users</strong> 
                        decide the victor. The platform with the most active community in 
                        <strong>6 months</strong> will be crowned the <em>Ultimate NexusValhalla</em>.
                        <br>
                        <span class="text-primary" style="font-size: 1.2rem;">
                            <i class="fas fa-feather-alt me-2"></i>
                            Your saga begins now. Which realm will you call home?
                        </span>
                    </p>
                </div>
                <div class="col-12 col-lg-4 text-center">
                    <a href="https://nexusvalhalla.beardedviking.org" 
                       class="btn btn-accent btn-lg px-5 w-100" 
                       target="_blank">
                        <i class="fas fa-helmet-battle me-2"></i> Join the Saga
                    </a>
                    <a href="https://github.com/BeardedVikingTX/NexusValhalla" 
                       class="btn btn-outline-accent btn-lg px-5 w-100 mt-2" 
                       target="_blank">
                        <i class="fab fa-github me-2"></i> View the Code
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================================
     FINAL SAGA
     ========================================================== -->
<section id="vision" class="py-6" style="background: rgba(0,0,0,0.2); border-top: 1px solid rgba(0,212,255,0.1); border-bottom: 1px solid rgba(0,212,255,0.1);">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-12 col-lg-6 order-lg-2">
                <div class="text-center">
                    <div style="font-size: 6rem; animation: float 6s ease-in-out infinite;">
                        🛡️
                    </div>
                    <h3 class="glow-text mt-3" style="font-family: 'Orbitron', monospace;">
                        From the Desk of the Bearded Viking
                    </h3>
                    
                    <div class="social-proof mt-4 p-4 rounded-4" style="background: rgba(0,212,255,0.03); border: 1px solid rgba(0,212,255,0.06);">
                        <div class="testimonial">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <p class="mt-2 text-muted small" style="font-style: italic;">
                                "NexusValhalla is the most ambitious social media project I've seen. 
                                The fusion of Sci-Fi and Viking culture is genius."
                            </p>
                            <span class="text-muted small">— Community Member</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6 order-lg-1">
                <blockquote class="fs-5 lh-lg" style="border-left: 4px solid #00d4ff; padding-left: 2rem; color: #8899aa;">
                    <i class="fas fa-quote-left me-2" style="color: #00d4ff;"></i>
                    This experiment isn't just about building websites – it's about 
                    <strong class="text-primary">pushing the boundaries</strong> of what AI 
                    can achieve. We're writing the <em>saga of the digital age</em>, one 
                    commit at a time. The winner of this race won't just get a domain 
                    and a server – they'll get a <strong>legacy</strong>. A place in the 
                    halls of Valhalla, where warriors and legends are made.
                    <br><br>
                    <span class="text-warning" style="font-size: 1.1rem;">
                        Skål, and may the best AI win. 🍻
                    </span>
                    <br>
                    <span class="text-muted" style="font-size: 0.9rem;">
                        — Bearded Viking, Keeper of the Nexus
                    </span>
                </blockquote>

                <div class="mt-4">
                    <span class="text-muted small d-block mb-2">Share the Saga:</span>
                    <div class="d-flex gap-2">
                        <a href="#" class="btn btn-outline-primary btn-sm share-btn" data-platform="twitter">
                            <i class="fab fa-x-twitter"></i>
                        </a>
                        <a href="#" class="btn btn-outline-primary btn-sm share-btn" data-platform="linkedin">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#" class="btn btn-outline-primary btn-sm share-btn" data-platform="reddit">
                            <i class="fab fa-reddit-alien"></i>
                        </a>
                        <a href="#" class="btn btn-outline-primary btn-sm share-btn" data-platform="facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include('includes/footer.php'); ?>
<!-- ==========================================================
     INTERACTIVE SCRIPTS
     ========================================================== -->
<script>
(function() {
    'use strict';

    // ==========================================================
    // 1. ANIMATE STATS ON SCROLL
    // ==========================================================
    function animateStats() {
        const statNumbers = document.querySelectorAll('.stat-number');
        statNumbers.forEach(stat => {
            const target = parseInt(stat.getAttribute('data-target'));
            if (target > 0 && !stat.classList.contains('animated')) {
                stat.classList.add('animated');
                let current = 0;
                const increment = Math.ceil(target / 60);
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        current = target;
                        clearInterval(timer);
                    }
                    stat.textContent = current.toLocaleString();
                }, 30);
            }
        });
    }

    // ==========================================================
    // 2. COUNTDOWN TIMER
    // ==========================================================
    function initCountdown() {
        const targetDate = new Date();
        targetDate.setMonth(targetDate.getMonth() + 6);

        function updateCountdown() {
            const now = new Date();
            const diff = targetDate - now;

            if (diff <= 0) {
                document.getElementById('countdown-timer').innerHTML = 
                    '<span style="font-family: Orbitron, monospace; color: #ffd700; font-size: 2rem;">THE RACE IS COMPLETE! 🏆</span>';
                return;
            }

            const days = Math.floor(diff / (1000 * 60 * 60 * 24));
            const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);

            document.getElementById('countdown-days').textContent = String(days).padStart(2, '0');
            document.getElementById('countdown-hours').textContent = String(hours).padStart(2, '0');
            document.getElementById('countdown-minutes').textContent = String(minutes).padStart(2, '0');
            document.getElementById('countdown-seconds').textContent = String(seconds).padStart(2, '0');
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);
    }

    // ==========================================================
    // 3. SCROLL ANIMATIONS
    // ==========================================================
    function initScrollAnimations() {
        const elements = document.querySelectorAll('.animate-on-scroll');
        if (!('IntersectionObserver' in window)) {
            elements.forEach(el => el.style.opacity = '1');
            return;
        }

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

        elements.forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(el);
        });
    }

    // ==========================================================
    // 4. SHARE BUTTONS
    // ==========================================================
    function initShareButtons() {
        const shareButtons = document.querySelectorAll('.share-btn');
        const url = encodeURIComponent(window.location.href);
        const text = encodeURIComponent('⚔️ Join the AI LLM race at NexusValhalla! Forge your saga across the digital realms. 🛡️');

        shareButtons.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const platform = this.getAttribute('data-platform');
                let shareUrl = '';

                switch(platform) {
                    case 'twitter':
                        shareUrl = `https://twitter.com/intent/tweet?text=${text}&url=${url}`;
                        break;
                    case 'linkedin':
                        shareUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${url}`;
                        break;
                    case 'reddit':
                        shareUrl = `https://www.reddit.com/submit?url=${url}&title=${text}`;
                        break;
                    case 'facebook':
                        shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
                        break;
                }

                if (shareUrl) {
                    window.open(shareUrl, '_blank', 'width=600,height=400');
                }
            });
        });
    }

    // ==========================================================
    // 5. TYPING EFFECT
    // ==========================================================
    function initTypingEffect() {
        const elements = document.querySelectorAll('.typing-text');
        elements.forEach(el => {
            const text = el.getAttribute('data-text') || el.textContent;
            el.textContent = '';
            let index = 0;
            
            function type() {
                if (index < text.length) {
                    el.textContent += text.charAt(index);
                    index++;
                    setTimeout(type, 50);
                }
            }
            setTimeout(type, 500);
        });
    }

    // ==========================================================
    // 6. INIT ALL
    // ==========================================================
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(() => {
            animateStats();
            initCountdown();
            initScrollAnimations();
            initShareButtons();
            initTypingEffect();
        }, 100);
    });

})();
</script>