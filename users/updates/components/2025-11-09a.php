<?php
$countE = $count = 0;
$db->query("ALTER TABLE settings ADD COLUMN max_users_dt int(11) NOT NULL DEFAULT 2000");
$db->query("ALTER TABLE settings ADD COLUMN social_login_location tinyint(1) default 1");
if(isset($settings->uman_search) && $settings->uman_search == 0){
    $db->query("UPDATE settings SET max_users_dt = 0");
}
$db->query("ALTER TABLE settings DROP COLUMN uman_search");

if (!isset($usespice_nonce)) {
    $file = $abs_us_root . $us_url_root . "users/init.php";

    if (file_exists($file)) {
        $contents = file_get_contents($file);
        
       
        $search_pattern = 'require_once $abs_us_root.$us_url_root."users/includes/loader.php";';
            
 
        $code_to_insert = "\n" .
          '$usespice_nonce = base64_encode(random_bytes(16));' . "\n" .
          "// Forces SSL verification in cURL requests to UserSpice API\n" .
          "// Will most likely break on localhost or self-signed certificates\n" .
          "define('EXTRA_CURL_SECURITY', false); \n";
          
        $replacement = $code_to_insert . $search_pattern;
        $new_contents = str_replace($search_pattern, $replacement, $contents);

        if ($new_contents !== $contents) {
            file_put_contents($file, $new_contents);
        }
    }
}

include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
