<?php
/**
 * UserSpice Rate Limiting Helper Functions
 * Wrapper functions for common rate limiting operations
 */

/**
 * Quick rate limit check for common scenarios
 * 
 * @param string $action The action being performed
 * @param int|null $userId User ID if logged in
 * @param string|null $email Email address if applicable
 * @param array $extraIdentifiers Additional identifiers
 * @return bool True if allowed, false if rate limited
 */
function checkRateLimit($action, $userId = null, $email = null, $extraIdentifiers = []) {
    static $rateLimit = null;
    
    if ($rateLimit === null) {
        $rateLimit = new RateLimit();
    }
    
    $identifiers = $extraIdentifiers;
    
    if ($userId) {
        $identifiers['user'] = $userId;
    }
    
    if ($email) {
        $identifiers['email'] = $email;
    }
    
    return $rateLimit->check($action, $identifiers);
}

/**
 * Record a rate limit attempt
 * 
 * @param string $action The action being performed
 * @param bool $success Whether the attempt was successful
 * @param int|null $userId User ID if logged in
 * @param string|null $email Email address if applicable
 * @param array $extraIdentifiers Additional identifiers
 * @param array $metadata Optional metadata
 */
function recordRateLimit($action, $success, $userId = null, $email = null, $extraIdentifiers = [], $metadata = []) {
    static $rateLimit = null;
    
    if ($rateLimit === null) {
        $rateLimit = new RateLimit();
    }
    
    $identifiers = $extraIdentifiers;
    
    if ($userId) {
        $identifiers['user'] = $userId;
    }
    
    if ($email) {
        $identifiers['email'] = $email;
    }
    
    $rateLimit->record($action, $identifiers, $success, $metadata);
}

/**
 * Clear failed attempts after successful authentication
 * 
 * @param string $action The action that succeeded
 * @param int|null $userId User ID if logged in
 * @param string|null $email Email address if applicable
 * @param array $extraIdentifiers Additional identifiers
 */
function clearFailedRateLimit($action, $userId = null, $email = null, $extraIdentifiers = []) {
    static $rateLimit = null;
    
    if ($rateLimit === null) {
        $rateLimit = new RateLimit();
    }
    
    $identifiers = $extraIdentifiers;
    
    if ($userId) {
        $identifiers['user'] = $userId;
    }
    
    if ($email) {
        $identifiers['email'] = $email;
    }
    
    $rateLimit->clearFailed($action, $identifiers);
}

/**
 * Get rate limit status for debugging
 * 
 * @param string $action The action to check
 * @param int|null $userId User ID if logged in
 * @param string|null $email Email address if applicable
 * @param array $extraIdentifiers Additional identifiers
 * @return array Status information
 */
function getRateLimitStatus($action, $userId = null, $email = null, $extraIdentifiers = []) {
    static $rateLimit = null;
    
    if ($rateLimit === null) {
        $rateLimit = new RateLimit();
    }
    
    $identifiers = $extraIdentifiers;
    
    if ($userId) {
        $identifiers['user'] = $userId;
    }
    
    if ($email) {
        $identifiers['email'] = $email;
    }
  
    return $rateLimit->getStatus($action, $identifiers);
}

/**
 * Validate a rate-limited action and record the attempt
 * Combines check + record in one function for convenience
 * 
 * @param string $action The action being performed
 * @param int|null $userId User ID if logged in
 * @param string|null $email Email address if applicable
 * @param array $extraIdentifiers Additional identifiers
 * @return bool True if allowed, false if rate limited
 */
function validateRateLimit($action, $userId = null, $email = null, $extraIdentifiers = []) {
    $allowed = checkRateLimit($action, $userId, $email, $extraIdentifiers);
    
    if (!$allowed) {
        // Record the failed attempt
        recordRateLimit($action, false, $userId, $email, $extraIdentifiers, [
            'blocked_by_rate_limit' => true,

            'user_agent' => Server::get('HTTP_USER_AGENT'),
            'timestamp' => time()
        ]);
        
        return false;
    }
    
    return true;
}

/**
 * Handle a successful authentication - record success and clear failures
 * 
 * @param string $action The action that succeeded
 * @param int|null $userId User ID if logged in
 * @param string|null $email Email address if applicable
 * @param array $extraIdentifiers Additional identifiers
 * @param array $metadata Optional success metadata
 */
function handleAuthSuccess($action, $userId = null, $email = null, $extraIdentifiers = [], $metadata = []) {
    // Record the successful attempt
    recordRateLimit($action, true, $userId, $email, $extraIdentifiers, $metadata);
    
    // Clear previous failures
    clearFailedRateLimit($action, $userId, $email, $extraIdentifiers);
}

/**
 * Handle a failed authentication attempt
 * 
 * @param string $action The action that failed
 * @param int|null $userId User ID if applicable
 * @param string|null $email Email address if applicable
 * @param array $extraIdentifiers Additional identifiers
 * @param array $metadata Optional failure metadata
 */
function handleAuthFailure($action, $userId = null, $email = null, $extraIdentifiers = [], $metadata = []) {
    recordRateLimit($action, false, $userId, $email, $extraIdentifiers, $metadata);
}

/**
 * Create appropriate error messages for rate limiting
 * 
 * @param string $action The action that was rate limited
 * @return string User-friendly error message
 */
function getRateLimitErrorMessage($action) {
    $messages = [
        'login_attempt' => lang("RATE_LIMIT_LOGIN"),
        'totp_verify' => lang("RATE_LIMIT_TOTP"),
        'totp_verify_and_activate' => lang("RATE_LIMIT_TOTP"),
        'totp_regenerate_backup_codes' => lang("RATE_LIMIT_TOTP"),
        'passkey_verify' => lang("RATE_LIMIT_PASSKEY"),
        'passkey_store' => lang("RATE_LIMIT_PASSKEY_STORE"),
        'password_reset_request' => lang("RATE_LIMIT_PASSWORD_RESET"),
        'password_reset_submit' => lang("RATE_LIMIT_PASSWORD_RESET_SUBMIT"),
        'registration_attempt' => lang("RATE_LIMIT_REGISTRATION"),
        'email_verification' => lang("RATE_LIMIT_EMAIL_VERIFICATION"),
        'email_change' => lang("RATE_LIMIT_EMAIL_CHANGE"),
        'password_change' => lang("RATE_LIMIT_PASSWORD_CHANGE"),
    ];
    
    return $messages[$action] ?? lang("RATE_LIMIT_GENERIC");
}

/**
 * Check if rate limiting is enabled for a specific action
 * 
 * @param string $action The action to check
 * @return bool True if rate limiting is configured for this action
 */
function isRateLimitEnabled($action) {
    global $abs_us_root, $us_url_root, $rateLimits;
    
    if (!isset($rateLimits)) {
        require_once $abs_us_root . $us_url_root . 'users/includes/rate_limits.php';
    }
    
    return isset($rateLimits[$action]);
}