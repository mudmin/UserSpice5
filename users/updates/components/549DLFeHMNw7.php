<?php

//Sets Force Notifications off if not set
//Release Version Unknown
//Release Date Unknown
//Rewrote 2019-02-19 BA

$db->query("UPDATE settings SET force_notif=0 WHERE force_notif IS NULL");
if(!$db->error()) {
  logger(1,"System Updates","Set force_notif to off if was not set");
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
  $error=$db->errorString();
  logger(1,"System Updates","Update $update unable to be applied, Error: ".$error);
  $errors[] = "Update $update unable to be applied, Error: ".$error;
}
