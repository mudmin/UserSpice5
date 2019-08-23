<?php

//Adds US Form Manager tables and data
//Release Version 4.4.11
//Release Date 2019-04-27
//Rewrote 2019-04-27 DH

$countE=0;

$db->query("DELETE FROM us_management WHERE view = ?",["permission"]);
$db->query("DELETE FROM us_management WHERE view = ?",["permissions"]);
$db->query("DELETE FROM us_management WHERE view = ?",["user"]);
$db->query("DELETE FROM us_management WHERE view = ?",["users"]);

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
