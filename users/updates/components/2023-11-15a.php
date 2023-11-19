<?php
$countE = 0;

$db->query("ALTER TABLE us_menu_items ADD COLUMN tags varchar(1000) default null");
  
include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
