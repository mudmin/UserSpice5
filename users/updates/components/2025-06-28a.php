<?php
//This is the upgrade file for version 2025-06-21b - Encrypt TOTP Secrets

$countE = $count = 0;
$db->query("CREATE TABLE us_oauth_client_login_options (
    id INT AUTO_INCREMENT PRIMARY KEY,
	oauth tinyint(1) DEFAULT 0,
	client_name VARCHAR(255) default 'UserSpice Login',
    client_icon varchar(255) default 'oauth.png',
    client_id VARCHAR(80) UNIQUE,
    client_secret VARCHAR(80) UNIQUE,
    redirect_uri VARCHAR(200) 
);");
$db->query("ALTER TABLE settings ADD COLUMN oauth tinyint(1) default 0");
$db->query("ALTER TABLE us_oauth_client_login_options ADD COLUMN server_url varchar(255)");
$db->query("ALTER TABLE us_oauth_client_login_options ADD COLUMN login_title VARCHAR(255) default 'UserSpice'");
$db->query("ALTER TABLE us_oauth_client_login_options ADD COLUMN login_script VARCHAR(255) default 'default_script.php'");


$db->query("CREATE TABLE us_oauth_client_login_tokens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    access_token VARCHAR(255) NOT NULL,
    refresh_token VARCHAR(255),
    expires_at DATETIME NOT NULL,
    scope VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);");

$db->query("CREATE TABLE us_oauth_client_logins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
	new_user tinyint(1) DEFAULT 0,
    ts DATETIME DEFAULT CURRENT_TIMESTAMP
);");

$db->query("ALTER TABLE us_oauth_client_login_options ADD COLUMN server_target varchar(255) default 'users/auth/' AFTER server_url");

include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
