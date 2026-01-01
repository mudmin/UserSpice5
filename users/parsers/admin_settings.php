<?php
//NOTE: This also serves as the reference file for how to do One Click Edit with UserSpice. See comments below.
  require_once '../init.php';
  
  if (!isset($user) || (!hasPerm([2], $user->data()->id) ) ) {
  die("You do not have permission to be here.");
  }

$msg = [];
$msg['api'] = "";
if(!Token::check(Input::get('token'))){
  $msg['success'] = "false";
  $msg['msg'] = "Invalid token";
  echo json_encode($msg);
  die;
}
$type = Input::get('type');
$field = Input::get('field');
$value = Input::get('value');
$desc = Input::get('desc');
$table = Input::get('table');
$token = Input::get('token');
if($table == ""){
  $table = "settings";
}elseif(!substr($table,0,4) == "plg_"){
  $table = "settings";
}else{
  if(isset($config['mysql']['db'])){
    $dbname = $config['mysql']['db'];
  }else{
    die("no db name");
  }
  
  $query = $db->query("SELECT table_name 
  FROM information_schema.tables
  WHERE table_schema = '$dbname'
  AND table_name LIKE 'plg%';")->results();

  $whitelist = ['settings',"us_password_strength"];
  foreach($query as $q){
    if(isset($q->table_name)){
      $whitelist[] = $q->table_name;
    }elseif(isset($q->TABLE_NAME)){
      $whitelist[] = $q->TABLE_NAME;
    }
  }

  if(!in_array($table,$whitelist)){
    $msg['success'] = "false";
    $msg['msg'] = $desc." Not Updated! Illegal table specified";
    echo json_encode($msg); die;
  }


}
$current = $db->query("SELECT * FROM $table")->first();
$hooks =  getMyHooks(['page'=>'admin_settings.php']);
includeHook($hooks,'pre');


if($type == 'resetPW'){
  $db->query("UPDATE users SET force_pr = 1");
  $msg['success'] = "true";
  $msg['msg'] = "Force password reset initiated!";
}
if($type == 'toggle'){
  //check for tomfoolery and make sure the old option was numeric
  if(is_numeric($current->$field)){
    if($value == 'true'){
      $value = 1;
    }else{
      $value = 0;
    }
    $db->update($table,1,[$field=>$value]);
    $msg['success'] = "true";
    $msg['msg'] = $desc." Updated!";
  }else{
    $msg['success'] = "false";
    $msg['msg'] = $desc." Not Updated!";
  }
}

if($type == 'num'){
  //check for tomfoolery and make sure the old option was numeric
  if(is_numeric($current->$field)){
    $db->update($table,1,[$field=>$value]);
    $msg['success'] = "true";
    $msg['msg'] = $desc." Updated!";
  }else{
    $msg['success'] = "false";
    $msg['msg'] = $desc." Not Updated!";
  }
}

if($type == 'txt'){

    $db->update($table,1,[$field=>$value]);
    $msg['success'] = "true";
    $msg['msg'] = $desc." Updated!!!";
  }


if($field == "spice_api"){
   $msg['api'] = checkAPIkey($value);
}


includeHook($hooks,'bottom');
echo json_encode($msg); die;
 