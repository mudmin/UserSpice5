<?php

//Add loader feature to init.php
//Release Version 5.2.7
//Release Date Unknown


$countE=0;

// $fp = fopen($abs_us_root.$us_url_root.'users/init.php', 'a');//opens file in append mode
// fwrite($fp,"\n");
// fwrite($fp, 'require_once $abs_us_root.$us_url_root."users/includes/loader.php";');
// fclose($fp);

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
