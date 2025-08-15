<?php
$noMaintenanceRedirect = true; 
require_once '../../users/init.php';

// Check if OAuth is enabled
if ($settings->oauth != 1) {
    usError('OAuth login is disabled');
    Redirect::to($us_url_root . 'users/login.php');
    exit;
}

// Get client ID from URL parameter if provided
$clientId = Input::get('client_id');

// Get the OAuth client configuration
if ($clientId && is_numeric($clientId)) {
    // Specific client requested
    $oSettingsQ = $db->query("SELECT * FROM us_oauth_client_login_options WHERE id = ? AND oauth = 1", [$clientId]);
    if ($oSettingsQ->count() == 0) {
        usError('OAuth client not found or not active');
        Redirect::to($us_url_root . 'users/login.php');
        exit;
    }
} else {
    // No specific client - get the first active one (backward compatibility)
    $oSettingsQ = $db->query("SELECT * FROM us_oauth_client_login_options WHERE oauth = 1 ORDER BY id ASC LIMIT 1");
    if ($oSettingsQ->count() == 0) {
        usError('No active OAuth client configuration found');
        Redirect::to($us_url_root . 'users/login.php');
        exit;
    }
}

$oSettings = $oSettingsQ->first();

// Validate configuration
if (empty($oSettings->client_id) || empty($oSettings->redirect_uri) || empty($oSettings->server_url)) {
    logger(1, "OAuth Client Error", "OAuth client configuration is incomplete for client: " . $oSettings->client_name);
    usError('OAuth client configuration is incomplete. Please contact the administrator.');
    Redirect::to($us_url_root . 'users/login.php');
    exit;
}

// OAuth server authorization endpoint
$authEndpoint = rtrim($oSettings->server_url, '/') . '/' . trim($oSettings->server_target, '/') . '/index.php';

// Generate a random state parameter for CSRF protection
try {
    $state = bin2hex(random_bytes(16));
} catch (Exception $e) {
    logger(1, "OAuth Client Error", "Failed to generate random state: " . $e->getMessage());
    usError('An error occurred while preparing the OAuth request.');
    Redirect::to($us_url_root . 'users/login.php');
    exit;
}

// Store the state and client info in the session for later verification
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$_SESSION['oauth_state'] = $state;
$_SESSION['oauth_client_id'] = $oSettings->id; // Store which client was used

// Build the authorization URL
$authParams = [
    'response_type' => 'code',
    'client_id' => $oSettings->client_id,
    'redirect_uri' => $oSettings->redirect_uri,
    'state' => $state,
    'scope' => 'profile email' // Add any scopes you need
];

$authUrl = $authEndpoint . '?' . http_build_query($authParams);

// Log the outgoing request
logger(1, "OAuth Client", "Initiating OAuth request to: " . $oSettings->client_name . " (" . $oSettings->server_url . ")");

// Redirect the user to the authorization URL
Redirect::to($authUrl);
exit;