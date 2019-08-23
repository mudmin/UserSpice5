<?php

//Resolves issues with vericode_expiry
//Release Version Unknown
//Release Date Unknown
//Rewrote 2019-03-01 BA

$countE=0;

$db->query("ALTER TABLE users DROP COLUMN vericode_expiry");
if(!$db->error()) {
    logger(1,"System Updates","Dropped vericode_expiry in users table");
    $db->query("ALTER TABLE users ADD COLUMN vericode_expiry datetime");
    if(!$db->error()) {
      logger(1,"System Updates","Added vericode_expiry to users table");
    } else {
      $error=$db->errorString();
      $countE++;
      logger(1,"System Updates","Unable to insert vericode_expiry to users table, Error: ".$error);
      $errors[] = "Unable to insert vericode_expiry to users table, Error: ".$error;
    }
} else {
  $error=$db->errorString();
  $countE++;
  logger(1,"System Updates","Unable to drop vericode_expiry from users table, Error: ".$error);
  $errors[] = "Unable to drop vericode_expiry from users table, Error: ".$error;
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
