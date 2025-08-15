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

$db->query("ALTER TABLE `users`
ADD COLUMN IF NOT EXISTS `passkey_enabled` BOOLEAN DEFAULT 0,
ADD COLUMN IF NOT EXISTS `totp_enabled` BOOLEAN DEFAULT 0;");

$db->query("ALTER TABLE `settings`
ADD COLUMN IF NOT EXISTS `totp` BOOLEAN DEFAULT 0;");









include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
