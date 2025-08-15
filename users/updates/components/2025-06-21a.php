<?php
//This is the upgrade file for version 2025-06-21b - Encrypt TOTP Secrets

$countE = $count = 0;

//drop old table
$db->query("DROP TABLE IF EXISTS us_totp_secrets;");

$db->query("CREATE TABLE us_totp_secrets (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL UNIQUE,
  secret_enc VARCHAR(255) NOT NULL,        -- base64(nonce+cipher)
  backup_codes_h TEXT,                     -- JSON of bcrypt hashes
  verified TINYINT(1) NOT NULL DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");





include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
