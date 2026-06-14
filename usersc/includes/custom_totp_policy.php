<?php
/*
 * Custom TOTP Policy Hook
 * ------------------------
 * Loaded from users/includes/totp_enforcement.php whenever the site's TOTP
 * setting is on (Optional or Required). Modify $settings->totp here to apply
 * your own per-user / per-IP / per-page policy:
 *
 *   $settings->totp = 0;  // disable TOTP for this request
 *   $settings->totp = 1;  // optional (only enforced for users who opted in)
 *   $settings->totp = 2;  // required (force the user through TOTP)
 *
 * Available in scope: $user, $settings, $currentPage, $db.
 * Available helpers : hasPerm(), ipCheck(), and anything else loaded globally.
 *
 * This file is a no-op until you uncomment one of the blocks below.
 */

// Example 1: disable TOTP for trusted IPs (loopback, office, etc.)
//
// $trusted_ips = ['::1', '127.0.0.1'];
// if (in_array(ipCheck(), $trusted_ips, true)) {
//     $settings->totp = 0;
//     return;
// }

// Example 2: force TOTP required for admins even when the site is set to Optional
//
// if (hasPerm(2)) {
//     $settings->totp = 2;
// }
