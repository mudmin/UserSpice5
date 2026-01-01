<?php
require_once '../../../users/init.php';

// Check if OAuth is enabled
if ($settings->oauth != 1) {
    usError('OAuth login is disabled');
    Redirect::to($us_url_root . 'users/login.php');
    exit;
}

// Get the OAuth client configuration from session
$oauthClientId = $_SESSION['oauth_client_id'] ?? null;
if (!$oauthClientId) {
    // Fallback: get any active client (backward compatibility)
    $oSettingsQ = $db->query("SELECT * FROM us_oauth_client_login_options WHERE oauth = 1 ORDER BY id ASC LIMIT 1");
} else {
    $oSettingsQ = $db->query("SELECT * FROM us_oauth_client_login_options WHERE id = ? AND oauth = 1", [$oauthClientId]);
}

if ($oSettingsQ->count() == 0) {
    usError('OAuth client configuration not found');
    Redirect::to($us_url_root . 'users/login.php');
    exit;
}
$oSettings = $oSettingsQ->first();

$authCode = $_GET['code'] ?? null;
$state = $_GET['state'] ?? null;
$response = $_GET['response'] ?? null;
$error = $_GET['error'] ?? null;

// Handle OAuth errors
if ($error) {
    logger(1, "OAuth Client Error", "OAuth error received: " . $error);
    usError('OAuth authentication failed: ' . htmlspecialchars($error));
    Redirect::to($us_url_root . 'users/login.php');
    exit;
}

// Verify required parameters
if (!$authCode) {
    logger(1, "OAuth Client Error", "Authorization code missing from OAuth response");
    usError('OAuth authentication failed: Missing authorization code');
    Redirect::to($us_url_root . 'users/login.php');
    exit;
}

// Verify the state to prevent CSRF attacks
if (!$state || $state !== ($_SESSION['oauth_state'] ?? '')) {
    logger(1, "OAuth Client Error", "Invalid or missing state parameter");
    usError('OAuth authentication failed: Invalid state parameter');
    Redirect::to($us_url_root . 'users/login.php');
    exit;
}

// Clear the state and client info from session
unset($_SESSION['oauth_state']);
unset($_SESSION['oauth_client_id']);

// Decode response data if present
$responseData = null;
if ($response) {
    $responseData = json_decode(base64_decode($response), true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        logger(1, "OAuth Client Error", "Failed to decode response data: " . json_last_error_msg());
        $responseData = null;
    }
}

// Exchange the authorization code for an access token
$tokenUrl = rtrim($oSettings->server_url, '/') . '/' . trim($oSettings->server_target, '/') . '/';
$tokenData = exchangeCodeForToken($tokenUrl, $oSettings->client_id, $oSettings->client_secret, $authCode, $oSettings->redirect_uri);

if (isset($tokenData['error'])) {
    logger(1, "OAuth Client Error", "Token exchange failed: " . ($tokenData['error'] ?? 'Unknown error'));
    usError('OAuth authentication failed during token exchange');
    Redirect::to($us_url_root . 'users/login.php');
    exit;
}

// Combine token data with user data from response
$userData = $responseData['userdata'] ?? [];
if (empty($userData['email'])) {
    logger(1, "OAuth Client Error", "No email address in OAuth response");
    usError('OAuth authentication failed: No email address provided');
    Redirect::to($us_url_root . 'users/login.php');
    exit;
}

// Check if user exists
$user = new User();
$existingUserQ = $db->query("SELECT * FROM users WHERE email = ?", [$userData['email']]);
$existingUserC = $existingUserQ->count();

if ($existingUserC > 0) {
    // Existing user - log them in
    $existingUser = $existingUserQ->first();

    // Update user data if instructed
    if (isset($responseData['instructions']['updateUserData']) && $responseData['instructions']['updateUserData'] == true) {
        updateUserData($existingUser->id, $responseData);
    }

    // Handle tags if present
    if (isset($responseData['tags'])) {
        storeUserTags($existingUser->id, $responseData);
    }

    // Log the login
    $log = [
        'user_id' => $existingUser->id,
        'new_user' => 0
    ];
    $db->insert('us_oauth_client_logins', $log);

    // Execute custom login script if specified
    if (!empty($oSettings->login_script)) {
        $loginScriptBaseDir = $abs_us_root . $us_url_root . 'usersc/oauth_client/login_scripts/';
        $safeLoginScriptPath = sanitizePath($oSettings->login_script, $loginScriptBaseDir);
        if ($safeLoginScriptPath) {
            include $safeLoginScriptPath;
        }
    }

    // Log the user in
    $sessionName = Config::get('session/session_name');
    Session::put($sessionName, $existingUser->id);

    // Execute custom login script if it exists
    if (file_exists($abs_us_root . $us_url_root . 'usersc/scripts/custom_login_script.php')) {
        include $abs_us_root . $us_url_root . 'usersc/scripts/custom_login_script.php';
    }

    // Set login method for TOTP/security purposes
    if (function_exists('setLoginMethod')) {
        setLoginMethod('oauth');
    }

    logger($existingUser->id, "OAuth Client Login", "User logged in via OAuth from: " . $oSettings->client_name);

    // Redirect to dashboard
    Redirect::to($us_url_root . $settings->redirect_uri_after_login);
    exit;
} else {
    // New user - create account
    $userId = createNewUser($userData, $responseData, $oSettings);
    if ($userId) {
        logger($userId, "OAuth Client Registration", "New user created via OAuth from: " . $oSettings->client_name);
        // User should be redirected by createNewUser function
    } else {
        usError('Failed to create user account');
        Redirect::to($us_url_root . 'users/login.php');
    }
}

