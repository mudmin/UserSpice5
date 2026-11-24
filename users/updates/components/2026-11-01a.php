<?php
// 2026-11-01a — Add settings.proxy_presets (comma-separated ClientIP preset
// names, e.g. "cloudflare"). Defaults to empty, so existing installs resolve
// client IPs exactly as before; presets only apply once an admin enables them
// on the Proxy & CDN page (and only while behind_reverse_proxy is on).
$countE = 0;

$exists = $db->query(
    "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS
     WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'settings' AND COLUMN_NAME = 'proxy_presets'"
)->count();

if ($exists == 0) {
    $db->query("ALTER TABLE `settings` ADD COLUMN `proxy_presets` VARCHAR(255) NOT NULL DEFAULT ''");
}

include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
