<?php

//Adds Built in Spice Shaker
//Release 5.0
//Release Date Unknown
//Rewrote 2019-07-21 DH

$countE=0;
$db->insert('updates',['migration'=>$update]);
$db->query("ALTER TABLE settings ADD COLUMN spice_api varchar(75)");
if(!$db->error()) {
  logger(1,"System Updates","Added column for spice shaker");
} else {
  $error=$db->errorString();
  $countE++;
  logger(1,"System Updates","Unable to add column for spice shaker, Error: ".$error);
  $errors[] = "Unable to add column for spice shaker. This error is probably not very important, Error: ".$error;
}

if($countE==0) {

  if(!$db->error()) {
    if($db->count()>0) {
      logger(1,"System Updates","Update $update successfully deployed.");
      $successes[] = "Update $update successfully deployed.";
    } else {
      logger(1,"System Updates","Menu errors on $update.");
      $errors[] = "Menu errors on $update.";
    }
  }
}