/**
 * Update existing user data from OAuth response
 */
function updateUserData($userId, $responseData)
{
    global $db;

    if (!isset($responseData['userdata'])) {
        return;
    }

    $existingQ = $db->query("SELECT * FROM users WHERE id = ?", [$userId]);
    if ($existingQ->count() == 0) {
        return;
    }

    $existing = $existingQ->first();
    $userData = $responseData['userdata'];
    $fields = [];

    foreach ($userData as $key => $value) {
        // Skip protected fields
        if (in_array($key, ['email', 'id', 'username'])) {
            continue;
        }

        // Only update if field exists and value has changed
        if (isset($existing->$key) && $existing->$key != $value) {
            $fields[$key] = $value;
        }
    }

    if (count($fields) > 0) {
        $db->update('users', $userId, $fields);
        logger($userId, "OAuth Client Update", "User data updated from OAuth: " . implode(', ', array_keys($fields)));
    }
}

/**
 * Create a new user from OAuth data
 */
function createNewUser($userData, $responseData, $oSettings)
{
    global $db, $abs_us_root, $us_url_root, $settings;

    // Check if user creation from OAuth is allowed
    if (file_exists($abs_us_root . $us_url_root . 'usersc/oauth_client/assets/before_user_creation.php')) {
        include $abs_us_root . $us_url_root . 'usersc/oauth_client/assets/before_user_creation.php';
    }

    $user = new User();
    $fields = [
        'email' => $userData['email'],
        'username' => $userData['email'], // Use email as username
        'fname' => $userData['fname'] ?? '',
        'lname' => $userData['lname'] ?? '',
        'password' => password_hash(randomstring(20), PASSWORD_BCRYPT, ['cost' => 14]),
        'permissions' => 1,
        'join_date' => date('Y-m-d H:i:s'),
        'email_verified' => 1,
        'vericode' => randomstring(12),
        'vericode_expiry' => date('Y-m-d H:i:s'),
        'oauth_tos_accepted' => true,
        'language' => 'en-US',
        'active' => 1
    ];

    $theNewId = $user->create($fields);
    if (!$theNewId) {
        logger(1, "OAuth Client Error", "Failed to create new user account");
        return false;
    }

    // Log the user in immediately
    $sessionName = Config::get('session/session_name');
    Session::put($sessionName, $theNewId);

    // Update user data from OAuth response
    updateUserData($theNewId, $responseData);

    // Handle tags if present
    if (isset($responseData['tags'])) {
        storeUserTags($theNewId, $responseData);
    }

    // Log the registration
    $log = [
        'user_id' => $theNewId,
        'new_user' => 1
    ];
    $db->insert('us_oauth_client_logins', $log);

    // Execute during user creation script
    if (file_exists($abs_us_root . $us_url_root . 'usersc/scripts/during_user_creation.php')) {
        include $abs_us_root . $us_url_root . 'usersc/scripts/during_user_creation.php';
    }

    // Execute custom login script if specified
    if (!empty($oSettings->login_script)) {
        $loginScriptBaseDir = $abs_us_root . $us_url_root . 'usersc/oauth_client/login_scripts/';
        $safeLoginScriptPath = sanitizePath($oSettings->login_script, $loginScriptBaseDir);
        if ($safeLoginScriptPath) {
            include $safeLoginScriptPath;
        }
    }
    // Execute custom login script if it exists
    if (file_exists($abs_us_root . $us_url_root . 'usersc/scripts/custom_login_script.php')) {
        include $abs_us_root . $us_url_root . 'usersc/scripts/custom_login_script.php';
    }

    // Set login method for TOTP/security purposes
    if (function_exists('setLoginMethod')) {
        setLoginMethod('oauth');
    }

    // Redirect to dashboard
    Redirect::to($us_url_root . $settings->redirect_uri_after_login);
    return $theNewId;
}

/**
 * Store user tags from OAuth response
 */
