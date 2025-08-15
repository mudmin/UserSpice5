<?php

//Reformats "Blacklisted User Visit" logs to "IP Logging" logtype
//Release Version Unknown
//Release Date Unknown
//Rewrote 2019-02-19 BA

$db->query("UPDATE logs SET logtype = ? WHERE logtype = ? AND lognote LIKE ?",array("IP Logging","User","%blacklisted%attempted%visit"));
if(!$db->error()) {
  logger(1,"System Updates","Updated logtype for Blacklisted Logs to IP Logging");
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
