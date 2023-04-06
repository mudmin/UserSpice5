<?php

//Updates int colums in group_menus and users table
//Release Version 4.4.04
//Release Date 2019-03-09

$countE=0;

$db->query("ALTER TABLE groups_menus
  ALTER COLUMN id SET DATA TYPE SERIAL,
  ALTER COLUMN group_id SET DATA TYPE INTEGER,
  ALTER COLUMN menu_id SET DATA TYPE INTEGER");
if(!$db->error()) {
  logger(1,"System Updates","Updated group_menu int columns to 11 and unsigned");
} else {
  $error=$db->errorString();
  $countE++;
  logger(1,"System Updates","Unable to update group_menu int columns to 11 and unsigned, Error: ".$error);
  $errors[] = "Unable to update group_menu int columns to 11 and unsigned, Error: ".$error;
}

$db->query("ALTER TABLE users MODIFY COLUMN logins integer NOT NULL");
if(!$db->error()) {
  logger(1,"System Updates","Updated users int columns to 11 and unsigned");
} else {
  $error=$db->errorString();
  $countE++;
  logger(1,"System Updates","Unable to update users int columns to 11 and unsigned, Error: ".$error);
  $errors[] = "Unable to update users int columns to 11 and unsigned, Error: ".$error;
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
