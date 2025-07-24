<?php

if (count(get_included_files()) == 1) die(); // Direct access not permitted

/**
 * Main OAuth enforcement handler
 * Called from loader.php for logged-in users when OAuth flow is active
 */
function handleOAuthEnforcement($user, $settings, $currentPage) {
    global $abs_us_root, $us_url_root, $db;
    
    // Early exit conditions
    if (shouldBypassOAuth()) {
        return;
    }
    
    // Check if OAuth flow is active for this session
    if (!isOAuthFlowActive()) {
        return;
    }
    
    $user_id = $user->data()->id;
    
    // Check if current page should be exempt from OAuth redirects
    if (isOAuthSafePage($currentPage)) {
        return;
    }
    
    // Get OAuth flow data
    $oauthData = $_SESSION[INSTANCE . '_oauth_data'] ?? null;
    $oauthClientData = $_SESSION[INSTANCE . '_oauth_client_data'] ?? null;
    
    if (!$oauthData || !$oauthClientData) {
        // OAuth flow is active but data is missing - clean up and continue
        logger($user_id, "OAuth Server Error", "OAuth flow active but data missing, clearing flow");
        clearOAuthFlow();
        return;
    }
    
    // Validate that the client is still enabled and valid
    $clientCheck = $db->query("SELECT client_enabled FROM us_oauth_server_clients WHERE client_id = ?", [$oauthData['client_id']])->first();
    if (!$clientCheck || $clientCheck->client_enabled != 1) {
        logger($user_id, "OAuth Server Error", "OAuth client disabled or not found: " . $oauthData['client_id']);
        clearOAuthFlow();
        usError("OAuth client is no longer available. Please try logging in again.");
        Redirect::to($us_url_root . 'users/login.php');
        exit;
    }
    
    // User is logged in and TOTP verified (if required) - complete OAuth flow
    completeOAuthFlow($user, $oauthData, $oauthClientData);
}

/**
 * Check if OAuth should be bypassed entirely
 */
function shouldBypassOAuth() {
    global $settings;
    
    // OAuth server disabled
    if (!isset($settings->oauth_server) || $settings->oauth_server < 1) {
        return true;
    }
    
    return false;
}

/**
 * Check if OAuth flow is active
 */
function isOAuthFlowActive() {
    return isset($_SESSION[INSTANCE . '_oauth_flow_active']) && $_SESSION[INSTANCE . '_oauth_flow_active'] === true;
}

/**
 * Check if current page is safe from OAuth redirects
 */
function isOAuthSafePage($currentPage) {
    $safe_pages = [
        'logout.php',
        'maintenance.php',
        'banned.php',
        'oauth_error.php', // In case you want to create an OAuth error page
    ];
    
    return in_array($currentPage, $safe_pages);
}

/**
 * Complete the OAuth flow and redirect to client
 */
function completeOAuthFlow($user, $oauthData, $oauthClientData) {
    global $abs_us_root, $us_url_root;
    
    require_once $abs_us_root . $us_url_root . 'users/auth/userspice_oauth_provider.php';
    $oauthProvider = new UserSpiceOAuthProvider();
    
    try {
        // Generate auth code
        $authCode = $oauthProvider->generateAuthCode(
            $user->data()->id, 
            $oauthData['client_id'], 
            $oauthData['redirect_uri']
        );
        
        if (!$authCode) {
            throw new Exception("Failed to generate authorization code");
        }
        
        logger($user->data()->id, "OAuth Server", "Generated Auth Code: $authCode for client: " . $oauthData['client_id']);
        
        // Build response data
        $response = [];
        $response['userdata']['fname'] = $user->data()->fname;
        $response['userdata']['lname'] = $user->data()->lname;
        $response['userdata']['email'] = $user->data()->email;
        
        // Execute custom login script if specified
        if ($oauthClientData->login_script != "" && 
            file_exists($abs_us_root . $us_url_root . 'usersc/oauth_server/login_scripts/' . $oauthClientData->login_script)) {
            
            try {
                include $abs_us_root . $us_url_root . 'usersc/oauth_server/login_scripts/' . $oauthClientData->login_script;
            } catch (Exception $e) {
                logger($user->data()->id, "OAuth Server Error", "Login script error: " . $e->getMessage());
                // Continue without custom script data
            }
        }
        
        $response = base64_encode(json_encode($response));
        
        // Construct redirect URL
        $redirectUrl = $oauthData['redirect_uri'] . '?code=' . $authCode;
        $redirectUrl .= '&response=' . urlencode($response);
        if (!empty($oauthData['state'])) {
            $redirectUrl .= '&state=' . urlencode($oauthData['state']);
        }
        
        // Log the completion
        logger($user->data()->id, "OAuth Server", "OAuth flow completed, redirecting to: " . $oauthData['redirect_uri']);
        
        // Clear OAuth session data
        clearOAuthFlow();
        
        // Redirect to OAuth client
        Redirect::to($redirectUrl);
        exit;
        
    } catch (Exception $e) {
        // Handle OAuth completion errors
        logger($user->data()->id, "OAuth Server Error", "OAuth completion failed: " . $e->getMessage());
        
        // Try to redirect back to client with error
        if (isset($oauthData['redirect_uri'])) {
            $errorUrl = $oauthData['redirect_uri'] . '?error=server_error';
            if (!empty($oauthData['state'])) {
                $errorUrl .= '&state=' . urlencode($oauthData['state']);
            }
            
            clearOAuthFlow();
            Redirect::to($errorUrl);
            exit;
        } else {
            // Can't redirect to client, show local error
            clearOAuthFlow();
            usError("OAuth authentication failed. Please try again.");
            Redirect::to($us_url_root . 'users/login.php');
            exit;
        }
    }
}

/**
 * Clear OAuth flow session data
 */
function clearOAuthFlow() {
    unset($_SESSION[INSTANCE . '_oauth_flow_active']);
    unset($_SESSION[INSTANCE . '_oauth_data']);
    unset($_SESSION[INSTANCE . '_oauth_client_data']);
    unset($_SESSION[INSTANCE . '_oauth_login_form']);
    unset($_SESSION[INSTANCE . '_oauth_login_title']);
}

/**
 * Initialize OAuth flow (called from users/auth/index.php)
 */
function initializeOAuthFlow($oauthData, $oauthClientData) {
    $_SESSION[INSTANCE . '_oauth_flow_active'] = true;
    $_SESSION[INSTANCE . '_oauth_data'] = $oauthData;
    $_SESSION[INSTANCE . '_oauth_client_data'] = $oauthClientData;
    
    logger(0, "OAuth Server", "OAuth flow initialized for client: " . $oauthData['client_id']);
}

/**
 * Get OAuth client info for display purposes
 */
function getOAuthClientInfo() {
    if (!isOAuthFlowActive()) {
        return null;
    }
    
    $oauthData = $_SESSION[INSTANCE . '_oauth_data'] ?? null;
    $oauthClientData = $_SESSION[INSTANCE . '_oauth_client_data'] ?? null;
    
    if (!$oauthData || !$oauthClientData) {
        return null;
    }
    
    return [
        'client_name' => $oauthClientData->client_name ?? 'Unknown Application',
        'login_title' => $oauthClientData->login_title ?? 'Login',
        'client_description' => $oauthClientData->client_description ?? '',
        'login_form' => $oauthClientData->login_form ?? 'default'
    ];
}

/**
 * Check if we're in an OAuth flow (for use in templates/hooks)
 */
function isInOAuthFlow() {
    return isOAuthFlowActive();
}