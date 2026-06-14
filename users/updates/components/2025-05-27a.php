<?php
$countE = 0;


$db->query("CREATE TABLE IF NOT EXISTS `us_totp_secrets` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `secret` VARCHAR(255) NOT NULL,
  `verified` BOOLEAN NOT NULL DEFAULT 0,
  `backup_codes` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id_unique` (`user_id`),
  CONSTRAINT `fk_us_totp_secrets_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;);
    ");

// users.passkey_enabled / users.totp_enabled columns intentionally NOT added.
// Passkey and TOTP "enabled" state are read from the authoritative tables
// (us_passkeys and us_totp_secrets.verified), so these denormalized flags are
// unused — and dropped outright by migration 2026-05-25a. Previously this was:
//   $db->query("ALTER TABLE `users`
//   ADD COLUMN `passkey_enabled` BOOLEAN DEFAULT 0,
//   ADD COLUMN `totp_enabled` BOOLEAN DEFAULT 0;");

$db->query("ALTER TABLE `settings`
ADD COLUMN `totp` BOOLEAN DEFAULT 0;");









include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
