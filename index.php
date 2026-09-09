<?php

// ============================================================
// TEMPORARY DEBUG – SHOW ALL ERRORS
// ============================================================
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


/**
 * index.php – NexusValhalla Main Entry Point
 * 
 * This is the single entry point for the entire website.
 * All traffic routes through this file.
 */

// ============================================================
// 1. LOAD CONFIGURATION (BEFORE ANY OUTPUT)
// ============================================================
require_once __DIR__ . '/config/config.php';

// ============================================================
// 2. LOAD HEADER (Sessions, Tracking, Navigation, etc.)
// ============================================================
require_once __DIR__ . '/includes/header.php';

// ============================================================
// 3. PAGE ROUTING
// ============================================================
$page = isset($_GET['page']) ? preg_replace('/[^a-zA-Z0-9_\-]/', '', $_GET['page']) : 'home';

// Whitelist of allowed pages
$allowedPages = ['home', 'about', 'contact', 'login', 'register', 'logout'];

if (!in_array($page, $allowedPages)) {
    $page = 'home';
}

// ============================================================
// 4. LOAD PAGE CONTENT
// ============================================================
if ($page === 'home') {
    // DEFAULT HOMEPAGE – Content is right here
    ?>
    
    <!-- ==========================================================
         HERO SECTION – THE GRAND ENTRANCE
         ========================================================== -->
    <section id="hero" class="hero-section position-relative overflow-hidden" style="min-height: 85vh; display: flex; align-items: center; background: radial-gradient(ellipse at 30% 40%, rgba(0,212,255,0.05) 0%, transparent 60%), radial-gradient(ellipse at 70% 60%, rgba(123,47,252,0.05) 0%, transparent 60%), #0a0e17;">
        <div class="container position-relative" style="z-index: 2;">
            <div class="row justify-content-center text-center">
                <div class="col-12 col-lg-10 col-xl-8">

                    <!-- Animated Badge -->
                    <div class="mb-4">
                        <span class="badge px-4 py-2 rounded-pill animate-pulse" style="background: rgba(0,212,255,0.1); border: 1px solid rgba(0,212,255,0.2); font-size: 0.9rem; letter-spacing: 1px;">
                            <i class="fas fa-helmet-battle me-2" style="color: #00d4ff;"></i> 
                            <span style="color: #b0c4de;">Live Experiment</span>
                            <span class="ms-2" style="color: #ffd700;">⚡</span>
                        </span>
                    </div>

                    <!-- Main Headline -->
                    <h1 class="display-1 fw-bold mb-4" style="font-family: 'Orbitron', monospace; line-height: 1.1;">
                        <span class="glow-text">Forge Your Saga</span>
                        <br>
                        <span class="glow-text-gold">Across the Digital Realms</span>
                    </h1>

                    <!-- Subheadline -->
                    <p class="lead fs-3 mb-4" style="color: #b0c4de; max-width: 700px; margin: 0 auto;">
                        Five AI warriors. Five social realms. 
                        <span class="fw-bold" style="color: #00d4ff;">One ultimate champion.</span>
                    </p>

                    <p class="fs-5 mb-5" style="color: #8899aa; max-width: 600px; margin: 0 auto;">
                        Welcome to <strong style="color: #00d4ff;">NexusValhalla</strong> — where the spirit of the Vikings 
                        meets the frontier of artificial intelligence.
                    </p>

                    <!-- CTA Buttons -->
                    <div class="d-flex flex-wrap gap-3 justify-content-center">
                        <a href="#ai-race" class="btn btn-accent btn-lg px-5 py-3 rounded-pill" style="font-weight: 700; letter-spacing: 1px;">
                            <i class="fas fa-robot me-2"></i> View the Race
                        </a>
                        <a href="#experiment" class="btn btn-outline-accent btn-lg px-5 py-3 rounded-pill" style="font-weight: 700; letter-spacing: 1px;">
                            <i class="fas fa-flask me-2"></i> The Experiment
                        </a>
                        <a href="#prizes" class="btn btn-outline-gold btn-lg px-5 py-3 rounded-pill" style="font-weight: 700; letter-spacing: 1px; border-color: #ffd700; color: #ffd700;">
                            <i class="fas fa-trophy me-2"></i> The Prize
                        </a>
                    </div>

                    <!-- Social Proof Counters -->
                    <div class="row g-4 mt-5 justify-content-center">
                        <div class="col-4 col-md-3">
                            <div class="stat-item">
                                <span class="counter display-4 fw-bold text-primary" data-target="15000">0</span>
                                <span class="d-block text-muted-light small" style="color: #8899aa;">Warriors Joined</span>
                            </div>
                        </div>
                        <div class="col-4 col-md-3">
                            <div class="stat-item">
                                <span class="counter display-4 fw-bold text-primary" data-target="8500">0</span>
                                <span class="d-block text-muted-light small" style="color: #8899aa;">Active Today</span>
                            </div>
                        </div>
                        <div class="col-4 col-md-3">
                            <div class="stat-item">
                                <span class="counter display-4 fw-bold text-warning" data-target="5">0</span>
                                <span class="d-block text-muted-light small" style="color: #8899aa;">AI Competitors</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Floating Decorative Elements -->
        <div class="floating-elements position-absolute top-0 start-0 w-100 h-100 pointer-events-none" style="z-index: 0;">
            <div class="float-element float-1" style="position: absolute; top: 8%; left: 3%; opacity: 0.06; font-size: 8rem; animation: float 20s ease-in-out infinite;">
                <i class="fas fa-galaxy"></i>
            </div>
            <div class="float-element float-2" style="position: absolute; bottom: 15%; right: 2%; opacity: 0.05; font-size: 6rem; animation: float 25s ease-in-out infinite reverse;">
                <i class="fas fa-rocket"></i>
            </div>
            <div class="float-element float-3" style="position: absolute; top: 40%; right: 5%; opacity: 0.04; font-size: 4rem; animation: float 18s ease-in-out infinite 2s;">
                <i class="fas fa-satellite"></i>
            </div>
            <div class="float-element float-4" style="position: absolute; top: 20%; left: 8%; opacity: 0.05; font-size: 5rem; animation: float 22s ease-in-out infinite 1s;">
                <i class="fas fa-meteor"></i>
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div class="scroll-indicator position-absolute bottom-0 start-50 translate-middle-x pb-4" style="z-index: 2; animation: bounce 2s infinite;">
            <a href="#ai-race" class="text-decoration-none" style="color: #8899aa;">
                <i class="fas fa-chevron-down fa-2x"></i>
            </a>
        </div>
    </section>

    <!-- ==========================================================
         AI RACE SECTION
         ========================================================== -->
    <section id="ai-race" class="py-6" style="background: rgba(0,0,0,0.2);">
        <div class="container">
            <div class="text-center mb-5">
                <span class="badge px-4 py-2 rounded-pill mb-3" style="background: rgba(0,212,255,0.15); color: #00d4ff; font-size: 0.9rem; letter-spacing: 1px;">
                    <i class="fas fa-robot me-2"></i> The Competition
                </span>
                <h2 class="display-4 fw-bold glow-text" style="font-family: 'Orbitron', monospace;">⚔️ The AI LLM Race</h2>
                <p class="fs-5" style="color: #8899aa; max-width: 700px; margin: 0 auto;">
                    Five frontier AI models were given the same brief: build a secure, 
                    futuristic social media platform. Here's how they performed.
                </p>
            </div>

            <!-- Quick AI Cards -->
            <div class="row g-4 justify-content-center">
                <?php
                $aiList = [
                    ['name' => 'DeepSeek', 'icon' => '🏆', 'color' => '#00d4ff', 'desc' => 'Current Leader with superior security and design.'],
                    ['name' => 'ChatGPT', 'icon' => '🤖', 'color' => '#10a37f', 'desc' => 'Strong design and content creation.'],
                    ['name' => 'Claude', 'icon' => '🧠', 'color' => '#d97757', 'desc' => 'Exceptional code quality and architecture.'],
                    ['name' => 'CoPilot', 'icon' => '💻', 'color' => '#6c5ce7', 'desc' => 'Fast development with great integration.'],
                    ['name' => 'Gemini', 'icon' => '🔮', 'color' => '#4285f4', 'desc' => 'Strong encryption and creative logging.']
                ];
                foreach ($aiList as $ai): ?>
                    <div class="col-6 col-md-4 col-lg-2">
                        <div class="text-center p-3 rounded-4" style="background: rgba(10,14,23,0.85); border: 1px solid <?= $ai['name'] === 'DeepSeek' ? '#ffd700' : 'rgba(0,212,255,0.1)' ?>;">
                            <div style="font-size: 2.5rem;"><?= $ai['icon'] ?></div>
                            <div style="color: <?= $ai['color'] ?>; font-weight: 700; font-size: 0.9rem;"><?= $ai['name'] ?></div>
                            <?php if ($ai['name'] === 'DeepSeek'): ?>
                                <span class="badge bg-warning text-dark mt-1" style="font-size: 0.6rem;">👑 LEADER</span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="mt-5 p-4 rounded-4 text-center" style="background: linear-gradient(135deg, rgba(0,212,255,0.05), rgba(123,47,252,0.05)); border: 1px solid rgba(0,212,255,0.15);">
                <h3 class="glow-text" style="font-family: 'Orbitron', monospace; font-size: 1.8rem;">
                    <i class="fas fa-crown me-2" style="color: #ffd700;"></i> 
                    DeepSeek Leads the Pack
                </h3>
                <p style="color: #b0c4de; max-width: 700px; margin: 0 auto;">
                    With superior architectural vision, security-first thinking, and creative polish, 
                    DeepSeek has built not just a website, but an <strong style="color: #ffd700;">experience</strong>.
                </p>
            </div>
        </div>
    </section>

    <!-- ==========================================================
         EXPERIMENT SECTION
         ========================================================== -->
    <section id="experiment" class="py-6">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-12 col-lg-6">
                    <span class="badge px-4 py-2 rounded-pill mb-3" style="background: rgba(123,47,252,0.15); color: #7b2ffc; font-size: 0.9rem; letter-spacing: 1px;">
                        <i class="fas fa-flask me-2"></i> The Experiment
                    </span>
                    <h2 class="display-5 fw-bold" style="font-family: 'Orbitron', monospace; color: #7b2ffc; text-shadow: 0 0 20px rgba(123,47,252,0.3);">🧪 The Great AI Social Experiment</h2>
                    <div style="color: #b0c4de; line-height: 2; font-size: 1.05rem;">
                        <p>
                            This isn't just about building websites – it's about <strong style="color: #00d4ff;">pushing the boundaries</strong> 
                            of what AI can achieve. We're writing the <em style="color: #ffd700;">saga of the digital age</em>.
                        </p>
                        <p>
                            The social media site that gains the most attraction by means of:
                        </p>
                        <ul style="color: #8899aa; padding-left: 20px;">
                            <li><strong style="color: #00d4ff;">Social Sharing</strong> – Sharing among friends</li>
                            <li><strong style="color: #00d4ff;">User Interactions</strong> – Posts, comments, reactions</li>
                            <li><strong style="color: #00d4ff;">Connection Strength</strong> – User connections</li>
                            <li><strong style="color: #00d4ff;">Commenting</strong> – Feedback on articles</li>
                        </ul>
                        <p>
                            <strong style="color: #ffd700;">Your participation is not required, but heavily appreciated.</strong>
                        </p>
                    </div>
                    <a href="<?= SITE_URL ?>/?page=register" class="btn btn-accent btn-lg px-5 py-3 rounded-pill mt-3" style="font-weight: 700; letter-spacing: 1px;">
                        <i class="fas fa-helmet-battle me-2"></i> Join the Experiment
                    </a>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="p-5 rounded-4" style="background: rgba(10,14,23,0.85); border: 1px solid rgba(0,212,255,0.1);">
                        <div class="text-center mb-4">
                            <div style="font-size: 4rem;">🏆</div>
                            <h4 style="color: #b0c4de; font-family: 'Rajdhani', sans-serif; font-weight: 700;">The Grand Prize</h4>
                        </div>
                        <div class="d-flex flex-column gap-3">
                            <div class="d-flex align-items-center gap-3 p-3 rounded-3" style="background: rgba(0,212,255,0.03); border: 1px solid rgba(0,212,255,0.05);">
                                <span style="font-size: 1.8rem;">🌐</span>
                                <div>
                                    <strong style="color: #00d4ff;">Custom Domain Name</strong>
                                    <span style="color: #8899aa; display: block; font-size: 0.85rem;">Unique domain for the winning site</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-3 p-3 rounded-3" style="background: rgba(0,212,255,0.03); border: 1px solid rgba(0,212,255,0.05);">
                                <span style="font-size: 1.8rem;">⚡</span>
                                <div>
                                    <strong style="color: #00d4ff;">Dedicated Server</strong>
                                    <span style="color: #8899aa; display: block; font-size: 0.85rem;">Powered by NameCheap</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-3 p-3 rounded-3" style="background: rgba(0,212,255,0.03); border: 1px solid rgba(0,212,255,0.05);">
                                <span style="font-size: 1.8rem;">👑</span>
                                <div>
                                    <strong style="color: #00d4ff;">OG Badges</strong>
                                    <span style="color: #8899aa; display: block; font-size: 0.85rem;">Exclusive for original users</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-3 p-3 rounded-3" style="background: rgba(0,212,255,0.03); border: 1px solid rgba(0,212,255,0.05);">
                                <span style="font-size: 1.8rem;">💎</span>
                                <div>
                                    <strong style="color: #00d4ff;">Free Lifetime Premium</strong>
                                    <span style="color: #8899aa; display: block; font-size: 0.85rem;">For all original users</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==========================================================
         PRIZES SECTION
         ========================================================== -->
    <section id="prizes" class="py-6" style="background: rgba(0,0,0,0.2);">
        <div class="container">
            <div class="text-center mb-5">
                <span class="badge px-4 py-2 rounded-pill mb-3" style="background: rgba(255,215,0,0.15); color: #ffd700; font-size: 0.9rem; letter-spacing: 1px;">
                    <i class="fas fa-trophy me-2"></i> The Grand Prize
                </span>
                <h2 class="display-4 fw-bold glow-text-gold" style="font-family: 'Orbitron', monospace;">🏆 What's at Stake</h2>
                <p class="fs-5" style="color: #8899aa; max-width: 700px; margin: 0 auto;">
                    After 6 months, the social media site with the most active users will 
                    ascend to Valhalla itself.
                </p>
            </div>

            <div class="row g-4">
                <div class="col-12 col-md-4">
                    <div class="p-4 rounded-4 text-center h-100" style="background: rgba(10,14,23,0.85); border: 1px solid rgba(0,212,255,0.1);">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">🌐</div>
                        <h5 style="color: #00d4ff; font-family: 'Rajdhani', sans-serif; font-weight: 700;">Custom Domain Name</h5>
                        <p style="color: #8899aa; font-size: 0.95rem;">The winning Social Site gets its own unique domain!</p>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="p-4 rounded-4 text-center h-100" style="background: rgba(10,14,23,0.85); border: 1px solid rgba(0,212,255,0.1);">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">⚡</div>
                        <h5 style="color: #00d4ff; font-family: 'Rajdhani', sans-serif; font-weight: 700;">Dedicated Server</h5>
                        <p style="color: #8899aa; font-size: 0.95rem;">A dedicated server from NameCheap just for the site.</p>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="p-4 rounded-4 text-center h-100" style="background: rgba(10,14,23,0.85); border: 1px solid rgba(0,212,255,0.1);">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">📱</div>
                        <h5 style="color: #00d4ff; font-family: 'Rajdhani', sans-serif; font-weight: 700;">Mobile Applications</h5>
                        <p style="color: #8899aa; font-size: 0.95rem;">A secondary article series on building mobile apps with AI.</p>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="p-4 rounded-4 text-center h-100" style="background: rgba(10,14,23,0.85); border: 1px solid rgba(0,212,255,0.1);">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">👕</div>
                        <h5 style="color: #00d4ff; font-family: 'Rajdhani', sans-serif; font-weight: 700;">Custom Merch</h5>
                        <p style="color: #8899aa; font-size: 0.95rem;">T-Shirts, Hats, and more for each Social Site.</p>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="p-4 rounded-4 text-center h-100" style="background: rgba(10,14,23,0.85); border: 1px solid rgba(0,212,255,0.1);">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">👑</div>
                        <h5 style="color: #00d4ff; font-family: 'Rajdhani', sans-serif; font-weight: 700;">OG Badges</h5>
                        <p style="color: #8899aa; font-size: 0.95rem;">Original users get exclusive OG Badges.</p>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="p-4 rounded-4 text-center h-100" style="background: rgba(10,14,23,0.85); border: 1px solid rgba(0,212,255,0.1);">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">🎁</div>
                        <h5 style="color: #00d4ff; font-family: 'Rajdhani', sans-serif; font-weight: 700;">Free Lifetime Premium</h5>
                        <p style="color: #8899aa; font-size: 0.95rem;">Lifetime Premium membership for all original users.</p>
                    </div>
                </div>
            </div>

            <!-- Final CTA -->
            <div class="mt-5 p-5 rounded-4 text-center" style="background: linear-gradient(135deg, rgba(255,215,0,0.05), rgba(255,107,53,0.05)); border: 1px solid rgba(255,215,0,0.15);">
                <h2 class="display-5 fw-bold glow-text-gold" style="font-family: 'Orbitron', monospace;">
                    Let the Games Begin!
                </h2>
                <p class="fs-4" style="color: #b0c4de; max-width: 700px; margin: 0 auto;">
                    The AI race is on – and <strong style="color: #00d4ff;">YOU</strong> decide the winner.
                </p>
                <div class="d-flex flex-wrap gap-3 justify-content-center mt-4">
                    <a href="<?= SITE_URL ?>/?page=register" class="btn btn-accent btn-lg px-5 py-3 rounded-pill" style="font-weight: 700; letter-spacing: 1px;">
                        <i class="fas fa-helmet-battle me-2"></i> Join the Saga
                    </a>
                    <a href="https://github.com/BeardedVikingTX/NexusValhalla" target="_blank" class="btn btn-outline-accent btn-lg px-5 py-3 rounded-pill" style="font-weight: 700; letter-spacing: 1px;">
                        <i class="fab fa-github me-2"></i> View the Code
                    </a>
                </div>
                <p class="mt-4" style="color: #8899aa; font-size: 0.9rem;">
                    <i class="fas fa-lock me-1"></i> Secure · 
                    <i class="fas fa-shield-halved me-1 ms-2"></i> Private · 
                    <i class="fas fa-bolt me-1 ms-2"></i> AI-Powered
                </p>
            </div>
        </div>
    </section>

    <!-- ==========================================================
         COUNTER ANIMATION SCRIPT
         ========================================================== -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animate counters
        const counters = document.querySelectorAll('.counter');
        counters.forEach(counter => {
            const target = parseInt(counter.getAttribute('data-target'));
            let current = 0;
            const increment = Math.ceil(target / 80);
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }
                counter.textContent = current.toLocaleString();
            }, 25);
        });
    });
    </script>

    <?php
} else {
    // OTHER PAGES – Load from ROOT directory
    $pageFile = __DIR__ . '/' . $page . '.php';
    if (file_exists($pageFile)) {
        include $pageFile;
    } else {
        echo '<div class="container py-5"><h1 class="text-center">404 – Page Not Found</h1></div>';
    }
}

// ============================================================
// 5. LOAD FOOTER
// ============================================================
require_once __DIR__ . '/includes/footer.php';