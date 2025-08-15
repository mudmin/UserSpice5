<?php
//This is the upgrade file for version 2025-06-20b - Add PHP EOL and Known Bad Tables

$countE = $count = 0;


$db->query("CREATE TABLE us_php_eol (
    id INT AUTO_INCREMENT PRIMARY KEY,
    release_version VARCHAR(20) NOT NULL,
    eol_date DATE NOT NULL,
    last_checked TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY idx_release_version (release_version)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");


$db->query("CREATE TABLE us_php_known_bad (
    id INT AUTO_INCREMENT PRIMARY KEY,
    version VARCHAR(20) NOT NULL,
    last_checked TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY idx_version (version)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

$db->query("CREATE TABLE us_versions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    release_version VARCHAR(20),
	bleeding_edge VARCHAR(20),
	experimental VARCHAR(20)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
$check = $db->query("SELECT id FROM us_versions")->count();
if($check < 1){
	$db->query("TRUNCATE TABLE us_versions");
	$db->insert("us_versions",["id"=>1]);
}


include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
