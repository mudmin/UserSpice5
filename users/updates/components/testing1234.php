<?php

$countE = 0;

// $fields = [
//   'menu'=>1,
//   'type'=>'link',
//   'label'=>'Testing1234',
//   'link'=>'index.php',
//   'icon_class'=>'fa fa-home',
//   'link_target'=>'_self',
//   'parent'=>0,
//   'display_order'=>0,
//   'permissions'=>"[2,1]",
// ];
// for ($i=0; $i < 7; $i++) {
// $db->insert("us_menu_items",$fields);
// }
$db->update("settings",1,['template'=>'bs5']);
include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
