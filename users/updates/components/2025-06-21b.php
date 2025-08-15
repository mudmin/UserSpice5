<?php
//This is the upgrade file for version 2025-06-21b - Encrypt TOTP Secrets

$countE = $count = 0;

$totpKeyFile = $abs_us_root . $us_url_root . 'usersc/includes/totp_key.php';
totp_init_encryption($totpKeyFile,true);
$db->update("settings",1,["announce"=>"2025-06-21 00:00:00"]); 

include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
