<?php
$countE = 0;

$db->query("ALTER TABLE permissions ADD COLUMN descrip varchar(255) default ''");
$db->query("ALTER TABLE plg_tags ADD COLUMN descrip varchar(255) default ''");
$db->update("permissions",1,["descrip"=>"Standard User"]);
$db->update("permissions",2,["descrip"=>"UserSpice Administrator"]);
include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
