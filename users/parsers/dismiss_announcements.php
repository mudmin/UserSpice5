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
$upd = Input::get('update');


$dis = Input::get('dismissed');
if($upd == "false" && is_numeric($dis) && ($dis != 0)){
  $fields = array(
    'dismissed' =>$dis,
    'link'      =>Input::get('link'),
    'title'      =>Input::get('title'),
    'message'      =>Input::get('message'),
    'ignore'      =>Input::get('ignore'),
    'class'      =>Input::get('class'),
   
  );
  $db->insert('us_announcements',$fields);
}elseif(is_numeric($upd)){
  $db->update('us_announcements',$upd,['dismissed_by'=>$user->data()->id]);

}

echo json_encode(['success'=>true]);
die;