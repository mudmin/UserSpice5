<?php

require_once '../init.php';
$db = DB::getInstance();
if(isset($user) && $user->isLoggedIn()) {
  if(hasPerm([2],$user->data()->id)){
    $name = Input::get('name');
    $pk = Input::get('pk');
    $value = Input::get('value');
    $fields = array($name => $value,'modified' => date("Y-m-d H:i:s"));
    $select = $db->query("SELECT * FROM crons WHERE id = ?",array($pk));
    $results = $select->first();
    $db->update('crons',$pk,$fields);
    logger($user->data()->id,"Cron Manager","Changed $name to $value for $results->name.");
  } else {
    http_response_code(403);
  }
} else {
  http_response_code(403);
}
 ?>
