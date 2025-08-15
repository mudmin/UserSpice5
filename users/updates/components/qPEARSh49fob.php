<?php

//Adds OAuth TOS Accepted to Database
//Release Version Unknown
//Release Date Unknown
//Rewrote 2019-03-01 BA

$countE=0;

$db->query("ALTER TABLE users ADD COLUMN oauth_tos_accepted tinyint(1)");
if(!$db->error()) {
  logger(1,"System Updates","Inserted oauth_tos_accepted to users table");
  $db->query("UPDATE users SET oauth_tos_accepted=1");
  if(!$db->error()) {
    logger(1,"System Updates","Upated tos accepted for existing users");
  } else {
    $error=$db->errorString();
    $countE++;
    logger(1,"System Updates","Unable to update tos accepted for existing users, Error: ".$error);
    $errors[] = "Unable to update tos accepted for existing users, Error: ".$error;
  }
} else {
  $error=$db->errorString();
  // $countE++;
  logger(1,"System Updates","Unable to insert oauth_tos_accepted to users table, Error: ".$error);
  $errors[] = "Unable to insert oauth_tos_accepted to users table, Error: ".$error;
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
