<?php
  require_once '../init.php';
  $db = DB::getInstance();
  if (!isset($user) || (!hasPerm([2], $user->data()->id) ) ) {
  die("You do not have permission to be here.");
  }
  if(!Token::check(Input::get('token'))){
    $msg = [];
    $msg['success'] = "false";
    $msg['msg'] = "Invalid token";
    echo json_encode($msg);
    die;
  }
$dis = Input::get('dismissed');
if(is_numeric($dis) && ($dis != 0)){
  $fields = array(
    'dismissed' =>$dis,
    'link'      =>Input::get('link'),
    'title'      =>Input::get('title'),
    'message'      =>Input::get('message'),
    'ignore'      =>Input::get('ignore'),
    'class'      =>Input::get('class'),
  );
  $db->insert('us_announcements',$fields);
}
