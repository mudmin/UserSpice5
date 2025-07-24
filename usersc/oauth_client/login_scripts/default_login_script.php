<?php
// This script runs after a successful OAuth login (both new and existing users)
// 

// 
// Available variables:
// $log - array containing login information including 'new_user' (1 for new, 0 for existing)
// $userData - array containing user data from OAuth response
// $responseData - full OAuth response data including instructions
// $oSettings - OAuth client configuration
// $userId or $theNewId - the user ID of the logged in user

// Check if this is a new user registration
if (isset($log) && $log['new_user'] == 1) {
    // This is a new user created via OAuth
    logger($userId ?? $theNewId, "OAuth Login Script", "New user welcomed via OAuth from: " . $oSettings->client_name);
    
    // You could set a welcome message here
    // usSuccess("Welcome! Your account has been created successfully via " . $oSettings->client_name);
    
    // Or redirect new users to a special onboarding page
    // Redirect::to($us_url_root . 'users/onboarding.php');
    
} else {
    // This is an existing user logging in via OAuth
    $loggedInUserId = $userId ?? $existingUser->id ?? $theNewId;
    if ($loggedInUserId) {
        logger($loggedInUserId, "OAuth Login Script", "Existing user logged in via OAuth from: " . $oSettings->client_name);
    }
    
    // You could set a welcome back message here
    // usSuccess("Welcome back via " . $oSettings->client_name . "!");
}

// Example: Log additional OAuth data if available
if (isset($responseData) && !empty($responseData)) {
    $loggedInUserId = $userId ?? $existingUser->id ?? $theNewId;
    if ($loggedInUserId) {
        // Log any custom data from the OAuth server
        if (isset($responseData['custom_data'])) {
            logger($loggedInUserId, "OAuth Custom Data", json_encode($responseData['custom_data']));
        }
    }
}

// Example: Handle specific OAuth server responses
if (isset($oSettings) && $oSettings->client_name) {
    switch (strtolower($oSettings->client_name)) {
        case 'company sso':
            // Handle company-specific SSO logic
            // Maybe assign to specific permission groups, etc.
            break;
            
        case 'partner portal':
            // Handle partner portal specific logic
            // Maybe set different default landing pages, etc.
            break;
            
        default:
            // Default OAuth handling
            break;
    }
}

// Note: This script should NOT redirect or exit unless you want to override
// the default redirect behavior. The oauth_response.php will handle the
// final redirect to the dashboard.
?>