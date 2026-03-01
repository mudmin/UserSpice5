<?php
/**
 * Shared rate limit health score calculation
 * Used by both the Security Dashboard and Rate Limiting pages for consistency
 */
if (!function_exists('calculateRateLimitHealth')) {
    function calculateRateLimitHealth($rateLimits, $using_defaults, $proxy_enabled, $proxy_count)
    {
        $score = 0;

        // Not using defaults (40 points)
        if (!$using_defaults) $score += 40;

        // Key actions have reasonable limits (30 points)
        $key_actions = ['login_attempt', 'password_reset_request', 'registration_attempt'];
        foreach ($key_actions as $action) {
            if (isset($rateLimits[$action]['ip_max']) && $rateLimits[$action]['ip_max'] < 1000) {
                $score += 10;
            }
        }

        // Proxy configuration (20 points)
        if ($proxy_enabled && $proxy_count > 0) {
            $score += 20;
        } elseif (!$proxy_enabled) {
            $score += 15; // Not behind proxy is also fine
        }

        // Rate limiting enabled (10 points)
        if (class_exists('RateLimit')) $score += 10;

        return min($score, 100);
    }
}
