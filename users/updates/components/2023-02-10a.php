<?php
$countE = 0;
$db->query("ALTER TABLE us_menus ADD COLUMN show_active tinyint(1) default 0");
$db->query("ALTER TABLE settings ADD COLUMN uman_search tinyint(1) default 0");
include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
