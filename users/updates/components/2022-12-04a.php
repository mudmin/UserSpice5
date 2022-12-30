<?php

$countE = 0;

$fields = [
  ['_admin_menus.php','menus','Manage UltraMenu'],
  // ['_admin_plugins.php','plugins','Manage Plugins'],
  ['_admin_logs.php','logs','System Logs'],
  // ['_admin_settings_general.php','general','General Settings'],
  // ['_admin_settings_register.php','reg','Registration Settings'],
];

foreach($fields as $f){
  $row = [
    'page'=>$f[0],
    'view'=>$f[1],
    'feature'=>$f[2],
  ];
  $db->insert("us_management",$row);
}

include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
