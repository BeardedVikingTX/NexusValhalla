<?php
/**
 * home.php – The Heart of the Realm
 * 
 * This is the main landing page content for NexusValhalla.
 * It showcases the AI LLM race, the VDP program, and the ultimate prize.
 */

if (!defined('SITE_URL')) {
    die('Direct access not permitted.');
}

// Define image paths for the AI comparison
$ai_models = [
    'DeepSeek' => [
        'img' => ASSETS_URL . 'assets/img/media/DeepSeek_Homepage.png',
        'site' => 'https://nexusvalhalla.beardedviking.org',
        'repo' => 'https://github.com/BeardedVikingTX/NexusValhalla',
        'winner' => true
    ],
    'ChatGPT' => [
        'img' => ASSETS_URL . 'assets/img/media/ChatGPT_Homepage.png',
        'site' => 'https://nexora.beardedviking.org',
        'repo' => 'https://github.com/BeardedVikingTX/Nexora',
        'winner' => false
    ],
    'Claude' => [
        'img' => ASSETS_URL . 'assets/img/media/Claude_Homepage.png',
        'site' => 'https://ravenwarp.beardedviking.org',
        'repo' => 'https://github.com/BeardedVikingTX/RavenWarp',
        'winner' => false
    ],
    'CoPilot' => [
        'img' => ASSETS_URL . 'assets/img/media/CoPilot_Homepage.png',
        'site' => 'https://sagasphere.beardedviking.org',
        'repo' => 'https://github.com/BeardedVikingTX/SagaSphere',
        'winner' => false
    ],
    'Gemini' => [
        'img' => ASSETS_URL . 'assets/img/media/Gemini_Homepage.png',
        'site' => 'https://valkyrin.beardedviking.org',
        'repo' => 'https://github.com/BeardedVikingTX/Valkyrin',
        'winner' => false
    ]
];
?>

<!-- ==========================================================
     HERO SECTION
     ========================================================== -->
<section id="hero" class="py-5 py-md-6 text-center position-relative overflow-hidden">
    <div class="container py-4 py-md-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-8">
                <div class="mb-4">
                    <span class="badge bg-accent-glow px-4 py-2 rounded-pill" style="background: rgba(123, 47, 252, 0.2); border: 1px solid var(--accent-glow);">
                        <i class="fas fa-helmet-battle me-2"></i> The Great AI LLM Experiment
                    </span>
                </div>
                <h1 class="display-3 display-md-2 fw-bold glow-text">
                    Forge Your Saga<br>
                    <span class="glow-text-gold">Across the Digital Realms</span>
                </h1>
                <p class="lead text-muted mt-4 fs-5 lh-lg" style="max-width: 700px; margin: 0 auto;">
                    Five AI warriors. Five social realms. One ultimate champion.
                    Welcome to <strong class="text-primary">NexusValhalla</strong> – where 
                    the spirit of the Vikings meets the frontier of artificial intelligence.
                </p>
                <div class="mt-5 d-flex flex-wrap gap-3 justify-content-center">
                    <a href="#ai-race" class="btn btn-accent btn-lg px-5">
                        <i class="fas fa-robot me-2"></i> View the Race
                    </a>
                    <a href="#prizes" class="btn btn-outline-accent btn-lg px-5">
                        <i class="fas fa-trophy me-2"></i> See the Prize
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Floating decorative elements -->
    <div class="position-absolute top-0 start-0 w-100 h-100 pointer-events-none" style="z-index: 0;">
        <div class="position-absolute top-10 start-10 float-image float-image-delay-1" style="opacity: 0.1; font-size: 8rem;">
            <i class="fas fa-galaxy"></i>
        </div>
        <div class="position-absolute bottom-10 end-10 float-image float-image-delay-3" style="opacity: 0.08; font-size: 6rem;">
            <i class="fas fa-rocket"></i>
        </div>
    </div>
</section>

<!-- ==========================================================
     THE AI RACE – COMPARISON SECTION
     ========================================================== -->