function storeUserTags($userId, $responseData)
{
    global $db;

    // Check if we should update tags and if tags plugin is active
    if (!isset($responseData['instructions']['updateTags']) || !$responseData['instructions']['updateTags']) {
        return;
    }

    if (!isset($responseData['tags']) || !is_array($responseData['tags'])) {
        return;
    }

    // Check if tags plugin tables exist
    $tagTableCheck = $db->query("SHOW TABLES LIKE 'plg_tags'")->count();
    if ($tagTableCheck == 0) {
        logger($userId, "OAuth Client Warning", "Tags data received but tags plugin not installed");
        return;
    }

    $tags = $responseData['tags'];
    $createTagIfNeeded = $responseData['instructions']['createTagIfNeeded'] ?? false;
    $removeTagIfNotSpecified = $responseData['instructions']['removeTagIfNotSpecified'] ?? false;

    // Get all existing tags for this user
    $existingTagsQ = $db->query("SELECT plg_tags.id, plg_tags.tag FROM plg_tags
                                 JOIN plg_tags_matches ON plg_tags.id = plg_tags_matches.tag_id
                                 WHERE plg_tags_matches.user_id = ?", [$userId]);
    $existingTags = $existingTagsQ->results();
    $existingTagNames = array_column($existingTags, 'tag', 'id');

    $newTagNames = array_column($tags, 'tag_name');
    $newTagNames = array_map('strtolower', $newTagNames);

    // Add new tags and associate them with the user
    foreach ($tags as $tag) {
        $tagName = strtolower($tag['tag_name']); // Normalize to lowercase for comparison

        // Check if the tag exists in the plg_tags table
        $tagExistsQ = $db->query("SELECT * FROM plg_tags WHERE LOWER(tag) = ?", [$tagName]);
        if ($tagExistsQ->count() > 0) {
            $tagId = $tagExistsQ->first()->id;
        } else {
            if ($createTagIfNeeded) {
                // Insert new tag into plg_tags
                $db->insert('plg_tags', ['tag' => $tag['tag_name']]);
                $tagId = $db->lastId();
            } else {
                // Skip if we're not allowed to create new tags
                continue;
            }
        }

        // Check if the tag is already associated with the user
        $tagMatchQ = $db->query("SELECT * FROM plg_tags_matches WHERE tag_id = ? AND user_id = ?", [$tagId, $userId]);
        if ($tagMatchQ->count() == 0) {
            // Associate the tag with the user
            $db->insert('plg_tags_matches', ['tag_id' => $tagId, 'tag_name' => $tag['tag_name'], 'user_id' => $userId]);
        }
    }

    // Remove old tags if instructed
    if ($removeTagIfNotSpecified) {
        foreach ($existingTags as $existingTag) {
            if (!in_array(strtolower($existingTag->tag), $newTagNames)) {
                // Remove the tag association from plg_tags_matches
                $db->query("DELETE FROM plg_tags_matches WHERE tag_id = ? AND user_id = ?", [$existingTag->id, $userId]);
            }
        }
    }

    logger($userId, "OAuth Client Tags", "Tags updated from OAuth response");
}

/**
 * Exchange authorization code for access token
 */
function exchangeCodeForToken($tokenUrl, $clientId, $clientSecret, $authCode, $redirectUri)
{
    $data = [
        'grant_type' => 'authorization_code',
        'code' => $authCode,
        'redirect_uri' => $redirectUri,
        'client_id' => $clientId,
        'client_secret' => $clientSecret
    ];

    logger(1, "OAuth Client", "Sending token request to: $tokenUrl");

    $ch = curl_init($tokenUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 3);

    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);

    if ($result === FALSE) {
        if (PHP_VERSION_ID < 80500) {
            curl_close($ch);
        }

        logger(1, "OAuth Client Error", "cURL error: $curlError");
        return ['error' => 'Network error: ' . $curlError];
    }

    if (PHP_VERSION_ID < 80500) {
        curl_close($ch);
    }

    logger(1, "OAuth Client", "Token exchange response - HTTP Code: $httpCode");

    if ($httpCode !== 200) {
        logger(1, "OAuth Client Error", "Token exchange failed - HTTP $httpCode: $result");
        return [
            'error' => 'Token exchange failed with HTTP code: ' . $httpCode,
            'response' => $result
        ];
    }

    $tokenData = json_decode($result, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        logger(1, "OAuth Client Error", "Invalid JSON response from token endpoint: " . json_last_error_msg());
        return ['error' => 'Invalid response from OAuth server'];
    }

    return $tokenData;
}

/**
 * Store the access token for future use
 */
function storeAccessToken($userId, $accessToken, $expiresIn)
{
    global $db;

    $expiresAt = date('Y-m-d H:i:s', time() + $expiresIn);
    $db->query(
        "INSERT INTO us_oauth_client_login_tokens (user_id, access_token, expires_at) 
                VALUES (?, ?, ?) 
                ON DUPLICATE KEY UPDATE access_token = VALUES(access_token), expires_at = VALUES(expires_at)",
        [$userId, $accessToken, $expiresAt]
    );
}
