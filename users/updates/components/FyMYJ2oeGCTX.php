<?php

//Adds DB Redirects after Login
//Release Version Unknown
//Release Date Unknown
//Rewrote 2019-03-01 BA

$countE=0;

$db->query("ALTER TABLE settings ADD COLUMN redirect_uri_after_login text NULL");
if(!$db->error()) {
  logger(1,"System Updates","Inserted redirect_uri_after_login to settings table");
  $db->update('settings',1,['redirect_uri_after_login' => 'users/account.php']);
  if(!$db->error()) {
    logger(1,"System Updates","Set redirect_uri_after_login to users/account.php");
  } else {
    $error=$db->errorString();
    logger(1,"System Updates","Unable to set redirect_uri_after_login to users/account.php, Error: ".$error);
    $errors[] = "Unable to set redirect_uri_after_login to users/account.php, Error: ".$error;
  }
} else {
  $error=$db->errorString();
  // $countE++;
  logger(1,"System Updates","Unable to insert redirect_uri_after_login to settings table, Error: ".$error);
  $errors[] = "Unable to insert redirect_uri_after_login to settings table, Error: ".$error;
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
