<?php

//Sets disable2fa to private=1 instead of 2 (former coding error)
//Release Version Unknown
//Release Date Unknown
//Rewrote 2019-03-01 BA

$countE=0;

$db->query("ALTER TABLE users
  MODIFY COLUMN password varchar(255) NULL");
if(!$db->error()) {
  logger(1,"System Updates","Allowed passwords to be NULL");
} else {
  $error=$db->errorString();
  $countE++;
  logger(1,"System Updates","Failed to set passwords column to allow null values, Error: ".$error);
  $errors[] = "Failed to set passwords column to allow null values, Error: ".$error;
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
