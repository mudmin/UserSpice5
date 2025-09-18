<?php
$countE = $count = 0;
$db->query("ALTER TABLE logs ADD COLUMN cloak_from int(11) DEFAULT null AFTER user_id");
include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
