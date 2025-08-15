<?php

//Adds force_notif and cron_ip to settings table, turns cron jobs off
//Release Version Unknown
//Release Date Unknown
//Rewrote 2019-02-19 BA

$countE=0;

$db->query("ALTER TABLE settings ADD COLUMN force_notif tinyint(1)");
if(!$db->error()) {
  logger(1,"System Updates","Inserted force_notif to settings table");
} else {
  $error=$db->errorString();
  $countE++;
  logger(1,"System Updates","Unable to insert force_notif to settings table, Error: ".$error);
  $errors[] = "Unable to insert force_notif to settings table, Error: ".$error;
}

$db->query("ALTER TABLE settings ADD COLUMN cron_ip varchar(255)");
if(!$db->error()) {
  logger(1,"System Updates","Inserted cron_ip to settings table");
} else {
  $error=$db->errorString();
  $countE++;
  logger(1,"System Updates","Unable to insert cron_ip to settings table, Error: ".$error);
  $errors[] = "Unable to insert cron_ip to settings table, Error: ".$error;
}

$db->update("settings",1,['cron_ip'=>'off']);
if(!$db->error()) {
  logger(1,"System Updates","Disabled cron jobs");
} else {
  $error=$db->errorString();
  $countE++;
  logger(1,"System Updates","Unable to disable cron jobs, Error: ".$error);
  $errors[] = "Unable to disable cron jobs, Error: ".$error;
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
