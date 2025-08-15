<?php
$countE = 0;

$db->query("ALTER TABLE settings add column `pwl_length` int(3) default 5");
include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
