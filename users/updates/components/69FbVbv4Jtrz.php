<?php

//Adds admin verify changes and Two FA pages, Admin Pin
//Release Version Unknown
//Release Date Unknown
//Rewrote 2019-02-24 BA

$countE=0;

$db->query("ALTER TABLE settings ADD COLUMN admin_verify tinyint(1)");
if(!$db->error()) {
  logger(1,"System Updates","Inserted admin_verify to settings table");
} else {
  $error=$db->errorString();
  $countE++;
  logger(1,"System Updates","Unable to insert admin_verify to settings table, Error: ".$error);
  $errors[] = "Unable to insert admin_verify to settings table, Error: ".$error;
}

$db->query("ALTER TABLE settings ADD COLUMN admin_verify_timeout int(9) NOT NULL");
if(!$db->error()) {
  logger(1,"System Updates","Inserted admin_verify_timeout to settings table");
} else {
  $error=$db->errorString();
  $countE++;
  logger(1,"System Updates","Unable to insert admin_verify_timeout to settings table, Error: ".$error);
  $errors[] = "Unable to insert admin_verify_timeout to settings table, Error: ".$error;
}

$db->query("ALTER TABLE users ADD COLUMN pin varchar(255) DEFAULT NULL AFTER `password`");
if(!$db->error()) {
  logger(1,"System Updates","Inserted pin to users table");
} else {
  $error=$db->errorString();
  $countE++;
  logger(1,"System Updates","Unable to insert pin to users table, Error: ".$error);
  $errors[] = "Unable to insert pin to users table, Error: ".$error;
}

$db->update("settings",1,['admin_verify'=>TRUE,'admin_verify_timeout' => 120]);
if(!$db->error()) {
  logger(1,"System Updates","Set admin_verify and admin_verify_timeout");
} else {
  $error=$db->errorString();
  $countE++;
  logger(1,"System Updates","Unable to set admin_verify and admin_verify_timeout, Error: ".$error);
  $errors[] = "Unable to set admin_verify and admin_verify_timeout, Error: ".$error;
}

$pages = [
  [
    'page' => 'users/admin_pin.php',
    'pageTitle' => 'Verification PIN',
    'private' => TRUE,
    'permissions' => [1]
  ],
  [
    'page' => 'users/manage2fa.php',
    'pageTitle' => 'Manage Two FA',
    'private' => TRUE,
    'permissions' => [1]
  ]
];

foreach($pages as $p) {
  $page = $p['page'];
  $pageTitle = $p['pageTitle'];
  $private = $p['private'];
  $permissionIds = $p['permissions'];
  $db->insert('pages',['page' => $page,'title' => $pageTitle,'private' => $private]);
  if(!$db->error()) {
    $lastId=$db->lastId();
    logger(1,"System Updates","Added ".$page." to database");
    foreach($permissionIds as $perm) {
      $db->insert('permission_page_matches',['permission_id' => $perm,'page_id' => $lastId]);
      if(!$db->error()) {
        logger(1,"System Updates","Added Permission ID#".$perm." to page ".$page);
      } else {
        $error=$db->errorString();
        $countE++;
        logger(1,"System Updates","Unable to insert Permission ID#".$perm." for ".$page.", Error: ".$error);
        $errors[] = "Unable to insert Permission ID#".$perm." for ".$page.", Error: ".$error;
      }
    }
  } else {
    $error=$db->errorString();
    $countE++;
    logger(1,"System Updates","Unable to insert ".$page.", Error: ".$error);
    $errors[] = "Unable to insert ".$page.", Error: ".$error;
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
