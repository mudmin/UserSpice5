<?php
/*
UserSpice - TOTP Enforcement System
This file handles all TOTP enforcement logic called from loader.php
FIXED: Prevents AJAX/API URLs from being stored as return destinations
*/

if (count(get_included_files()) == 1) die(); // Direct access not permitted

/**
 * Main TOTP enforcement handler
 * Called from loader.php for logged-in users when TOTP settings > 0
 */
function handleTotpEnforcement($user, $settings, $currentPage) {
    global $abs_us_root, $us_url_root, $db;
    
    // Early exit conditions - API/programmatic access
    if (shouldBypassTotp()) {
        return;
    }
    
    $user_id = $user->data()->id;
    
    // Load TOTP requirements with user context available
    $totp_requirements = loadTotpRequirements($user_id);
    
    // Check if current page should be exempt from redirects
    if (isSafePage($currentPage, $totp_requirements)) {
        return;
    }
    
    // Get user's TOTP setup status
    $totp_status = getUserTotpStatus($user_id);
    
    // Get the login method for this session
    $login_method = $_SESSION[INSTANCE . '_login_method'] ?? 'password';
    
    // Determine if TOTP is required for this user/method/settings combo
    $totp_required = isTotpRequired($settings, $login_method, $totp_requirements, $user_id);
    
    if (!$totp_required) {
        // TOTP not required, ensure session reflects this
        $_SESSION[INSTANCE . '_totp_verified'] = true;
        return;
    }
    
    // TOTP is required - check status and redirect as needed
    handleTotpRedirects($totp_status, $user_id, $currentPage);
}

/**
 * Check if TOTP should be bypassed entirely
 */
function shouldBypassTotp() {
    global $settings;
    
    // Global bypass flag
    if (defined('TOTP_BYPASS') && defined('TOTP_BYPASS') === true) {
        return true;
    }
    
    // Settings override (can be set by APIs, etc.)
    if ($settings->totp == 0) {
        return true;
    }
    
    return false;
}

/**
 * Check if current request is an AJAX/API request
 */
function isAjaxRequest() {
    // Check for AJAX header
    $x_requested_with = Server::get('HTTP_X_REQUESTED_WITH');
    if ($x_requested_with !== '' && strtolower($x_requested_with) === 'xmlhttprequest') {
        return true;
    }

    // Check for common API patterns in the URL
    $request_uri = Server::get('REQUEST_URI');
    $api_patterns = [
        '/api/',
        '/ajax/',
        '.json',
        '.xml',
        '/webservice/',
        '/ws/',
        '/rest/'
    ];

    foreach ($api_patterns as $pattern) {
        if (stripos($request_uri, $pattern) !== false) {
            return true;
        }
    }

    // Check Content-Type for API requests
    $content_type = Server::get('CONTENT_TYPE');
    if ($content_type === '') {
        $content_type = Server::get('HTTP_CONTENT_TYPE');
    }
    if (stripos($content_type, 'application/json') !== false ||
        stripos($content_type, 'application/xml') !== false) {
        return true;
    }

    // Check Accept header for API responses
    $accept = Server::get('HTTP_ACCEPT');
    if (stripos($accept, 'application/json') !== false &&
        stripos($accept, 'text/html') === false) {
        return true;
    }

    return false;
}

/**
 * Load TOTP requirements with user context
 */
function loadTotpRequirements($user_id) {
    global $abs_us_root, $us_url_root, $db, $user;
    
    // Load custom requirements if they exist, otherwise use defaults
    if (file_exists($abs_us_root . $us_url_root . 'usersc/includes/totp_requirements.php')) {
        include $abs_us_root . $us_url_root . 'usersc/includes/totp_requirements.php';
    } else {
        include $abs_us_root . $us_url_root . 'users/includes/totp_requirements.php';
    }
    
    return $totp_requirements;
}

/**
 * Check if current page is safe from TOTP redirects
 */
function isSafePage($currentPage, $totp_requirements) {
    //these are just fallbacks
    $safe_pages = $totp_requirements['safe_pages'] ?? [
        'totp_management.php',
        'totp_verification.php',
        'logout.php',
        'maintenance.php',
        'banned.php'
    ];
    
    return in_array($currentPage, $safe_pages);
}

/**
 * Get user's TOTP setup and verification status
 */
function getUserTotpStatus($user_id) {
    global $db;
    
    $totp_record = $db->query("SELECT verified FROM us_totp_secrets WHERE user_id = ?", [$user_id])->first();
    $has_totp_setup = $totp_record && $totp_record->verified == 1;
    $session_verified = $_SESSION[INSTANCE . '_totp_verified'] ?? false;
    
    return [
        'has_setup' => $has_totp_setup,
        'session_verified' => $session_verified,
        'needs_setup' => !$has_totp_setup,
        'needs_verification' => $has_totp_setup && !$session_verified
    ];
}

/**
 * Determine if TOTP is required based on settings, login method, and custom rules
 */
