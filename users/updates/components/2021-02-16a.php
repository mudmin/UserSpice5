<?php

//Disables messaging in settings table if plugin not active
//Release Version 5.1.0
//Release Date Unknown


$countE=0;

$settings = $db->query("SELECT * FROM settings")->first();
if($settings->max_pw = 30){
  $db->update('settings',$settings->id,['max_pw'=>150]);
}

if($settings->us_css1 == '../users/css/color_schemes/bootstrap.min.css'){
  $db->query("ALTER TABLE settings DROP COLUMN us_css1");
}

if($settings->us_css2 == '../users/css/sb-admin.css'){
  $db->query("ALTER TABLE settings DROP COLUMN us_css2");
}

if($settings->us_css3 == '../users/css/custom.css'){
  $db->query("ALTER TABLE settings DROP COLUMN us_css3");
}

if($settings->track_guest == 1){
  $db->query("ALTER TABLE settings DROP COLUMN track_guest");
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
