<?php
// OAuth Login Success Hook - executed after successful login
// This handles the OAuth flow completion

if (!isset($_SESSION[INSTANCE . '_oauth_flow_active'])) {
    return;
}

require_once $abs_us_root . $us_url_root . 'users/includes/oauth_enforcement.php';
require_once $abs_us_root . $us_url_root . 'users/auth/userspice_oauth_provider.php';

$oauthData = $_SESSION[INSTANCE . '_oauth_data'] ?? null;
$oauthClientData = $_SESSION[INSTANCE . '_oauth_client_data'] ?? null;

// Validate OAuth CSRF token to prevent cross-site request forgery
$submittedCsrfToken = Input::get('oauth_csrf_token');
if (!validateOAuthCsrfToken($submittedCsrfToken)) {
    logger(0, "OAuth Server Security", "OAuth CSRF token validation failed - possible CSRF attack");
    clearOAuthFlow();
    usError("Security validation failed. Please try logging in again.");
    Redirect::to($us_url_root . 'users/login.php');
    exit;
}

if ($oauthData && $oauthClientData && $user->isLoggedIn()) {
    $oauthProvider = new UserSpiceOAuthProvider();
    
    // Generate the auth code
    $authCode = $oauthProvider->generateAuthCode(
        $user->data()->id, 
        $oauthData['client_id'], 
        $oauthData['redirect_uri']
    );
    
    if ($authCode) {
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

        $responseJson = json_encode($response);
        $responseEncoded = base64_encode($responseJson);

        // Sign the response with HMAC-SHA256 if response_secret is configured
        $signature = '';
        if (!empty($oauthClientData->response_secret)) {
            $signature = hash_hmac('sha256', $responseJson, $oauthClientData->response_secret);
        }

        // Construct the redirect URL
        $redirectUrl = $oauthData['redirect_uri'] . '?code=' . $authCode;
        $redirectUrl .= '&response=' . urlencode($responseEncoded);
        if (!empty($signature)) {
            $redirectUrl .= '&signature=' . urlencode($signature);
        }
        if (!empty($oauthData['state'])) {
            $redirectUrl .= '&state=' . urlencode($oauthData['state']);
        }
        
        // Clear OAuth session data
        clearOAuthFlow();

        // Redirect to the OAuth client
        Redirect::to($redirectUrl);
        exit;
    } else {
        // Auth code generation failed
        logger($user->data()->id, "OAuth Server", "Failed to generate auth code for client: " . $oauthData['client_id']);
        usError("OAuth authentication failed. Please try again.");
    }
}
?>