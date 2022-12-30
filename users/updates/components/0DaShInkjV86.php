<?php

//Adds US Form Manager tables and data
//Release Version 4.4.11
//Release Date 2019-04-27
//Rewrote 2019-04-27 DH

$countE=0;
$db->query("DROP TABLE IF EXISTS us_management");

$db->query("CREATE TABLE `us_management` (
  `id` int(11) NOT NULL,
  `page` varchar(255) NOT NULL,
  `view` varchar(255) NOT NULL,
  `feature` varchar(255) NOT NULL,
  `access` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1");

$db->query("INSERT INTO `us_management` (`id`, `page`, `view`, `feature`, `access`) VALUES
(1, '_admin_manage_ip.php', 'ip', 'IP Whitelist/Blacklist', ''),
(2, '_admin_messages.php', 'messages', 'Messages', ''),
(3, '_admin_nav.php', 'nav', 'Navigation', ''),
(4, '_admin_nav_item.php', 'nav_item', 'Navigation', ''),
(5, '_admin_notifications.php', 'notifications', 'Notifications', ''),
(6, '_admin_page.php', 'page', 'Page Management', ''),
(7, '_admin_pages.php', 'pages', 'Page Management', ''),
(8, '_admin_permission.php', 'permission', 'Permission Management', ''),
(9, '_admin_permissions.php', 'permissions', 'Permission Management', ''),
(10, '_admin_security_logs.php', 'security_logs', 'Security Logs', ''),
(11, '_admin_sessions.php', 'sessions', 'Session Management', ''),
(12, '_admin_templates.php', 'templates', 'Templates', ''),
(13, '_admin_tools_check_updates.php', 'updates', 'Check Updates', ''),
(14, '_admin_user.php', 'user', 'User Management', ''),
(15, '_admin_users.php', 'users', 'User Management', '')");

$db->query("ALTER TABLE `us_management`
  ADD PRIMARY KEY (`id`)");

$db->query("ALTER TABLE `us_management`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT");

include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
