<?php

//Adds Support for Multiple Languages
//Release Version Unknown
//Release Date Unknown
//Rewrote 2019-03-29 DH

$countE=0;
$db->insert('updates',['migration'=>$update]);
$db->query("ALTER TABLE settings ADD COLUMN default_language varchar(11)");
if(!$db->error()) {
  logger(1,"System Updates","Added default language to settings table");
} else {
  $error=$db->errorString();
  $countE++;
  logger(1,"System Updates","Unable to add default_language column to settings, Error: ".$error);
  $errors[] = "Unable to add default_language column to settings, Error: ".$error;
}

$db->query("ALTER TABLE settings ADD COLUMN allow_language tinyint(1)");
if(!$db->error()) {
  logger(1,"System Updates","Added default language to settings table");
} else {
  $error=$db->errorString();
  $countE++;
  logger(1,"System Updates","Unable to add allow_language column to settings, Error: ".$error);
  $errors[] = "Unable to add allow_language column to settings, Error: ".$error;
}

$fields = array(
  'default_language'=>'en-US',
  'allow_language'=>0,
);
$db->update('settings',1,$fields);
if(!$db->error()) {
  logger(1,"System Updates","Added language info to settings table");
} else {
  $error=$db->errorString();
  $countE++;
  logger(1,"System Updates","Unable to set default language in settings, Error: ".$error);
  $errors[] = "Unable to set default language in settings, Error: ".$error;
}

$db->query("ALTER TABLE users
  ADD COLUMN language varchar(255) DEFAULT 'en-US'");
  if(!$db->error()) {
    logger(1,"System Updates","Added default language to settings table");
  } else {
    $error=$db->errorString();
    $countE++;
    logger(1,"System Updates","Unable to set default language in users table, Error: ".$error);
    $errors[] = "Unable to set default language in users table, Error: ".$error;
  }

 $_SESSION['us_lang'] = "en-US";

$find = $db->query("SELECT id,label FROM menus WHERE label = ?",array("Home"))->results();
foreach($find as $f){
	$db->update('menus',$f->id,['label'=>'{{home}}']);
  if(!$db->error()) {
    logger(1,"System Updates","Modified menus for multilanguage");
  } else {
    $countE++;
  }
}
$find = $db->query("SELECT id,label FROM menus WHERE label = ?",array("Log In"))->results();
foreach($find as $f){
	$db->update('menus',$f->id,['label'=>'{{login}}']);
  if(!$db->error()) {
    logger(1,"System Updates","Modified menus for multilanguage");
  } else {
    $countE++;
  }
}
$find = $db->query("SELECT id,label FROM menus WHERE label = ?",array("Register"))->results();
foreach($find as $f){
	$db->update('menus',$f->id,['label'=>'{{register}}']);
  if(!$db->error()) {
    logger(1,"System Updates","Modified menus for multilanguage");
  } else {
    $countE++;
  }
}
$find = $db->query("SELECT id,label FROM menus WHERE label = ?",array("Help"))->results();
foreach($find as $f){
	$db->update('menus',$f->id,['label'=>'{{help}}']);
  if(!$db->error()) {
    logger(1,"System Updates","Modified menus for multilanguage");
  } else {
    $countE++;
  }
}
$find = $db->query("SELECT id,label FROM menus WHERE label = ?",array("Account"))->results();
foreach($find as $f){
	$db->update('menus',$f->id,['label'=>'{{account}}']);
  if(!$db->error()) {
    logger(1,"System Updates","Modified menus for multilanguage");
  } else {
    $countE++;
  }
}
$find = $db->query("SELECT id,label FROM menus WHERE label = ?",array("Admin Dashboard"))->results();
foreach($find as $f){
	$db->update('menus',$f->id,['label'=>'{{dashboard}}']);
  if(!$db->error()) {
    logger(1,"System Updates","Modified menus for multilanguage");
  } else {
    $countE++;
  }
}
$find = $db->query("SELECT id,label FROM menus WHERE label = ?",array("Permissions Manager"))->results();
foreach($find as $f){
	$db->update('menus',$f->id,['label'=>'{{perms}}']);
  if(!$db->error()) {
    logger(1,"System Updates","Modified menus for multilanguage");
  } else {
    $countE++;
  }
}
$find = $db->query("SELECT id,label FROM menus WHERE label = ?",array("Page Management"))->results();
foreach($find as $f){
	$db->update('menus',$f->id,['label'=>'{{pages}}']);
  if(!$db->error()) {
    logger(1,"System Updates","Modified menus for multilanguage");
  } else {
    $countE++;
  }
}
$find = $db->query("SELECT id,label FROM menus WHERE label = ?",array("System Logs"))->results();
foreach($find as $f){
	$db->update('menus',$f->id,['label'=>'{{logs}}']);
  if(!$db->error()) {
    logger(1,"System Updates","Modified menus for multilanguage");
  } else {
    $countE++;
  }
}
$find = $db->query("SELECT id,label FROM menus WHERE label = ?",array("Messages Manager"))->results();
foreach($find as $f){
	$db->update('menus',$f->id,['label'=>'{{messages}}']);
  if(!$db->error()) {
    logger(1,"System Updates","Modified menus for multilanguage");
  } else {
    $countE++;
  }
}
$find = $db->query("SELECT id,label FROM menus WHERE label = ?",array("Forgot Password"))->results();
foreach($find as $f){
	$db->update('menus',$f->id,['label'=>'{{forgot}}']);
  if(!$db->error()) {
    logger(1,"System Updates","Modified menus for multilanguage");
  } else {
    $countE++;
  }
}
$find = $db->query("SELECT id,label FROM menus WHERE label = ?",array("Logout"))->results();
foreach($find as $f){
	$db->update('menus',$f->id,['label'=>'{{logout}}']);
  if(!$db->error()) {
    logger(1,"System Updates","Modified menus for multilanguage");
  } else {
    $countE++;
  }
}
$find = $db->query("SELECT id,label FROM menus WHERE label = ?",array("Resend Activation Email"))->results();
foreach($find as $f){
	$db->update('menus',$f->id,['label'=>'{{resend}}']);
  if(!$db->error()) {
    logger(1,"System Updates","Modified menus for multilanguage");
  } else {
    $countE++;
  }
}


if($countE==0) {

  if(!$db->error()) {
    if($db->count()>0) {
      logger(1,"System Updates","Update $update successfully deployed.");
      $successes[] = "Update $update successfully deployed.";
    } else {
      logger(1,"System Updates","Menu errors on $update.");
      $errors[] = "Menu errors on $update.";
    }
  }
}
