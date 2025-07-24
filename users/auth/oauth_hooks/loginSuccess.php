<?php
// OAuth Login Success Hook - executed after successful login
// This handles the OAuth flow completion

if (!isset($_SESSION[INSTANCE . '_oauth_flow_active'])) {
    return;
}

require_once $abs_us_root . $us_url_root . 'users\auth\userspice_oauth_provider.php';

$oauthData = $_SESSION[INSTANCE . '_oauth_data'] ?? null;
$oauthClientData = $_SESSION[INSTANCE . '_oauth_client_data'] ?? null;

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
            include $abs_us_root . $us_url_root . 'usersc/oauth_server/login_scripts/' . $oauthClientData->login_script;
        }
        
        $response = base64_encode(json_encode($response));
        
        // Construct the redirect URL
        $redirectUrl = $oauthData['redirect_uri'] . '?code=' . $authCode;
        $redirectUrl .= '&response=' . urlencode($response);
        if (!empty($oauthData['state'])) {
            $redirectUrl .= '&state=' . urlencode($oauthData['state']);
        }
        
        // Clear OAuth session data
        unset($_SESSION[INSTANCE . '_oauth_flow_active']);
        unset($_SESSION[INSTANCE . '_oauth_data']);
        unset($_SESSION[INSTANCE . '_oauth_client_data']);
        
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