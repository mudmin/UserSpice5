<?php
// 2026-05-30a — Add us_menus.sticky for the UltraMenu horizontal-sticky option.
$countE = 0;

$exists = $db->query(
    "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS
     WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'us_menus' AND COLUMN_NAME = 'sticky'"
)->count();

if ($exists == 0) {
    $db->query("ALTER TABLE `us_menus` ADD COLUMN `sticky` TINYINT(1) NOT NULL DEFAULT 0 AFTER `justify`");
}

include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
