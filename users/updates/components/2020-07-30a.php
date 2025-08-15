<?php

//Disables messaging in settings table if plugin not active
//Release Version 5.1.0
//Release Date Unknown


$countE=0;

$pages = ['users/admin_pin.php','users/update.php'];
foreach($pages as $p){
  $q = $db->query("SELECT * FROM pages WHERE page = ?",[$p]);
  $c = $q->count();
  if($c > 0){
    $f = $q->first();
    $db->update("pages",$f->id,['core'=>1]);
  }
}

$pages = ['users/user_agreement_acknowledge.php','users/views_admin_notifications.php'];
foreach($pages as $p){
  if(file_exists($abs_us_root.$us_url_root.$p)){
    unlink($abs_us_root.$us_url_root.$p);
  }
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
