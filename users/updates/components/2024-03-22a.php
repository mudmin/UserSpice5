<?php
$countE = 0;


$db->query("CREATE TABLE `us_password_strength` (
    `id` INT NOT NULL AUTO_INCREMENT, 
    `enforce_rules` TINYINT(1) default 0,
    `meter_active` TINYINT(1) default 0,
    `min_length` INT(11) default 8,
    `max_length` INT(11) default 24,
    `require_lowercase` TINYINT(1) default 1,
    `require_uppercase` TINYINT(1) default 1,
    `require_numbers` TINYINT(1) default 1,
    `require_symbols` TINYINT(1) default 1,
    `min_score` INT(11) default 5,
    PRIMARY KEY (`id`));
    ");

$test = $db->query("SELECT * FROM us_password_strength")->count();
if($test < 1){
    $db->query("TRUNCATE TABLE us_password_strength");
    $fields = [
        'enforce_rules' => 0,
        'meter_active' => 1,
        'min_length' => $settings->min_pw,
        'max_length' => $settings->max_pw,
        'require_lowercase' => 1,
        'require_uppercase' => $settings->req_cap,
        'require_numbers' => $settings->req_num,
        'require_symbols' => 1,
        'min_score' => 75
    ];
    $db->insert('us_password_strength', $fields);

  
}




include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
