<?php

/**
 * UserSpice Rate Limiting Configuration
 * Framework defaults - can be overridden in usersc/includes/rate_limits.php
 * for instance 
 * $rateLimits['login_attempt']['ip_max'] = 100;
 */


$rateLimits = [
    // Authentication attempts
    'login_attempt' => [
        // Limits based on IP address. Set higher to avoid blocking legitimate users on shared networks (e.g., universities, corporate NATs).
        'ip_max' => 10000,           // Max FAILED attempts from a single IP.
        'ip_window' => 900,       // 15-minute window for the IP failure count to reset.

        // Limits based on User ID/Username. Set lower to quickly block targeted brute-force attacks on a specific account.
        'user_max' => 5000,          // Max FAILED attempts for a single user account.
        'user_window' => 300,     // 5-minute window for a user's failure count to reset. A shorter window allows legitimate users to retry sooner.

        // A high-level circuit breaker for a single misbehaving identifier (IP or User). This is a limit on TOTAL attempts (successful + failed).
        'total_max' => 15000,        // Max TOTAL attempts from one IP or for one User. Prevents a single identifier from spamming the system.
        'total_window' => 900     // 15-minute window, same as the IP failure window.
    ],


    // Multi-Factor Authentication (MFA)
    'totp_verify' => [
        'ip_max' => 5000,
        'ip_window' => 600,
        'user_max' => 2500,
        'user_window' => 600,
        'total_max' => 10000,
        'total_window' => 600
    ],

    'totp_verify_and_activate' => [
        'ip_max' => 5000,
        'ip_window' => 3600,
        'user_max' => 2500,
        'user_window' => 3600,
        'total_max' => 10000,
        'total_window' => 3600
    ],

    'totp_regenerate_backup_codes' => [
        'ip_max' => 5000,
        'ip_window' => 3600,
        'user_max' => 2500,
        'user_window' => 3600,
        'total_max' => 10000,
        'total_window' => 3600
    ],

    // Passkey operations
     'passkey_register' => [ 
        'ip_max' => 5000,  
        'ip_window' => 3600,                       
        'user_max' => 2500, 
        'user_window' => 3600,
        'total_max'=> 10000,
        'total_window'=> 3600 ],

    'passkey_verify' => [
        'ip_max'         => 5000,
        'ip_window'   => 600,   // 30 fails / 10 min / IP
        'user_max'       => 2500,
        'user_window' => 600,   // 10 fails / 10 min / account
        'credential_max' => 2500,
        'credential_window' => 900, // 6 fails / 15 min / cred
        'total_max'      => 10000,
        'total_window' => 900
    ],
    'passkey_store' => [
        'ip_max'   => 5000,
        'ip_window'   => 3600,
        'user_max' => 2500,
        'user_window' => 3600,
        'total_max' => 10000,
        'total_window' => 3600
    ],

    // Password and account recovery
    'password_reset_request' => [
        'ip_max' => 5000,
        'ip_window' => 3600,
        'email_max' => 2500,
        'email_window' => 3600,
        'total_max' => 10000,
        'total_window' => 3600
    ],

    'password_reset_submit' => [
        'ip_max' => 5000,
        'ip_window' => 1800,
        'token_max' => 2500,
        'token_window' => 1800,
        'total_max' => 10000,
        'total_window' => 1800
    ],

    // Registration and verification
    'registration_attempt' => [
        'ip_max' => 10000,
        'ip_window' => 3600,
        'total_max' => 10000,
        'total_window' => 3600
    ],

    'email_verification' => [
        'ip_max' => 5000,
        'ip_window' => 3600,
        'email_max' => 2500,
        'email_window' => 3600,
        'total_max' => 10000,
        'total_window' => 3600
    ],

    // Development/testing - very lenient
    'diagnostics' => [
        'ip_max' => 50000,
        'ip_window' => 300,
        'user_max' => 50000,
        'user_window' => 300,
        'total_max' => 100000,
        'total_window' => 300
    ]
];



// Allow usersc customization
if (file_exists($abs_us_root . $us_url_root . 'usersc/includes/rate_limits.php')) {
    include $abs_us_root . $us_url_root . 'usersc/includes/rate_limits.php';
}

// Validate configuration
foreach ($rateLimits as $action => $limits) {
    if (!is_array($limits)) {
        throw new Exception("Rate limit configuration for '$action' must be an array");
    }

    // Ensure required keys exist
    $requiredKeys = ['ip_max', 'ip_window'];
    foreach ($requiredKeys as $key) {
        if (!isset($limits[$key])) {
            throw new Exception("Rate limit configuration for '$action' missing required key: $key");
        }
    }
}
