<?php
require_once '../init.php';
require_once $abs_us_root . $us_url_root . 'users/auth/userspice_oauth_provider.php';

if (!isset($settings->oauth_server) || $settings->oauth_server < 1) {
    http_response_code(404);
    die('OAuth server not enabled');
}

// Initialize OAuth provider
$oauthProvider = new UserSpiceOAuthProvider();
$user = new User();

// HANDLE TOKEN REQUESTS FIRST (POST to /users/auth/)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['grant_type'])) {
    logger(1, "OAuth Server", "Token request received: " . json_encode($_POST));
    
    if ($_POST['grant_type'] === 'authorization_code') {
        $oauthProvider->handleTokenRequest();
        exit; // handleTokenRequest() sends its own response
    } else {
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode(['error' => 'unsupported_grant_type']);
        exit;
    }
}

// HANDLE AUTHORIZATION REQUESTS (GET to /users/auth/)

// STEP 1: Validate that this is a proper OAuth authorization request
if (!isset($_GET['client_id'])) {
    // No client_id provided - this is not a valid OAuth request
    http_response_code(400);
    header('Content-Type: application/json');
    echo json_encode([
        'error' => 'invalid_request',
        'error_description' => 'Missing required parameter: client_id'
    ]);
    exit;
}

// STEP 2: Handle the authorization request and validate client
$oauthData = $oauthProvider->handleAuthorizationRequest();

if (!is_array($oauthData)) {
    // handleAuthorizationRequest() should have already sent an error response
    // But if it returns false without sending a response, send a generic error
    if (!headers_sent()) {
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode([
            'error' => 'invalid_client',
            'error_description' => 'Invalid client credentials'
        ]);
    }
    exit;
}

// STEP 3: Get client data from database
if ($clientDataQ->count() == 0) {
    // Client not found or disabled
    http_response_code(400);
    header('Content-Type: application/json');
    echo json_encode([
        'error' => 'invalid_client',
        'error_description' => 'The client ID is invalid or disabled.'
    ]);
    logger(0, "OAuth Server Error", "Invalid or disabled client: " . $oauthData['client_id']);
    exit;
}

$oauthClientData = $clientDataQ->first();


// STEP 4: Validate redirect_uri matches what's registered
if ($oauthData['redirect_uri'] !== $oauthClientData->redirect_uri) {
    // Redirect URI mismatch - this is a security issue, don't redirect
    http_response_code(400);
    header('Content-Type: application/json');
    echo json_encode([
        'error' => 'invalid_request',
        'error_description' => 'Redirect URI does not match registered URI'
    ]);
    logger(0, "OAuth Server Security", "Redirect URI mismatch for client: " . $oauthData['client_id'] . 
           ". Provided: " . $oauthData['redirect_uri'] . ", Expected: " . $oauthClientData->redirect_uri);
    exit;
}

// STEP 5: Check if user is already logged in AND OAuth flow is already active
if ($user->isLoggedIn() && isset($_SESSION[INSTANCE . '_oauth_flow_active'])) {
    // Check if this is the same OAuth flow or a new one
    $existingOauthData = $_SESSION[INSTANCE . '_oauth_data'] ?? null;
    
    if ($existingOauthData && $existingOauthData['client_id'] === $oauthData['client_id']) {
        // Same OAuth flow, redirect to trigger enforcement
        logger($user->data()->id, "OAuth Server", "Existing OAuth flow detected, redirecting to enforcement");
        Redirect::to($us_url_root . 'users/account.php');
        exit;
    } else {
        // Different OAuth flow, clear the old one and start new
        logger($user->data()->id, "OAuth Server", "New OAuth flow, clearing previous flow");
        require_once $abs_us_root . $us_url_root . 'users/includes/oauth_enforcement.php';
        clearOAuthFlow();
    }
}

// STEP 6: Check if user is already logged in but no OAuth flow active
if ($user->isLoggedIn()) {
    // User is logged in, initialize OAuth flow and let enforcement handle it
    require_once $abs_us_root . $us_url_root . 'users/includes/oauth_enforcement.php';
    initializeOAuthFlow($oauthData, $oauthClientData);
    
    logger($user->data()->id, "OAuth Server", "User already logged in, initializing OAuth flow for client: " . $oauthData['client_id']);
    
    // Redirect to trigger the enforcement system
    Redirect::to($us_url_root . 'users/account.php');
    exit;
}

// STEP 7: User not logged in - initialize OAuth flow and show login form
require_once $abs_us_root . $us_url_root . 'users/includes/oauth_enforcement.php';
initializeOAuthFlow($oauthData, $oauthClientData);

// Store custom form data for hooks
$_SESSION[INSTANCE . '_oauth_login_form'] = $oauthClientData->login_form ?? 'default';
$_SESSION[INSTANCE . '_oauth_login_title'] = $oauthClientData->login_title ?? 'Login';

logger(0, "OAuth Server", "OAuth flow initialized for client: " . $oauthData['client_id'] . ", showing login form");

// STEP 8: Set up hooks for login form customization
$oauthHooks = [];
if (isset($_SESSION[INSTANCE . '_oauth_flow_active'])) {
    $oauthHooks['pre'][] = 'users/auth/oauth_hooks/pre.php';
    $oauthHooks['post'][] = 'users/auth/oauth_hooks/post.php';
    $oauthHooks['loginSuccess'][] = 'users/auth/oauth_hooks/loginSuccess.php';
}

// STEP 9: Load appropriate login page
$custom_login_path = $abs_us_root . $us_url_root . 'usersc/login.php';
$use_custom_login = false;

if (file_exists($custom_login_path)) {
    // Check if the custom login file contains 'USERSPICE_LOGIN_CALLED to determine if it supports oauth
    $login_content = file_get_contents($custom_login_path);
    if (strpos($login_content, 'USERSPICE_LOGIN_CALLED') !== false) {
        $use_custom_login = true;
    }
}
define('USERSPICE_LOGIN_CALLED', true);
if ($use_custom_login) {
    require_once $custom_login_path;
} else {
    require_once '../login.php';
}