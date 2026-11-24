<?php
/*
 * Refresh Cloudflare's edge ranges for the 'cloudflare' proxy preset.
 *
 * Add this file in the Cron Manager. It is safe to run on any schedule: it
 * only contacts cloudflare.com when the cached list is more than six days old,
 * waits 12 hours after any attempt (success or failure) before trying again,
 * and a failed or partial download never replaces the list in use.
 */
require_once __DIR__ . '/../init.php';
$db = DB::getInstance();

// Requested directly (not included by users/cron/cron.php, which gates its
// own requests): allow only the box itself, the configured cron caller by its
// real connection address, or a logged-in admin.
if (!defined('US_CRON_RUNNER')) {
    $cronIp = strtolower(trim((string)($settings->cron_ip ?? '')));
    $cronIpLoopback = in_array($cronIp, ['127.0.0.1', '::1', 'localhost'], true);
    $allowed = ClientIP::isLocal()
        || ($cronIp !== '' && $cronIp !== 'off' && !$cronIpLoopback && ClientIP::peer() === $cronIp)
        || (isset($user) && $user->isLoggedIn() && hasPerm(2));
    if (!$allowed) {
        logger("", "CronRequest", "Cloudflare range refresh DENIED from " . ClientIP::peer() . ".");
        die;
    }
}

$cfCache = ClientIP::cloudflareCacheFile();
$cfStale = !is_readable($cfCache) || filemtime($cfCache) < time() - 6 * 86400;
$cfRecentAttempt = $db->query(
    "SELECT id FROM logs WHERE logtype = 'Proxy' AND lognote LIKE 'Cron%Cloudflare ranges%' AND logdate > ?",
    [date('Y-m-d H:i:s', time() - 12 * 3600)]
)->count() > 0;

if ($cfStale && !$cfRecentAttempt) {
    $cfResult = ClientIP::refreshCloudflareRanges();
    logger(
        1,
        'Proxy',
        $cfResult['ok']
            ? "Cron refreshed Cloudflare ranges ({$cfResult['count']})"
            : 'Cron could not refresh Cloudflare ranges: ' . $cfResult['message']
    );
}
