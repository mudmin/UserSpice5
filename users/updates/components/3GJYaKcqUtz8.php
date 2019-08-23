<?php

//This update fixes vericodes-DUPLICATE
//Release Version Unknown
//Release Date Unknown
//Rewrote 2019-02-19 BA

$countE=0;
$db->query("SELECT id FROM users");
if(!$db->error()) {
  foreach($db->results() as $u) {
    $db->update('users',$u->id,['vericode'=>randomstring(15)]);
    if($db->error()) {
      $error=$db->errorString();
      logger(1,"System Updates","Failed to update Vericode for UID#".$u->id.", Error: ".$error);
      $countE++;
      $errors[] = "Failed to update Vericode for UID#".$u->id.", Error: ".$error;
    }
  }
  if($countE==0) {
    logger(1,"System Updates","Reformatted existing vericodes");
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
    logger(1,"System Updates","Update $update unable to be deployed, there were errors while completin the update.");
    $errors[] = "Update $update unable to be deployed, there were errors while completin the update.";
  }
} else {
  $error=$db->errorString();
  logger(1,"System Updates","Update $update unable to be applied, Error: ".$error);
  $errors[] = "Update $update unable to be applied, Error: ".$error;
}
