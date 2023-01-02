<?php

$countE = 0;

$db->query("DELETE FROM us_menu_items WHERE menu = 2");
$db->query("INSERT INTO `us_menu_items` (`menu`, `type`, `label`, `link`, `icon_class`, `li_class`, `a_class`, `link_target`, `parent`, `display_order`, `disabled`, `permissions`) VALUES
  (2, 'dropdown', 'Tools', '', 'fa fa-wrench', '', '', '_self', 0, 3, 0, '[2]')
");
$id = $db->lastId();


$fields = [
['menu'=>2, 'type'=>'link', 'label'=>'User Manager', 'link'=>'users/admin.php?view=users', 'icon_class'=>'fa fa-user', 'parent'=>$id, 'display_order'=>15, 'permissions'=>'[2]'],
['menu'=>2, 'type'=>'link', 'label'=>'Bug Report', 'link'=>'users/admin.php?view=bugs', 'icon_class'=>'fa fa-bug', 'parent'=>$id, 'display_order'=>1, 'permissions'=>'[2]'],
['menu'=>2, 'type'=>'link', 'label'=>'IP Manager', 'link'=>'users/admin.php?view=ip', 'icon_class'=>'fa fa-warning', 'parent'=>$id, 'display_order'=>3, 'permissions'=>'[0]'],
['menu'=>2, 'type'=>'link', 'label'=>'Cron Jobs', 'link'=>'users/admin.php?view=cron', 'icon_class'=>'fa fa-terminal', 'parent'=>$id, 'display_order'=>2, 'permissions'=>'[2]'],
['menu'=>2, 'type'=>'link', 'label'=>'Security Logs', 'link'=>'users/admin.php?view=security_logs', 'icon_class'=>'fa fa-lock', 'parent'=>$id, 'display_order'=>9, 'permissions'=>'[2]'],
['menu'=>2, 'type'=>'link', 'label'=>'System Logs', 'link'=>'users/admin.php?view=logs', 'icon_class'=>'fa fa-list-ol', 'parent'=>$id, 'display_order'=>10, 'permissions'=>'[2]'],
['menu'=>2, 'type'=>'link', 'label'=>'Templates', 'link'=>'users/admin.php?view=templates', 'icon_class'=>'fa fa-eye', 'parent'=>$id, 'display_order'=>11, 'permissions'=>'[2]'],
['menu'=>2, 'type'=>'link', 'label'=>'Updates', 'link'=>'users/admin.php?view=updates', 'icon_class'=>'fa fa-arrow-circle-o-up', 'parent'=>$id, 'display_order'=>12, 'permissions'=>'[2]'],
['menu'=>2, 'type'=>'link', 'label'=>'Page Manager', 'link'=>'users/admin.php?view=pages', 'icon_class'=>'fa fa-file', 'parent'=>$id, 'display_order'=>7, 'permissions'=>'[2]'],
['menu'=>2, 'type'=>'link', 'label'=>'Permissions', 'link'=>'users/admin.php?view=permissions', 'icon_class'=>'fa fa-unlock-alt', 'parent'=>$id, 'display_order'=>8, 'permissions'=>'[2]'],
];
foreach($fields as $f){
$db->insert("us_menu_items",$f);
}

$db->query("INSERT INTO `us_menu_items` (`menu`, `type`, `label`, `link`, `icon_class`, `li_class`, `a_class`, `link_target`, `parent`, `display_order`, `disabled`, `permissions`) VALUES
  (2, 'dropdown', 'Settings', '', 'fa fa-gear', '', '', '_self', 0, 4, 0, '[2]')
");

$id = $db->lastId();


$fields = [
['menu'=>2, 'type'=>'link', 'label'=>'General', 'link'=>'users/admin.php?view=general', 'icon_class'=>'fa fa-check', 'parent'=>$id, 'display_order'=>1, 'permissions'=>'[2]'],
['menu'=>2, 'type'=>'link', 'label'=>'Registration', 'link'=>'users/admin.php?view=reg', 'icon_class'=>'fa fa-users', 'parent'=>$id, 'display_order'=>2, 'permissions'=>'[2]'],
['menu'=>2, 'type'=>'link', 'label'=>'Email', 'link'=>'users/admin.php?view=email', 'icon_class'=>'fa fa-envelope', 'parent'=>$id, 'display_order'=>3, 'permissions'=>'[0]'],
['menu'=>2, 'type'=>'link', 'label'=>'Navigation (Classic)', 'link'=>'users/admin.php?view=nav', 'icon_class'=>'fa fa-rocket', 'parent'=>$id, 'display_order'=>4, 'permissions'=>'[2]'],
['menu'=>2, 'type'=>'link', 'label'=>'UltraMenu', 'link'=>'users/admin.php?view=menus', 'icon_class'=>'fa fa-lock', 'parent'=>$id, 'display_order'=>5, 'permissions'=>'[2]'],
['menu'=>2, 'type'=>'link', 'label'=>'Dashboard Access', 'link'=>'users/admin.php?view=access', 'icon_class'=>'fa fa-file-code-o', 'parent'=>$id, 'display_order'=>5, 'permissions'=>'[2]'],

];
foreach($fields as $f){
$db->insert("us_menu_items",$f);
}

$db->query("INSERT INTO `us_menu_items` (`menu`, `type`, `label`, `link`, `icon_class`, `li_class`, `a_class`, `link_target`, `parent`, `display_order`, `disabled`, `permissions`) VALUES
  (2, 'dropdown', 'Plugins', '#', 'fa fa-plug', '', '', '_self', 0, 5, 0, '[2]')
");

$id = $db->lastId();
// dump($db->errorString());

$fields = [
['menu'=>2, 'type'=>'snippet', 'label'=>'All Plugins', 'link'=>'users/includes/menu_hooks/plugins.php', 'icon_class'=>'', 'parent'=>$id, 'display_order'=>2, 'permissions'=>'[2]'],
['menu'=>2, 'type'=>'link', 'label'=>'Plugin Manager', 'link'=>'users/admin.php?view=plugins', 'icon_class'=>'fa fa-puzzle-piece', 'parent'=>$id, 'display_order'=>1, 'permissions'=>'[2]'],
];
foreach($fields as $f){
$db->insert("us_menu_items",$f);
}
// dump($db->errorString());
$db->query("INSERT INTO `us_menu_items` (`menu`, `type`, `label`, `link`, `icon_class`, `li_class`, `a_class`, `link_target`, `parent`, `display_order`, `disabled`, `permissions`) VALUES
(2, 'link', 'Spice Shaker', 'users/admin.php?view=spice', 'fa fa-user-secret', '', '', '_self', 0, 2, 0, '[2]'),
(2, 'link', 'Home', '#', 'fa fa-home', '', '', '_self', 0, 1, 0, '[2]'),
(2, 'link', 'Dashboard', 'users/admin.php', 'fa-solid fa-desktop', '', '', '_self', 0, 1, 0, '[2]')
");

include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
