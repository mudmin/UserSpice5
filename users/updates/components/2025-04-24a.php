<?php
$countE = 0;

$db->query("CREATE TABLE `us_passkeys` (
	`id` int(11) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `user_id` int(11) default 0,
	`credentialId` varchar(255) default NULL,   
	`publicKey` varchar(255) default NULL,
	`created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `times_used` int(1) default 0,
    `last_used` timestamp NULL DEFAULT NULL,
    `last_ip` varchar(255) default NULL
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
  ");

  $db->query("ALTER TABLE us_passkeys ADD COLUMN `passkey_note` varchar(255) DEFAULT NULL AFTER `last_ip`");
  $db->query("ALTER TABLE settings ADD COLUMN `passkeys` tinyint(1) DEFAULT 0");
include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
