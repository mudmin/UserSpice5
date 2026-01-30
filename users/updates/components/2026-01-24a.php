<?php
// Add lang_key to pages table for multi-language page titles

$countE = $count = 0;
$db->query("ALTER TABLE pages ADD COLUMN lang_key VARCHAR(100) DEFAULT NULL");

// Extend vericode column to accommodate HMAC-SHA256 hashed tokens (64 hex chars)
$db->query("ALTER TABLE us_email_logins MODIFY COLUMN vericode VARCHAR(128)");
$db->query("ALTER TABLE us_email_logins MODIFY COLUMN verification_code VARCHAR(128)");

include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
