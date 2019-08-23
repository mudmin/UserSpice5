<?php

//Adds Support for Multiple Languages
//Release Version Unknown
//Release Date Unknown
//Rewrote 2019-03-29 DH

$countE=0;
$db->insert('updates',['migration'=>$update]);

$find = $db->query("SELECT id,label FROM menus WHERE label = ?",array("User Management"))->results();
foreach($find as $f){
	$db->update('menus',$f->id,['label'=>'{{users}}']);
  if(!$db->error()) {
    logger(1,"System Updates","Modified menus for multilanguage");
  } else {
    //not finding the key doesn't mean an error. Ignore it.
  }
}

logger(1,"System Updates","Update $update successfully deployed.");
$successes[] = "Update $update successfully deployed.";
