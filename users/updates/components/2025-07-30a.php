<?php
$countE = $count = 0;

$db->query("ALTER TABLE users 
MODIFY COLUMN lname VARCHAR(255) NULL,
MODIFY COLUMN fname VARCHAR(255) NULL;");

include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
