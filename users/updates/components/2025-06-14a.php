<?php
//This is the upgrade file for version 2025-06-14a


$countE = $count = 0;

// 0 = disabled, 1 = enabled, 2 = required
$db->query("ALTER TABLE `settings` ADD COLUMN  `totp` tinyint(1) DEFAULT 0;");
$db->query("ALTER TABLE `settings` modify COLUMN `container_open_class` text");


include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
