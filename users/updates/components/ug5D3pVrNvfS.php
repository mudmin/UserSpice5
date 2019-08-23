<?php

//Adds Vericode Expiry
//Release Version Unknown
//Release Date Unknown
//Rewrote 2019-02-23 BA

$countE=0;

$db->query("ALTER TABLE settings ADD COLUMN join_vericode_expiry int(9) UNSIGNED NOT NULL");
if(!$db->error()) {
  logger(1,"System Updates","Inserted join_vericode_expiry to settings table");
} else {
  $error=$db->errorString();
  $countE++;
  logger(1,"System Updates","Unable to insert join_vericode_expiry to settings table, Error: ".$error);
  $errors[] = "Unable to insert join_vericode_expiry to settings table, Error: ".$error;
}

$db->query("ALTER TABLE settings ADD COLUMN reset_vericode_expiry int(9) UNSIGNED NOT NULL");
if(!$db->error()) {
  logger(1,"System Updates","Inserted reset_vericode_expiry to settings table");
} else {
  $error=$db->errorString();
  $countE++;
  logger(1,"System Updates","Unable to insert reset_vericode_expiry to settings table, Error: ".$error);
  $errors[] = "Unable to insert reset_vericode_expiry to settings table, Error: ".$error;
}

$db->query("UPDATE settings SET settings.join_vericode_expiry=24,reset_vericode_expiry=15 WHERE id=1");
if(!$db->error()) {
  logger(1,"System Updates","Set Join and Reset Vericode Expiry");
} else {
  $error=$db->errorString();
  $countE++;
  logger(1,"System Updates","Unable to Set Join and Reset Vericode Expiry, Error: ".$error);
  $errors[] = "Unable to Set Join and Reset Vericode Expiry, Error: ".$error;
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
