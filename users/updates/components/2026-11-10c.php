<?php
// 2026-11-10c — settings.cron_ip_source: which address users/cron/cron.php
// compares with settings.cron_ip. 'peer' = the connection address, 'resolved' =
// the visitor resolved through trusted proxies (the behavior before this update).
// The two only differ for a remote cron_ip while proxy mode is on, so those
// installs keep 'resolved' and every other install gets 'peer' with no change.
$countE = 0;

$exists = $db->query(
    "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS
     WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'settings' AND COLUMN_NAME = 'cron_ip_source'"
)->count();

if ($exists == 0) {
    $db->query("ALTER TABLE `settings` ADD COLUMN `cron_ip_source` VARCHAR(10) NOT NULL DEFAULT 'peer'");
    if ($db->error()) {
        $countE++;
        logger(1, 'System Updates', '2026-11-10c: ' . $db->errorString());
    } else {
        $cronIp = strtolower(trim((string)($settings->cron_ip ?? '')));
        $remoteCronIp = $cronIp !== '' && $cronIp !== 'off' && !in_array($cronIp, ['127.0.0.1', '::1', 'localhost'], true);
        $proxyOn = !empty(ClientIP::config()['enabled']);
        if ($remoteCronIp && $proxyOn) {
            $db->update('settings', 1, ['cron_ip_source' => 'resolved']);
            logger(1, 'System Updates', "2026-11-10c: cron_ip is matched against the resolved visitor, as before (proxy mode is on). Review it on the Proxy & CDN page.");
        }
    }
}

include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
