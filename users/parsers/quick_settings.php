<?php
//NOTE: This also serves as the reference file for how to do One Click Edit with UserSpice. See comments below.
  require_once '../init.php';
  $db = DB::getInstance();
  if(!in_array($user->data()->id, $master_account)){
  die("You do not have permission to be here.");
  }
$msg = [];

if(!empty($_POST)){
  if(!empty($_POST['backup_source'])){
    $db->update('settings',1,['backup_source'=>Input::get('backup_source')]);
    $msg['success'] = "Backup source updated";
    echo json_encode($msg);
  }

  if(!empty($_POST['backup_dest'])){
    $db->update('settings',1,['backup_dest'=>Input::get('backup_dest')]);
    $msg['success'] = "Backup destination updated";
    echo json_encode($msg);
  }

  if(!empty($_POST['backup_table'])){
    $db->update('settings',1,['backup_table'=>Input::get('backup_table')]);
    $msg['success'] = "Backup table updated";
    echo json_encode($msg);
  }

}
