<?php

//Removes stock ip black/whitelist
//Release Version 5.0.9
//Release Date Unknown


$countE=0;

$db->query("DELETE FROM us_ip_blacklist WHERE ip = ? OR ip = ? OR ip = ?",['192.168.0.21','192.168.0.22','192.168.0.222']);
$db->query("DELETE FROM us_ip_whitelist WHERE ip = ? OR ip = ?",['192.168.0.21','192.168.0.23']);

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
