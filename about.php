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

<!-- ========================================================== -->
<!-- HTML content (unchanged from previous version) -->
<!-- ========================================================== -->
<!-- ... (rest of the HTML sections remain identical) ... -->