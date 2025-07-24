<?php
//This is the upgrade file for version 2025-06-21b - Encrypt TOTP Secrets

$countE = $count = 0;

$db->query("CREATE TABLE us_oauth_server_clients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_name VARCHAR(80) NOT NULL,
    client_description VARCHAR(200),
    client_enabled TINYINT(1) DEFAULT 1,
    client_id VARCHAR(80) UNIQUE NOT NULL,
    client_secret VARCHAR(80) UNIQUE NOT NULL,
    redirect_uri VARCHAR(200) NOT NULL,
    ip_restrict VARCHAR(200)
)");

$db->query("CREATE TABLE us_oauth_server_codes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT(11),
    user_id INT(11),
    auth_code VARCHAR(80) NOT NULL,
    expires_at DATETIME NOT NULL,
    INDEX (auth_code)
)");

$db->query("CREATE TABLE us_oauth_server_tokens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT(11),
    user_id INT(11),
    access_token VARCHAR(80) NOT NULL,
    refresh_token VARCHAR(80),
    expires_at DATETIME NOT NULL,
    INDEX (access_token)
)");

$db->query("CREATE TABLE us_oauth_server_settings (
    id INT AUTO_INCREMENT PRIMARY KEY
)");
$osetQ = $db->query("SELECT * FROM us_oauth_server_settings");
if($osetQ->count() == 0){
	$db->query("TRUNCATE TABLE us_oauth_server_settings");
	$db->insert('us_oauth_server_settings', ['id'=>1]);
	$oset = $db->query("SELECT * FROM us_oauth_server_settings")->first();
}else{
	$oset = $osetQ->first();
}
if(!isset($oset->other_columns)){
	$db->query("ALTER TABLE us_oauth_server_settings ADD COLUMN other_columns TEXT");
	$db->query("ALTER TABLE us_oauth_server_settings ADD COLUMN include_tags tinyint(1) DEFAULT 1");
	$db->update('us_oauth_server_settings', 1, ['other_columns'=>'language,created']);
}

$db->query("ALTER TABLE us_oauth_server_codes ADD COLUMN used tinyint(1) DEFAULT 0");
$db->query("ALTER TABLE us_oauth_server_clients ADD COLUMN login_title VARCHAR(255) default 'Login with UserSpice'");
$db->query("ALTER TABLE us_oauth_server_clients ADD COLUMN login_form VARCHAR(255) default 'default_login.php'");
$db->query("ALTER TABLE us_oauth_server_clients ADD COLUMN login_script VARCHAR(255) default 'default_script.php'");
$db->query("ALTER TABLE us_oauth_server_codes ADD COLUMN redirect_uri tinyint(1) DEFAULT 0");

include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
