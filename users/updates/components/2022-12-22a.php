<?php

$countE = 0;

  $fields = [
    'id'=>2,
    'menu_name'=>'Dashboard Menu',
    'type'=>'horizontal',
    'theme'=>'dark',
    'z_index'=>55,
    'brand_html'=>'&lt;a href=&quot;{{root}}&quot; title=&quot;Home Page&quot;&gt;
&lt;img src=&quot;{{root}}users/images/logo.png&quot; alt=&quot;Main logo&quot; /&gt;&lt;/a&gt;',
    'disabled'=>0,
    'justify'=>'right',
  ];

  $db->insert("us_menus",$fields);

  $db->query("INSERT INTO `us_menu_items` (`menu`, `type`, `label`, `link`, `icon_class`, `li_class`, `a_class`, `link_target`, `parent`, `display_order`, `disabled`, `permissions`) VALUES
  (2, 'link', 'User Manager', 'users/admin.php?view=users', 'fa fa-user', '', '', '_self', 26, 1, 0, '[\"2\"]'),
  (2, 'link', 'Spice Shaker', 'users/admin.php?view=spice', 'fa fa-user-secret', '', '', '_self', 0, 2, 0, '[\"2\"]'),
  (2, 'dropdown', 'Tools', '', 'fa fa-wrench', '', '', '_self', 0, 3, 0, '[\"2\"]'),
  (2, 'link', 'Bug Report', 'users/admin.php?view=bugs', 'fa fa-bug', '', '', '_self', 26, 2, 0, '[\"2\"]'),
  (2, 'link', 'IP Manager', 'users/admin.php?view=ip', 'fa fa-warning', '', '', '_self', 26, 3, 0, '[\"0\"]'),
  (2, 'link', 'Cron Jobs', 'users/admin.php?view=cron', 'fa fa-terminal', '', '', '_self', 26, 4, 0, '[\"2\"]'),
  (2, 'link', 'Security Logs', 'users/admin.php?view=security_logs', 'fa fa-lock', '', '', '_self', 26, 5, 0, '[\"2\"]'),
  (2, 'link', 'System Logs', 'users/admin.php?view=logs', 'fa fa-list-ol', '', '', '_self', 26, 6, 0, '[\"2\"]'),
  (2, 'link', 'Templates', 'users/admin.php?view=templates', 'fa fa-eye', '', '', '_self', 26, 7, 0, '[\"2\"]'),
  (2, 'link', 'Updates', 'users/admin.php?view=updates', 'fa fa-arrow-circle-o-up', '', '', '_self', 26, 8, 0, '[\"2\"]'),
  (2, 'dropdown', 'Settings', '', 'fa fa-gear', '', '', '_self', 0, 4, 0, '[\"2\"]'),
  (2, 'link', 'General', 'users/admin.php?view=general', 'fa fa-check', '', '', '_self', 34, 2, 0, '[\"2\"]'),
  (2, 'link', 'Registration', 'admin.php?view=reg', 'fa fa-users', '', '', '_self', 34, 3, 0, '[\"2\"]'),
  (2, 'link', 'Email', 'users/admin.php?view=email', 'fa fa-envelope', '', '', '_self', 34, 4, 0, '[\"2\"]'),
  (2, 'link', 'Navigation (Classic)', 'users/admin.php?view=nav', 'fa fa-list-alt', '', '', '_self', 34, 5, 0, '[\"2\"]'),
  (2, 'link', 'UltraMenu', 'users/admin.php?view=menus', 'fa fa-rocket', '', '', '_self', 34, 6, 0, '[\"2\"]'),
  (2, 'link', 'Dashboard Access', 'users/admin.php?view=access', 'fa fa-file-code-o', '', '', '_self', 34, 7, 0, '[\"2\"]'),
  (2, 'link', 'Page Manager', 'users/admin.php?view=pages', 'fa fa-file', '', '', '_self', 26, 9, 0, '[\"2\"]'),
  (2, 'link', 'Permissions', 'users/admin.php?view=permissions', 'fa fa-unlock-alt', '', '', '_self', 26, 10, 0, '[\"2\"]'),
  (2, 'dropdown', 'Plugins', '#', 'fa fa-plug', '', '', '_self', 0, 5, 0, '[\"2\"]'),
  (2, 'snippet', 'All Plugins', 'users/includes/menu_hooks/plugins.php', '', '', '', '_self', 43, 2, 0, '[\"2\"]'),
  (2, 'link', 'Plugin Manager', 'users/admin.php?view=plugins', 'fa fa-puzzle-piece', '', '', '_self', 43, 1, 0, '[\"2\"]'),
  (2, 'link', 'Home', '#', 'fa fa-home', '', '', '_self', 0, 1, 0, '[\"2\"]'),
  (2, 'link', 'Admin Dashboard', 'users/admin.php', 'fa fa-cogs', '', '', '_self', 34, 1, 0, '[\"2\"]'),
  (2, 'link', 'Dashboard', 'users/admin.php', 'fa-solid fa-desktop', '', '', '_self', 0, 1, 0, '[\"2\"]');
");
include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
