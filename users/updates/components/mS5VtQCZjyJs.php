<?php

//SECURITY-Sanitizes Existing Bios
//Release Version Unknown
//Release Date Unknown
//Rewrote 2019-03-01 BA

$countE=0;

$q=$db->query("SELECT * FROM profiles");
if(!$db->error()) {
  if($db->count()>0) {
    $updateCount=0;
    foreach($q->results() as $row) {
      $db->update('profiles',$row->id,['bio' => Input::sanitize($row->bio)]);
      if($db->error()) {
        $errorString=$db->errorString();
        $error++;
        $errors[]=$errorString;
        logger(1,"System Updates","Unable to update bio, Error: ".$errorString);
      } else $updateCount++;
    }
  }
  if($updateCount==1) {
    logger(1,"System Updates","Sanitized 1 Bio");
  }
  if($updateCount >1) {
    logger(1,"System Updates","Sanitized ".$count." Bios");
  }
} else {
  $error=$db->errorString();
  $countE++;
  $errors[]=$errorString;
  logger(1,"System Updates","Unable to select bios, Error: ".$error);
  $errors[] = "Unable to select bios, Error: ".$error;
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
