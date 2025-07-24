<?php
// Before User Creation Script - EXAMPLE
// This script runs before a new user is created through OAuth
// 
// Rename this file to 'before_user_creation.php' to activate it
//
// The most common use case is to prevent new user creation entirely
// and require users to register locally first

// Available variables:
// $userData - array containing user data from OAuth response
// $responseData - full OAuth response data
// $oSettings - OAuth client configuration

// Example: Prevent new user creation entirely
/*
usError("New user accounts must be created locally. Please register first, then link your OAuth account.");
Redirect::to($us_url_root . 'users/join.php');
exit;
*/

// Example: Only allow users from specific email domains
/*
$allowedDomains = ['company.com', 'partner.org', 'trusted-client.net'];
$userEmail = $userData['email'] ?? '';
$emailDomain = substr(strrchr($userEmail, "@"), 1);

if (!in_array($emailDomain, $allowedDomains)) {
    usError("Only users from approved organizations can register via " . ($oSettings->client_name ?? 'OAuth') . ".");
    Redirect::to($us_url_root . 'users/login.php');
    exit;
}
*/

// Example: Require specific tags/roles from OAuth server
/*
if (isset($responseData['tags']) && is_array($responseData['tags'])) {
    $userTags = array_column($responseData['tags'], 'tag_name');
    $requiredTags = ['employee', 'contractor', 'partner'];
    
    $hasRequiredTag = false;
    foreach ($requiredTags as $requiredTag) {
        if (in_array($requiredTag, $userTags)) {
            $hasRequiredTag = true;
            break;
        }
    }
    
    if (!$hasRequiredTag) {
        usError("You must have appropriate permissions to register via " . ($oSettings->client_name ?? 'OAuth') . ".");
        Redirect::to($us_url_root . 'users/login.php');
        exit;
    }
} else {
    // No tags provided - maybe require them?
    usError("User role information is required for OAuth registration.");
    Redirect::to($us_url_root . 'users/login.php');
    exit;
}
*/

// Example: Log the attempt for security monitoring
/*
logger(1, "OAuth User Creation", "User creation attempt from: " . ($userData['email'] ?? 'unknown') . " via " . ($oSettings->client_name ?? 'OAuth'));
*/

// Example: Set different default permission levels based on OAuth provider
/*
if (isset($oSettings->client_name)) {
    switch (strtolower($oSettings->client_name)) {
        case 'company sso':
            // Company employees get higher default permissions
            // This would need to be implemented in the main user creation code
            break;
            
        case 'partner portal':
            // Partners get limited permissions
            break;
            
        default:
            // Regular OAuth users get basic permissions
            break;
    }
}
*/

// If this script completes without redirecting or exiting,
// the user creation process will continue normally
?>