function isTotpRequired($settings, $login_method, $totp_requirements, $user_id) {
    global $db;
    
    // If TOTP is disabled globally
    if ($settings->totp == 0) {
        return false;
    }
    
    // Check if login method requires TOTP verification
    $login_method_requires_totp = $totp_requirements['login_methods'][$login_method] ?? true;
    
    // If this login method doesn't require TOTP (e.g., passkeys, some SSO methods)
    if (!$login_method_requires_totp) {
        return false;
    }
    
    // If TOTP is required globally (setting = 2), check login method requirements
    if ($settings->totp == 2) {
        return $login_method_requires_totp;
    }
    
    // If TOTP is optional (setting = 1), check if user has voluntarily set it up
    if ($settings->totp == 1) {
        // Only require TOTP if:
        // 1. The login method normally requires it AND
        // 2. The user has voluntarily set up TOTP
        if ($login_method_requires_totp) {
            $totp_record = $db->query("SELECT verified FROM us_totp_secrets WHERE user_id = ?", [$user_id])->first();
            return $totp_record && $totp_record->verified == 1;
        }
        return false;
    }
    
    return false;
}

/**
 * Handle redirects based on TOTP status
 */
function handleTotpRedirects($totp_status, $user_id, $currentPage) {
    global $us_url_root;
    
    // Don't redirect AJAX requests - return JSON error instead
    if (isAjaxRequest()) {
        if ($totp_status['needs_setup'] || $totp_status['needs_verification']) {
            header('Content-Type: application/json');
            http_response_code(401);
            echo json_encode([
                'error' => 'TOTP verification required',
                'redirect' => $us_url_root . 'users/totp_verification.php',
                'needs_setup' => $totp_status['needs_setup']
            ]);
            exit;
        }
        return;
    }
    
    if ($totp_status['needs_setup']) {
        // User needs to set up TOTP
        logger($user_id, "TOTP_Enforcement", "User redirected to TOTP setup - required but not configured");
        
        // Add query parameter to indicate this is required setup
        $redirect_url = $us_url_root . 'users/totp_management.php?setup_required=1';
        if ($currentPage != 'totp_management.php') {
            usError("Two-factor authentication is required. Please set up your authenticator app.");
            Redirect::to($redirect_url);
            exit;
        }
    }
    
    if ($totp_status['needs_verification']) {
        // User has TOTP set up but hasn't verified this session
        logger($user_id, "TOTP_Enforcement", "User redirected to TOTP verification - session not verified");
        
        // Store the page they were trying to access (but NOT if it's an API endpoint)
        if ($currentPage != 'totp_verification.php' && !isAjaxRequest()) {
            $current_url = Server::get('REQUEST_URI');
            
            // Validate it's not an API endpoint before storing
            if (!isApiUrl($current_url)) {
                $_SESSION[INSTANCE . '_totp_return_to'] = $current_url;
            }
            
            usError("Please verify your identity with your authenticator app.");
            Redirect::to($us_url_root . 'users/totp_verification.php');
            exit;
        }
    }
}

/**
 * Check if a URL appears to be an API endpoint
 */
function isApiUrl($url) {
    if (empty($url)) {
        return false;
    }
    
    $api_patterns = [
        '/api/',
        '/ajax/',
        '.json',
        '.xml',
        '/webservice/',
        '/ws/',
        '/rest/',
        '/endpoint/',
        '/service/'
    ];
    
    foreach ($api_patterns as $pattern) {
        if (stripos($url, $pattern) !== false) {
            return true;
        }
    }
    
    return false;
}

/**
 * Mark TOTP as verified for this session
 */
function markTotpVerified($user_id) {
    $_SESSION[INSTANCE . '_totp_verified'] = true;
    logger($user_id, "TOTP_Verification", "TOTP verified for session");
}

/**
 * Clear TOTP verification from session
 */
function clearTotpVerification() {
    unset($_SESSION[INSTANCE . '_totp_verified']);
    unset($_SESSION[INSTANCE . '_login_method']);
    unset($_SESSION[INSTANCE . '_totp_return_to']);
}

/**
 * Get where user should be redirected after TOTP verification
 */
function getTotpReturnUrl() {
    global $us_url_root, $settings;
    
    $return_to = $_SESSION[INSTANCE . '_totp_return_to'] ?? '';
    unset($_SESSION[INSTANCE . '_totp_return_to']);
    
    // Validate the return URL
    if (!empty($return_to)) {
        // Make sure it's not an API endpoint
        if (isApiUrl($return_to)) {
            logger(null, "TOTP_Verification", "Blocked redirect to API endpoint: " . $return_to);
            $return_to = ''; // Clear it
        }
        // Make sure it starts with our URL root for security
        elseif (strpos($return_to, $us_url_root) === 0) {
            return $return_to;
        }
    }
    
    // Fall back to default redirect
    return $us_url_root . ($settings->redirect_uri_after_login ?? 'users/account.php');
}
?>