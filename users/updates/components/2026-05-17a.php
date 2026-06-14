<?php
// 2026-05-17a — Core ReAuth (step-up authentication) feature.
// - Creates us_reauth_log, an audit trail of re-authentication events.
// - Adds settings.reauth_timeout, the grace window (minutes) for forceReauth().
// - Drops the now-retired users.pin column (the PIN admin-verify flow has
//   been replaced by the unified reauth decision tree).
$countE = 0;

$db->query("CREATE TABLE IF NOT EXISTS `us_reauth_log` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `purpose` VARCHAR(64) DEFAULT NULL,
  `method` VARCHAR(32) DEFAULT NULL,
  `success` TINYINT(1) NOT NULL DEFAULT 0,
  `ip` VARCHAR(45) DEFAULT NULL,
  `user_agent` VARCHAR(255) DEFAULT NULL,
  `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `created` (`created`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
if ($db->error()) {
  $countE++;
  $errors[] = "us_reauth_log table: " . $db->errorString();
}

$db->query("ALTER TABLE `settings` ADD COLUMN `reauth_timeout` INT(9) NOT NULL DEFAULT 15;");
if ($db->error()) {
  $countE++;
  $errors[] = "settings.reauth_timeout column: " . $db->errorString();
}

// PIN-based admin verification has been retired in favor of the unified
// reauth flow. Dropping the column is cleanup only — a failure here (e.g. the
// column never existed on this install) must not block the migration.
$db->query("ALTER TABLE `users` DROP COLUMN IF EXISTS `pin`;");

// Remove the retired PIN admin-verification pages if they are still on disk.
// File cleanup only — failure here must not block the migration.
foreach (['users/admin_pin.php', 'users/admin_verify.php'] as $retiredPage) {
  $retiredPath = $abs_us_root . $us_url_root . $retiredPage;
  if (file_exists($retiredPath)) {
    if (@unlink($retiredPath)) {
      logger(1, 'System Updates', "Removed retired page {$retiredPage}.");
    } else {
      logger(1, 'System Updates', "Could not remove retired page {$retiredPage} - check file permissions.");
    }
  }
}

include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
