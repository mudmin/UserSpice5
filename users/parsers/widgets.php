<?php

  require_once '../init.php';
  $db = DB::getInstance();
  $settings = $db->query("SELECT * FROM settings")->first();
  if (!isset($user) || (!hasPerm([2], $user->data()->id) ) ) {
  die("You do not have permission to be here.");
  }

$msg = [];
if(!Token::check(Input::get('token'))){
  $msg['success'] = "false";
  $msg['msg'] = "Invalid token";
  echo json_encode($msg);
  die;
}
$msg['msg'] = "Widget ordering saved";

$action = Input::get('action');
if($action == "sort_widgets"){
  $order = Input::get('order');
  foreach($order as $k=>$v){
    $order[$k] = Input::sanitize($v);
  }

  $string = implode(",",$order);
  $db->update("settings",1,["widgets"=>$string]);
}
echo json_encode($msg);
