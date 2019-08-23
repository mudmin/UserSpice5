<?php

//Sets disable2fa to private=1 instead of 2 (former coding error)
//Release Version Unknown
//Release Date Unknown
//Rewrote 2019-03-01 BA

$countE=0;

$db->query("UPDATE pages SET private=1 WHERE page=? AND private=2",['users/disable2fa.php']);
if(!$db->error()) {
  logger(1,"System Updates","Set disable2fa.php to private");
} else {
  $error=$db->errorString();
  $countE++;
  logger(1,"System Updates","Unable to set disable2fa.php to private, Error: ".$error);
  $errors[] = "Unable to set disable2fa.php to private, Error: ".$error;
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
