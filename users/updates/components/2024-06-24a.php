<?php
$countE = 0;

$db->query("ALTER TABLE users MODIFY COLUMN vericode text");

include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
