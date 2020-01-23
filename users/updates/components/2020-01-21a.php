<?php

//Removes stock ip black/whitelist
//Release Version 5.0.9
//Release Date Unknown


$countE=0;

$db->query("ALTER TABLE pages ADD COLUMN core int(1) DEFAULT 0");
$core = [1,2,3,4,14,15,16,17,18,20,21,24,25,26,45,68,90,91];
foreach($core as $c){
  $db->update('pages',$c,['core'=>1]);
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
