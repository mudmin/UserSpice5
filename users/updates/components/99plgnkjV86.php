<?php

//Adds US Plugin Hook support
//Release Version 4.4.10
//Release Date Unknown
//Rewrote 2019-02-23 BA

$countE=0;

$db->query("CREATE TABLE us_plugin_hooks (
  id int(11) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  page varchar(255) NOT NULL,
  folder varchar(255) NOT NULL,
  position varchar(255) NOT NULL,
  hook varchar(255) NOT NULL,
  disabled tinyint(1) DEFAULT 0
)");
if(!$db->error()) {
  logger(1,"System Updates","Added us_plugin_hooks table");
} else {
  $error=$db->errorString();
  $countE++;
  logger(1,"System Updates","Unable to add us_form_views table, Error: ".$error);
  $errors[] = "Unable to add us_form_views table, Error: ".$error;
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
