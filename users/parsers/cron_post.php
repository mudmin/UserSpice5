<?php

require_once '../init.php';
$db = DB::getInstance();
if(!Token::check(Input::get('token'))){
  $msg = [];
  $msg['success'] = "false";
  $msg['msg'] = "Invalid token";
  echo json_encode($msg);
  die;
}

if(isset($user) && $user->isLoggedIn()) {
  if(hasPerm([2],$user->data()->id) && in_array($user->data()->id,$master_account)){
    $msg = [];
    $field = Input::get('field');
    $id = Input::get('id');
    $value = Input::get('value');

    if($field != "deleteMe"){
    $fields = array($field => $value,'modified' => date("Y-m-d H:i:s"));
    $select = $db->query("SELECT * FROM crons WHERE id = ?",array($id));
    $results = $select->first();

    if($field == 'name' || $field == 'file'){
    $db->update('crons',$id,$fields);
    logger($user->data()->id,"Cron Manager","Changed $field to $value for $results->name.");
    $msg['success'] = "true";
    $msg['msg'] = "Cron ".$field." updated!";
    }

    if($field == 'sort'){
    if(!is_numeric($value) || $value < 0 || $value > 999){
      $msg['success'] = "false";
      $msg['msg'] = "Sort must be an integer between 0 and 999";
    }else{
    $db->update('crons',$id,$fields);
    logger($user->data()->id,"Cron Manager","Changed $field to $value for $results->name.");
    $msg['success'] = "true";
    $msg['msg'] = "Cron ".$field." updated!";
    }
    }

    if($field == 'active'){
    $value = $value * 1;
    if(!is_int($value) || $value < 0 || $value > 1){
      $msg['success'] = "false";
      $msg['msg'] = "Active must be 0 or 1";
    }else{
    $db->update('crons',$id,$fields);
    logger($user->data()->id,"Cron Manager","Changed $field to $value for $results->name.");
    $msg['success'] = "true";
    $msg['msg'] = "Cron ".$field." updated!";
    }
    }
  }else{//deleteMe

    if(is_numeric($value)){
      $db->query("DELETE FROM crons WHERE id = ?",array($value));
      $msg['success'] = "true";
      $msg['msg'] = "Cron deleted";
      $msg['refresh'] = "true";
    }
  }
    echo json_encode($msg);

  } else {
    $msg['success'] = "false";
    $msg['msg'] = "Requires Master Account";
    echo json_encode($msg);
    http_response_code(403);
  }
} else {
  http_response_code(403);
}
 ?>
