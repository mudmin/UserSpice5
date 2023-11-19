<?php
$countE = 0;

$db->query("ALTER TABLE us_menus ADD COLUMN screen_reader_mode tinyint(1) default 0");
  
include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
