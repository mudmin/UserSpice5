<?php
// 2026-11-10b — us_oauth_server_clients.cors_origins: browser origins allowed
// to call the token and userinfo endpoints (public clients only). Empty for
// every existing client, so no CORS headers are sent until an admin adds one.
$countE = 0;

$tableExists = $db->query(
    "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES
     WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'us_oauth_server_clients'"
)->count();
$exists = $db->query(
    "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS
     WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'us_oauth_server_clients' AND COLUMN_NAME = 'cors_origins'"
)->count();

if ($tableExists && $exists == 0) {
    $db->query("ALTER TABLE us_oauth_server_clients ADD COLUMN cors_origins VARCHAR(1000) NOT NULL DEFAULT ''");
    if ($db->error()) {
        $countE++;
        logger(1, 'System Updates', '2026-11-10b: ' . $db->errorString());
    }
}

include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