<section id="ai-race" class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title glow-text">⚔️ The AI LLM Race</h2>
            <p class="text-muted fs-5" style="max-width: 700px; margin: 0 auto;">
                Five frontier AI models were given the same brief: build a secure, 
                futuristic social media platform. Here's how they performed.
            </p>
        </div>

        <div class="row g-4">
            <?php foreach ($ai_models as $name => $data): ?>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="ai-card <?= $data['winner'] ? 'winner' : '' ?>">
                        <?php if ($data['winner']): ?>
                            <div class="position-absolute top-0 start-0 w-100 h-100 pointer-events-none" style="background: radial-gradient(circle at center, rgba(255,215,0,0.05), transparent);"></div>
                        <?php endif; ?>
                        
                        <img src="<?= htmlspecialchars($data['img']) ?>" 
                             alt="<?= htmlspecialchars($name) ?> Homepage" 
                             class="img-fluid rounded-3 mb-3"
                             loading="lazy">
                        
                        <div class="ai-name">
                            <?= htmlspecialchars($name) ?>
                            <?php if ($data['winner']): ?>
                                <span class="ms-1">👑</span>
                            <?php endif; ?>
                        </div>
                        
                        <a href="<?= htmlspecialchars($data['site']) ?>" 
                           target="_blank" 
                           rel="noopener noreferrer" 
                           class="ai-link">
                            <i class="fas fa-globe me-1"></i> <?= htmlspecialchars($data['site']) ?>
                        </a>
                        
                        <a href="<?= htmlspecialchars($data['repo']) ?>" 
                           target="_blank" 
                           rel="noopener noreferrer" 
                           class="ai-repo mt-1">
                            <i class="fab fa-github me-1"></i> GitHub Repo
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- DeepSeek Victory Callout -->
        <div class="mt-5 p-4 p-md-5 rounded-4" style="background: linear-gradient(135deg, rgba(0,212,255,0.05), rgba(123,47,252,0.05)); border: 1px solid var(--border-glow);">
            <div class="row align-items-center g-4">
                <div class="col-12 col-md-8">
                    <h3 class="glow-text" style="font-family: var(--font-display);">
                        <i class="fas fa-crown me-2" style="color: #ffd700;"></i> 
                        Why DeepSeek Stands Above the Rest
                    </h3>
                    <p class="text-muted lh-lg mb-0">
                        While all five AIs delivered functional platforms, <strong class="text-primary">DeepSeek</strong> 
                        demonstrated superior architectural vision, security-first thinking, and a level of 
                        creative polish that truly captures the <em>NexusValhalla</em> spirit. From the 
                        encrypted session handling to the futuristic UI design, DeepSeek built not just 
                        a website, but an <strong>experience</strong> – a digital longship worthy of sailing 
                        the cosmic seas. The code is cleaner, the structure is more scalable, and the 
                        attention to detail is unmatched. <span class="glow-text-gold">This is the work of a 
                        true champion.</span>
                    </p>
                </div>
                <div class="col-12 col-md-4 text-center">
                    <div style="font-size: 4rem; animation: float 4s ease-in-out infinite;">
                        🏆
                    </div>
                    <span class="badge bg-warning text-dark px-4 py-2 rounded-pill fw-bold" 
                          style="font-family: var(--font-display); letter-spacing: 0.1em;">
                        ULTIMATE WINNER
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================================
     VDP & HACKERONE / BUG CROWD SECTION
     ========================================================== -->
