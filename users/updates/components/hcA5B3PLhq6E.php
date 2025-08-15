<?php

//Fixes naming issue with Session Management pages
//Release Version Unknown
//Release Date Unknown
//Rewrote 2019-03-01 BA

$countE=0;

$db->update('pages',['page'=>'users/admin_manage_sessions.php','title'=>'Session Manage'],['title'=>'Session Administrator']);
if(!$db->error()) {
  logger(1,"System Updates","Renamed admin_manage_sessions.php");
} else {
  $error=$db->errorString();
  $countE++;
  logger(1,"System Updates","Unable to rename admin_manage_sessions, Error: ".$error);
  $errors[] = "Unable to rename admin_manage_sessions, Error: ".$error;
}

$db->update('pages',['page'=>'users/manage_sessions.php','title'=>'Session Manage'],['title'=>'Session Manager']);
if(!$db->error()) {
  logger(1,"System Updates","Renamed admin_manage_sessions.php");
} else {
  $error=$db->errorString();
  $countE++;
  logger(1,"System Updates","Unable to rename admin_manage_sessions, Error: ".$error);
  $errors[] = "Unable to rename admin_manage_sessions, Error: ".$error;
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
