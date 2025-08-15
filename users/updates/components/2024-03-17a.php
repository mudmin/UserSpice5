<?php
$countE = 0;


$db->query("CREATE TABLE `plg_social_logins` (
    `id` INT NOT NULL AUTO_INCREMENT, 
    `plugin` VARCHAR(50) NOT NULL, 
    `provider` VARCHAR(50) NOT NULL, 
    `enabledsetting` VARCHAR(50) NOT NULL, 
    `image` VARCHAR(255) NOT NULL, 
    `link` VARCHAR(255) NOT NULL, 
    `built_in` TINYINT(1) default 0,
    PRIMARY KEY (`id`));
    ");

$db->query("CREATE TABLE `us_email_logins` (
    `id` INT NOT NULL AUTO_INCREMENT, 
    `user_id` int(11) NOT NULL,  
    `vericode` VARCHAR(50) NOT NULL, 
    `success` TINYINT(1) default 0,
    `login_ip` VARCHAR(50) NOT NULL,
    `login_date` DATETIME NOT NULL,
    `expired` TINYINT(1) default 0,
    PRIMARY KEY (`id`));
 ");

$db->query("CREATE TABLE `us_login_fails` (
    `id` INT NOT NULL AUTO_INCREMENT, 
    `login_method` VARCHAR(50) NOT NULL,
    `ip` VARCHAR(50) NOT NULL,
    `ts` DATETIME NOT NULL,
    
    PRIMARY KEY (`id`));
 ");

$db->query("ALTER TABLE settings ADD COLUMN no_passwords tinyint (1) default 0");
$db->query("ALTER TABLE settings ADD COLUMN email_login tinyint (1) default 0");




include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