<section id="vdp" class="py-5" style="background: rgba(0,0,0,0.3);">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title glow-text-purple">🛡️ The Future of Security</h2>
            <p class="text-muted fs-5" style="max-width: 700px; margin: 0 auto;">
                Vulnerability Disclosure Programs (VDP) are the shieldwall of the digital age.
                The winning platform will be forged in the fires of ethical hacking.
            </p>
        </div>

        <div class="row g-4">
            <div class="col-12 col-md-6">
                <div class="sci-fi-card h-100">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-shield-halved fa-2x me-3" style="color: var(--primary);"></i>
                        <h4 class="card-title mb-0">HackerOne Integration</h4>
                    </div>
                    <p class="card-text">
                        The winning platform will be submitted to <strong class="text-primary">HackerOne</strong>, 
                        the world's leading ethical hacking platform. This means real security researchers 
                        will probe every corner of the application – from the authentication flows to the 
                        encryption layers – ensuring that NexusValhalla becomes a fortress worthy of 
                        Asgard itself. The VDP will be public, transparent, and reward-driven, 
                        attracting the best white-hat hackers on the planet.
                    </p>
                    <div class="mt-3">
                        <span class="badge bg-primary me-2">Bug Bounty</span>
                        <span class="badge bg-secondary">Responsible Disclosure</span>
                        <span class="badge bg-secondary">Public VDP</span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="sci-fi-card h-100">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-bug fa-2x me-3" style="color: var(--secondary);"></i>
                        <h4 class="card-title mb-0">BugCrowd Collaboration</h4>
                    </div>
                    <p class="card-text">
                        Alongside HackerOne, the winning platform will also launch on 
                        <strong class="text-secondary">BugCrowd</strong>, creating a dual-layer 
                        security net. This ensures maximum coverage and diverse testing 
                        methodologies. The combination of these two platforms will make 
                        NexusValhalla one of the <strong>most thoroughly vetted social media 
                        sites in existence</strong> – a benchmark for privacy and security 
                        in the social networking space.
                    </p>
                    <div class="mt-3">
                        <span class="badge bg-secondary me-2">Crowdsourced Security</span>
                        <span class="badge bg-secondary">Continuous Testing</span>
                        <span class="badge bg-secondary">Global Researchers</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- The VDP Vision -->
        <div class="mt-4 p-4 rounded-4" style="background: rgba(123, 47, 252, 0.05); border: 1px solid rgba(123, 47, 252, 0.2);">
            <p class="text-muted lh-lg mb-0 text-center" style="font-size: 1.05rem;">
                <i class="fas fa-quote-left me-2" style="color: var(--accent-glow);"></i>
                The VDP program isn't just about finding bugs – it's about building a 
                <strong class="text-primary">culture of security</strong>. By opening our 
                platform to the global ethical hacking community, we demonstrate that 
                NexusValhalla values <strong>transparency, trust, and continuous improvement</strong>. 
                This is how we earn the loyalty of our users and set a new standard for 
                social media security.
                <i class="fas fa-quote-right ms-2" style="color: var(--accent-glow);"></i>
            </p>
        </div>
    </div>
</section>

<!-- ==========================================================
     THE PRIZE – 6-MONTH RACE
     ========================================================== -->
