<?php
// 2026-06-16a — Add updates.confirm_skipped so admins can acknowledge updates
// that were skipped/overridden instead of applied.
$countE = 0;

$exists = $db->query(
    "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS
     WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'updates' AND COLUMN_NAME = 'confirm_skipped'"
)->count();

if ($exists == 0) {
    $db->query("ALTER TABLE `updates` ADD COLUMN `confirm_skipped` TINYINT(1) NOT NULL DEFAULT 0");
}

include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
