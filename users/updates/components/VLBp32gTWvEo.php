<?php

//Adding Vericode Expiry and fixing some page titles
//Release Version Unknown
//Release Date Unknown
//Rewrote 2019-02-24 BA

$countE=0;

$db->query("ALTER TABLE users ADD COLUMN vericode_expiry timestamp AFTER `vericode`");
if(!$db->error()) {
  logger(1,"System Updates","Inserted vericode_expiry to users table");
} else {
  $error=$db->errorString();
  $countE++;
  logger(1,"System Updates","Unable to insert vericode_expiry to users table, Error: ".$error);
  $errors[] = "Unable to insert vericode_expiry to users table, Error: ".$error;
}

$pages = [
  [NULL,'users/cron_post.php','Post a Cron Job'],
  ['Two Factor Authentication','users/twofa.php',''],
  ['Disable 2 Factor Auth','users/disable2fa.php','Enable 2 Factor Auth'],
  ['Notifications Manager','users/admin_notifications.php','Admin Notifications'],
  ['IP Manager','users/admin_ips.php','Admin IPs'],
  ['Menu Manager','users/admin_menu.php','Manage Menus'],
  ['Menu Manager','users/admin_menus.php','Manage Menus'],
  ['Menu Manager','users/admin_menu_item.php','Manage Menus'],
  ['Update Manager','users/update.php','Update UserSpice'],
  ['Logs Manager','users/admin_logs.php','Site Logs'],
  ['Logs Manager','users/admin_logs_exempt.php','Site Logs'],
  ['Logs Manager','users/admin_logs_manager.php','Site Logs'],
  ['Logs Manager','users/admin_logs_mapper.php','Site Logs'],
  ['Messages Manager','users/admin_messages.php','View Messages'],
  ['Messages Manager','users/admin_message.php','View Message'],
  ['Password Verification','users/admin_verify.php','Verify Password'],
  ['Backup Manager','users/admin_backup.php','Backup Files'],
  ['Messages','users/messages.php','My Messages'],
  ['Messages','users/message.php','My Messages'],
  ['User Settings','users/user_settings.php','My Settings'],
  ['User Manager','users/admin_users.php','Manage Users'],
  ['User Manager','users/admin_user.php','Manage User'],
  ['Permissions Manager','users/admin_permissions.php','Manage Permissions'],
  ['Permissions Manager','users/admin_permission.php','Manage Permission'],
  ['Pages Manager','users/admin_pages.php','Manage Pages'],
  ['Pages Manager','users/admin_page.php','Manage Page'],
];

foreach($pages as $p) {
  $newTitle=$p[0];
  $page=$p[1];
  $oldTitle=$p[2];
  $db->query("UPDATE pages SET title=? WHERE page = ? and (title = ? OR title = null)",[$newTitle,$page,$oldTitle]);
  if(!$db->error()) {
    if($db->count()>0) {
      logger(1,"System Updates","Updated ".$page." name to ".$newTitle);
    }
  } else {
    $error=$db->errorString();
    $countE++;
    logger(1,"System Updates","Unable to update ".$page." name to ".$newTitle.", Error: ".$error);
    $errors[] = "Unable to update ".$page." name to ".$newTitle.", Error: ".$error;
  }
}

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