<section id="prizes" class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title glow-text-gold">🏆 The Grand Prize</h2>
            <p class="text-muted fs-5" style="max-width: 700px; margin: 0 auto;">
                After 6 months, the social media site with the most active users will 
                ascend to Valhalla itself. Here's what awaits the champion.
            </p>
        </div>

        <div class="row g-4">
            <div class="col-12 col-md-4">
                <div class="prize-pillar">
                    <span class="prize-icon">🌐</span>
                    <h5>Own Domain Name</h5>
                    <p>The winning platform receives a <strong>premium paid domain</strong>, 
                    solidifying its identity as the <em>official</em> NexusValhalla realm.</p>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="prize-pillar">
                    <span class="prize-icon">⚡</span>
                    <h5>Dedicated Hosted Server</h5>
                    <p>Upgrade from shared hosting to a <strong>dedicated server</strong> 
                    with guaranteed resources, ensuring lightning-fast performance and 
                    zero latency.</p>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="prize-pillar">
                    <span class="prize-icon">🔐</span>
                    <h5>Increased Security</h5>
                    <p>Enhanced security measures including <strong>advanced DDoS protection</strong>, 
                    WAF deployment, and prioritized VDP engagement with HackerOne & BugCrowd.</p>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="prize-pillar">
                    <span class="prize-icon">👑</span>
                    <h5>Founding User Roles</h5>
                    <p>Exclusive <strong>Founding User badges</strong> and roles for early 
                    adopters, immortalizing the first warriors to join the realm.</p>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="prize-pillar">
                    <span class="prize-icon">🏅</span>
                    <h5>Premium Badge System</h5>
                    <p>A <strong>custom badge system</strong> with unique, limited-edition 
                    designs for the winning platform's most active and loyal users.</p>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="prize-pillar">
                    <span class="prize-icon">📰</span>
                    <h5>+ SO MUCH MORE!</h5>
                    <p>Exclusive interviews, media coverage, and a permanent place in the 
                    <strong>Bearded Viking</strong> hall of fame. The champion gets it all.</p>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="mt-5 text-center">
            <div class="p-5 rounded-4" style="background: linear-gradient(135deg, rgba(255,215,0,0.05), rgba(255,107,53,0.05)); border: 2px solid rgba(255,215,0,0.2);">
                <h3 class="glow-text-gold" style="font-family: var(--font-display);">
                    The Race Is On!
                </h3>
                <p class="text-muted lh-lg fs-5" style="max-width: 700px; margin: 0 auto;">
                    Five AI warriors have built their realms. Now, the <strong>users</strong> 
                    decide the victor. The platform with the most active community in 
                    <strong>6 months</strong> will be crowned the <em>Ultimate NexusValhalla</em>.
                    <br><br>
                    <span class="glow-text" style="font-size: 1.2rem;">
                        <i class="fas fa-feather-alt me-2"></i>
                        Your saga begins now. Which realm will you call home?
                    </span>
                </p>
                <div class="mt-4 d-flex flex-wrap gap-3 justify-content-center">
                    <a href="https://nexusvalhalla.beardedviking.org" class="btn btn-accent btn-lg px-5" target="_blank">
                        <i class="fas fa-helmet-battle me-2"></i> Join NexusValhalla
                    </a>
                    <a href="https://github.com/BeardedVikingTX/NexusValhalla" class="btn btn-outline-accent btn-lg px-5" target="_blank">
                        <i class="fab fa-github me-2"></i> View the Code
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================================
     FINAL SAGA – The Bearded Viking's Vision
     ========================================================== -->
<section id="vision" class="py-5" style="background: rgba(0,0,0,0.2); border-top: 1px solid var(--border-glow); border-bottom: 1px solid var(--border-glow);">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-12 col-lg-6 order-lg-2">
                <div class="text-center">
                    <div style="font-size: 5rem; animation: float 6s ease-in-out infinite;">
                        🛡️
                    </div>
                    <h3 class="glow-text mt-3" style="font-family: var(--font-display);">
                        From the Desk of the Bearded Viking
                    </h3>
                </div>
            </div>
            <div class="col-12 col-lg-6 order-lg-1">
                <blockquote class="fs-5 lh-lg" style="border-left: 4px solid var(--primary); padding-left: 2rem; color: var(--text-muted);">
                    <i class="fas fa-quote-left me-2" style="color: var(--primary);"></i>
                    This experiment isn't just about building websites – it's about 
                    <strong class="text-primary">pushing the boundaries</strong> of what AI 
                    can achieve. We're writing the <em>saga of the digital age</em>, one 
                    commit at a time. The winner of this race won't just get a domain 
                    and a server – they'll get a <strong>legacy</strong>. A place in the 
                    halls of Valhalla, where warriors and legends are made.
                    <br><br>
                    <span class="glow-text-gold" style="font-size: 1.1rem;">
                        Skål, and may the best AI win. 🍻
                    </span>
                    <br>
                    <span class="text-muted" style="font-size: 0.9rem;">
                        — Bearded Viking, Keeper of the Nexus
                    </span>
                </blockquote>
            </div>
        </div>
    </div>
</section>