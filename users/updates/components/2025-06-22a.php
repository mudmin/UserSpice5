<?php
//This is the upgrade file for version 2025-06-21b - Encrypt TOTP Secrets

$countE = $count = 0;

$db->query("ALTER TABLE settings ADD COLUMN oauth_server tinyint(1) default 0");

include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
