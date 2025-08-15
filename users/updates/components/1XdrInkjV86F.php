<?php

//Adds US Form Manager tables and data
//Release Version Unknown
//Release Date Unknown
//Rewrote 2019-02-23 BA

$countE=0;

$db->query("CREATE TABLE us_form_views (
  id int(11) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  form_name varchar(255) NOT NULL,
  view_name varchar(255) NOT NULL,
  fields text NOT NULL
)");
if(!$db->error()) {
  logger(1,"System Updates","Added us_form_views table");
} else {
  $error=$db->errorString();
  $countE++;
  logger(1,"System Updates","Unable to add us_form_views table, Error: ".$error);
  $errors[] = "Unable to add us_form_views table, Error: ".$error;
}

$db->query("CREATE TABLE us_form_validation (
  id int(11) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  value varchar(255) NOT NULL,
  description varchar(255) NOT NULL,
  params varchar(255) NOT NULL
)");
if(!$db->error()) {
  logger(1,"System Updates","Added us_form_validation table");
  $db->query("INSERT INTO `us_form_validation` (`value`, `description`, `params`) VALUES
  ('min', 'Minimum # of Characters', 'number'),
  ('max', 'Maximum # of Characters', 'number'),
  ('is_numeric', 'Must be a number', 'true'),
  ('valid_email', 'Must be a valid email address', 'true'),
  ('<', 'Must be a number less than', 'number'),
  ('>', 'Must be a number greater than', 'number'),
  ('<=', 'Must be a number less than or equal to', 'number'),
  ('>=', 'Must be a number greater than or equal to', 'number'),
  ('!=', 'Must not be equal to', 'text'),
  ('==', 'Must be equal to', 'text'),
  ('is_integer', 'Must be an integer', 'true'),
  ('is_timezone', 'Must be a valid timezone name', 'true'),
  ('is_datetime', 'Must be a valid DateTime', 'true')");
  if(!$db->error()) {
    if($db->count()>0) {
      logger(1,"System Updates","Added form validation data");
    }
  } else {
    $error=$db->errorString();
    $countE++;
    logger(1,"System Updates","Unable to add data for us_form_validation table, Error: ".$error);
    $errors[] = "Unable to add data for us_form_validation table, Error: ".$error;
  }
} else {
  $error=$db->errorString();
  $countE++;
  logger(1,"System Updates","Unable to add us_form_validation table, Error: ".$error);
  $errors[] = "Unable to add us_form_validation table, Error: ".$error;
}

$db->query("CREATE TABLE us_forms (
  id int(11) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  form varchar(255) NOT NULL
)");
if(!$db->error()) {
  logger(1,"System Updates","Added us_forms table");
} else {
  $error=$db->errorString();
  $countE++;
  logger(1,"System Updates","Unable to add us_forms table, Error: ".$error);
  $errors[] = "Unable to add us_forms table, Error: ".$error;
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
