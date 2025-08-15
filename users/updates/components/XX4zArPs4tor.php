<?php

//Adds Session Manager
//Release Version Unknown
//Release Date Unknown
//Rewrote 2019-03-01 BA

$countE=0;

$db->query("ALTER TABLE settings ADD COLUMN session_manager tinyint(1) DEFAULT 0");
if(!$db->error()) {
  logger(1,"System Updates","Inserted session_manager to settings table");
} else {
  $error=$db->errorString();
  $countE++;
  logger(1,"System Updates","Unable to insert session_manager to settings table, Error: ".$error);
  $errors[] = "Unable to insert session_manager to settings table, Error: ".$error;
}

$pages = [
  [
    'page' => 'users/manage_sessions.php',
    'pageTitle' => 'Session Manager',
    'private' => TRUE,
    'permissions' => [1]
  ],
  [
    'page' => 'users/admin_manage_sessions.php',
    'pageTitle' => 'Session Administrator',
    'private' => TRUE,
    'permissions' => [2]
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
