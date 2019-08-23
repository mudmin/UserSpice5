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

if($countE==0) {
  $db->insert('updates',['migration'=>$update]);
  if(!$db->error()) {
    if($db->count()>0) {
      logger(1,"System Updates","Update $update successfully deployed.");
      $successes[] = "Update $update successfully deployed.";
    } else {
      logger(1,"System Updates","Update $update unable to be marked complete, query was successful but no database entry was made.");
      $errors[] = "Update ".$update." unable to be marked complete, query was successful but no database entry was made.";
    }
  } else {
    $error=$db->errorString();
    logger(1,"System Updates","Update $update unable to be marked complete, Error: ".$error);
    $errors[] = "Update $update unable to be marked complete, Error: ".$error;
  }
} else {
  logger(1,"System Updates","Update $update unable to be marked complete");
  $errors[] = "Update $update unable to be marked complete";
}
